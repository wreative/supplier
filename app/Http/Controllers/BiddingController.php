<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\Customer;
use App\Models\Bidding;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class BiddingController extends Controller
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
        return view('pages.penawaran.penawaran');
    }

    public function create()
    {
        $code = $this->createCode();
        $items = Items::all();
        $customer = Customer::all();
        return view('pages.penawaran.createPenawaran', [
            'code' => $code, 'items' => $items, 'customer' => $customer
        ]);
    }

    public function store(Request $req)
    {
        $items = Items::all();
        $customer = Customer::all();

        $this->validate($req, [
            'code' => 'required',
            'customer' => 'required',
            'ppn' => 'required|numeric|integer',
            // 'items' => 'required',

            // 'total' => 'required|numeric|integer|min:1',
            // 'dsc_per' => 'nullable|numeric|max:100',
            // 'tax' => 'numeric|max:100',
            // 'tgl' => 'required|date',
            // 'marketer' => 'required',            
        ]);
        // return Response()->json(['status' => 'error']);
        // dd($req->all());
        $items = $req->items;
        $total = $req->total;


        // return Response()->json(['status' => "nulled"]);
        if ($req->items == null) {
            return redirect()->route('bidding.create', [
                'code' => $this->createCode(), 'items' => $items, 'customer' => $customer
            ])->with(['status' => 'Pastikan sudah menambahkan barang minimal 1']);
        } else {
            $items = count($req->items);
        }

        // DB::beginTransaction();
        // try {
        //     // if ($req->hasFile('gambar')) {
        //     //     if (filesize($req->file('gambar')) > 2000000) {
        //     //         return Response()->json(['status' => 'big_image']);
        //     //     } else {
        //     //         $imagePath = $req->file('gambar');
        //     //         $fileName =  '/public/buku/buku_' . $req->id . '.' . $imagePath->getClientOriginalExtension();
        //     //         $fileNames =  'buku_' . $req->id . '.' . $imagePath->getClientOriginalExtension();
        //     //         Storage::put($fileName, file_get_contents($req->file('gambar')));
        //     //     }
        //     // } else {
        //     //     $fileName = $req->gambar_old;
        //     // }
        //     // if (filesize($req->file('gambar')) > 2000000) {
        //     //     return Response()->json(['status' => 'big_image']);
        //     // } elseif ($req->hasFile('gambar')) {
        //     //     $imagePath = $req->file('gambar');
        //     //     // $fileName =  '/public/buku/buku_' . $id . '.' . $imagePath->getClientOriginalExtension();
        //     //     $fileNames =  'buku_' . $req->id . '.' . $imagePath->getClientOriginalExtension();
        //     //     // Storage::put($fileName, file_get_contents($req->file('gambar')));
        //     //     $imagePath->move(public_path('storage/buku'), $fileNames);
        //     // } else {
        //     //     $fileNames = 'default.svg';
        //     // }

        //     // $this->model->buku()->where('mb_id', $req->id)->update([
        //     //     'mb_kategori' => $req->kategori,
        //     //     'mb_penerbit' => $req->penerbit,
        //     //     'mb_pengarang' => $req->pengarang,
        //     //     'mb_created_by' => Auth::user()->id,
        //     //     'mb_created_at' => date('Y-m-d H:i:s'),
        //     //     'mb_name' => $req->name,
        //     //     'mb_image' => $fileNames,
        //     //     'mb_desc' => $req->desc,
        //     //     'mb_pinjam' => $req->pinjam,
        //     // ]);

        //     // for ($i = 0; $i < count($req->isbn); $i++) {
        //     //     $this->model->buku_dt()->where('mbdt_status', 'TERSEDIA')->where('mbdt_id', $req->id)->delete();
        //     // }
        //     // for ($i = 0; $i < count($req->isbn); $i++) {
        //     //     if ($req->status[$i] == 'TERSEDIA') {
        //     //         $dt = $this->model->buku_dt()->where('mbdt_id', $req->id)->max('mbdt_dt') + 1;
        //     //         $this->model->buku_dt()->create([
        //     //             'mbdt_id'  => $req->id,
        //     //             'mbdt_dt'  => $dt,
        //     //             'mbdt_isbn' => $req->isbn[$i],
        //     //             'mbdt_status' => $req->status[$i],
        //     //             'mbdt_rak_buku_dt' => $req->kode_rak_dt[$i],
        //     //             'mbdt_kondisi' => $req->kondisi[$i],
        //     //         ]);
        //     //     }
        //     // }
        // dd(array_merge($req->items, $req->total));
        // foreach ($req->items as $items => $req->total) {
        //     $data2[] = [
        //         'id_items' => $items,
        //         'total' => $req->total
        //     ];
        // }
        for ($i = 0; $i <= count($req->items); $i++) {
            $items = [
                'id_items' => $req->items,
                'total' => $req->total
            ];
        }

        // $collection = collect($req->items);

        // $merged = $collection->merge($req->total);

        // dd($merged->all());


        Bidding::create([
            'code' => $req->code,
            'cus_id' => $req->customer,
            'items' => json_encode($items),
            'date' => date("Y-m-d"),
            'ppn' => $req->code,
            'dsc' => $req->customer,
            'gt' => $req->marketer,
            'info' => $req->marketer,
            'cost' => $req->marketer,
        ]);
        // DB::commit();

        //     // return Response()->json(['status' => 'sukses']);


        //     // all good
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     // something went wrong
        //     return Response()->json(['status' => 'nulled']);
        // }

        // $datas = $this->PublicController->calculate(
        //     $req->total,
        //     $req->items,
        //     $req->dsc_nom,
        //     $req->dsc_per,
        //     $req->dp,
        //     $req->ppn
        // );

        // $discount = $this->createJSON($datas[2], $datas[7], $datas[8]);
        // // $codeCustomer = Str::substr(Customer::find($req->customer)->code, 3, 5);
        // // $code = Str::replaceLast('CUS', $codeCustomer, $req->code);
        // $count = $this->PublicController->countID('sales');

        // $sellPrice = $this->PublicController->checkPricePPN(
        //     $datas[1],
        //     $req->ppn,
        //     $req->profit
        // );

        // Bidding::create([
        //     'items_id' => $req->items,
        //     's_id' => $count,
        //     'total' => $req->total,
        //     'tgl' => $req->tgl,
        //     'price' => $sellPrice,
        //     'cus_id' => $req->customer,
        //     'mar_id' => $req->marketer,
        // ]);

        // Sales::create([
        //     'id' => $count,
        //     'code' => $req->code,
        //     'dsc' => $discount,
        //     'info' => $req->info,
        //     'dp' => $datas[5],
        //     'tax' => $datas[4],
        //     'ppn' => $req->ppn
        // ]);

        // // Modify Stock Items
        // $items = Items::find($req->items);
        // $stock = $items->stock > $datas[3] ?
        //     $items->stock - $datas[3] :
        //     $datas[3] - $items->stock;
        // $items->stock = $stock;

        // // Saved Datas
        // $items->save();

        // return redirect()->route('bidding.index');
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $sales = Sales::find($transaction->p_id);
        $items = Items::find($transaction->items_id);
        $stock = $items->stock + $transaction->total;

        // Modification Data
        $items->stock = $stock;
        $items->save();
        // Deleted Data
        $sales->delete();
        $transaction->delete();

        return redirect()->route('bidding.index');
    }

    function createCode()
    {
        return "SP" . $this->PublicController->getRandom('bidding') . "/SS/BB/" . date("m") . "/" . date("Y");
    }
}
