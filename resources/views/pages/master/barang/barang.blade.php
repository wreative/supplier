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
                    <th>{{ __('Harga Pokok') }}</th>
                    <th>{{ __('Include PPN') }}</th>
                    <th>{{ __('Harga PPN') }}</th>
                    <th>{{ __('Keuntungan') }}</th>
                    <th>{{ __('Harga Jual') }}</th>
                    <th>{{ __('Limit') }}</th>
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
                    <td>{{ number_format($i->stock)." ".$i->relationUnits->name }}</td>
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
                        {{ __('Rp.0 / 0%') }}
                        @else
                        {{ __('Rp.').number_format($i->relationDetail->ppn_price, 2).
                        " / ".$i->relationDetail->profit.__('%') }}
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
                        @if($i->limit != null)
                        {{ $i->limit." ".$i->relationUnits->name }}
                        @else
                        {{ __('0 Hari') }}
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
                        <a href="/items/{{ $i->id }}/edit" class="btn btn-primary btn-action mb-1 mt-1 mr-1"><i
                                data-toggle="tooltip" title="Edit" class="fas fa-pencil-alt"></i></a>
                        <form id="del-data{{ $i->id }}" action="{{ route('items.destroy',$i->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-action mb-1 mt-1" data-toggle="tooltip" title="Delete"
                                data-confirm="Apakah Anda Yakin?|Aksi ini tidak dapat dikembalikan. Apakah ingin melanjutkan?"
                                data-confirm-yes="document.getElementById('del-data{{ $i->id }}').submit();"><i
                                    class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{-- {{ json_encode($items->original["data"][0]["name"]) }} --}}
@endsection
@section('script')
<script src="{{ asset('pages/items/items.js') }}"></script>
{{-- <script>
    $("#items").dataTable({
    responsive: true,
    // lengthMenu: [
    //     [10, 25, 50, -1],
    //     [10, 25, 50, "Semua"]
    // ],
    paging: false,
    searching: false,
    processing: true,
    responsive: true,
    serverSide: true,
    ajax: "/items",
    columns: [{ data: "id" }, { data: "name" }, { data: "email" }]
});
</script> --}}
@endsection