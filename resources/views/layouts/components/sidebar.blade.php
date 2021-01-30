<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">{{ __('pages.title') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">{{ __('pages.brand') }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('Menu Utama') }}</li>
            <li class="{{ Request::route()->getName() == 'home' ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>{{ __('Dashboard') }}</span></a>
            </li>
            <li class="menu-header">{{ __('Master') }}</li>
            <li class="{{ Request::route()->getName() == 'masterUnits' ? 'active' : (
                    Request::route()->getName() == 'createUnits' ? 'active' : '') }}">
                <a class="nav-link" href="{{ route('masterUnits') }}"><i class="fas fa-tags"></i>
                    <span>{{ __('Satuan') }}</span></a>
            </li>
            @if (Auth::user()->role_id == '1')
            <li class="{{ Request::route()->getName() == 'items.index' ? 'active' : (
                    Request::route()->getName() == 'items.create' ? 'active' : (
                        Request::route()->getName() == 'items.edit' ? 'active' : '')) }}">
                <a class="nav-link" href="{{ route('items.index') }}"><i class="fas fa-boxes"></i>
                    <span>{{ __('Barang') }}</span></a>
            </li>
            <li class="{{ Request::route()->getName() == 'masterCustomer' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('masterCustomer') }}"><i class="fas fa-users"></i>
                    <span>{{ __('Customers') }}</span></a>
            </li>
            <li class="{{ Request::route()->getName() == 'masterSupplier' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('masterSupplier') }}"><i class="fas fa-people-carry"></i>
                    <span>{{ __('Supplier') }}</span></a>
            </li>
            <li class="{{ Request::route()->getName() == 'masterMarketer' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('masterMarketer') }}"><i class="fas fa-hands-helping"></i>
                    <span>{{ __('Sales') }}</span></a>
            </li>
            <li class="menu-header">{{ __('Transaksi') }}</li>
            <li class="{{ Request::route()->getName() == 'masterPurchase' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('masterPurchase') }}"><i class="fas fa-exchange-alt"></i>
                    <span>{{ __('Pembelian') }}</span></a>
            </li>
            <li class="{{ Request::route()->getName() == 'masterSales' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('masterSales') }}"><i class="fas fa-exchange-alt"></i>
                    <span>{{ __('Penjualan') }}</span></a>
            </li>
            @elseif(Auth::user()->role_id == '2')
            <li class="{{ Request::route()->getName() == 'masterItemsAlmaas' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('masterItemsAlmaas') }}"><i class="fas fa-boxes"></i>
                    <span>{{ __('Barang') }}</span></a>
            </li>
            @endif
        </ul>
    </aside>
</div>