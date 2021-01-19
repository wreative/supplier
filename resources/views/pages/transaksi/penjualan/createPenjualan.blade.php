@extends('layouts.default')
@section('title', __('pages.title').__(' | Tambah Pembelian'))
@section('titleContent', __('Tambah Pembelian'))
@section('breadcrumb', __('Transaksi'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Pembelian') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $code }}</h2>
<p class="section-lead">
    {{ __('Kode transaksi yang berisi kode unik untuk setiap transaksi pembelian yang dilakukan.') }}
</p>
<div class="card">
    <form method="POST" action="{{ route('storePurchase') }}">
        @csrf
        <input type="hidden" value="{{ $code }}" name="code">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('Nama Barang') }}<code>*</code></label>
                <select class="form-control select2 @error('items') is-invalid @enderror" name="items" id="items"
                    required>
                    @foreach ($items as $i)
                    <option value="{{ $i->id }}">
                        {{ $i->name." - ".$i->stock." Stok - Rp.".number_format($i->relationDetail->price) }}
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
                <label>{{ __('Pajak') }}</label>
                <div class="input-group">
                    <input class="form-control currency @error('tax') is-invalid @enderror" type="text" name="tax"
                        id="tax" max="100" value="10" disabled>
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            {{ __('%') }}
                        </div>
                    </div>
                </div>
                @error('tax')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
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
                <label>{{ __('Supplier') }}<code>*</code></label>
                <select class="form-control select2 @error('supplier') is-invalid @enderror" name="supplier" required>
                    @foreach ($supplier as $s)
                    <option value="{{ $s->id }}">
                        {{ $s->name." - ".$s->code }}
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