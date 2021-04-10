@extends('layouts.default')
@section('title', __('pages.title').__(' | Master Penjualan'))
@section('titleContent', __('Penjualan'))
@section('breadcrumb', __('Transaksi'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Penjualan') }}</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('sales.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Transaksi Penjualan') }}</a>
    </div>
    <div class="card-body">
        @if($count == 0)
        <h4 class="text-center">{{ __('DATA KOSONG') }}</h4>
        @else
        <table class="table-striped table" id="transaction" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th>{{ __('No Transaksi') }}</th>
                    <th>{{ __('Kode Barang') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Diskon') }}</th>
                    <th>{{ __('Diskon Nominal') }}</th>
                    <th>{{ __('Diskon Persen') }}</th>
                    <th>{{ __('Pajak') }}</th>
                    <th>{{ __('PPN') }}</th>
                    <th>{{ __('Uang Muka') }}</th>
                    <th>{{ __('Harga') }}</th>
                    <th>{{ __('Biaya Kirim') }}</th>
                    <th>{{ __('Biaya Lain') }}</th>
                    <th>{{ __('Kode Customer') }}</th>
                    <th>{{ __('Kode Sales') }}</th>
                    <th>{{ __('Tanggal') }}</th>
                    <th>{{ __('Keterangan') }}</th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $number => $s)
                <tr>
                    <td class="text-center">
                        {{ $number+1 }}
                    </td>
                    <td>{{ $s->relationSales->code }}</td>
                    <td>{{ $s->relationItems->code }}</td>
                    <td>{{ $s->total.__(" Items") }}</td>
                    <td>{{ __('Rp.').number_format(json_decode($s->relationSales->dsc)[0]) }}</td>
                    <td>{{ __('Rp.').number_format(json_decode($s->relationSales->dsc)[1]) }}</td>
                    <td>{{ json_decode($s->relationSales->dsc)[2].__('%') }}</td>
                    <td>{{ __('Rp.').number_format($s->relationSales->tax) }}</td>
                    <td>
                        @if ($s->relationSales->ppn == 1)
                        <span class="badge badge-success">{{ __('YA') }}</span>
                        @else
                        <span class="badge badge-danger">{{ __('TIDAK') }}</span>
                        @endif
                    </td>
                    <td>{{ __('Rp.').number_format($s->relationSales->dp) }}</td>
                    <td>{{ __('Rp.').number_format($s->price) }}</td>
                    <td>{{ __('Rp.').number_format($p->relationSales->ship_price) }}</td>
                    <td>{{ __('Rp.').number_format($p->relationSales->etc_price) }}</td>
                    <td>{{ $s->relationCustomer->code }}</td>
                    <td>{{ $s->relationMarketer->code }}</td>
                    <td>{{ date("d-M-Y", strtotime($s->tgl)) }}</td>
                    <td>
                        @if ($s->relationSales->info != null)
                        {{ $s->relationSales->info }}
                        @else
                        {{ __('Kosong') }}
                        @endif
                    </td>
                    <td>
                        <form id="del-data{{ $s->id }}" action="{{ route('sales.destroy',$s->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-action mb-1 mt-1" data-toggle="tooltip" title="Delete"
                                data-confirm="Apakah Anda Yakin?|Aksi ini tidak dapat dikembalikan. Apakah ingin melanjutkan?"
                                data-confirm-yes="document.getElementById('del-data{{ $s->id }}').submit();"><i
                                    class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('pages/transaction/transaction.js') }}"></script>
@endsection