@extends('layouts.default')
@section('title', __('pages.title').__(' | Tambah Pembelian'))
@section('titleContent', __('Tambah Pembelian'))
@section('breadcrumb', __('Transaksi'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Pembelian') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah') }}</div>
@endsection

@section('content')
{{ $transaction }}
<h2 class="section-title">{{ $transaction->relationPurchase->code }}</h2>
<p class="section-lead">
    {{ __('Kode transaksi yang berisi kode unik untuk setiap transaksi pembelian yang dilakukan. Dibuat pada tanggal ').
    date("d-M-Y", strtotime($transaction->tgl)) }}
</p>
<form method="POST" action="{{ route('purchase.store') }}" id="addPurchase">
    @csrf
    <div class="card card-primary">
        <div class="card-body">
            <h2 class="section-title mt-0">{{ __('Supplier') }}</h2>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Nama') }}</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="name_supplier"
                                value="{{ $transaction->relationSupplier->name }}" readonly>
                            <div class="input-group-append">
                                <button class="btn cbcopy btn-primary" type="button"
                                    data-clipboard-target="#name_supplier" data-toggle="tooltip" title="Copy Data">
                                    <i class="far fa-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Kode') }}</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="code_supplier"
                                value="{{ $transaction->relationSupplier->code }}" readonly>
                            <div class="input-group-append">
                                <button class="btn cbcopy btn-primary" type="button"
                                    data-clipboard-target="#code_supplier" data-toggle="tooltip" title="Copy Data">
                                    <i class="far fa-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="section-title mb-3">{{ __('Barang') }}</h2>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Nama Barang') }}<code>*</code></label>
                        {{-- <select class="form-control select2 @error('items') is-invalid @enderror" name="items"
                            id="items" required>
                            @foreach ($items as $i)
                            <option value="{{ $i->id }}">
                        {{ $i->name }}
                        </option>
                        @endforeach
                        </select> --}}
                        @error('items')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                        <button class="mt-2 btn btn-primary btn-block" type="button"
                            onclick="getItems()">{{ __('Cek Data') }}</button>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Harga Pokok Barang') }}<code>*</code></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input class="form-control currency @error('price_items') is-invalid @enderror"
                                id="price_items" type="text" name="price_items">
                        </div>
                        @error('price_items')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label class="form-label">{{ __('Ganti Harga Pada Master Barang') }}<code>*</code></label>
                        <div class="selectgroup w-100" id="price_replace">
                            <label class="selectgroup-item">
                                <input type="radio" name="price_replace" value="1" class="selectgroup-input">
                                <span class="selectgroup-button">{{ __('Ya') }}</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="price_replace" value="0" class="selectgroup-input" checked>
                                <span class="selectgroup-button">{{ __('Tidak') }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Total Barang') }}<code>*</code></label>
                        <input type="text" class="form-control @error('total') is-invalid @enderror" name="total"
                            id="total" required autofocus>
                        @error('total')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Discount Per Item (Nominal)') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input class="form-control currency @error('dsc_nom') is-invalid @enderror" id="dsc_nom"
                                type="text" name="dsc_nom">
                        </div>
                        <span class="text-primary" role="alert">
                            {{ __('Prioritas') }}
                        </span>
                        @error('dsc_nom')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Discount Per Item (Persen)') }}</label>
                        <div class="input-group">
                            <input class="form-control @error('dsc_per') is-invalid @enderror" type="text"
                                name="dsc_per" id="dsc_per" max="100">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('%') }}
                                </div>
                            </div>
                        </div>
                        @error('dsc_per')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Include PPN') }}<code>*</code></label>
                <div class="selectgroup w-100" id="ppn">
                    <label class="selectgroup-item">
                        <input type="radio" name="ppn" value="1" class="selectgroup-input" checked>
                        <span class="selectgroup-button">{{ __('Ya') }}</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="ppn" value="0" class="selectgroup-input">
                        <span class="selectgroup-button">{{ __('Tidak') }}</span>
                    </label>
                </div>
            </div>
            <hr>
            <div class="form-row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Uang Muka (DP)') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input class="form-control currency @error('dp') is-invalid @enderror" id="dp" type="text"
                                name="dp">
                        </div>
                        @error('dp')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Biaya Kirim') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input class="form-control currency @error('ship_price') is-invalid @enderror"
                                id="ship_price" type="text" name="ship_price">
                        </div>
                        @error('ship_price')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Biaya Lain') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input class="form-control currency @error('etc_price') is-invalid @enderror" id="etc_price"
                                type="text" name="etc_price">
                        </div>
                        @error('etc_price')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Status') }}<code>*</code></label>
                <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                        <input type="radio" name="status" value="0" class="selectgroup-input">
                        <span class="selectgroup-button">{{ __('Dipesan') }}</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="status" value="1" class="selectgroup-input" checked>
                        <span class="selectgroup-button">{{ __('Diterima') }}</span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('Keterangan') }}</label>
                <textarea type="text" class="form-control @error('info') is-invalid @enderror" name="info" cols="150"
                    rows="10" style="height: 77px;"></textarea>
                @error('info')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
        </div>
    </div>
    <h2 class="section-title">{{ __('Pembayaran') }}</h2>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Jumlah') }}<code>*</code></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input class="form-control currency @error('payment') is-invalid @enderror" type="text"
                                name="payment" required>
                        </div>
                        @error('payment')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Metode Pembayaran') }}<code>*</code></label>
                        {{-- <select class="form-control @error('payment_method') is-invalid @enderror" name="payment_method"
                            required>
                            @foreach ($payment as $p)
                            <option value="{{ $p->id }}">
                        {{ $p->name }}
                        </option>
                        @endforeach
                        </select> --}}
                        @error('payment_method')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.transaction.components.floatingButton', ['form' => 'addPurchase'])
</form>
@endsection
@section('script')
<script>
    $(document).ready(function () {
    new Clipboard('.cbcopy');
    $(".cbcopy").click(function() {
  iziToast.success({
    title: 'Sukses',
    message: 'Copy data berhasil',
    position: 'topRight'
  });
});
});
</script>
@endsection