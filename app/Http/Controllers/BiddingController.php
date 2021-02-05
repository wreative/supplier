<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\Customer;

class BiddingController extends Controller
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
        return view('pages.penawaran.penawaran');
    }

    public function create()
    {
        $code = "SP" . $this->PublicController->getRandom('bidding') . "/SS/BB/" . date("m") . "/" . date("Y");
        // $units = Units::all();
        $items = Items::all();
        $customer = Customer::all();
        // $marketer = Marketer::all();
        return view('pages.penawaran.createPenawaran', [
            'code' => $code, 'items' => $items, 'customer' => $customer
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

        return redirect()->route('bidding.index');
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

        return redirect()->route('bidding.index');
    }
}
