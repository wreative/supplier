@extends('layouts.default')
@section('title', __('pages.title').__(' | Edit Barang'))
@section('titleContent', __('Edit Barang'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Barang') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Barang') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $items->code }}</h2>
<p class="section-lead">
    {{ __('ID yang digunakan untuk mengidentifikasi setiap barang.') }}
</p>
<div class="card">
    <form method="POST" action="/items-almaas/update/{{ $items->id }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $items->code }}" name="code">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('Nama') }}<code>*</code></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ $items->name }}" required autofocus>
                @error('name')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Stock') }}<code>*</code></label>
                <input type="text" class="form-control @error('stock') is-invalid @enderror" name="stock"
                    value="{{ $items->stock }}" required autofocus>
                @error('stock')
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
                <label>{{ __('Harga Beli') }}<code>*</code></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            {{ __('Rp.') }}
                        </div>
                    </div>
                    <input class="form-control currency @error('price_buy') is-invalid @enderror"
                        value="{{ $items->relationDetail->price_buy }}" type="text" name="price_buy" required>
                </div>
                @error('price_buy')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Harga Jual') }}<code>*</code></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            {{ __('Rp.') }}
                        </div>
                    </div>
                    <input class="form-control currency @error('price_sell') is-invalid @enderror"
                        value="{{ $items->relationDetail->price_sell }}" type="text" name="price_sell" required>
                </div>
                @error('price_sell')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Keterangan') }}</label>
                <textarea type="text" class="form-control @error('info') is-invalid @enderror" name="info" cols="150"
                    rows="10" style="height: 77px;">{{ $items->relationDetail->info }}</textarea>
                @error('info')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="submit">{{ __('Edit') }}</button>
        </div>
    </form>
</div>
@endsection
@section('script')
<script src="{{ asset('pages/items/changesAlmaas.js') }}"></script>
@endsection