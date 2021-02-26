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
            <li class="{{ Request::route()->getName() == 'bidding.index' ? 'active' : (
                Request::route()->getName() == 'bidding.create' ? 'active' : (
                    Request::route()->getName() == 'bidding.edit' ? 'active' : '')) }}">
                <a href="{{ route('bidding.index') }}" class="nav-link"><i
                        class="fas fa-handshake"></i><span>{{ __('Penawaran') }}</span></a>
            </li>
            <li class="{{ Request::route()->getName() == 'tdoc.index' ? 'active' : (
                Request::route()->getName() == 'tdoc.create' ? 'active' : (
                    Request::route()->getName() == 'tdoc.edit' ? 'active' : '')) }}">
                <a href="{{ route('tdoc.index') }}" class="nav-link"><i
                        class="fas fa-shipping-fast"></i><span>{{ __('Surat Jalan') }}</span></a>
            </li>
            <li class="menu-header">{{ __('Master') }}</li>
            <li class="{{ Request::route()->getName() == 'units.index' ? 'active' : (
                    Request::route()->getName() == 'units.create' ? 'active' : (
                        Request::route()->getName() == 'units.edit' ? 'active' : '')) }}">
                <a class="nav-link" href="{{ route('units.index') }}"><i class="fas fa-tags"></i>
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
            <li class="{{ Request::route()->getName() == 'purchase.index' ? 'active' : (
                Request::route()->getName() == 'purchase.create' ? 'active' : '') }}">
                <a class="nav-link" href="{{ route('purchase.index') }}"><i class="fas fa-exchange-alt"></i>
                    <span>{{ __('Pembelian') }}</span></a>
            </li>
            <li class="{{ Request::route()->getName() == 'sales.index' ? 'active' : (
                Request::route()->getName() == 'sales.create' ? 'active' : '') }}">
                <a class="nav-link" href="{{ route('sales.index') }}"><i class="fas fa-exchange-alt"></i>
                    <span>{{ __('Penjualan') }}</span></a>
            </li>
            @elseif(Auth::user()->role_id == '2')
            <li class="{{ Request::route()->getName() == 'masterItemsAlmaas' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('masterItemsAlmaas') }}"><i class="fas fa-boxes"></i>
                    <span>{{ __('Barang') }}</span></a>
            </li>
            @endif
            <li class="menu-header">{{ __('Lainnya') }}</li>
            <li class="{{ Request::route()->getName() == 'report.index' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('report.index') }}"><i class="fas fa-file-alt"></i>
                    <span>{{ __('Laporan') }}</span></a>
            </li>
            <li class="{{ Request::route()->getName() == 'settings.index' ? 'active' : (
                Request::route()->getName() == 'settings.edit' ? 'active' : '') }}">
                <a class="nav-link" href="{{ route('settings.index') }}"><i class="fas fa-cogs"></i>
                    <span>{{ __('Pengaturan') }}</span></a>
            </li>
        </ul>
    </aside>
</div>