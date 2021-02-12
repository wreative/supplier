<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\Customer;
use App\Models\Bidding;


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
        $bidding = Bidding::with('relationCustomer')->get();
        return view('pages.penawaran.penawaran', ['bidding' => $bidding]);
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
        ]);
        // dd($req->all());

        // Null Safety
        $dsc_nom = $req->dsc_nom == null ? 0 : $req->dsc_nom;
        $ship_cost = $req->ship_cost == null ? 0 : $req->ship_cost;
        $pack_fee = $req->pack_fee == null ? 0 : $req->pack_fee;

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
        $discount = $this->PublicController->createJSON2(
            $this->PublicController->removeComma($dsc_nom),
            $req->dsc_per
        );
        $cost = $this->PublicController->createJSON2(
            $this->PublicController->removeComma($ship_cost),
            $this->PublicController->removeComma($pack_fee)
        );

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

        return redirect()->route('bidding.index');
    }

    public function destroy($id)
    {
        $bidding = Bidding::find($id);
        $bidding->delete();
        return redirect()->route('bidding.index');
    }

    function biddingItems(Request $req)
    {
        $bidding = Bidding::find($req->id)->items;
        $decode = json_decode($bidding);
        $array = array();
        for ($i = 0; $i < count($decode->id_items); $i++) {
            $items = Items::find($decode->id_items[$i]);
            array_push($array, $items);
        }
        return Response()->json([
            'items' => $array,
            'total' => $decode->total,
            'code' => Bidding::find($req->id)->code
        ]);
    }

    function createCode()
    {
        return "SP" . $this->PublicController->getRandom('bidding') .
            "/SS/BB/" . date("m") . "/" . date("Y");
    }
}
