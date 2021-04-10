<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marketer;
use Illuminate\Support\Facades\Redirect;

class MarketerController extends Controller
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
        $sales = Marketer::all();
        return view('pages.data.marketer.indexMarketer', ['sales' => $sales]);
    }

    public function create()
    {
        $sales = Marketer::all();
        return view('pages.data.marketer.indexMarketer', [
            'code' => $this->generateCode(), 'sales' => $sales
        ]);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            // 'code' => 'required',
            'name' => 'required',
            'tlp' => 'required',
        ]);

        $code = $req->code == null ? $this->generateCode() : $req->code;

        Marketer::create([
            'name' => $req->name,
            'code' => $code,
            'tlp' => $req->tlp,
        ]);

        return $req->code == null ? Redirect::route('sales.create')
            : Redirect::route('marketer.index');
    }

    public function destroy($id)
    {
        $sales = Marketer::find($id);

        $sales->delete();
        return Redirect::route('marketer.index');
    }

    public function edit($id)
    {
        $sales = Marketer::find($id);
        return view('pages.data.marketer.updateMarketer', ['sales' => $sales]);
    }

    public function update($id, Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'name' => 'required',
            'tlp' => 'required',
        ]);

        $sales = Marketer::find($id);

        // Stored Sales
        $sales->code = $req->code;
        $sales->name = $req->name;
        $sales->tlp = $req->tlp;

        // Saved Datas
        $sales->save();
        return Redirect::route('marketer.index');
    }

    function generateCode()
    {
        $code = "SA-" . str_pad($this->PublicController->getRandom('marketer'), 5, '0', STR_PAD_LEFT);
        return $code;
    }
}
