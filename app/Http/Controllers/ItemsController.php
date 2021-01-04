<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\Units;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
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
        $items = Items::with('relationUnits')->get();
        return view('pages.master.barang.barang', ['items' => $items]);
    }

    public function create()
    {
        $items = DB::table('items')->count();
        //TODO:Duplicate Code
        $code = "I" . $this->getRandom();
        $units = Units::all();
        return view('pages.master.barang.createBarang', ['code' => $code, 'units' => $units]);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'name' => 'required',
            'stock' => 'required|numeric|integer|min:1',
            'units' => 'required',
        ]);

        Items::create([
            'name' => $req->name,
            'unit_id' => $req->units,
            'stock' => $req->stock,
            'code' => $req->code,
            'info' => $req->info
        ]);

        return redirect()->route('masterItems');
    }

    public function delete($id)
    {
        $items = Items::find($id);
        $items->delete();
        return redirect()->route('masterItems');
    }

    public function edit($id)
    {
        $items = Items::with('relationUnits')->find($id);
        $units = Units::all();
        return view('pages.master.barang.updateBarang', ['items' => $items, 'units' => $units]);
    }

    public function update($id, Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'name' => 'required',
            'stock' => 'required|numeric|integer|min:1',
            'units' => 'required',
        ]);

        $items = Items::find($id);

        // Stored Items
        $items->name = $req->name;
        $items->stock = $req->stock;
        $items->unit_id = $req->units;
        $items->info = $req->info;

        // Saved Datas
        $items->save();
        return redirect()->route('masterItems');
    }

    public function getRandom()
    {
        do {
            $random = rand(00001, 99999);
            $check = DB::table('items')
                ->select('code')
                ->having('code', '=', $random)
                ->first();
        } while ($check != null);
        return $random;
    }
}
