@extends('layouts.default')
@section('title', __('pages.title').__(' | Master Pembelian'))
@section('titleContent', __('Pembelian'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Transaksi') }}</div>
<div class="breadcrumb-item active">{{ __('Pembelian') }}</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('purchase.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Transaksi Pembelian') }}</a>
    </div>
    <div class="card-body">
        @if ($count == 0)
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
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Harga Diskon') }}</th>
                    <th>{{ __('Diskon') }}</th>
                    <th>{{ __('Pajak') }}</th>
                    <th>{{ __('PPN') }}</th>
                    <th>{{ __('Uang Muka') }}</th>
                    <th>{{ __('Harga') }}</th>
                    <th>{{ __('Biaya Kirim') }}</th>
                    <th>{{ __('Biaya Lain') }}</th>
                    <th>{{ __('Kode Supplier') }}</th>
                    <th>{{ __('Tanggal') }}</th>
                    <th>{{ __('Keterangan') }}</th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchase as $number => $p)
                <tr>
                    <td class="text-center">
                        {{ $number+1 }}
                    </td>
                    <td>{{ $p->relationPurchase->code }}</td>
                    <td>{{ $p->relationItems->code }}</td>
                    <td>
                        <span class="badge badge-info">
                            {{ $p->relationPurchase->status }}
                        </span>
                    </td>
                    <td>{{ $p->total.__(" Items") }}</td>
                    <td>{{ __('Rp.').number_format(json_decode($p->relationPurchase->dsc)[0]) }}</td>
                    <td>
                        {{ __('Rp.').number_format(json_decode($p->relationPurchase->dsc)[1])." / ".json_decode($p->relationPurchase->dsc)[2].__('%') }}
                    </td>
                    <td>{{ __('Rp.').number_format($p->relationPurchase->tax) }}</td>
                    <td>
                        @if ($p->relationPurchase->ppn == 1)
                        <span class="badge badge-success">{{ __('YA') }}</span>
                        @else
                        <span class="badge badge-danger">{{ __('TIDAK') }}</span>
                        @endif
                    </td>
                    <td>{{ __('Rp.').number_format($p->relationPurchase->dp) }}</td>
                    <td>{{ __('Rp.').number_format($p->price) }}</td>
                    <td>{{ __('Rp.').number_format($p->relationPurchase->ship_price) }}</td>
                    <td>{{ __('Rp.').number_format($p->relationPurchase->etc_price) }}</td>
                    <td>{{ $p->relationSupplier->code }}</td>
                    <td>{{ date("d-M-Y", strtotime($p->tgl)) }}</td>
                    <td>
                        @if ($p->relationPurchase->info != null)
                        {{ $p->relationPurchase->info }}
                        @else
                        {{ __('Kosong') }}
                        @endif
                    </td>
                    <td>
                        <form id="del-data{{ $p->id }}" action="{{ route('purchase.destroy',$p->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-action mb-1 mt-1" data-toggle="tooltip" title="Delete"
                                data-confirm="Apakah Anda Yakin?|Aksi ini tidak dapat dikembalikan. Apakah ingin melanjutkan?"
                                data-confirm-yes="document.getElementById('del-data{{ $p->id }}').submit();"><i
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