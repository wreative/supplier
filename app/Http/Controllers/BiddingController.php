<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\Customer;
use App\Models\Bidding;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


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
        return view('pages.penawaran.createPenawaran', [
            'code' => $this->createCode(),
            'items' => Items::all(),
            'customer' => Customer::all()
        ]);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'customer' => 'required',
            'ppn' => 'required|numeric|integer',
            // 'items' => 'required',
            // 'total' => 'required|numeric|integer|min:1',
            // 'dsc_per' => 'nullable|numeric|max:100',
            // 'tax' => 'numeric|max:100',
            // 'tgl' => 'required|date',
            // 'marketer' => 'required',            
        ]);
        // dd($req->all());

        if ($req->items == null) {
            return redirect()->route('bidding.create', [
                'code' => $this->createCode(),
                'items' => Items::all(),
                'customer' => Customer::all()
            ])->with(['status' => 'Pastikan sudah menambahkan barang minimal 1']);
        } else {
            $items = $totalItems = count($req->items);
        }

        // Create items
        for ($i = 0; $i <= $totalItems; $i++) {
            // $sellpriceItems = Items::with('relationDetail')->find($req->items);
            $items = [
                'id_items' => $req->items,
                'total' => $req->total,
                // 'price' => $sellpriceItems
            ];
        }

        // Create array from sell price items
        $sellPrice = $this->PublicController->createArrayPrice($totalItems, $items);

        // Create Sub total items
        $subtotalPrice = $this->PublicController->createSubtotalPrice($sellPrice, $items);

        // Create total price from array
        $totalPrice = $this->PublicController->createTotalPrice($subtotalPrice);

        // Other functions
        $discount = $this->PublicController->createJSON2($req->dsc_nom, $req->dsc_per);
        $cost = $this->PublicController->createJSON2($req->ship_cost, $req->pack_fee);

        // Grand Total
        $gt = $this->PublicController->biddingPrice($totalPrice, $discount, $cost, $req->ppn);


        // Stored data
        Bidding::create([
            'code' => $req->code,
            'cus_id' => $req->customer,
            'items' => json_encode($items),
            'date' => date("Y-m-d"),
            'ppn' => $req->ppn,
            'dsc' => $discount,
            'gt' => $gt,
            'info' => $req->info,
            'cost' => $cost,
        ]);

        // $datas = $this->PublicController->calculate(
        //     $req->total,
        //     $req->items,
        //     $req->dsc_nom,
        //     $req->dsc_per,
        //     $req->dp,
        //     $req->ppn
        // );

        // $discount = $this->createJSON($datas[2], $datas[7], $datas[8]);
        // // $codeCustomer = Str::substr(Customer::find($req->customer)->code, 3, 5);
        // // $code = Str::replaceLast('CUS', $codeCustomer, $req->code);
        // $count = $this->PublicController->countID('sales');

        // $sellPrice = $this->PublicController->checkPricePPN(
        //     $datas[1],
        //     $req->ppn,
        //     $req->profit
        // );

        // Bidding::create([
        //     'items_id' => $req->items,
        //     's_id' => $count,
        //     'total' => $req->total,
        //     'tgl' => $req->tgl,
        //     'price' => $sellPrice,
        //     'cus_id' => $req->customer,
        //     'mar_id' => $req->marketer,
        // ]);

        // Sales::create([
        //     'id' => $count,
        //     'code' => $req->code,
        //     'dsc' => $discount,
        //     'info' => $req->info,
        //     'dp' => $datas[5],
        //     'tax' => $datas[4],
        //     'ppn' => $req->ppn
        // ]);

        // // Modify Stock Items
        // $items = Items::find($req->items);
        // $stock = $items->stock > $datas[3] ?
        //     $items->stock - $datas[3] :
        //     $datas[3] - $items->stock;
        // $items->stock = $stock;

        // // Saved Datas
        // $items->save();

        // return redirect()->route('bidding.index');
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

    function createCode()
    {
        return "SP" . $this->PublicController->getRandom('bidding') .
            "/SS/BB/" . date("m") . "/" . date("Y");
    }
}
