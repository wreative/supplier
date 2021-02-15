@extends('layouts.default')
@section('title', __('pages.title').__(' | Tambah Penawaran'))
@section('titleContent', __('Tambah Penawaran'))
@section('breadcrumb', __('Penawaran'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Tambah Penawaran') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $code }}</h2>
<p class="section-lead">
    {{ __('ID yang digunakan untuk mengidentifikasi setiap penawaran.') }}
</p>
@if(Session::has('status'))
<div class="alert alert-primary alert-has-icon">
    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
    <div class="alert-body">
        <div class="alert-title">{{ __('Informasi') }}</div>
        {{ Session::get('status') }}
    </div>
</div>
@endif
{{-- <form class="form-save" enctype="multipart/form-data"> --}}
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
                    <input class="form-control currency @error('ship_cost') is-invalid @enderror" id="ship_cost"
                        type="text" name="ship_cost">
                </div>
                @error('ship_cost')
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
                    <input class="form-control currency @error('pack_fee') is-invalid @enderror" id="pack_fee"
                        type="text" name="pack_fee">
                </div>
                @error('pack_fee')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>s
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
                <div class="form-group">
                    <label>{{ __('Keterangan') }}</label>
                    <textarea type="text" class="form-control @error('info') is-invalid @enderror" name="info"
                        cols="150" rows="10" style="height: 77px;"></textarea>
                    @error('info')
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
            <a class="btn btn-primary mr-1" style="color: white;cursor: pointer;">{{ __('Cek Data') }}</a>
            <button class="btn btn-primary mr-1" onclick="save()">{{ __('Tambah') }}</button>
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
            '<select class="form-control select2" name="items[]">'+
              @foreach ($items as $i )
              '<option value="{{ $i->id }}">{{ $i->name }}</option>'+
              @endforeach
            '</select>'+
        '</th>'+
        '<th>'+
            '<input type="text" class="form-control @error('total') is-invalid @enderror" name="total[]" required
                    autofocus>'+
        '</th>'+        
        '<th><button type="button" class="btn btn-danger" onclick="remove_item(\''+(remove+1)+'\')"><i class="fas fa-trash"></i> Hapus</button></th>'+
      '</tr>'      
    );
    $(".select2").select2();
}
</script>
@endsection