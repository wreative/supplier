@extends('layouts.default')
@section('title', __('pages.title').__(' | Master Transaksi'))
@section('titleContent', __('Transaksi'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Transaksi') }}</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('createTransaction') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Transaksi') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="transaction" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th>{{ __('No Transaksi') }}</th>
                    <th>{{ __('Barang') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Tanggal') }}</th>
                    <th>{{ __('Tipe Transaksi') }}</th>
                    <th>{{ __('Satuan') }}</th>
                    <th>{{ __('Keterangan') }}</th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction as $number => $t)
                <tr>
                    <td class="text-center">
                        {{ $number+1 }}
                    </td>
                    <td>{{ $t->code }}</td>
                    <td>{{ $t->relationItems->name }}</td>
                    <td>{{ $t->total }}</td>
                    <td>{{ date("d-M-Y", strtotime($t->tgl)) }}</td>
                    <td>{{ $t->type }}</td>
                    <td>{{ $t->relationUnits->name }}</td>
                    <td>
                        @if ($t->info != null)
                        {{ $t->info }}
                        @else
                        {{ __('Kosong') }}
                        @endif
                    </td>
                    <td>
                        <a href="/transaction/edit/{{ $t->id }}" class="btn btn-primary btn-action mb-1 mt-1 mr-1"
                            data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-danger btn-action mb-1 mt-1" style="cursor: pointer" data-toggle="tooltip"
                            title="Delete"
                            data-confirm="Apakah Anda Yakin?|Aksi ini tidak dapat dikembalikan. Apakah ingin melanjutkan?"
                            data-confirm-yes="window.open('/transaction/delete/{{ $t->id }}','_self')"><i
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