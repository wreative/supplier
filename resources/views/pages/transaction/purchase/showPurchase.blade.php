@extends('layouts.default')
@section('title', __('pages.title').__(' | Detail Pembelian'))
@section('titleContent', __('Detail Pembelian'))
@section('breadcrumb', __('Transaksi'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Pembelian') }}</div>
<div class="breadcrumb-item active">{{ __('Detail') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $transaction->relationPurchase->code }}</h2>
<p class="section-lead">
    {{ __('Kode transaksi yang berisi kode unik untuk setiap transaksi pembelian yang dilakukan. Dibuat pada tanggal ').
    date("d-M-Y", strtotime($transaction->tgl)) }}
</p>
<form method="POST" action="{{ route('purchase.update',$transaction->id) }}" id="addPurchase">
    @csrf
    @method('PUT')
    <input value="{{ $transaction->id }}" name="id" type="hidden">
    <div class="card card-primary">
        <div class="card-body">
            <h2 class="section-title mt-0">{{ __('Supplier') }}</h2>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Nama') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="name_supplier"
                                value="{{ $transaction->relationSupplier->name }}" readonly>
                            <div class="input-group-append">
                                <button class="btn cbcopy btn-primary" type="button"
                                    data-clipboard-target="#name_supplier" data-toggle="tooltip" title="Copy Data">
                                    <i class="far fa-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Kode') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="code_supplier"
                                value="{{ $transaction->relationSupplier->code }}" readonly>
                            <div class="input-group-append">
                                <button class="btn cbcopy btn-primary" type="button"
                                    data-clipboard-target="#code_supplier" data-toggle="tooltip" title="Copy Data">
                                    <i class="far fa-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="section-title mb-3">{{ __('Barang') }}</h2>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Barang') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="items"
                                value="{{ $transaction->relationItems->code.__(' - ').$transaction->relationItems->name }}"
                                readonly>
                            <div class="input-group-append">
                                <button class="btn cbcopy btn-primary" type="button" data-clipboard-target="#items"
                                    data-toggle="tooltip" title="Copy Data">
                                    <i class="far fa-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Harga Pokok Barang') }}<code>*</code></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input class="form-control" id="price" value="{{ number_format($detailItems->price) }}"
                                type="text" readonly>
                            <div class="input-group-append">
                                <button class="btn cbcopy btn-primary" type="button" data-clipboard-target="#price"
                                    data-toggle="tooltip" title="Copy Data">
                                    <i class="far fa-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label class="form-label">{{ __('Ganti Harga Pada Master Barang') }}</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" value="1" class="selectgroup-input" disabled>
                                <span class="selectgroup-button">{{ __('Ya') }}</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" value="0" class="selectgroup-input" checked disabled>
                                <span class="selectgroup-button">{{ __('Tidak') }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Total Barang') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="total" value="{{ $transaction->total }}"
                                readonly>
                            <div class="input-group-append">
                                <button class="btn cbcopy btn-primary" type="button" data-clipboard-target="#total"
                                    data-toggle="tooltip" title="Copy Data">
                                    <i class="far fa-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Discount Per Item (Nominal)') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input class="form-control" id="nom" value="{{ $transaction->relationPurchase->dsc }}"
                                type="text" readonly>
                            <div class="input-group-append">
                                <button class="btn cbcopy btn-primary" type="button" data-clipboard-target="#nom"
                                    data-toggle="tooltip" title="Copy Data">
                                    <i class="far fa-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Discount Per Item (Persen)') }}</label>
                        <div class="input-group">
                            <input class="form-control" id="percent"
                                value="{{ $transaction->relationPurchase->dsc_per.__('%') }}" type="text" readonly>
                            <div class="input-group-append">
                                <button class="btn cbcopy btn-primary" type="button" data-clipboard-target="#percent"
                                    data-toggle="tooltip" title="Copy Data">
                                    <i class="far fa-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Harga Diskon') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input class="form-control" id="price_dsc"
                                value="{{ number_format($transaction->relationPurchase->dsc_nom) }}" type="text"
                                readonly>
                            <div class="input-group-append">
                                <button class="btn cbcopy btn-primary" type="button" data-clipboard-target="#price_dsc"
                                    data-toggle="tooltip" title="Copy Data">
                                    <i class="far fa-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Pajak') }}<code>*</code></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input class="form-control" id="tax"
                                value="{{ number_format($transaction->relationPurchase->tax) }}" type="text" readonly>
                            <div class="input-group-append">
                                <button class="btn cbcopy btn-primary" type="button" data-clipboard-target="#tax"
                                    data-toggle="tooltip" title="Copy Data">
                                    <i class="far fa-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label class="form-label">{{ __('Include PPN') }}</label>
                        <div class="selectgroup w-100" id="ppn">
                            <label class="selectgroup-item">
                                <input type="radio" class="selectgroup-input" disabled
                                    {{ $transaction->relationPurchase->ppn == 1 ? 'checked' : '' }}>
                                <span class="selectgroup-button">{{ __('Ya') }}</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" class="selectgroup-input" disabled
                                    {{ $transaction->relationPurchase->ppn == 0 ? 'checked' : '' }}>
                                <span class="selectgroup-button">{{ __('Tidak') }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Uang Muka (DP)') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input type="text" class="form-control currency" id="dp"
                                value="{{ $transaction->relationPurchase->dp }}" readonly>
                            <div class="input-group-append">
                                <button class="btn cbcopy btn-primary" type="button" data-clipboard-target="#dp"
                                    data-toggle="tooltip" title="Copy Data">
                                    <i class="far fa-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Biaya Kirim') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input type="text" class="form-control currency" id="ship_price"
                                value="{{ $transaction->relationPurchase->ship_price }}" readonly>
                            <div class="input-group-append">
                                <button class="btn cbcopy btn-primary" type="button" data-clipboard-target="#ship_price"
                                    data-toggle="tooltip" title="Copy Data">
                                    <i class="far fa-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Biaya Lain') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input type="text" class="form-control currency" id="etc_price"
                                value="{{ $transaction->relationPurchase->etc_price }}" readonly>
                            <div class="input-group-append">
                                <button class="btn cbcopy btn-primary" type="button" data-clipboard-target="#etc_price"
                                    data-toggle="tooltip" title="Copy Data">
                                    <i class="far fa-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('Status') }}<code>*</code></label>
                <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                        <input type="radio" name="status" value="0" class="selectgroup-input"
                            {{ $transaction->relationPurchase->status == 'Dipesan' ? 'checked' : '' }}>
                        <span class="selectgroup-button">{{ __('Dipesan') }}</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="status" value="1" class="selectgroup-input"
                            {{ $transaction->relationPurchase->status == 'Diterima' ? 'checked' : '' }}>
                        <span class="selectgroup-button">{{ __('Diterima') }}</span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('Keterangan') }}</label>
                <textarea type="text" class="form-control @error('info') is-invalid @enderror" name="info" cols="150"
                    rows="10" style="height: 77px;" readonly>
                    @if ($transaction->relationPurchase->info != null)
                    {{ $transaction->relationPurchase->info }}
                    @else
                    {{ __('Kosong') }}
                    @endif
                </textarea>
            </div>
        </div>
    </div>
    <h2 class="section-title">{{ __('Pembayaran') }}</h2>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Jumlah') }}<code>*</code></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ __('Rp.') }}
                                </div>
                            </div>
                            <input class="form-control currency @error('payment') is-invalid @enderror"
                                value="{{ $transaction->relationPurchase->payment }}" type="text" name="payment"
                                required>
                        </div>
                        @error('payment')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>{{ __('Metode Pembayaran') }}<code>*</code></label>
                        <select class="form-control @error('payment_method') is-invalid @enderror" name="payment_method"
                            required>
                            @foreach ($payment as $p)
                            <option value="{{ $p->id }}" {{ $transaction->pay_id == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('payment_method')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.transaction.components.floatingButton', ['form' => 'addPurchase'])
</form>
@endsection
@section('script')
<script>
    $(".currency")
    .toArray()
    .forEach(function(field) {
        new Cleave(field, {
            numeral: true,
            numeralDecimalMark: ".",
            delimiter: ","
        });
    });
</script>
@endsection