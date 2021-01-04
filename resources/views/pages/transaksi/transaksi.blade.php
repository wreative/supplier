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
        <table class="table-striped table" id="karyawan" width="100%">
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
                </tr>
            </thead>
            <tbody>
                @foreach($items as $number => $u)
                <tr>
                    <td class="text-center">
                        {{ $number+1 }}
                    </td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->name }}</td>
                    <td>
                        <a href="/transaction/edit/{{ $u->id }}" class="btn btn-primary btn-action mb-1 mt-1 mr-1"
                            data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-danger btn-action mb-1 mt-1" style="cursor: pointer" data-toggle="tooltip"
                            title="Delete"
                            data-confirm="Apakah Anda Yakin?|Aksi ini tidak dapat dikembalikan. Apakah ingin melanjutkan?"
                            data-confirm-yes="window.open('/transaction/delete/{{ $u->id }}','_self')"><i
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
<script src="{{ asset('pages/karyawan/karyawan.js') }}"></script>
@endsection