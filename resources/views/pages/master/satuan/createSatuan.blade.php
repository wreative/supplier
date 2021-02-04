@extends('layouts.default')
@section('title', __('pages.title').__(' | Tambah Satuan'))
@section('titleContent', __('Tambah Satuan'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Satuan') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Satuan') }}</div>
@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('units.store') }}">
        @csrf
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