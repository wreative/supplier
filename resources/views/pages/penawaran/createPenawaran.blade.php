@extends('layouts.default')
@section('title', __('pages.title').__(' | Tambah Penawaran'))
@section('titleContent', __('Tambah Penawaran'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Penawaran') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Penawaran') }}</div>
@endsection

@section('content')
{{-- <h2 class="section-title">{{ $code }}</h2> --}}
<p class="section-lead">
    {{ __('ID yang digunakan untuk mengidentifikasi setiap penawaran.') }}
</p>
<div class="card">
    <form method="POST" action="{{ route('storeMarketer') }}">
        @csrf
        {{-- <input type="hidden" value="{{ $code }}" name="code"> --}}
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('Nama') }}<code>*</code></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required
                    autofocus>
                @error('name')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('No Telepon') }}<code>*</code></label>
                <input type="text" class="form-control tlp @error('tlp') is-invalid @enderror" name="tlp" required>
                @error('tlp')
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
<script src="{{ asset('pages/sales/changes.js') }}"></script>
@endsection