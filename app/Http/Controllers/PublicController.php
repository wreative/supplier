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
        $total = (int)$req->total;
        $itemPrice = ItemsDetail::find(Items::find($req->items)->detail_id)->price;
        $dsc_nom = (int)$req->dsc_nom;
        $dsc_per = (int)$req->dsc_per;
        $tax = 10;
        $dp = (int)$req->dp;

        $array = array($total, $dsc_nom, $dsc_per, $tax, $dp, $item);
        return Response()->json(['hasil' => $array]);
    }
}
