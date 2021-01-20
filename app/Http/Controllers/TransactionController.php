<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Items;
use App\Models\Marketer;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sales;
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
        $purchase = Transaction::with('relationItems', 'relationSupplier')->get();
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
            'dsc_per' => 'nullable|numeric|max:100',
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
            // 'unit_id' => $req->units,
            'p_id' => $count,
            'sup_id' => $req->supplier,
            'total' => $req->total,
            'tgl' => $req->tgl,
            'price' => $datas[1]
        ]);

        Purchase::create([
            'id' => $count,
            'code' => $code,
            'dsc' => $discount,
            'info' => $req->info,
            'dp' => $datas[5],
            'tax' => $datas[4],
        ]);

        // Modify Stock Items
        $items = Items::find($req->items);
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
        $sales = Transaction::with('relationItems', 'relationSales')->get();
        return view('pages.transaksi.penjualan.penjualan', ['purchase' => $sales]);
    }

    public function createSales()
    {
        $code = "TSS/" . $this->PublicController->getRandom('sales') . "/" . date("dmY") . "/CUS";
        $units = Units::all();
        $items = Items::all();
        $customer = Customer::all();
        $marketer = Marketer::all();
        return view('pages.transaksi.penjualan.createPenjualan', [
            'code' => $code, 'units' => $units, 'items' => $items,
            'customer' => $customer, 'marketer' => $marketer
        ]);
    }

    public function storeSales(Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'items' => 'required',
            'total' => 'required|numeric|integer|min:1',
            'dsc_per' => 'nullable|numeric|max:100',
            'tax' => 'numeric|max:100',
            'tgl' => 'required|date',
            'customer' => 'required',
            'marketer' => 'required'
        ]);

        $datas = $this->PublicController->calculate($req->total, $req->items, $req->dsc_nom, $req->dsc_per, $req->tax);
        $discount = $this->createJSON($datas[2], $datas[7], $datas[8]);
        $codeCustomer = Str::substr(Customer::find($req->customer)->code, 3, 5);
        $code = Str::replaceLast('CUS', $codeCustomer, $req->code);
        $count = $this->PublicController->countID('sales');

        Transaction::create([
            'items_id' => $req->items,
            // 'unit_id' => $req->units,
            's_id' => $count,
            'cus_id' => $req->customer,
            'mar_id' => $req->marketer,
            'total' => $req->total,
            'tgl' => $req->tgl,
            'price' => $datas[1]
        ]);

        Sales::create([
            'id' => $count,
            'code' => $code,
            'dsc' => $discount,
            'info' => $req->info,
            'dp' => $datas[5],
            'tax' => $datas[4],
        ]);

        // Modify Stock Items
        $items = Items::find($req->items);
        $stock = $items->stock > $datas[3] ? $items->stock - $datas[3] : $datas[3] - $items->stock;
        $items->stock = $stock;

        // Saved Datas
        $items->save();

        return redirect()->route('masterSales');
    }

    public function deleteSales($id)
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
