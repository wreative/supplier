<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerDetail;
use App\Http\Controllers\PublicController;
use App\Models\Sales;

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
        $customer = Customer::with('relationDetail', 'relationSales')->get();
        return view('pages.master.customer.customer', ['customer' => $customer]);
    }

    public function create()
    {
        $code = "C-" . str_pad($this->PublicController->getRandom('customer'), 5, '0', STR_PAD_LEFT);
        $customer = Customer::all();
        $sales = Sales::all();
        return view('pages.master.customer.createCustomer', ['code' => $code, 'customer' => $customer, 'sales' => $sales]);
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

        $count = $this->PublicController->countID('customer');

        Customer::create([
            'name' => $req->name,
            'code' => $req->code,
            'address' => $this->PublicController->createJSON($req->city, $req->province, $req->pos),
            'tlp' => $req->tlp,
            'detail_id' => $count,
            'sales_id' => $req->sales
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
            'name' => 'required',
            'tlp' => 'required',
            'city' => 'required',
            'province' => 'required',
            'pos' => 'required'
        ]);

        $customer = Customer::find($id);
        $customerDetail = CustomerDetail::find($customer->detail_id);

        // Stored Customer
        $customer->code = $req->code;
        $customer->name = $req->name;
        $customer->code = $req->code;
        $customer->address = $this->PublicController->createJSON($req->city, $req->province, $req->pos);
        $customer->tlp = $req->tlp;
        $customer->sales_id = $req->sales;

        // Stored Customer Detail
        $customerDetail->email = $req->email;
        $customerDetail->fax = $req->fax;
        $customerDetail->no_rek = $req->no_rek;
        $customerDetail->name_rek = $req->name_rek;
        $customerDetail->bank = $req->bank;
        $customerDetail->npwp = $req->npwp;
        $customerDetail->info = $req->info;

        // Saved Datas
        $customer->save();
        $customerDetail->save();
        return redirect()->route('masterCustomer');
    }
}
