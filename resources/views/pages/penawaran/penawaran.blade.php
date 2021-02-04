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
                    <th>{{ __('Nama') }}</th>
                    <th>{{ __('Telepon') }}</th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($sales as $s)
                <tr>
                    <td class="text-center">
                        {{ $s->code }}
                </td>
                <td>{{ $s->name }}</td>
                <td>{{ $s->tlp }}</td>
                <td>
                    <a href="/marketer/edit/{{ $s->id }}" class="btn btn-primary btn-action mb-1 mt-1 mr-1"
                        data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                    <a class="btn btn-danger btn-action mb-1 mt-1" style="cursor: pointer" data-toggle="tooltip"
                        title="Delete"
                        data-confirm="Apakah Anda Yakin?|Aksi ini tidak dapat dikembalikan. Apakah ingin melanjutkan?"
                        data-confirm-yes="window.open('/marketer/delete/{{ $s->id }}','_self')"><i
                            class="fas fa-trash"></i></a>
                </td>
                </tr>
                @endforeach --}}
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('pages/sales/sales.js') }}"></script>
@endsection