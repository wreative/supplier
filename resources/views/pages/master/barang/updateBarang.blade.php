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
    <form method="POST" action="{{ route('items.update',$items->id) }}">
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
                    <option value="{{ $u->id }}" {{ $items->relationUnits->id == $u->id ? 'selected' : '' }}>
                        {{ $u->name }}</option>
                    @endforeach
                </select>
                @error('units')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Limit') }}<code>*</code></label>
                <div class="input-group">
                    <input type="text" class="form-control @error('limit') is-invalid @enderror" name="limit" required>
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            {{ __('Hari') }}
                        </div>
                    </div>
                </div>
                @error('limit')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Harga Pokok') }}<code>*</code></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            {{ __('Rp.') }}
                        </div>
                    </div>
                    <input class="form-control currency @error('price') is-invalid @enderror" id="price" type="text"
                        name="price" value="{{ $items->relationDetail == null ? 0 : $items->relationDetail->price }}">
                </div>
                @error('price')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Include PPN') }}<code>*</code></label>
                <div class="selectgroup w-100" id="ppn">
                    <label class="selectgroup-item">
                        <input type="radio" name="ppn" value="1" class="selectgroup-input"
                            {{ $items->relationDetail == null ? 'checked' : ($items->relationDetail->ppn == 1 ? 'checked' : '') }}>
                        <span class="selectgroup-button">{{ __('Ya') }}</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="ppn" value="0" class="selectgroup-input"
                            {{ $items->relationDetail == null ? '' : ($items->relationDetail->ppn == 0 ? 'checked' : '') }}>
                        <span class="selectgroup-button">{{ __('Tidak') }}</span>
                    </label>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            {{ __('Rp.') }}
                        </div>
                    </div>
                    <input class="form-control currency" type="text" id="result_ppn"
                        value="{{ $items->relationDetail == null ? 0 : $items->relationDetail->ppn_price }}" disabled>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"
                            onclick="checkPPN()">{{ __('Ambil Data') }}</button>
                    </div>
                </div>
                <span class="text-primary" role="alert">
                    {{ __('Klik tombol Ambil Data jika ada perubahan pada Harga Pokok atau PPN') }}
                </span>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>{{ __('Keuntungan Nominal') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input class="form-control currency @error('profit_nom') is-invalid @enderror" type="text"
                                name="profit_nom" id="profit_nom"
                                value="{{ $items->relationDetail == null ? 0 : $items->relationDetail->profit_nom }}">
                        </div>
                        @error('profit_nom')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>{{ __('Keuntungan Persen') }}</label>
                        <div class="input-group">
                            <input class="form-control @error('profit') is-invalid @enderror" type="text" name="profit"
                                id="profit" max="100"
                                value="{{ $items->relationDetail == null ? 0 : $items->relationDetail->profit }}">
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
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('Harga Jual') }}<code>*</code></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            {{ __('Rp.') }}
                        </div>
                    </div>
                    <input class="form-control currency @error('sell_price') is-invalid @enderror" type="text"
                        name="sell_price" id="sell_price"
                        value="{{ $items->relationDetail == null ? 0 : $items->relationDetail->sell_price }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"
                            onclick="checkPrice()">{{ __('Ambil Data') }}</button>
                    </div>
                </div>
                @error('sell_price')
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
            <button class="btn btn-primary mr-1" type="submit">{{ __('pages.edit') }}</button>
        </div>
    </form>
</div>
@endsection
@section('script')
<script src="{{ asset('pages/items/changesBarang.js') }}"></script>
@endsection