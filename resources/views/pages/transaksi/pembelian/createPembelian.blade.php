@extends('layouts.default')
@section('title', __('pages.title').__(' | Tambah Pembelian'))
@section('titleContent', __('Tambah Pembelian'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Transaksi') }}</div>
<div class="breadcrumb-item active">{{ __('Pembelian') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $code }}</h2>
<p class="section-lead">
    {{ __('Kode transaksi yang berisi kode unik untuk setiap transaksi yang dilakukan.') }}
</p>
<div class="card">
    <form method="POST" action="{{ route('storePurchase') }}">
        @csrf
        <input type="hidden" value="{{ $code }}" name="code">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('Total') }}<code>*</code></label>
                <input type="text" class="form-control @error('total') is-invalid @enderror" name="total" required
                    autofocus>
                @error('total')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Units') }}<code>*</code></label>
                <select class="custom-select @error('units') is-invalid @enderror" name="units" required>
                    @foreach ($units as $u)
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
                @error('units')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Nama Barang') }}<code>*</code></label>
                <select class="form-control select2 @error('items') is-invalid @enderror" name="items">
                    @foreach ($items as $i)
                    <option value="{{ $i->id }}">
                        {{ $i->name." - ".$i->stock." Stok" }}
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
                <label>{{ __('Harga Pokok (Include PPN)') }}<code>*</code></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            {{ __('Rp.') }}
                        </div>
                    </div>
                    <input class="form-control currency @error('price_inc') is-invalid @enderror" id="price_inc"
                        type="text" name="price_inc">
                </div>
                @error('price_inc')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Harga Pokok (Exclude PPN)') }}<code>*</code></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            {{ __('Rp.') }}
                        </div>
                    </div>
                    <input class="form-control currency @error('price_exc') is-invalid @enderror" type="text"
                        name="price_exc" id="price_exc">
                </div>
                @error('price_exc')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Keuntungan') }}</label>
                <div class="input-group">
                    <input class="form-control @error('profit') is-invalid @enderror" type="text" name="profit"
                        id="profit" max="100">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            {{ __('%') }}
                        </div>
                    </div>
                </div>
                @error('profit')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Harga') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            {{ __('Rp.') }}
                        </div>
                    </div>
                    <input class="form-control currency @error('price') is-invalid @enderror" type="text" name="price"
                        id="price">
                </div>
                @error('price')
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
            <button class="btn btn-primary mr-1" type="submit">{{ __('Tambah') }}</button>
        </div>
    </form>
</div>
@endsection
@section('script')
<script src="{{ asset('pages/transaction/pembelian/createPembelian.js') }}"></script>
@endsection