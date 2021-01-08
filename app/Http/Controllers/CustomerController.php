<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\CustomerDetail;
use App\Http\Controllers\PublicController;

class CustomerController extends Controller
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
        $customer = Customer::with('relationDetail')->get();
        return view('pages.master.customer.customer', ['customer' => $customer]);
    }

    public function create()
    {
        $code = "C-" . str_pad($this->PublicController->getRandom('customer'), 5, '0', STR_PAD_LEFT);
        $customer = Customer::all();
        return view('pages.master.customer.createCustomer', ['code' => $code, 'customer' => $customer]);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'code' => 'required',
            'name' => 'required',
            'tlp' => 'required',
            'city' => 'required',
            'province' => 'required',
            'pos' => 'required'
        ]);

        // $array = json_encode(array($req->city, $req->province, $req->pos));
        // $test = json_decode($array);
        // dd($test[4]);

        $count = $this->PublicController->countID('customer');

        Customer::create([
            'name' => $req->name,
            'code' => $req->code,
            'address' => $this->PublicController->createJSON($req->city, $req->province, $req->pos),
            'tlp' => $req->tlp,
            'detail_id' => $count
        ]);

        CustomerDetail::create([
            'id' => $count,
            'email' => $req->email,
            'fax' => $req->fax,
            'no_rek' => $req->no_rek,
            'name_rek' => $req->name_rek,
            'bank' => $req->bank,
            'npwp' => $req->npwp,
            'info' => $req->info
        ]);

        return redirect()->route('masterCustomer');
    }

    public function delete($id)
    {
        $customer = Customer::find($id);
        $customerDetail = CustomerDetail::find($customer->detail_id);

        $customer->delete();
        $customerDetail->delete();
        return redirect()->route('masterCustomer');
    }

    public function edit($id)
    {
        $customer = Customer::with('relationDetail')->find($id);
        return view('pages.master.customer.updateCustomer', ['customer' => $customer]);
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
}
