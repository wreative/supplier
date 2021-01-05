<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Items;
use App\Models\Units;
use App\Models\Transaction;

class TransactionController extends Controller
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
        $transaction = Transaction::with('relationItems', 'relationUnits')->get();
        return view('pages.transaksi.transaksi', ['transaction' => $transaction]);
    }

    public function create()
    {
        $code = "TS-" . $this->getRandom();
        $units = Units::all();
        $items = Items::all();
        return view('pages.transaksi.createTransaksi', ['code' => $code, 'units' => $units, 'items' => $items]);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'total' => 'required|numeric|integer|min:1',
            'units' => 'required',
            'items' => 'required',
            'type' => 'required',
            'tgl' => 'required|date'
        ]);

        $this->calculateStock($req->items, $req->units, $req->type, $req->total);

        $items = Items::find($req->items);
        $units = Items::find($req->units);

        Transaction::create([
            'items_id' => $items->id,
            'total' => $req->total,
            'code' => $req->code,
            'tgl' => $req->tgl,
            'type' => $req->type,
            'unit_id' => $units->id,
            'info' => $req->info
        ]);

        return redirect()->route('masterTransaction');
    }

    public function delete($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        return redirect()->route('masterTransaction');
    }

    public function edit($id)
    {
        $transaction = Transaction::find($id);
        $units = Units::all();
        $items = Items::all();
        return view('pages.transaksi.updateTransaksi', ['items' => $items, 'units' => $units, 'transaction' => $transaction]);
    }

    public function update($id, Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'total' => 'required|numeric|integer|min:1',
            'units' => 'required',
            'items' => 'required',
            'type' => 'required',
            'tgl' => 'required|date'
        ]);

        $transaction = Transaction::find($id);

        // Stored Items
        $transaction->code = $req->code;
        $transaction->total = $req->total;
        $transaction->unit_id = $req->units;
        $transaction->items_id = $req->items;
        $transaction->tgl = $req->tgl;
        $transaction->type = $req->type;
        $transaction->info = $req->info;

        // Saved Datas
        $transaction->save();
        return redirect()->route('masterTransaction');
    }

    public function getRandom()
    {
        do {
            $random = rand(00001, 99999);
            $check = DB::table('transaction')
                ->select('code')
                ->having('code', '=', $random)
                ->first();
        } while ($check != null);
        return $random;
    }

    public function calculateStock($items, $units, $type, $total)
    {
        $items = Items::find($items);
        $units = Items::find($units);

        $totalItems = $type == 'Keluar' ?
            $items->stock - $total :
            $items->stock + $total;

        $items->stock = $totalItems;
        $items->save();
    }
}
