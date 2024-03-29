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
@if (Auth::user()->role_id == 1)
@foreach ($stockValue as $s)
<div class="alert alert-danger alert-dismissible show fade">
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        <i class="far fa-lightbulb"></i>
        {{ __(' Barang ').$s->name.__(' akan habis karena memiliki ').$s->stock.__(' stok') }}
    </div>
</div>
@endforeach
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
                    <h4>{{ __('Transaksi Masuk') }}</h4>
                </div>
                <div class="card-body">
                    {{ $purchase }}
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
                    <h4>{{ __('Transaksi Keluar') }}</h4>
                </div>
                <div class="card-body">
                    {{ $sales }}
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col">
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
    <div class="col">
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
</div>
@endif
@endsection
@section('script')
<script src="{{ asset('pages/home.js') }}"></script>
@endsection