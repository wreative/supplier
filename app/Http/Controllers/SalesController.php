<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\Marketer;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sales;
use App\Models\Supplier;
use App\Models\Units;
use App\Models\Transaction;
use Illuminate\Support\Str;

class SalesController extends Controller
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
        $sales = Transaction::with('relationItems', 'relationSales', 'relationCustomer', 'relationMarketer')
            ->whereNull('p_id')->get();
        $count = Sales::count();
        return view('pages.transaksi.penjualan.penjualan', ['sales' => $sales, 'count' => $count]);
    }

    public function create()
    {
        $code = "SP" . $this->PublicController->getRandom('sales') . "/PJL/" . date("m") . date("Y");
        $units = Units::all();
        $items = Items::all();
        $customer = Customer::all();
        $marketer = Marketer::all();
        return view('pages.transaksi.penjualan.createPenjualan', [
            'code' => $code, 'units' => $units, 'items' => $items,
            'customer' => $customer, 'marketer' => $marketer
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
            'marketer' => 'required',
            'customer' => 'required'
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
        // $codeCustomer = Str::substr(Customer::find($req->customer)->code, 3, 5);
        // $code = Str::replaceLast('CUS', $codeCustomer, $req->code);
        $count = $this->PublicController->countID('sales');

        $sellPrice = $this->PublicController->checkPricePPN(
            $datas[1],
            $req->ppn,
            $req->profit
        );

        Transaction::create([
            'items_id' => $req->items,
            's_id' => $count,
            'total' => $req->total,
            'tgl' => $req->tgl,
            'price' => $sellPrice,
            'cus_id' => $req->customer,
            'mar_id' => $req->marketer,
        ]);

        Sales::create([
            'id' => $count,
            'code' => $req->code,
            'dsc' => $discount,
            'info' => $req->info,
            'dp' => $datas[5],
            'tax' => $datas[4],
            'ppn' => $req->ppn
        ]);

        // Modify Stock Items
        $items = Items::find($req->items);
        $stock = $items->stock > $datas[3] ?
            $items->stock - $datas[3] :
            $datas[3] - $items->stock;
        $items->stock = $stock;

        // Saved Datas
        $items->save();

        return redirect()->route('sales.index');
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $sales = Sales::find($transaction->p_id);
        $items = Items::find($transaction->items_id);
        $stock = $items->stock + $transaction->total;

        // Modification Data
        $items->stock = $stock;
        $items->save();
        // Deleted Data
        $sales->delete();
        $transaction->delete();

        return redirect()->route('sales.index');
    }

    // public function calculateStock($items, $units, $type, $total)
    // {
    //     $items = Items::find($items);
    //     $units = Items::find($units);

    //     $totalItems = $type == 'Penjualan' ?
    //         $items->stock - $total :
    //         $items->stock + $total;

    //     $items->stock = $totalItems;
    //     $items->save();
    // }

    function createJSON($dsc, $dscNom, $dscPer)
    {
        $array = array($dsc, $dscNom, $dscPer);
        return json_encode($array);
    }

    public function checkPricePPN($price, $ppn, $profit)
    {
        if ($ppn == 1) {
            $include = $price + ($price * 10 / 100);
            $price = round($include + ($include * $profit / 100));
        } else if ($ppn == 0) {
            $price = round($price + ($price * $profit / 100));
        }
        return $price;
    }
}
