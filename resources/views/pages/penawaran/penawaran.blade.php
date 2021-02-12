@extends('layouts.default')
@section('title', __('pages.title').__(' | Master Penawaran'))
@section('titleContent', __('Penawaran'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Penawaran') }}</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('bidding.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Penawaran') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="penawaran" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('Kode') }}
                    </th>
                    <th>{{ __('Kode Customer') }}</th>
                    <th>{{ __('Tanggal') }}</th>
                    <th>{{ __('Diskon Nominal') }}</th>
                    <th>{{ __('Diskon Persen') }}</th>
                    <th>{{ __('PPN') }}</th>
                    <th>{{ __('Biaya Kirim') }}</th>
                    <th>{{ __('Biaya Packing') }}</th>
                    <th>{{ __('Grand Total') }}</th>
                    <th>{{ __('Keterangan') }}</th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bidding as $b)
                <tr>
                    <td class="text-center">
                        {{ $b->code }}
                    </td>
                    <td>{{ $b->relationCustomer->code }}</td>
                    <td>{{ date("d-M-Y", strtotime($b->date)) }}</td>
                    <td>{{ __('Rp.').number_format(json_decode($b->dsc)[0]) }}</td>
                    <td>
                        @if(json_decode($b->dsc)[1] == "")
                        {{ __('0%') }}
                        @else
                        {{ json_decode($b->dsc)[1].__('%') }}
                        @endif
                    </td>
                    <td>
                        @if ($b->ppn == 1)
                        <span class="badge badge-success">{{ __('YA') }}</span>
                        @else
                        <span class="badge badge-danger">{{ __('TIDAK') }}</span>
                        @endif
                    </td>
                    <td>{{ __('Rp.').number_format(json_decode($b->cost)[0]) }}</td>
                    <td>{{ __('Rp.').number_format(json_decode($b->cost)[1]) }}</td>
                    <td>{{ __('Rp.').number_format($b->gt) }}</td>
                    <td>
                        @if ($b->info != null)
                        {{ $b->info }}
                        @else
                        {{ __('Kosong') }}
                        @endif
                    </td>
                    <td>
                        <button onclick="getItem({{ $b->id }})" class="btn btn-primary btn-action mb-1 mt-1 mr-1"
                            data-toggle="tooltip" title="Lihat data barang"><i class="fas fa-eye"></i></button>
                        <form id="del-data" action="{{ route('bidding.destroy',$b->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-action mb-1 mt-1" data-toggle="tooltip" title="Delete"
                                data-confirm="Apakah Anda Yakin?|Aksi ini tidak dapat dikembalikan. Apakah ingin melanjutkan?"
                                data-confirm-yes="document.getElementById('del-data').submit();"><i
                                    class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('pages/penawaran/penawaran.js') }}"></script>
@endsection