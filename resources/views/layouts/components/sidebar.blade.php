<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">{{ __('HRD BatuBeling') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">{{ __('HBB') }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('Dashboard') }}</li>
            <li class="{{ Request::route()->getName() == 'home' ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>{{ __('Dashboard') }}</span></a>
            </li>
            <li class="menu-header">{{ __('Master') }}</li>
            <li class="{{ Request::route()->getName() == 'masterEmployees' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('masterEmployees') }}"><i class="fas fa-users"></i>
                    <span>{{ __('Karyawan') }}</span></a>
            </li>
            <li class="nav-item dropdown {{ Request::route()->getName() == 'masterSalary' ? 'active' : (
                    Request::route()->getName() == 'createSalary' ? 'active':(
                        Request::route()->getName() == 'masterLoyalty' ? 'active':(
                            Request::route()->getName() == 'createLoyalty' ? 'active' : ''))) }}">
                <a class="nav-link has-dropdown" href="javascript:void(0)"><i class="fas fa-hand-holding-usd"></i>
                    <span>{{ __('Gaji') }}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::route()->getName() == 'masterSalary' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('masterSalary') }}">{{ __('Daftar Gaji Karyawan') }}</a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'masterLoyalty' ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('masterLoyalty') }}">{{ __('Daftar Loyalitas & Dedikasi') }}</a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'createLoyalty' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('createLoyalty') }}">{{ __('Loyalitas & Dedikasi') }}</a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'createSalary' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('createSalary') }}">{{ __('Tambah Gaji Karyawan') }}</a>
                    </li>
                </ul>
            </li>
            @if (Auth::user()->previleges == "Administrator")
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
            </li>
        </ul>
    </aside>
</div>