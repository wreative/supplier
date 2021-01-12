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
            <li class="{{ Request::route()->getName() == 'masterUnits' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('masterUnits') }}"><i class="fas fa-tags"></i>
                    <span>{{ __('Satuan') }}</span></a>
            </li>
            @if (Auth::user()->role_id == '1')
            <li class="{{ Request::route()->getName() == 'masterItems' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('masterItems') }}"><i class="fas fa-boxes"></i>
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
            <li class="{{ Request::route()->getName() == 'masterSales' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('masterSales') }}"><i class="fas fa-hands-helping"></i>
                    <span>{{ __('Sales') }}</span></a>
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
            @endif
        </ul>
    </aside>
</div>