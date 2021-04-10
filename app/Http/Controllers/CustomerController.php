<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerDetail;
use App\Http\Controllers\PublicController;
use App\Models\Marketer;
use Illuminate\Support\Facades\Redirect;

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
        $customer = Customer::with('relationDetail', 'relationMarketer')->get();
        return view('pages.data.customer.indexCustomer', ['customer' => $customer]);
    }

    public function create()
    {
        $customer = Customer::all();
        $marketer = Marketer::all();
        return view('pages.data.customer.createCustomer', [
            'code' => $this->generateCode(), 'customer' => $customer, 'marketer' => $marketer
        ]);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            // 'code' => 'required',
            'name' => 'required',
            'tlp' => 'required',
            'city' => 'required',
            'province' => 'required',
            'pos' => 'required',
        ]);

        $count = $this->PublicController->countID('customer');
        $code = $req->code == null ? $this->generateCode() : $req->code;

        Customer::create([
            'name' => $req->name,
            'code' => $code,
            'address' => $this->PublicController->createJSON($req->city, $req->province, $req->pos),
            'tlp' => $req->tlp,
            'detail_id' => $count,
            'sales_id' => $req->marketer
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

        return $req->code == null ? Redirect::route('sales.create')
            : Redirect::route('customer.index');
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customerDetail = CustomerDetail::find($customer->detail_id);

        $customer->delete();
        $customerDetail->delete();
        return Redirect::route('customer.index');
    }

    public function edit($id)
    {
        $customer = Customer::with('relationDetail', 'relationMarketer')->find($id);
        // dd($customer);
        $marketer = Marketer::all();
        return view('pages.data.customer.updateCustomer', [
            'customer' => $customer,
            'marketer' => $marketer
        ]);
    }

    public function update($id, Request $req)
    {
        $this->validate($req, [
            'name' => 'required',
            'tlp' => 'required',
            'city' => 'required',
            'province' => 'required',
            'pos' => 'required',
            'marketer' => 'required'
        ]);

        $customer = Customer::find($id);
        $customerDetail = CustomerDetail::find($customer->detail_id);

        // Stored Customer
        $customer->code = $req->code;
        $customer->name = $req->name;
        $customer->code = $req->code;
        $customer->address = $this->PublicController->createJSON($req->city, $req->province, $req->pos);
        $customer->tlp = $req->tlp;
        $customer->sales_id = $req->marketer;

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
        return Redirect::route('customer.index');
    }

    function generateCode()
    {
        $code = "C-" . str_pad($this->PublicController->getRandom('customer'), 5, '0', STR_PAD_LEFT);
        return $code;
    }
}
