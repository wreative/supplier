<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">{{ __('pages.title') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">{{ __('PBB') }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('Menu Utama') }}</li>
            <li class="{{ Request::route()->getName() == 'home' ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>{{ __('Dashboard') }}</span></a>
            </li>
            <li class="menu-header">{{ __('Master') }}</li>
            <li class="{{ Request::route()->getName() == 'masterItems' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('masterItems') }}"><i class="fas fa-boxes"></i>
                    <span>{{ __('Barang') }}</span></a>
            </li>
            <li class="{{ Request::route()->getName() == 'masterUnits' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('masterUnits') }}"><i class="fas fa-tags"></i>
                    <span>{{ __('Satuan') }}</span></a>
            </li>
            <li class="nav-item dropdown {{ Request::route()->getName() == 'masterPurchase' ? 'active' : (
                Request::route()->getName() == 'masterPurchase' ? 'active':'') }}">
                <a class="nav-link has-dropdown" href="javascript:void(0)">
                    <i class="fas fa-exchange-alt"></i><span>{{ __('Transaksi') }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::route()->getName() == 'masterPurchase' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('masterPurchase') }}">{{ __('Pembelian') }}</a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'masterPurchase' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('masterPurchase') }}">{{ __('Penjualan') }}</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>