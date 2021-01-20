<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\ItemsAlmaas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
    public function index()
    {
        if (Auth::user()->role_id == 1) {
            $items = DB::table('items')->count();
            $stock = Items::sum('stock');
            $purchase = DB::table('purchase')->count();
            $sales = DB::table('sales')->count();
            return view('home', ['items' => $items, 'stock' => $stock, 'purchase' => $purchase, 'sales' => $sales]);
        } else {
            $items = DB::table('al_items')->count();
            $stock = ItemsAlmaas::sum('stock');
            return view('home', ['items' => $items, 'stock' => $stock]);
        }
    }
}
