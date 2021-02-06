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

<form method="POST" action="{{ route('bidding.store') }}">
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
    </div>
    <h2 class="section-title">{{ __('Barang') }}</h2>
    <div class="card">
        <div class="card-header">
            <a class="btn btn-icon icon-left btn-primary" style="cursor: pointer;color: white" onclick="add_item()">
                <i class="far fa-edit"></i>{{ __(' Tambah Barang') }}
            </a>
        </div>
        <div class="card-body">
            <table class="table-striped table" id="penawaran" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">
                            {{ __('Barang') }}
                        </th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody class="drop"></tbody>
            </table>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="submit">{{ __('Tambah') }}</button>
        </div>
    </div>
</form>
@endsection
@section('script')
<script src="{{ asset('pages/penawaran/changesPenawaran.js') }}"></script>
<script>
    function add_item(){
        var remove = $('.remove').length;
        $('.drop').append(
            '<tr class="remove remove_'+(remove+1)+'">'+
        '<th>'+
            '<select class="form-control select2" name="kode_rak_dt[]">'+
              @foreach ($items as $i )
              '<option value="{{ $i->id }}">{{ $i->name }}</option>'+
              @endforeach
            '</select>'+
        '</th>'+
        '<th>'+
            '<input type="text" class="form-control @error('stock') is-invalid @enderror" name="stock" required
                    autofocus>'+
        '</th>'+        
        '<th><button type="button" class="btn btn-danger" onclick="remove_item(\''+(remove+1)+'\')"><i class="fas fa-trash"></i> Hapus</button></th>'+
      '</tr>'      
    );
    $(".select2").select2();
}
</script>
@endsection