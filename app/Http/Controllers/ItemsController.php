<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\ItemsDetail;
use App\Models\Units;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;


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
        $items = Items::with('relationUnits', 'relationDetail')
            ->where('hide', '=', 0)
            ->get();
        // DataTables::
        // if ($req->ajax()) {
        //     datatables()->of(Items::all())->toJson();
        //     datatables(Items::with('relationUnits', 'relationDetail')->toJson());
        //     // dd('asdas');
        // }

        return view('pages.master.barang.barang', ['items' => $items]);
        //TODO:Yajra Datatables
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
            'stock' => 'required|numeric|integer|min:0',
            'limit' => 'required|numeric|integer|min:1',
            'units' => 'required',
            'price' => 'required',
            'ppn' => 'required|numeric|integer',
            'profit' => 'nullable|numeric|max:100',
            'sell_price' => 'required',
        ]);

        // Initial
        // $include = $this->PublicController->removeComma($req->price_inc);
        // $exclude = $this->PublicController->removeComma($req->price_exc);
        // $profit = $this->PublicController->removeComma($req->profit);

        // Calculate
        // $includeCalculate = $exclude + ($exclude * 10 / 100);
        // $excludeCalculate = $include / 1.1;
        // if ($include != '' && $exclude != '') {
        //     $final = $include;
        // } elseif ($include != '') {
        //     $final = $include;
        // } else {
        //     $final = $include;
        // }

        // $price = $final + $profit;
        // dd($price);
        // $price_exc = $req->price_exc == null ? $price_exc = 0
        //     : $this->PublicController->removeComma($req->price_exc);
        $count = $this->PublicController->countID('d_items');
        $profit_nom = $req->profit_nom == null ? 0
            : $this->PublicController->removeComma($req->profit_nom);

        Items::create([
            'name' => $req->name,
            'unit_id' => $req->units,
            'stock' => $this->PublicController->removeComma($req->stock),
            'code' => $req->code,
            'info' => $req->info,
            'detail_id' => $count,
            'limit' => $req->limit,
            'hide' => '0'
        ]);

        $sellPrice = $this->PublicController->checkPricePPN(
            $this->PublicController->removeComma($req->price),
            $req->ppn,
            $req->profit
        );

        $ppnPrice = $this->checkPPN($req->price, $req->ppn);

        ItemsDetail::create([
            'id' => $count,
            'price' => $this->PublicController->removeComma($req->price),
            'profit' => $req->profit,
            'profit_nom' => $profit_nom,
            'sell_price' => $sellPrice,
            'ppn' => $req->ppn,
            'ppn_price' => $sellPrice == $ppnPrice ? 0 : $ppnPrice,
        ]);

        return redirect()->route('items.index');
    }

    public function destroy($id)
    {
        $items = Items::find($id);
        // $itemsDetail = ItemsDetail::find($items->detail_id);

        $items->hide = 1;
        $items->save();
        // $items->delete();
        // $itemsDetail->delete();
        return redirect()->route('items.index');
    }

    public function edit($id)
    {
        $items = Items::with('relationUnits', 'relationDetail')->find($id);
        $units = Units::all();
        return view('pages.master.barang.updateBarang', ['items' => $items, 'units' => $units]);
    }

    public function update($id, Request $req)
    {
        $this->validate($req, [
            'name' => 'required',
            'stock' => 'required|numeric|integer|min:1',
            'limit' => 'required|numeric|integer|min:1',
            'units' => 'required',
            'price' => 'required',
            'ppn' => 'required|numeric|integer',
            'profit' => 'nullable|numeric|max:100',
            'sell_price' => 'required',
        ]);

        $items = Items::find($id);

        // Stored Items
        $items->name = $req->name;
        $items->unit_id = $req->units;
        $items->stock = $this->PublicController->removeComma($req->stock);
        $items->info = $req->info;
        $items->limit = $req->limit;

        $sellPrice = $this->PublicController->checkPricePPN(
            $this->PublicController->removeComma($req->price),
            $req->ppn,
            $req->profit
        );

        $ppnPrice = $this->checkPPN($req->price, $req->ppn);

        if ($items->detail_id == null) {
            // Stored Items
            ItemsDetail::create([
                'price' => $this->PublicController->removeComma($req->price),
                'profit' => $req->profit,
                'profit_nom' => $this->PublicController->removeComma($req->profit_nom),
                'sell_price' => $sellPrice,
                'ppn' => $req->ppn,
                'ppn_price' => $sellPrice == $ppnPrice ? 0 : $ppnPrice,
            ]);

            $count = DB::table('d_items')
                ->select('id')
                ->orderByDesc('id')
                ->limit('1')
                ->first()->id;
            $items->detail_id = $count;
        } else {
            $itemsDetail = ItemsDetail::find($items->detail_id);

            // Stored Items
            $itemsDetail->price = $this->PublicController->removeComma($req->price);
            $itemsDetail->profit = $req->profit;
            $itemsDetail->profit_nom = $this->PublicController->removeComma($req->profit_nom);
            $itemsDetail->sell_price = $sellPrice;
            $itemsDetail->ppn = $req->ppn;
            $itemsDetail->ppn_price = $sellPrice == $ppnPrice ? 0 : $ppnPrice;

            $itemsDetail->save();
        }

        // Saved Datas
        $items->save();
        return redirect()->route('items.index');
    }

    function checkPPN($price, $ppn)
    {
        $price = $this->PublicController->removeComma($price);
        $price = $ppn == 1 ? $price + ($price * 10 / 100) : $price;
        return $price;
    }
}
