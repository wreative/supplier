<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\Units;
use Illuminate\Support\Facades\Validator;

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
        $code = "SP" . $this->PublicController->getRandom('purchase') . "/PBL/" . date("m") . "/" . date("Y");
        $items = Items::all();
        $supplier = Supplier::all();
        $units = Units::all();
        $payment = Payment::all();
        return view('pages.transaksi.pembelian.createPembelian', [
            'code' => $code, 'items' => $items, 'supplier' => $supplier,
            'units' => $units, 'payment' => $payment
        ]);
    }

    public function store(Request $req)
    {
        Validator::make($req->all(), [
            'code' => 'required',
            'items' => 'required',
            'total' => 'required|numeric|integer|min:1',
            'dsc_per' => 'nullable|numeric|max:100',
            'tax' => 'numeric|max:100',
            'tgl' => 'required|date',
            'supplier' => 'required',
            'status' => 'required'
        ]);

        //Intial Variable
        $idItems = $req->items;

        // Null Safety
        $etc_price = $req->etc_price == null ? 0 :
            $this->PublicController->removeComma($req->etc_price);
        $ship_price = $req->ship_price == null ? 0 :
            $this->PublicController->removeComma($req->ship_price);
        $downPayment = $req->dp == null ? 0 : $req->dp;

        // Custom Items Price
        $customPrice = $req->price_replace == 1 ? $req->price_items : 0;

        // Calculate Formula
        $datas = $this->PublicController->calculate(
            $req->total,
            $idItems,
            $req->dsc_nom,
            $req->dsc_per,
            $downPayment,
            $req->ppn,
            $ship_price,
            $etc_price,
            $customPrice,
            0
        );

        $status = $req->status == '1' ? 'Diterima' : 'Dipesan';
        $discount = $this->createJSON($datas[2], $datas[7], $datas[8]);
        // $codeSupplier = Str::substr(Supplier::find($req->supplier)->code, 3, 5);
        // $code = Str::replaceLast('SUP', $codeSupplier, $req->code);
        $count = $this->PublicController->countID('purchase');

        Transaction::create([
            'items_id' => $idItems,
            'p_id' => $count,
            'sup_id' => $req->supplier,
            'total' => $req->total,
            'tgl' => $req->tgl,
            'price' => $datas[6],
            'c_price' => $customPrice,
            'pay_id' => $req->payment_method
        ]);

        Purchase::create([
            'id' => $count,
            'code' => $req->code,
            'dsc' => $discount,
            'info' => $req->info,
            'dp' => $datas[5],
            'tax' => $datas[4],
            'ppn' => $req->ppn,
            'status' => $status,
            'etc_price' => $datas[10],
            'ship_price' => $datas[9],
            'pay' => $this->PublicController->removeComma($req->payment) >= $datas[6] ?
                "Dibayar" : "Tempo"
        ]);

        // Modify Stock Items
        $items = Items::find($idItems);
        $items->stock = $items->stock + $datas[3];
        if ($req->price_replace == 1) {
            $items->price = $this->PublicController->removeComma($req->price_items);
        }

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
