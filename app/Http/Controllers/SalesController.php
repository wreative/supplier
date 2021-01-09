<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;

class SalesController extends Controller
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
        $sales = Sales::all();
        return view('pages.master.sales.sales', ['sales' => $sales]);
    }

    public function create()
    {
        $code = "SA-" . str_pad($this->PublicController->getRandom('sales'), 5, '0', STR_PAD_LEFT);
        $sales = Sales::all();
        return view('pages.master.sales.createSales', ['code' => $code, 'sales' => $sales]);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'name' => 'required',
            'tlp' => 'required',
        ]);

        Sales::create([
            'name' => $req->name,
            'code' => $req->code,
            'tlp' => $req->tlp,
        ]);

        return redirect()->route('masterSales');
    }

    public function delete($id)
    {
        $sales = Sales::find($id);

        $sales->delete();
        return redirect()->route('masterSales');
    }

    public function edit($id)
    {
        $sales = Sales::find($id);
        return view('pages.master.sales.updateSales', ['sales' => $sales]);
    }

    public function update($id, Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'name' => 'required',
            'tlp' => 'required',
        ]);

        $sales = Sales::find($id);

        // Stored Sales
        $sales->code = $req->code;
        $sales->name = $req->name;
        $sales->tlp = $req->tlp;

        // Saved Datas
        $sales->save();
        return redirect()->route('masterSupplier');
    }
}
