<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PublicController;
use App\Models\Supplier;
use App\Models\SupplierDetail;

class SupplierController extends Controller
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
        $supplier = Supplier::with('relationDetail')->get();
        return view('pages.master.supplier.supplier', ['supplier' => $supplier]);
    }

    public function create()
    {
        $code = "SU-" . str_pad($this->PublicController->getRandom('customer'), 5, '0', STR_PAD_LEFT);
        $supplier = Supplier::all();
        return view('pages.master.supplier.createSupplier', ['code' => $code, 'supplier' => $supplier]);
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

        $count = $this->PublicController->countID('supplier');

        Supplier::create([
            'name' => $req->name,
            'code' => $req->code,
            'address' => $this->PublicController->createJSON($req->city, $req->province, $req->pos),
            'tlp' => $req->tlp,
            'detail_id' => $count
        ]);

        SupplierDetail::create([
            'id' => $count,
            'email' => $req->email,
            'fax' => $req->fax,
            'sales' => $this->PublicController->createJSON2($req->sales_name, $req->sales_tlp),
            'no_rek' => $req->no_rek,
            'name_rek' => $req->name_rek,
            'bank' => $req->bank,
            'npwp' => $req->npwp,
            'info' => $req->info
        ]);

        return redirect()->route('masterSupplier');
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id);
        $supplierDetail = SupplierDetail::find($supplier->detail_id);

        $supplier->delete();
        $supplierDetail->delete();
        return redirect()->route('masterSupplier');
    }

    public function edit($id)
    {
        $supplier = Supplier::with('relationDetail')->find($id);
        return view('pages.master.supplier.updateSupplier', ['supplier' => $supplier]);
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

        $supplier = Supplier::find($id);
        $supplierDetail = SupplierDetail::find($supplier->detail_id);

        // Stored Customer
        $supplier->code = $req->code;
        $supplier->name = $req->name;
        $supplier->code = $req->code;
        $supplier->address = $this->PublicController->createJSON($req->city, $req->province, $req->pos);
        $supplier->tlp = $req->tlp;

        // Stored Customer Detail
        $supplierDetail->email = $req->email;
        $supplierDetail->fax = $req->fax;
        $supplierDetail->sales = $this->PublicController->createJSON2($req->sales_name, $req->sales_tlp);
        $supplierDetail->no_rek = $req->no_rek;
        $supplierDetail->name_rek = $req->name_rek;
        $supplierDetail->bank = $req->bank;
        $supplierDetail->npwp = $req->npwp;
        $supplierDetail->info = $req->info;

        // Saved Datas
        $supplier->save();
        $supplierDetail->save();
        return redirect()->route('masterSupplier');
    }
}
