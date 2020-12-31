@extends('layouts.default')
@section('title', __('HRD BatuBeling | Dashboard'))
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
                <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('Total Karyawan') }}</h4>
                </div>
                <div class="card-body">
                    {{ $karyawan }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('Karyawan Aktif') }}</h4>
                </div>
                <div class="card-body">
                    {{ $aktif }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-user-minus"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('Karyawan Pasif') }}</h4>
                </div>
                <div class="card-body">
                    {{ $pasif }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('Jumlah Pelamar') }}</h4>
                </div>
                <div class="card-body">
                    {{ $pelamar }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h4>{{ __('Absensi Karyawan Bulanan') }}</h4>
    </div>
    <div class="card-body">
        <canvas id="absensi"></canvas>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('pages/home.js') }}"></script>
@endsection