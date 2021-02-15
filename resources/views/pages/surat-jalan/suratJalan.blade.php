@extends('layouts.default')
@section('title', __('pages.title').__(' | Master Surat Jalan'))
@section('titleContent', __('Surat Jalan'))

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('tdoc.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Surat Jalan') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="surat-jalan" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('Kode') }}
                    </th>
                    <th>{{ __('Kode Customer') }}</th>
                    <th>{{ __('Kode Penawaran') }}</th>
                    <th>{{ __('Tanggal') }}</th>
                    <th>{{ __('Driver') }}</th>
                    <th>{{ __('Nomor Polisi') }}</th>
                    <th>
                        {{ __('Keterangan') }}
                    </th>
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
                    <td>{{ __('Rp.').number_format($b->gt) }}</td>
                    <td>{{ __('Rp.').number_format($b->gt) }}</td>
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
<script src="{{ asset('pages/surat-jalan/surat-jalan.js') }}"></script>
@endsection