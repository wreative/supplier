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
        <a href="{{ route('items.create') }}" class="btn btn-icon icon-left btn-primary">
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
                    <th>{{ __('Harga Pokok') }}</th>
                    <th>{{ __('Include PPN') }}</th>
                    <th>{{ __('Harga PPN') }}</th>
                    <th>{{ __('Keuntungan Nominal') }}</th>
                    <th>{{ __('Keuntungan Persen') }}</th>
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
                    <td>{{ number_format($i->stock) }}</td>
                    <td>{{ $i->relationUnits->name }}</td>
                    <td>
                        @if($i->relationDetail != null)
                        {{ __('Rp.').number_format($i->relationDetail->price, 2) }}
                        @else
                        {{ __('Rp.0') }}
                        @endif
                    </td>
                    <td>
                        @if($i->relationDetail != null)
                        @if ($i->relationDetail->ppn == 1)
                        <span class="badge badge-success">{{ __('YA') }}</span>
                        @else
                        <span class="badge badge-danger">{{ __('TIDAK') }}</span>
                        @endif
                        @else
                        <span class="badge badge-info">{{ __('KOSONG') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($i->relationDetail == null || $i->relationDetail->ppn_price == null)
                        {{ __('Rp.0') }}
                        @else
                        {{ __('Rp.').number_format($i->relationDetail->ppn_price, 2) }}
                        @endif
                    </td>
                    <td>
                        @if($i->relationDetail == null || $i->relationDetail->profit_nom == null)
                        {{ __('Rp.0') }}
                        @else
                        {{ __('Rp.').number_format($i->relationDetail->ppn_price, 2) }}
                        @endif
                    </td>
                    <td>
                        @if($i->relationDetail == null || $i->relationDetail->profit == null)
                        {{ __('0%') }}
                        @else
                        {{ $i->relationDetail->profit.__('%') }}
                        @endif
                    </td>
                    <td>
                        @if($i->relationDetail != null)
                        {{ __('Rp.').number_format($i->relationDetail->sell_price, 2) }}
                        @else
                        {{ __('Rp.0') }}
                        @endif
                    </td>
                    <td>
                        @if ($i->info != null)
                        {{ $i->info }}
                        @else
                        {{ __('Kosong') }}
                        @endif
                    </td>
                    <td>
                        <a href="/items/{{ $i->id }}/edit" class="btn btn-primary btn-action mb-1 mt-1 mr-1"
                            data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                        <form id="del-data" action="{{ route('items.destroy',$i->id) }}" method="POST" class="d-inline">
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
<script src="{{ asset('pages/items/items.js') }}"></script>
@endsection