<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\ItemsAlmaas;
use App\Models\ItemsDetailAlmaas;
use App\Models\Units;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
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
        $items = Items::with('relationUnits')->get();
        return view('pages.master.barang.barang', ['items' => $items]);
    }

    public function create()
    {
        $code = "I" . str_pad($this->PublicController->getRandom('items'), 5, '0', STR_PAD_LEFT);
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

    public function indexAlmaas()
    {
        $items = ItemsAlmaas::with('relationUnits', 'relationDetail')->get();
        return view('pages.master.almaas.barang.barang', ['items' => $items]);
    }

    public function createAlmaas()
    {
        $code = "I" . str_pad($this->PublicController->getRandom('items'), 5, '0', STR_PAD_LEFT);
        $units = Units::all();
        return view('pages.master.almaas.barang.createBarang', ['code' => $code, 'units' => $units]);
    }

    public function storeAlmaas(Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'name' => 'required',
            'stock' => 'required|numeric|integer|min:1',
            'units' => 'required',
            'price_sell' => 'required',
            'price_buy' => 'required'
        ]);

        $count = $this->PublicController->countID('al_items');

        ItemsAlmaas::create([
            'name' => $req->name,
            'unit_id' => $req->units,
            'stock' => $req->stock,
            'code' => $req->code,
            'detail_id' => $count
        ]);

        ItemsDetailAlmaas::create([
            'id' => $count,
            'price_sell' => $this->PublicController->removeComma($req->price_sell),
            'price_buy' => $this->PublicController->removeComma($req->price_buy),
            'info' => $req->info,
        ]);

        return redirect()->route('masterItemsAlmaas');
    }

    public function deleteAlmaas($id)
    {
        $items = ItemsAlmaas::find($id);
        $itemsDetail = ItemsDetailAlmaas::find($items->detail_id);

        $items->delete();
        $itemsDetail->delete();
        return redirect()->route('masterItemsAlmaas');
    }

    public function editAlmaas($id)
    {
        $items = ItemsAlmaas::with('relationUnits', 'relationDetail')->find($id);
        $units = Units::all();
        return view('pages.master.almaas.barang.updateBarang', ['items' => $items, 'units' => $units]);
    }

    public function updateAlmaas($id, Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'name' => 'required',
            'stock' => 'required|numeric|integer|min:1',
            'units' => 'required',
            'price_sell' => 'required',
            'price_buy' => 'required'
        ]);

        $items = ItemsAlmaas::find($id);
        $itemsDetail = ItemsDetailAlmaas::find($items->detail_id);

        // Stored Items
        $items->code = $req->code;
        $items->name = $req->name;
        $items->stock = $req->stock;
        $items->unit_id = $req->units;

        // Stored Items Detail
        $itemsDetail->price_sell = $this->PublicController->removeComma($req->price_sell);
        $itemsDetail->price_buy = $this->PublicController->removeComma($req->price_buy);
        $itemsDetail->info = $req->info;

        // Saved Datas
        $items->save();
        $itemsDetail->save();
        return redirect()->route('masterItemsAlmaas');
    }
}
