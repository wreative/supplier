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

    public function removeComma($number)
    {
        return str_replace(',', '', $number);
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
        $include = (int)$req->include;
        $profit = (int)$req->profit;
        if ($profit >= 100) {
            return Response()->json(['status' => 'error']);
        } else {
            $price = round($include + ($include * $profit / 100));
            return Response()->json(['price' => $price]);
        }
    }

    public function checkPurchase(Request $req)
    {
        // Initial
        $dsc_per = (int)$req->dsc_per;

        // Validation
        if ($dsc_per >= 100) {
            return Response()->json(['status' => 'error']);
        }

        $datas = $this->purchase($req->total, $req->items, $req->dsc_nom, $req->dsc_per, $req->dp);
        return Response()->json(['hasil' => $datas]);
    }

    public function purchase($total, $items, $discountNom, $discountPer, $dp)
    {
        // Initial
        $totalItems = (int)$total;
        $itemsName = Items::find($items)->name;
        $items = Items::find($items)->detail_id;
        $itemsDetail = ItemsDetail::find($items);
        $itemsPrice = $itemsDetail->price;
        $dsc_nom = (int)$discountNom;
        $dsc_per = (int)$discountPer;
        $tax = $itemsDetail->price_inc * $totalItems;
        $downPayment = (int)$dp;

        // Initial New Price
        $newPrice = $totalItems * $itemsPrice;

        // Discount
        $discount = $dsc_nom != 0 ? $discount = $dsc_nom : ($dsc_per != 0 ? round($newPrice * $dsc_per / 100) : 0);

        // Calculate Total Price
        $totalPrice = round($newPrice - $discount - $downPayment);

        // Passing Data
        $datas = array(
            $itemsName, $itemsPrice, $discount, $totalItems, $tax, $downPayment, $totalPrice, $dsc_nom, $dsc_per
        );
        return $datas;
    }
}
