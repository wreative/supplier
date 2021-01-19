<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Items;
use App\Models\Marketer;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Units;
use App\Models\Transaction;
use Illuminate\Support\Str;

class TransactionController extends Controller
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
    public function indexPurchase()
    {
        $purchase = Transaction::with('relationItems', 'relationPurchase')->get();
        return view('pages.transaksi.pembelian.pembelian', ['purchase' => $purchase]);
    }

    public function createPurchase()
    {
        $code = "TSP/" . $this->PublicController->getRandom('purchase') . "/" . date("dmY") . "/SUP";
        $items = Items::all();
        $supplier = Supplier::all();
        return view('pages.transaksi.pembelian.createPembelian', [
            'code' => $code, 'items' => $items, 'supplier' => $supplier
        ]);
    }

    public function storePurchase(Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'items' => 'required',
            'total' => 'required|numeric|integer|min:1',
            'dsc_per' => 'numeric|max:100',
            'tax' => 'numeric|max:100',
            'tgl' => 'required|date',
            'supplier' => 'required',
        ]);

        $datas = $this->PublicController->calculate($req->total, $req->items, $req->dsc_nom, $req->dsc_per, $req->tax);
        $discount = $this->createJSON($datas[2], $datas[7], $datas[8]);
        $codeSupplier = Str::substr(Supplier::find($req->supplier)->code, 3, 5);
        $code = Str::replaceLast('SUP', $codeSupplier, $req->code);
        $count = $this->PublicController->countID('purchase');

        Transaction::create([
            'items_id' => $req->items,
            'unit_id' => $req->units,
            'p_id' => $count,
            'sup_id' => $req->supplier
        ]);

        Purchase::create([
            'id' => $count,
            'code' => $code,
            'total' => $req->total,
            'dsc' => $discount,
            'info' => $req->info,
            'dp' => $datas[5],
            'tgl' => $req->tgl,
            'tax' => $datas[4],
            'price' => $datas[1]
        ]);

        // Modify Stock Items
        $items = Items::find($req->items);
        // $stock = $items->stock > $datas[3] ? $items->stock - $datas[3] : $datas[3] - $items->stock;
        $items->stock = $items->stock + $datas[3];

        // Saved Datas
        $items->save();

        return redirect()->route('masterPurchase');
    }

    public function deletePurchase($id)
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

        return redirect()->route('masterPurchase');
    }

    //TODO: Sales
    public function indexSales()
    {
        $purchase = Transaction::with('relationItems', 'relationUnits', 'relationPurchase')->get();
        return view('pages.transaksi.penjualan.penjualan', ['purchase' => $purchase]);
    }

    public function createSales()
    {
        $code = "TSS-" . $this->getRandom();
        $units = Units::all();
        $items = Items::all();
        $customer = Customer::all();
        $marketer = Marketer::all();
        return view('pages.transaksi.pembelian.createPembelian', [
            'code' => $code, 'units' => $units, 'items' => $items,
            'customer' => $customer, 'marketer' => $marketer
        ]);
    }

    public function storeSales(Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'total' => 'required|numeric|integer|min:1',
            'units' => 'required',
            'items' => 'required',
            'type' => 'required',
            'tgl' => 'required|date'
        ]);

        $this->calculateStock($req->items, $req->units, $req->type, $req->total);

        $items = Items::find($req->items);
        $units = Items::find($req->units);

        Transaction::create([
            'items_id' => $items->id,
            'total' => $req->total,
            'code' => $req->code,
            'tgl' => $req->tgl,
            'type' => $req->type,
            'unit_id' => $units->id,
            'info' => $req->info
        ]);

        return redirect()->route('masterTransaction');
    }

    public function deleteSales($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        return redirect()->route('masterTransaction');
    }

    public function editSales($id)
    {
        $transaction = Transaction::find($id);
        $units = Units::all();
        $items = Items::all();
        return view('pages.transaksi.updateTransaksi', ['items' => $items, 'units' => $units, 'transaction' => $transaction]);
    }

    public function updateSales($id, Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'total' => 'required|numeric|integer|min:1',
            'units' => 'required',
            'items' => 'required',
            'type' => 'required',
            'tgl' => 'required|date'
        ]);

        $transaction = Transaction::find($id);

        // Stored Items
        $transaction->code = $req->code;
        $transaction->total = $req->total;
        $transaction->unit_id = $req->units;
        $transaction->items_id = $req->items;
        $transaction->tgl = $req->tgl;
        $transaction->type = $req->type;
        $transaction->info = $req->info;

        // Saved Datas
        $transaction->save();
        return redirect()->route('masterTransaction');
    }

    public function getRandom()
    {
        do {
            $random = rand(00001, 99999);
            $check = DB::table('transaction')
                ->select('code')
                ->having('code', '=', $random)
                ->first();
        } while ($check != null);
        return $random;
    }

    public function calculateStock($items, $units, $type, $total)
    {
        $items = Items::find($items);
        $units = Items::find($units);

        $totalItems = $type == 'Penjualan' ?
            $items->stock - $total :
            $items->stock + $total;

        $items->stock = $totalItems;
        $items->save();
    }

    function createJSON($dsc, $dscNom, $dscPer)
    {
        $array = array($dsc, $dscNom, $dscPer);
        return json_encode($array);
    }
}
