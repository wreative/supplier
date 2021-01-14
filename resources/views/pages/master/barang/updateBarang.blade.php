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
    <form method="POST" action="/items/update/{{ $items->id }}">
        @csrf
        @method('PUT')
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
                <label>{{ __('Harga Pokok (Include PPN)') }}<code>*</code></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            {{ __('Rp.') }}
                        </div>
                    </div>
                    <input class="form-control currency @error('price_inc') is-invalid @enderror" id="price_inc"
                        type="text" name="price_inc"
                        value="{{ $items->relationDetail != null ? $items->relationDetail->price_inc : 0 }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"
                            onclick="checkInclude()">{{ __('Ambil Data') }}</button>
                    </div>
                </div>
                <span class="text-primary" role="alert">
                    {{ __('Harga Pokok (Exclude PPN) harus terisi untuk mengambil data') }}
                </span>
                @error('price_inc')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Harga Pokok (Exclude PPN)') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            {{ __('Rp.') }}
                        </div>
                    </div>
                    <input class="form-control currency @error('price_exc') is-invalid @enderror" type="text"
                        name="price_exc" id="price_exc"
                        value="{{ $items->relationDetail != null ? $items->relationDetail->price_exc : 0 }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"
                            onclick="checkExclude()">{{ __('Ambil Data') }}</button>
                    </div>
                </div>
                <span class="text-primary" role="alert">
                    {{ __('Harga Pokok (Include PPN) harus terisi untuk mengambil data') }}
                </span>
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
                        id="profit" max="100"
                        value="{{ $items->relationDetail != null ? $items->relationDetail->profit : 0 }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            {{ __('%') }}
                        </div>
                    </div>
                </div>
                <span class="text-primary" role="alert">
                    {{ __('Maksimal 100%') }}
                </span>
                @error('profit')
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
                    <input class="form-control currency @error('price') is-invalid @enderror" type="text" name="price"
                        id="price" value="{{ $items->relationDetail != null ? $items->relationDetail->price : 0 }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"
                            onclick="checkPrice()">{{ __('Ambil Data') }}</button>
                    </div>
                </div>
                @error('price')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Keterangan') }}</label>
                <textarea type="text" class="form-control @error('info') is-invalid @enderror" name="info" cols="150"
                    rows="10" style="height: 77px;">{{ $items->info }}</textarea>
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
<script src="{{ asset('pages/items/changesBarang.js') }}"></script>
@endsection