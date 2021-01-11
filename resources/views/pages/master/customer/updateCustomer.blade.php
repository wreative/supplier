@extends('layouts.default')
@section('title', __('pages.title').__(' | Edit Customer'))
@section('titleContent', __('Edit Customer'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Customer') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Customer') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $customer->code }}</h2>
<p class="section-lead">
    {{ __('ID yang digunakan untuk mengidentifikasi setiap customer.') }}
</p>
<div class="card">
    <form method="POST" action="/customer/update/{{ $customer->id }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="code" value="{{ $customer->code }}">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('Nama') }}<code>*</code></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                    value="{{ $customer->name }}" name="name" required autofocus>
                @error('name')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('No Telepon') }}<code>*</code></label>
                <input type="text" class="form-control tlp @error('tlp') is-invalid @enderror" name="tlp"
                    value="{{ $customer->tlp }}" required>
                @error('tlp')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Email') }}</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ $customer->email }}">
                @error('email')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Fax') }}</label>
                <input type="text" class="form-control @error('fax') is-invalid @enderror" name="fax"
                    value="{{ $customer->fax }}">
                @error('fax')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('NPWP') }}</label>
                <input type="text" class="form-control @error('npwp') is-invalid @enderror" name="npwp"
                    value="{{ $customer->npwp }}">
                @error('npwp')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Keterangan') }}</label>
                <textarea type="text" class="form-control @error('info') is-invalid @enderror" name="info" cols="150"
                    rows="10" style="height: 77px;">{{ $customer->info }}</textarea>
                @error('info')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Sales') }}<code>*</code></label>
                <select class="form-control select2 @error('sales') is-invalid @enderror" name="sales">
                    @foreach ($sales as $s)
                    <option value="{{ $s->id }}">
                        {{ $s->name." - ".$s->code }}
                    </option>
                    @endforeach
                </select>
                @error('sales')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <h2 class="section-title">{{ __('Alamat') }}</h2>
            <div class="form-group">
                <label>{{ __('Kota') }}<code>*</code></label>
                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                    value="{{ json_decode($customer->address)[0]}}" required>
                @error('city')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Provinsi') }}<code>*</code></label>
                <input type="text" class="form-control @error('province') is-invalid @enderror" name="province"
                    value="{{ json_decode($customer->address)[1] }}" required>
                @error('province')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Kode POS') }}<code>*</code></label>
                <input type="text" class="form-control @error('pos') is-invalid @enderror" name="pos"
                    value="{{ json_decode($customer->address)[2] }}" required>
                @error('pos')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <h2 class="section-title">{{ __('Rekening') }}</h2>
            <div class="form-group">
                <label>{{ __('No Rekening') }}</label>
                <input type="text" class="form-control @error('no_rek') is-invalid @enderror" name="no_rek"
                    value="{{ $customer->no_rek }}">
                @error('no_rek')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Nama Rekening') }}</label>
                <input type="text" class="form-control @error('name_rek') is-invalid @enderror" name="name_rek"
                    value="{{ $customer->name_rek }}">
                @error('name_rek')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Bank') }}</label>
                <input type="text" class="form-control @error('bank') is-invalid @enderror" name="bank"
                    value="{{ $customer->bank }}">
                @error('bank')
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
<script src="{{ asset('pages/customer/changes.js') }}"></script>
@endsection