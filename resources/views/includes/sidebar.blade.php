<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-text mx-3">SI Produksi Susu Sapi </div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ Request::is('setoran*') || Request::is('/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.setoran') }}">
      <!-- <i class="fas fa-fw fa-tachometer-alt"></i> -->
      <span>Setoran</span></a>
  </li>
  <li class="nav-item {{ Request::is('pembagian_pakan*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.pembagian_pakan') }}">
      <!-- <i class="fas fa-fw fa-tachometer-alt"></i> -->
      <span>Pembagian Pakan </span></a>
  </li>
  <li class="nav-item {{ Request::is('pakan*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.pakan') }}">
      <!-- <i class="fas fa-fw fa-tachometer-alt"></i> -->
      <span>Stok Pakan</span></a>
  </li>
  <li class="nav-item {{ Request::is('perahan*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.perahan') }}">
      <!-- <i class="fas fa-fw fa-tachometer-alt"></i> -->
      <span>Hasil Perahan</span></a>
  </li>
  <li class="nav-item {{ Request::is('sapi*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.sapi') }}">
      <!-- <i class="fas fa-fw fa-tachometer-alt"></i> -->
      <span>Data Sapi</span></a>
  </li>
</ul>
<!-- End of Sidebar -->