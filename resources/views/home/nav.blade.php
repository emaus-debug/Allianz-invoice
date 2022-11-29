<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Container wrapper -->
    <div class="container">
      <!-- Navbar brand -->
      <a class="navbar-brand me-2" href="/">
        <img src="{{asset("img/logo.png")}}" height="30" alt="Allianz Logo" style="margin-top: 1px; margin-right: 8px"/>
      </a>

      <!-- Toggle button -->
      <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarButtonsExample" aria-controls="navbarButtonsExample" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Collapsible wrapper -->
      <div class="collapse navbar-collapse" id="navbarButtonsExample">
        <!-- Left links -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{route('admin')}}">Dashboard</a>
          </li>
        </ul>
        <!-- Left links -->

        @guest
          <div class="d-flex align-items-center">
            @if (Route::has('login'))
              <a href="{{route('login')}}"><button type="button" class="btn btn-primary px-3 me-2">
                  Login
                </button></a>
            @endif
            @if (Route::has('register'))
              <button type="button" class="btn btn-primary me-3">
                Sign up for free
              </button>
            @endif

          </div>
        @endguest
      </div>
      <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
</nav>