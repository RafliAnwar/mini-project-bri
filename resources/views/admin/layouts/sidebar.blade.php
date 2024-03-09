<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #1A374D">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle"
            style="opacity: .8">
        <span class="brand-text font-weight-semibold" style="color: #ffffff">
            Absensi Ruang Baca
            {{-- <img class ="w-50" src="{{ asset("images/perkantas.png") }}" alt=""> --}}
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="pb-3 mt-3 mb-3 user-panel d-flex">
            <div class="image">
                <img src="{{ asset('adminlte/dist/img/admin.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            {{-- <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div> --}}
            <div class="info">
                <a href="#" class="d-block" style="color: #ffffff;">Admin</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item {{ Route::is('admin.dashboard*') ? 'menu-open':'' }}">
                    <a href="#" class="nav-link" style="color: #ffffff;">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dasbor
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('admin.special*', 'admin.book*', 'admin.loans*', 'admin.donate*') ? 'menu-open' : 'menu-close' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book" style="color: #ffffff;"></i>
                        <p style="color: #ffffff;">
                            Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link" style="color: #ffffff;">
                                <i class="far nav-icon {{ Route::is('admin.special*') ? 'fa-dot-circle': 'fa-circle' }}"></i>
                                <p>
                                    Data Asisten
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link" style="color: #ffffff;">
                                <i class="far nav-icon {{ Route::is('admin.book*') ? 'fa-dot-circle': 'fa-circle' }}"></i>
                                <p>
                                    Data Kelas
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link" style="color: #ffffff;">
                                <i class="far nav-icon {{ Route::is('admin.loans*') ? 'fa-dot-circle': 'fa-circle' }}"></i>
                                <p>
                                    Data Materi
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ Route::is('admin.special*', 'admin.book*', 'admin.loans*', 'admin.donate*') ? 'menu-open' : 'menu-close' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-qrcode" style="color: #ffffff;"></i>
                        <p style="color: #ffffff;">
                            Generator
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link" style="color: #ffffff;">
                                <i class="far nav-icon {{ Route::is('admin.special*') ? 'fa-dot-circle': 'fa-circle' }}"></i>
                                <p>
                                    Code Generator
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ Route::is('admin.shift*', 'admin.text*', 'admin.librarian*', 'admin.facility*') ? 'menu-open' : 'menu-close' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-edit" style="color: #ffffff;"></i>
                        <p style="color: #ffffff;">
                            Report
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link" style="color: #ffffff;">
                                <i class="far nav-icon {{ Route::is('admin.shift*') ? 'fa-dot-circle': 'fa-circle' }}"></i>
                                <p>
                                    Report
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link" style="color: #ffffff;">
                                <i class="far nav-icon {{ Route::is('admin.text*') ? 'fa-dot-circle': 'fa-circle' }}"></i>
                                <p>
                                    Riwayat Absen
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="cursor-default disabled">
                    <a href="#" class="cursor-default nav-link disabled">
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" style="color: #ffffff;"
                        onclick="confirmLogout(event)">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<script>
    function confirmLogout(event) {
        event.preventDefault(); // Prevent default link behavior

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: 'Logout',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Kembali',
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, redirect to the logout route
                window.location.href = "{{ route('logout') }}";
            }
        });
    }
</script>
