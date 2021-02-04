<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Units;

class UnitsController extends Controller
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
        $units = Units::all();
        return view('pages.master.satuan.satuan', ['units' => $units]);
    }

    public function create()
    {
        return view('pages.master.satuan.createSatuan');
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'name' => 'required',
        ]);

        Units::create([
            'name' => $req->name
        ]);

        return redirect()->route('units.index');
    }

    public function delete($id)
    {
        $units = Units::find($id);
        $units->delete();
        return redirect()->route('units.index');
    }

    public function edit($id)
    {
        $units = Units::find($id);
        return view('pages.master.satuan.updateSatuan', ['units' => $units]);
    }

    public function update($id, Request $req)
    {
        $this->validate($req, [
            'name' => 'required',
        ]);

        $units = Units::find($id);

        // Stored Units
        $units->name = $req->name;

        // Saved Datas
        $units->save();
        return redirect()->route('units.index');
    }
}
