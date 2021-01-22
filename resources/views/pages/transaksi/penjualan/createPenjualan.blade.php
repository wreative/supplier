@extends('layouts.default')
@section('title', __('pages.title').__(' | Tambah Penjualan'))
@section('titleContent', __('Tambah Penjualan'))
@section('breadcrumb', __('Transaksi'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Penjualan') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $code }}</h2>
<p class="section-lead">
    {{ __('Kode transaksi yang berisi kode unik untuk setiap transaksi penjualan yang dilakukan.') }}
</p>
<div class="card">
    <form method="POST" action="{{ route('storeSales') }}">
        @csrf
        <input type="hidden" value="{{ $code }}" name="code">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('Nama Barang') }}<code>*</code></label>
                <select class="form-control select2 @error('items') is-invalid @enderror" name="items" id="items"
                    required>
                    @foreach ($items as $i)
                    <option value="{{ $i->id }}">
                        {{ $i->name." - ".$i->stock." Stok - Rp.".number_format($i->relationDetail->sell_price) }}
                    </option>
                    @endforeach
                </select>
                @error('items')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Total Barang') }}<code>*</code></label>
                <input type="text" class="form-control @error('total') is-invalid @enderror" name="total" id="total"
                    required autofocus>
                @error('total')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
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
                <div class="form-group col-md-6">
                    <label>{{ __('Discount Per Item (Persen)') }}</label>
                    <div class="input-group">
                        <input class="form-control @error('dsc_per') is-invalid @enderror" type="text" name="dsc_per"
                            id="dsc_per" max="100">
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
            <div class="form-group">
                <label>{{ __('Tanggal') }}<code>*</code></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="far fa-calendar"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control datepicker @error('tgl') is-invalid @enderror" name="tgl"
                        required>
                    @error('tgl')
                    <span class="text-danger" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('Customer') }}<code>*</code></label>
                <select class="form-control select2 @error('customer') is-invalid @enderror" name="customer" required>
                    @foreach ($customer as $c)
                    <option value="{{ $c->id }}">
                        {{ $c->name." - ".$c->code }}
                    </option>
                    @endforeach
                </select>
                @error('customer')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Sales') }}<code>*</code></label>
                <select class="form-control select2 @error('marketer') is-invalid @enderror" name="marketer" required>
                    @foreach ($marketer as $m)
                    <option value="{{ $m->id }}">
                        {{ $m->name." - ".$m->code }}
                    </option>
                    @endforeach
                </select>
                @error('marketer')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
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
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="button" onclick="getPrice()">{{ __('Cek Harga') }}</button>
            <button class="btn btn-primary mr-1" type="submit">{{ __('Tambah') }}</button>
        </div>
    </form>
</div>
@endsection
@section('script')
<script src="{{ asset('pages/transaction/pembelian/createPembelian.js') }}"></script>
@endsection