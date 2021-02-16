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
                    <th>{{ __('Print') }}</th>
                    <th>
                        {{ __('Keterangan') }}
                    </th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($travelDocument as $td)
                <tr>
                    <td class="text-center">
                        {{ $td->code }}
                    </td>
                    <td>{{ $td->c_code }}</td>
                    <td>{{ $td->b_code }}</td>
                    <td>{{ date("d-M-Y", strtotime($td->date)) }}</td>
                    <td>{{ $td->driver }}</td>
                    <td>{{ $td->police_num }}</td>
                    <td>
                        @if ($td->print == 1)
                        <span class="badge badge-success">{{ __('PERNAH') }}</span>
                        @else
                        <span class="badge badge-danger">{{ __('TIDAK') }}</span>
                        @endif
                    </td>
                    <td>
                        @if ($td->info != null)
                        {{ $td->info }}
                        @else
                        {{ __('Kosong') }}
                        @endif
                    </td>
                    <td>
                        <button onclick="getItem({{ $td->id }})" class="btn btn-dark btn-action mb-1 mt-1 mr-1"
                            data-toggle="tooltip" title="Print"><i class="fas fa-print"></i></button>
                        <form id="del-data" action="{{ route('tdoc.destroy',$td->id) }}" method="POST" class="d-inline">
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