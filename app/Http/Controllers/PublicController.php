<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\ItemsDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getRandom($table)
    {
        do {
            $random = rand(00001, 99999);
            $check = DB::table($table)
                ->select('code')
                ->having('code', '=', $random)
                ->first();
        } while ($check != null);
        return $random;
    }

    public function createJSON($city, $province, $pos)
    {
        $array = array($city, $province, $pos);
        return json_encode($array);
    }

    public function createJSON2($name, $tlp)
    {
        $array = array($name, $tlp);
        return json_encode($array);
    }

    public function countID($table)
    {
        return DB::table($table)->count() == 0 ?
            1 :
            DB::table($table)
            ->select('id')
            ->orderByDesc('id')
            ->limit('1')
            ->first()->id + 1;
    }

    public function checkInclude(Request $req)
    {
        $exclude = (int)$req->exclude;
        $include = $exclude + ($exclude * 10 / 100);
        return Response()->json(['include' => $include]);
    }

    public function checkExclude(Request $req)
    {
        $include = (int)$req->include;
        $exclude = round($include / 110 * 100);
        return Response()->json(['exclude' => $exclude]);
    }

    public function checkPPN(Request $req)
    {
        $ppn = $req->ppn;
        $price = $this->removeComma($req->price);
        $price = $ppn == 1 ? $price + ($price * 10 / 100) : $price;
        return Response()->json(['price' => number_format($price, 2)]);
    }

    // Check Data From Purchase
    public function checkPurchase(Request $req)
    {
        // Initial
        $dsc_per = (int)$req->dsc_per;

        // Validation
        if ($dsc_per >= 100) {
            return Response()->json(['status' => 'error']);
        } else if ($req->total <= 0 or $req->total ==  null) {
            return Response()->json(['status' => 'null']);
        }

        // Null Safety
        $etc_price = $req->etc_price == null ? 0 :
            $this->removeComma($req->etc_price);
        $ship_price = $req->ship_price == null ? 0 :
            $this->removeComma($req->ship_price);
        $dp = $req->dp == null ? 0 :
            $req->dp;

        $datas = $this->calculate(
            $req->total,
            $req->items,
            $req->dsc_nom,
            $req->dsc_per,
            $dp,
            $req->ppn,
            $ship_price,
            $etc_price,
            $this->removeComma($req->price_items),
            0
        );
        return Response()->json(['hasil' => $datas]);
    }

    // Sales
    public function checkSales(Request $req)
    {
        // Initial
        $dsc_per = (int)$req->dsc_per;

        // Validation
        if ($dsc_per >= 100) {
            return Response()->json(['status' => 'error']);
        }

        // Null Safety
        $etc_price = $req->etc_price == null ? 0 :
            $this->removeComma($req->etc_price);
        $ship_price = $req->ship_price == null ? 0 :
            $this->removeComma($req->ship_price);
        $dp = $req->dp == null ? 0 :
            $req->dp;

        $datas = $this->calculate(
            $req->total,
            $req->items,
            $req->dsc_nom,
            $req->dsc_per,
            $dp,
            $req->ppn,
            $ship_price,
            $etc_price,
            $this->removeComma($req->price_items),
            1
        );
        return Response()->json(['hasil' => $datas]);
    }

    public function getPrice(Request $req)
    {
        $sellPrice = ItemsDetail::find($req->id)->sell_price;
        return Response()->json(['price' => $sellPrice]);
    }

    // Main Formula
    public function calculate($total, $items, $discountNom, $discountPer, $dp, $ppn, $shipPrice, $etcPrice, $customPrice, $type)
    {
        // Initial
        $totalItems = (int)$total;
        $itemsName = Items::find($items)->name;
        $items = Items::find($items)->detail_id;
        $itemsDetail = ItemsDetail::find($items);
        //TODO:change to price
        if ($type == '0') {
            $itemsPrice = $customPrice != 0 ? $customPrice : $itemsDetail->price;
        } else {
            $itemsPrice = $customPrice != 0 ? $customPrice : $itemsDetail->sell_price;
        }

        $dsc_nom = (int)$discountNom;
        $dsc_per = (int)$discountPer;
        $downPayment = $this->removeComma($dp);

        // Initial New Price
        $newPrice = $totalItems * $itemsPrice;

        // Tax
        if ($ppn == 1) {
            $tax = round($newPrice * 10 / 100);
        } else if ($ppn == 0) {
            $tax = 0;
        }

        // Discount
        $discount = $dsc_nom != 0 ? $discount = $dsc_nom : ($dsc_per != 0 ? round($newPrice * $dsc_per / 100) : 0);
        $discount *= $totalItems;

        // Calculate Total Price
        $totalPrice = $newPrice - $discount - $downPayment + $shipPrice + $etcPrice + $tax;

        // Passing Data
        $datas = array(
            $itemsName, $itemsPrice, $discount, $totalItems, $tax, $downPayment, $totalPrice, $dsc_nom, $dsc_per, $shipPrice, $etcPrice
        );
        return $datas;
    }

    // Items Function
    public function checkPricePPN($price, $ppn, $profit)
    {
        if ($ppn == 1) {
            $include = $price + ($price * 10 / 100);
            $price = $include + ($include * $profit / 100);
        } else if ($ppn == 0) {
            $price = $price + ($price * $profit / 100);
        }
        return $price;
    }

    public function checkPrice(Request $req)
    {
        //TODO: Don't Remove
        // $include = (int)$req->include;
        // $profit = (int)$req->profit;
        // if ($profit >= 100) {
        //     return Response()->json(['status' => 'error']);
        // } else {
        //     $price = round($include + ($include * $profit / 100));
        //     return Response()->json(['price' => $price]);
        // }
        // $include = (int)$req->include;

        // $price = (int)$req->price;
        $price = $this->removeComma($req->price);
        // $price = $price * 2000.22;
        // $price = number_format($req->price, 2, '.', '');
        // $price = $price + 2000.22;
        $profit = (int)$req->profit;
        $profitNom = $this->removeComma($req->profit_nom);
        $ppn = $req->ppn;


        if ($profit >= 100) {
            return Response()->json(['status' => 'error']);
        } else if ($ppn == 1) {
            $include = $price + ($price * 10 / 100);
            $price = $include + ($include * $profit / 100);
        } else if ($ppn == 0) {
            $price = $price + ($price * $profit / 100);
        }
        return Response()->json(['price' => number_format($price, 2)]);
    }

    public function getItems(Request $req)
    {
        $datas = Items::with('relationDetail', 'relationUnits')->find($req->items);
        $itemDetail = $datas->relationDetail;
        // TODO:PR PPN PRICE
        $ppn = $itemDetail->ppn_price == $itemDetail->price ? 0 : $itemDetail->ppn_price;
        $profit = $itemDetail->profit == null ? 0 : $itemDetail->profit;
        return Response()->json(['items' => $datas, 'ppn' => $ppn, 'profit' => $profit]);
    }

    // Bidding
    public function biddingPrice($totalPrice, $discount, $cost, $ppn)
    {
        // Initial
        $dsc_nom = json_decode($discount)[0];
        $dsc_per = json_decode($discount)[1];
        $ship_cost = $this->removeComma(json_decode($cost)[0]);
        $pack_fee = $this->removeComma(json_decode($cost)[1]);

        // PPN
        $pricePPN = $ppn == 1 ? $totalPrice * 10 / 100 : 0;

        // Other Cost
        $totalPrice = $ppn == 1 ? $totalPrice + 10000 + $ship_cost + $pack_fee + $pricePPN
            : $totalPrice + $ship_cost + $pack_fee;

        // Discount 
        $discount = $dsc_nom != 0 ? $discount = $dsc_nom
            : ($dsc_per != 0 ? round($totalPrice * $dsc_per / 100)
                : 0);

        // Grand Total
        $grandTotal = $totalPrice - $discount;
        return $grandTotal;
    }

    public function createArrayPrice($totalItems, $items)
    {
        $array = array();
        for ($i = 0; $i < $totalItems; $i++) {
            $sellpriceItems = Items::with('relationDetail')->find($items['id_items'][$i])->relationDetail->sell_price;
            array_push($array, $sellpriceItems);
        }
        return $array;
    }

    public function createSubtotalPrice($sellPrice, $items)
    {
        $array = array();
        for ($i = 0; $i < count($items['id_items']); $i++) {
            $sellpriceItems = $sellPrice[$i] * $items['total'][$i];
            array_push($array, $sellpriceItems);
        }
        return $array;
    }

    public function createTotalPrice($subTotal)
    {
        $total = 0;
        for ($i = 0; $i < count($subTotal); $i++) {
            $total = $total + $subTotal[$i];
        }
        return $total;
    }

    // Other functions
    public function removeComma($number)
    {
        return str_replace(',', '', $number);
    }
}
