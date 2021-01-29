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
        $ppn = $req->ppn;
        if ($profit >= 100) {
            return Response()->json(['status' => 'error']);
        } else if ($ppn == 1) {
            $include = $price + ($price * 10 / 100);
            $price = round($include + ($include * $profit / 100));
        } else if ($ppn == 0) {
            $price = round($price + ($price * $profit / 100));
        }
        return Response()->json(['price' => number_format($price, 2)]);
    }

    public function checkPPN(Request $req)
    {
        $ppn = $req->ppn;
        $price = $this->removeComma($req->price);
        $price = $ppn == 1 ? $price + ($price * 10 / 100) : $price;
        return Response()->json(['price' => number_format($price, 2)]);
    }

    public function checkPurchase(Request $req)
    {
        // Initial
        $dsc_per = (int)$req->dsc_per;

        // Validation
        if ($dsc_per >= 100) {
            return Response()->json(['status' => 'error']);
        }

        $datas = $this->calculate($req->total, $req->items, $req->dsc_nom, $req->dsc_per, $req->dp, $req->ppn);
        return Response()->json(['hasil' => $datas]);
    }

    public function checkSales(Request $req)
    {
        // Initial
        $dsc_per = (int)$req->dsc_per;

        // Validation
        if ($dsc_per >= 100) {
            return Response()->json(['status' => 'error']);
        }

        $datas = $this->calculate($req->total, $req->items, $req->dsc_nom, $req->dsc_per, $req->dp, $req->ppn);
        return Response()->json(['hasil' => $datas]);
    }

    public function calculate($total, $items, $discountNom, $discountPer, $dp, $ppn)
    {
        // Initial
        $totalItems = (int)$total;
        $itemsName = Items::find($items)->name;
        $items = Items::find($items)->detail_id;
        $itemsDetail = ItemsDetail::find($items);
        $itemsPrice = $itemsDetail->sell_price;
        $dsc_nom = (int)$discountNom;
        $dsc_per = (int)$discountPer;
        $downPayment = (int)$dp;

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

        // Calculate Total Price
        $totalPrice = round($newPrice - $discount - $downPayment + $tax);

        // Passing Data
        $datas = array(
            $itemsName, $itemsPrice, $discount, $totalItems, $tax, $downPayment, $totalPrice, $dsc_nom, $dsc_per
        );
        return $datas;
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

    public function getItems(Request $req)
    {
        $datas = Items::with('relationDetail')->find($req->items);
        return Response()->json(['items' => $datas]);
    }

    public function removeComma($number)
    {
        return str_replace(',', '', $number);
    }
}
