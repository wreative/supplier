@extends('layouts.default')
@section('title', __('pages.title').__(' | Master Customer'))
@section('titleContent', __('Customer'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Customer') }}</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('createCustomer') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Customer') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="customer" width="100%">
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
                    <th>{{ __('No Rekening') }}</th>
                    <th>{{ __('Nama Rekening') }}</th>
                    <th>{{ __('Bank') }}</th>
                    <th>{{ __('NPWP') }}</th>
                    <th>{{ __('Info') }}</th>
                    <th>{{ __('Kode Sales') }}</th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customer as $c)
                <tr>
                    <td class="text-center">
                        {{ $c->code }}
                    </td>
                    <td>{{ $c->name }}</td>
                    <td>{{ 
                    __('Kota ').json_decode($c->address)[0].
                    __(', Provinsi ').json_decode($c->address)[1].
                    __(', Kode Pos ').json_decode($c->address)[2] 
                    }}</td>
                    <td>{{ $c->tlp }}</td>
                    <td>{{ $c->relationDetail->email }}</td>
                    <td>{{ $c->relationDetail->fax }}</td>
                    <td>{{ $c->relationDetail->no_rek }}</td>
                    <td>{{ $c->relationDetail->name_rek }}</td>
                    <td>{{ $c->relationDetail->bank }}</td>
                    <td>{{ $c->relationDetail->npwp }}</td>
                    <td>
                        @if ($c->info != null)
                        {{ $c->info }}
                        @else
                        {{ __('Kosong') }}
                        @endif
                    </td>
                    <td>{{ $c->relationSales->code }}</td>
                    <td>
                        <a href="/customer/edit/{{ $c->id }}" class="btn btn-primary btn-action mb-1 mt-1 mr-1"
                            data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-danger btn-action mb-1 mt-1" style="cursor: pointer" data-toggle="tooltip"
                            title="Delete"
                            data-confirm="Apakah Anda Yakin?|Aksi ini tidak dapat dikembalikan. Apakah ingin melanjutkan?"
                            data-confirm-yes="window.open('/customer/delete/{{ $c->id }}','_self')"><i
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
<script src="{{ asset('pages/customer/customer.js') }}"></script>
@endsection