@extends('layouts.default')
@section('title', __('pages.title').__(' | Dashboard'))
@section('titleContent', __('Dashboard'))
@section('breadcrumb', __('Tanggal ').date('d-M-Y'))

@section('content')
@if(Session::has('status'))
<div class="alert alert-primary alert-has-icon">
    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
    <div class="alert-body">
        <div class="alert-title">{{ __('Informasi') }}</div>
        {{ Session::get('status') }}
    </div>
</div>
@endif
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('Total Barang') }}</h4>
                </div>
                <div class="card-body">
                    {{ $items }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-chart-area"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('Total Stok') }}</h4>
                </div>
                <div class="card-body">
                    {{ number_format($stock) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('Stok Masuk') }}</h4>
                </div>
                <div class="card-body">
                    {{ __('0') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('Stok Keluar') }}</h4>
                </div>
                <div class="card-body">
                    {{ __('0') }}
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="card">
    <div class="card-header">
        <h4>{{ __('Absensi Karyawan Bulanan') }}</h4>
</div>
<div class="card-body">
    <canvas id="absensi"></canvas>
</div>
</div> --}}
@endsection
@section('script')
<script src="{{ asset('pages/home.js') }}"></script>
@endsection