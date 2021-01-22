@extends('layouts.default')
@section('title', __('pages.title').__(' | Edit Sales'))
@section('titleContent', __('Edit Sales'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Sales') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Sales') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $sales->code }}</h2>
<p class="section-lead">
    {{ __('ID yang digunakan untuk mengidentifikasi setiap sales.') }}
</p>
<div class="card">
    <form method="POST" action="/marketer/update/{{ $sales->id }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="code" value="{{ $sales->code }}">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('Nama') }}<code>*</code></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ $sales->name }}" required autofocus>
                @error('name')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('No Telepon') }}<code>*</code></label>
                <input type="text" class="form-control tlp @error('tlp') is-invalid @enderror" name="tlp"
                    value="{{ $sales->tlp }}" required>
                @error('tlp')
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
<script src="{{ asset('pages/sales/changes.js') }}"></script>
@endsection