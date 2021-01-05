@extends('layouts.default')
@section('title', __('pages.title').__(' | Tambah Transaksi'))
@section('titleContent', __('Tambah Transaksi'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Transaksi') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Transaksi') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $code }}</h2>
<p class="section-lead">
    {{ __('Kode transaksi yang berisi kode unik untuk setiap transaksi yang dilakukan.') }}
</p>
<div class="card">
    <form method="POST" action="{{ route('storeTransaction') }}">
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
                <label>{{ __('Jenis Transaksi') }}<code>*</code></label>
                <select class="custom-select @error('type') is-invalid @enderror" name="type" required>
                    <option value="{{ __('Keluar') }}">{{ __('Transaksi Keluar') }}</option>
                    <option value="{{ __('Masuk') }}">{{ __('Transaksi Masuk') }}</option>
                </select>
                @error('type')
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
<script src="{{ asset('pages/karyawan/createKaryawan.js') }}"></script>
@endsection