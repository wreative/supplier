<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">{{ __('pages.title') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">{{ __('HBB') }}</a>
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
            <li class="{{ Request::route()->getName() == 'masterEmployees' ? 'active' : '' }}">
                <a class="nav-link" href="#"><i class="fas fa-exchange-alt"></i>
                    <span>{{ __('Transaksi') }}</span></a>
            </li>
            {{--@if (Auth::user()->previleges == "Administrator")
            <li class="{{ Request::route()->getName() == 'masterUser' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('masterUser') }}"><i class="fas fa-user"></i>
                <span>{{ __('User') }}</span></a>
            </li>
            @endif
            <li class="menu-header">{{ __('Laporan') }}</li>
            <li class="{{ Request::route()->getName() == 'employeesReport' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('employeesReport') }}"><i class="fas fa-file-alt"></i>
                    <span>{{ __('Karyawan') }}</span></a>
            </li>
            <li class="{{ Request::route()->getName() == 'masterEmployees' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('employeesReport') }}"><i class="fas fa-file-invoice-dollar"></i>
                    <span>{{ __('Gaji') }}</span></a>
            </li> --}}
        </ul>
    </aside>
</div>