@extends('layouts.default')
@section('title', __('pages.title').__(' | Tambah Penawaran'))
@section('titleContent', __('Tambah Penawaran'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Penawaran') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Penawaran') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $code }}</h2>
<p class="section-lead">
    {{ __('ID yang digunakan untuk mengidentifikasi setiap penawaran.') }}
</p>

<form method="POST" action="{{ route('storeMarketer') }}">
    @csrf
    <input type="hidden" value="{{ $code }}" name="code">
    <div class="card">
        <div class="card-body">
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
                <label>{{ __('Biaya Kirim') }}</label>
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
                <label>{{ __('Biaya Packing') }}</label>
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
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="submit">{{ __('Tambah') }}</button>
        </div>
    </div>
    <h2 class="section-title">{{ __('Tambah Barang') }}</h2>
    <div class="card" id="mycard-dimiss">
        <div class="card-header">
            <h4 class="d-none">{{ __('Add Data') }}</h4>
            <div class="card-header-action">
                <a data-dismiss="#mycard-dimiss" class="btn btn-icon btn-danger" href="#"><i
                        class="fas fa-times"></i></a>
            </div>
        </div>
        <div class="card-body">
            You can dimiss this card.
        </div>
        <div class="card-footer">
            Card Footer
        </div>
    </div>
</form>
@endsection
@section('script')
<script src="{{ asset('pages/sales/changes.js') }}"></script>
@endsection