@extends('layouts.default')
@section('title', __('pages.title').__(' | Master Supplier'))
@section('titleContent', __('Supplier'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Supplier') }}</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('createSupplier') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Supplier') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="supplier" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('Kode') }}
                    </th>
                    <th>{{ __('Nama') }}</th>
                    <th>{{ __('Alamat') }}</th>
                    <th>{{ __('Telepon') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Fax') }}</th>
                    <th>{{ __('Nama Sales') }}</th>
                    <th>{{ __('Telepon Sales') }}</th>
                    <th>{{ __('No Rekening') }}</th>
                    <th>{{ __('Nama Rekening') }}</th>
                    <th>{{ __('Bank') }}</th>
                    <th>{{ __('NPWP') }}</th>
                    <th>{{ __('Info') }}</th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($supplier as $s)
                <tr>
                    <td class="text-center">
                        {{ $s->code }}
                    </td>
                    <td>{{ $s->name }}</td>
                    <td>{{ 
                    __('Kota ').json_decode($s->address)[0].
                    __(', Provinsi ').json_decode($s->address)[1].
                    __(', Kode Pos ').json_decode($s->address)[2] 
                    }}</td>
                    <td>{{ $s->tlp }}</td>
                    <td>{{ $s->relationDetail->email }}</td>
                    <td>{{ $s->relationDetail->fax }}</td>
                    <td>
                        @isset($s->relationDetail->sales)
                        {{ json_decode($s->relationDetail->sales)[0] }}
                        @endisset
                    </td>
                    <td>
                        @isset($s->relationDetail->sales)
                        {{ json_decode($s->relationDetail->sales)[1] }}
                        @endisset
                    </td>
                    <td>{{ $s->relationDetail->no_rek }}</td>
                    <td>{{ $s->relationDetail->name_rek }}</td>
                    <td>{{ $s->relationDetail->bank }}</td>
                    <td>{{ $s->relationDetail->npwp }}</td>
                    <td>
                        @if ($s->info != null)
                        {{ $s->info }}
                        @else
                        {{ __('Kosong') }}
                        @endif
                    </td>
                    <td>
                        <a href="/supplier/edit/{{ $s->id }}" class="btn btn-primary btn-action mb-1 mt-1 mr-1"
                            data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-danger btn-action mb-1 mt-1" style="cursor: pointer" data-toggle="tooltip"
                            title="Delete"
                            data-confirm="Apakah Anda Yakin?|Aksi ini tidak dapat dikembalikan. Apakah ingin melanjutkan?"
                            data-confirm-yes="window.open('/supplier/delete/{{ $s->id }}','_self')"><i
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
<script src="{{ asset('pages/supplier/supplier.js') }}"></script>
@endsection