@extends('layouts.default')
@section('title', __('pages.title').__(' | Master Barang'))
@section('titleContent', __('Barang'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Barang') }}</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('createItems') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Barang') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="items" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th class="text-center">
                        {{ __('Kode') }}
                    </th>
                    <th>{{ __('Nama') }}</th>
                    <th>{{ __('Stock') }}</th>
                    <th>{{ __('Units') }}</th>
                    <th>{{ __('Harga Include PPN') }}</th>
                    <th>{{ __('Harga Exclude PPN') }}</th>
                    <th>{{ __('Keuntungan') }}</th>
                    <th>{{ __('Harga Jual') }}</th>
                    <th>{{ __('Keterangan') }}</th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $number => $i)
                <tr>
                    <td class="text-center">
                        {{ $number+1 }}
                    </td>
                    <td class="text-center">
                        {{ $i->code }}
                    </td>
                    <td>{{ $i->name }}</td>
                    <td>{{ $i->stock }}</td>
                    <td>{{ $i->relationUnits->name }}</td>
                    <td>{{ __('Rp.').number_format($i->relationDetail->price_inc) }}</td>
                    <td>{{ __('Rp.').number_format($i->relationDetail->price_exc) }}</td>
                    <td>{{ $i->relationDetail->profit.__('%') }}</td>
                    <td>{{ __('Rp.').number_format($i->relationDetail->price) }}</td>
                    <td>
                        @if ($i->info != null)
                        {{ $i->info }}
                        @else
                        {{ __('Kosong') }}
                        @endif
                    </td>
                    <td>
                        <a href="/items/edit/{{ $i->id }}" class="btn btn-primary btn-action mb-1 mt-1 mr-1"
                            data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-danger btn-action mb-1 mt-1" style="cursor: pointer" data-toggle="tooltip"
                            title="Delete"
                            data-confirm="Apakah Anda Yakin?|Aksi ini tidak dapat dikembalikan. Apakah ingin melanjutkan?"
                            data-confirm-yes="window.open('/items/delete/{{ $i->id }}','_self')"><i
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
<script src="{{ asset('pages/items/items.js') }}"></script>
@endsection