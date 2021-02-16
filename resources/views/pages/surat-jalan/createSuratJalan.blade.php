@extends('layouts.default')
@section('title', __('pages.title').__(' | Tambah Surat Jalan'))
@section('titleContent', __('Tambah Surat Jalan'))
@section('breadcrumb', __('Surat Jalan'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Tambah Surat Jalan') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $code }}</h2>
<p class="section-lead">
    {{ __('ID yang digunakan untuk mengidentifikasi setiap surat jalan.') }}
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
<form method="POST" action="{{ route('tdoc.store') }}">
    @csrf
    <input type="hidden" value="{{ $code }}" name="code">
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('Surat Penawaran') }}<code>*</code></label>
                <select class="form-control select2 @error('sp') is-invalid @enderror" name="sp" required>
                    @foreach ($bidding as $b)
                    <option value="{{ $b->id }}">
                        {{ $b->code }}
                    </option>
                    @endforeach
                </select>
                @error('sp')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Driver') }}</label>
                <div class="input-group">
                    <input class="form-control @error('driver') is-invalid @enderror" id="driver" type="text"
                        name="driver">
                </div>
                @error('driver')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Nomor Polisi') }}</label>
                <div class="input-group">
                    <input class="form-control @error('police_num') is-invalid @enderror" id="police_num" type="text"
                        name="police_num">
                </div>
                @error('police_num')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('Keterangan') }}</label>
                <textarea type="text" class="form-control @error('info') is-invalid @enderror" name="info" cols="150"
                    rows="10" style="height: 77px;"></textarea>
                @error('info')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
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
@endsection