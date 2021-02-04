<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\Units;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PublicController $PublicController)
    {
        $this->PublicController = $PublicController;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $purchase = Transaction::with('relationItems', 'relationSupplier', 'relationPurchase')
            ->whereNull('s_id')->get();
        $count = Purchase::count();
        return view('pages.transaksi.pembelian.pembelian', ['purchase' => $purchase, 'count' => $count]);
    }

    public function create()
    {
        $code = "SP" . $this->PublicController->getRandom('purchase') . "/PBL/" . date("m") . date("Y");
        $items = Items::all();
        $supplier = Supplier::all();
        $units = Units::all();
        return view('pages.transaksi.pembelian.createPembelian', [
            'code' => $code, 'items' => $items, 'supplier' => $supplier, 'units' => $units
        ]);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'items' => 'required',
            'total' => 'required|numeric|integer|min:1',
            'dsc_per' => 'nullable|numeric|max:100',
            'tax' => 'numeric|max:100',
            'tgl' => 'required|date',
            'supplier' => 'required',
        ]);

        $datas = $this->PublicController->calculate(
            $req->total,
            $req->items,
            $req->dsc_nom,
            $req->dsc_per,
            $req->dp,
            $req->ppn
        );

        $discount = $this->createJSON($datas[2], $datas[7], $datas[8]);
        $codeSupplier = Str::substr(Supplier::find($req->supplier)->code, 3, 5);
        $code = Str::replaceLast('SUP', $codeSupplier, $req->code);
        $count = $this->PublicController->countID('purchase');

        $sellPrice = $this->PublicController->checkPricePPN(
            $datas[1],
            $req->ppn,
            $req->profit
        );

        Transaction::create([
            'items_id' => $req->items,
            'p_id' => $count,
            'sup_id' => $req->supplier,
            'total' => $req->total,
            'tgl' => $req->tgl,
            'price' => $sellPrice
        ]);

        Purchase::create([
            'id' => $count,
            'code' => $code,
            'dsc' => $discount,
            'info' => $req->info,
            'dp' => $datas[5],
            'tax' => $datas[4],
            'ppn' => $req->ppn
        ]);

        // Modify Stock Items
        $items = Items::find($req->items);
        $items->stock = $items->stock + $datas[3];

        // Saved Datas
        $items->save();

        return redirect()->route('purchase.index');
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $purchase = Purchase::find($transaction->p_id);
        $items = Items::find($transaction->items_id);
        $stock = $items->stock > $transaction->total ?
            $items->stock - $transaction->total :
            $transaction->total - $items->stock;
        // Modification Data
        $items->stock = $stock;
        $items->save();
        // Deleted Data
        $purchase->delete();
        $transaction->delete();

        return redirect()->route('purchase.index');
    }

    function createJSON($dsc, $dscNom, $dscPer)
    {
        $array = array($dsc, $dscNom, $dscPer);
        return json_encode($array);
    }
}
