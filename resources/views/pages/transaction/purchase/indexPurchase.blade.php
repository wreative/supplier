@extends('layouts.default')
@section('title', __('pages.title').__(' | Master Pembelian'))
@section('titleContent', __('Pembelian'))
@section('breadcrumb', __('Transaksi'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Pembelian') }}</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('purchase.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Transaksi Pembelian') }}</a>
    </div>
    <div class="card-body">
        @if ($count == 0)
        <h4 class="text-center">{{ __('DATA KOSONG') }}</h4>
        @else
        <table class="table-striped table" id="transaction" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th>{{ __('No Transaksi') }}</th>
                    <th>{{ __('Kode Barang') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Pembayaran') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Harga Diskon') }}</th>
                    <th>{{ __('Diskon') }}</th>
                    <th>{{ __('Pajak') }}</th>
                    <th>{{ __('PPN') }}</th>
                    <th>{{ __('Uang Muka') }}</th>
                    <th>{{ __('Harga') }}</th>
                    <th>{{ __('Biaya Kirim') }}</th>
                    <th>{{ __('Biaya Lain') }}</th>
                    <th>{{ __('Kode Supplier') }}</th>
                    <th>{{ __('Tanggal') }}</th>
                    <th>{{ __('Keterangan') }}</th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchase as $number => $p)
                <tr>
                    <td class="text-center">
                        {{ $number+1 }}
                    </td>
                    <td>{{ $p->relationPurchase->code }}</td>
                    <td>{{ $p->relationItems->code }}</td>
                    <td>
                        <span class="badge badge-{{ $p->relationPurchase->status == 'Dipesan' ? 'info' : 'success' }}">
                            {{ $p->relationPurchase->status }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $p->relationPurchase->pay == 'Tempo' ? 'danger' : 'success' }}">
                            {{ $p->relationPurchase->pay }}
                        </span>
                    </td>
                    <td>{{ $p->total.__(" Items") }}</td>
                    <td>{{ __('Rp.').number_format($p->relationPurchase->dsc) }}</td>
                    {{-- <td>
                        {{ __('Rp.').number_format(json_decode($p->relationPurchase->dsc)[1])." / ".json_decode($p->relationPurchase->dsc)[2].__('%') }}
                    </td> --}}
                    <td>
                        {{ __('Rp.').number_format($p->relationPurchase->dsc_nom)." / ".$p->relationPurchase->dsc_per.__('%') }}
                    </td>
                    <td>{{ __('Rp.').number_format($p->relationPurchase->tax) }}</td>
                    <td>
                        @if ($p->relationPurchase->ppn == 1)
                        <span class="badge badge-success">{{ __('YA') }}</span>
                        @else
                        <span class="badge badge-danger">{{ __('TIDAK') }}</span>
                        @endif
                    </td>
                    <td>{{ __('Rp.').number_format($p->relationPurchase->dp) }}</td>
                    <td>{{ __('Rp.').number_format($p->price) }}</td>
                    <td>{{ __('Rp.').number_format($p->relationPurchase->ship_price) }}</td>
                    <td>{{ __('Rp.').number_format($p->relationPurchase->etc_price) }}</td>
                    <td>{{ $p->relationSupplier->code }}</td>
                    <td>{{ date("d-M-Y", strtotime($p->tgl)) }}</td>
                    <td>
                        @if ($p->relationPurchase->info != null)
                        {{ $p->relationPurchase->info }}
                        @else
                        {{ __('Kosong') }}
                        @endif
                    </td>
                    <td>
                        <div class="dropdown d-inline">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{ __('Lainnya') }}
                            </button>
                            <div class="dropdown-menu">
                                <form id="del-data{{ $p->id }}" action="{{ route('purchase.destroy',$p->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <a class="dropdown-item has-icon" data-toggle="tooltip" title="Delete"
                                        data-confirm="Apakah Anda Yakin?|Aksi ini tidak dapat dikembalikan. Apakah ingin melanjutkan?"
                                        data-confirm-yes="document.getElementById('del-data{{ $p->id }}').submit();"
                                        style="cursor: pointer"><i class="far fa-trash-alt"></i>
                                        {{ __(' Hapus') }}
                                    </a>
                                </form>
                                <a class="dropdown-item has-icon" href="{{ route('purchase.show',$p->id) }}">
                                    <i class="far fa-eye"></i>{{ __(' Lihat Detail') }}
                                </a>
                                {{-- <a class="dropdown-item has-icon" onclick="getPayment({{ $p->id }})"
                                style="cursor: pointer">
                                <i class="far fa-money-bill-alt"></i>{{ __(' Lihat Pembayaran') }}
                                </a>
                                <a class="dropdown-item has-icon" onclick="changeStatus({{ $p->id }})"
                                    style="cursor: pointer">
                                    <i class="far fa-handshake"></i>{{ __(' Ubah Status') }}
                                </a> --}}
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
<button class="btn btn-primary d-none" id="modal-4"></button>
@endsection
@section('script')
<script src="{{ asset('pages/transaction/purchase/createPurchase.js') }}"></script>
<script src="{{ asset('pages/transaction/transaction.js') }}"></script>
@endsection