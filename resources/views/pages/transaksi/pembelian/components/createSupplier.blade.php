<form method="POST" action="{{ route('storeSupplier') }}" class="modal-part" id="modal-supplier">
    @csrf
    <div class="form-group">
        <label>{{ __('Nama') }}<code>*</code></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autofocus>
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
    <div class="form-group">
        <label>{{ __('Email') }}</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email">
        @error('email')
        <span class="text-danger" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label>{{ __('Fax') }}</label>
        <input type="text" class="form-control @error('fax') is-invalid @enderror" name="fax">
        @error('fax')
        <span class="text-danger" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label>{{ __('NPWP') }}</label>
        <input type="text" class="form-control @error('npwp') is-invalid @enderror" name="npwp">
        @error('npwp')
        <span class="text-danger" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label>{{ __('Keterangan') }}</label>
        <textarea type="text" class="form-control @error('info') is-invalid @enderror" name="info" cols="150" rows="10"
            style="height: 77px;"></textarea>
        @error('info')
        <span class="text-danger" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label>{{ __('Kota') }}<code>*</code></label>
        <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" required>
        @error('city')
        <span class="text-danger" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label>{{ __('Provinsi') }}<code>*</code></label>
        <input type="text" class="form-control @error('province') is-invalid @enderror" name="province" required>
        @error('province')
        <span class="text-danger" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label>{{ __('Kode POS') }}<code>*</code></label>
        <input type="text" class="form-control @error('pos') is-invalid @enderror" name="pos" required>
        @error('pos')
        <span class="text-danger" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label>{{ __('No Rekening') }}</label>
        <input type="text" class="form-control @error('no_rek') is-invalid @enderror" name="no_rek">
        @error('no_rek')
        <span class="text-danger" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label>{{ __('Nama Rekening') }}</label>
        <input type="text" class="form-control @error('name_rek') is-invalid @enderror" name="name_rek">
        @error('name_rek')
        <span class="text-danger" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label>{{ __('Bank') }}</label>
        <input type="text" class="form-control @error('bank') is-invalid @enderror" name="bank">
        @error('bank')
        <span class="text-danger" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label>{{ __('Nama Sales') }}</label>
        <input type="text" class="form-control @error('sales_name') is-invalid @enderror" name="sales_name">
        @error('sales_name')
        <span class="text-danger" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label>{{ __('Telepon Sales') }}</label>
        <input type="text" class="form-control tlp @error('sales_tlp') is-invalid @enderror" name="sales_tlp">
        @error('sales_tlp')
        <span class="text-danger" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
</form>