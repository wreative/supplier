<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bidding;
use App\Models\TravelDocument;
use Illuminate\Support\Facades\DB;


class TravelDocumentController extends Controller
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
        $travelDocument = DB::table('travel_doc')
            ->select(DB::raw('travel_doc.*,customer.code as c_code,bidding.code as b_code'))
            ->join('bidding', 'travel_doc.bid_id', '=', 'bidding.id')
            ->join('customer', 'bidding.cus_id', '=', 'customer.id')
            ->get();
        return view('pages.surat-jalan.suratJalan', ['travelDocument' => $travelDocument]);
    }

    public function create()
    {
        return view('pages.surat-jalan.createSuratJalan', [
            'code' => $this->createCode(),
            'bidding' => Bidding::all()
        ]);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'sp' => 'required',
        ]);

        // Stored data
        TravelDocument::create([
            'code' => $req->code,
            'bid_id' => $req->sp,
            'date' => date("Y-m-d"),
            'driver' => $req->driver,
            'police_num' => $req->police_num,
            'info' => $req->info,
            'print' => '0',
        ]);

        return redirect()->route('tdoc.index');
    }

    public function destroy($id)
    {
        $travelDocument = TravelDocument::find($id);
        $travelDocument->delete();
        return redirect()->route('tdoc.index');
    }

    function createCode()
    {
        return $this->PublicController->getRandom('travel_doc') .
            "/SS/BB/" . date("m") . "/" . date("Y");
    }
}
