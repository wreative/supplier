@extends('layouts.default')
@section('title', __('pages.title').__(' | Edit Supplier'))
@section('titleContent', __('Edit Supplier'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Supplier') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Supplier') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $supplier->code }}</h2>
<p class="section-lead">
    {{ __('ID yang digunakan untuk mengidentifikasi setiap supplier.') }}
</p>
<div class="card">
    <form method="POST" action="{{ route('supplier.update',$supplier->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="code" value="{{ $supplier->code }}">
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Nama') }}<code>*</code></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            value="{{ $supplier->name }}" name="name" required autofocus>
                        @error('name')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('No Telepon') }}<code>*</code></label>
                        <input type="text" class="form-control tlp @error('tlp') is-invalid @enderror" name="tlp"
                            value="{{ $supplier->tlp }}" required>
                        @error('tlp')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Email') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ $supplier->relationDetail->email }}">
                        @error('email')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Fax') }}</label>
                        <input type="text" class="form-control @error('fax') is-invalid @enderror" name="fax"
                            value="{{ $supplier->relationDetail->fax }}">
                        @error('fax')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('NPWP') }}</label>
                        <input type="text" class="form-control @error('npwp') is-invalid @enderror" name="npwp"
                            value="{{ $supplier->relationDetail->npwp }}">
                        @error('npwp')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('Keterangan') }}</label>
                <textarea type="text" class="form-control @error('info') is-invalid @enderror" name="info" cols="150"
                    rows="10" style="height: 77px;">{{ $supplier->relationDetail->info }}</textarea>
                @error('info')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <h2 class="section-title">{{ __('Alamat') }}</h2>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Kota') }}<code>*</code></label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                            value="{{ json_decode($supplier->address)[0]}}" required>
                        @error('city')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Provinsi') }}<code>*</code></label>
                        <input type="text" class="form-control @error('province') is-invalid @enderror" name="province"
                            value="{{ json_decode($supplier->address)[1] }}" required>
                        @error('province')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Kode POS') }}<code>*</code></label>
                        <input type="text" class="form-control @error('pos') is-invalid @enderror" name="pos"
                            value="{{ json_decode($supplier->address)[2] }}" required>
                        @error('pos')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <h2 class="section-title">{{ __('Rekening') }}</h2>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('No Rekening') }}</label>
                        <input type="text" class="form-control @error('no_rek') is-invalid @enderror" name="no_rek"
                            value="{{ $supplier->relationDetail->no_rek }}">
                        @error('no_rek')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Nama Rekening') }}</label>
                        <input type="text" class="form-control @error('name_rek') is-invalid @enderror" name="name_rek"
                            value="{{ $supplier->relationDetail->name_rek }}">
                        @error('name_rek')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Bank') }}</label>
                        <input type="text" class="form-control @error('bank') is-invalid @enderror" name="bank"
                            value="{{ $supplier->relationDetail->bank }}">
                        @error('bank')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <h2 class="section-title">{{ __('Sales') }}</h2>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Nama Sales') }}</label>
                        <input type="text" class="form-control @error('sales_name') is-invalid @enderror"
                            name="sales_name"
                            value="@isset($supplier->relationDetail->sales){{ json_decode($supplier->relationDetail->sales)[0] }}@endisset">
                        @error('sales_name')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Telepon Sales') }}</label>
                        <input type="text" class="form-control tlp @error('sales_tlp') is-invalid @enderror"
                            name="sales_tlp"
                            value="@isset($supplier->relationDetail->sales){{ json_decode($supplier->relationDetail->sales)[1] }}@endisset">
                        @error('sales_tlp')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" type="submit">{{ __('pages.edit') }}</button>
        </div>
    </form>
</div>
@endsection
@section('script')
<script src="{{ asset('pages/supplier/changes.js') }}"></script>
@endsection