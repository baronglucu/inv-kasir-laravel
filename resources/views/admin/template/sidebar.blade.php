<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('')}}dist/img/AdminLTELogo.png" alt="Aplikasi Inventori" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Apl-Inventori</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('')}}dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Benprology</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
          </li>
                   
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Data Nominatif
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('rakserver.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Rak Server</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('produk.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Produk</p>
                </a>
              </li>            
              <li class="nav-item">
                <a href="{{ route('whm.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data WHM</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('mitra.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Mitra</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('perangkat.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Perangkat</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('domain.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Domain</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('aplsisfo.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Sisfo/Aplikasi</p>
                </a>
              </li>
              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p><code>Data Perangkat</code></p>
                </a>
              </li> --}}
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p><code>Data e-Mail Dinas</code></p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tags"></i>
              <p>
                Pelayanan
                <i class="fas fa-angle-left right"></i>
                {{-- <span class="badge badge-info right">6</span> --}}
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('pengaduan.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Pengaduan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('permohonan.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Permohonan</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Pemeliharaan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">              
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p><code>Data Lisensi Produk</code></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route(name: 'modelrak.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Model Rak Server</p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jenis Server</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User/Pengguna</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Utility
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('produk.logproduk') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Log Produk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('ipcheck.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Check IP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('tracer.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tracer</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
