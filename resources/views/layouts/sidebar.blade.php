<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text font-weight-light">Keuangan Pribadi</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <!-- Pemasukan -->
                <li class="nav-item">
                    <a href="{{ url('pemasukan') }}" class="nav-link {{ request()->is('pemasukan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-arrow-down text-success"></i>
                        <p>Pemasukan</p>
                    </a>
                </li>

                <!-- Pengeluaran -->
                <li class="nav-item">
                    <a href="{{ url('pengeluaran') }}" class="nav-link {{ request()->is('pengeluaran*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-arrow-up text-danger"></i>
                        <p>Pengeluaran</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
