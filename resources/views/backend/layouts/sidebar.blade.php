<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
    <div class="d-flex justify-content-center">
        <img width="30%" src="{{asset('img/Allianz-Logo-Transparent-Background.png')}}" alt="logo" loading="lazy"/>
    </div>

  <!-- Divider -->
    <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('admin')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

  <!-- Divider -->
    <hr class="sidebar-divider">

  <!-- Heading -->
    <div class="sidebar-heading">
        Cotation
    </div>

  <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-truck"></i>
            <span>Terrestre</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Cotation Térrestre:</h6>
                <a class="collapse-item" href="{{route('earth.create')}}">Créer</a>
                <a class="collapse-item" href="{{route('earth.index')}}">Liste</a>
            </div>
        </div>
    </li>

  <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-plane"></i>
            <span>Aérien</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Cotation Aérienne:</h6>
                <a class="collapse-item" href="utilities-color.html">Créer</a>
                <a class="collapse-item" href="utilities-border.html">Liste</a>
            </div>
        </div>
    </li>


    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
          aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-ship"></i>
          <span>Maritime</span>
      </a>
      <div id="collapseThree" class="collapse" aria-labelledby="headingUtilities"
          data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Cotation Maritime:</h6>
              <a class="collapse-item" href="utilities-color.html">Créer</a>
              <a class="collapse-item" href="utilities-border.html">Liste</a>
          </div>
      </div>
    </li>

  <!-- Divider -->
    <hr class="sidebar-divider">

  <!-- Heading -->
    <div class="sidebar-heading">
        Addition
    </div>

  <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Profil Client</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Login Screens:</h6> --}}
                <a class="collapse-item" href="{{route('customer.create')}}">Nouveau</a>
                <a class="collapse-item" href="{{route('customer.index')}}">Liste</a>
            </div>
        </div>
    </li>

  <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Taux</span></a>
    </li>


  <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->