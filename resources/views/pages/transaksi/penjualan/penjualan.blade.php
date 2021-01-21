@extends('layouts.default')
@section('title', __('pages.title').__(' | Master Penjualan'))
@section('titleContent', __('Penjualan'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Transaksi') }}</div>
<div class="breadcrumb-item active">{{ __('Penjualan') }}</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('createSales') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Transaksi Penjualan') }}</a>
    </div>
    <div class="card-body">
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
                    <th>{{ __('Uang Muka') }}</th>
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
                    <td>{{ __('Rp.').number_format($s->relationSales->dp) }}</td>
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
                        <a class="btn btn-danger btn-action mb-1 mt-1" style="cursor: pointer" data-toggle="tooltip"
                            title="Delete" data-confirm="Apakah Anda Yakin?|Aksi ini tidak dapat dikembalikan dan 
                            mengembalikan perubahan yang sebelumnya. Apakah ingin melanjutkan?"
                            data-confirm-yes="window.open('/sales/delete/{{ $s->id }}','_self')"><i
                                class="fas fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('pages/transaction/transaction.js') }}"></script>
@endsection