<!-- Session login check -->
@if (session()->get('factory') == null && session()->get('username') == null) redirect()->route('log') @endif

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="{{ asset('assets/dist/img/tl-logo.png') }}" alt="TLS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Traffic Light System</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
        @if (session()->get('level') == 'S')
        <li class="nav-header">BASIC DATA SETTING</li>
        <li class="nav-item
                    @if (url('') == url('users/Section') || url('') == url('users/Process'))
                      {{ 'menu-open' }}
                    @endif
                    ">
          <a  href="#"
              class="nav-link
                    @if (url('') == url('users/Section') || url('') == url('users/Process'))
                        {{ 'active' }}
                    @endif
                    ">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Basic Data
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a  href="{{ url('users/Section') }}"
                  class="nav-link
                        @if (url('') == url('users/Section'))
                            {{ 'active' }}
                        @endif
                        ">
                <i class="far fa-circle nav-icon"></i>
                <p>Section/Line Data</p>
              </a>
            </li>
            <li class="nav-item">
              <a  href="{{ url('users/Process') }}"
                  class="nav-link
                        @if (url('') == url('users/Process'))
                            {{ 'active' }}
                        @endif
                        ">
                <i class="far fa-circle nav-icon"></i>
                <p>Step Process Data</p>
              </a>
            </li>
            <li class="nav-item">
              <a  href="{{ url('users/Defect') }}"
                  class="nav-link
                        @if (url('') == url('users/Defect'))
                            {{ 'active' }}
                        @endif
                        ">
                <i class="far fa-circle nav-icon"></i>
                <p>Defect List Data</p>
              </a>
            </li>
            <li class="nav-item">
              <a  href="{{ url('users/Suggest') }}"
                  class="nav-link
                        @if (url('') == url('users/Suggest'))
                            {{ 'active' }}
                        @endif
                        ">
                <i class="far fa-circle nav-icon"></i>
                <p>Suggestion List Data</p>
              </a>
            </li>
          </ul>
        </li>
        @endif
        <li class="nav-header">TRAFFIC LIGHT PROCESS</li>
        @if (session()->get('level') == 'S' | session()->get('level') == 'U')
        <li class="nav-item">
          <a  href="{{ url('users/Collection') }}"
              class="nav-link
                    @if (url('') == url('users/Collection'))
                        {{ 'active' }}
                    @endif
                    ">
            <i class="nav-icon fas fa-database"></i>
            <p>Data Collection</p>
          </a>
        </li>
        @endif
        <li class="nav-item">
          <a  href="{{ url('users/Collection/visual') }}"
              class="nav-link
              @if (url('') == url('users/Collection/visual') ||
                    url('') == url('users/Collection/detail'))
                  {{ 'active' }}
              @endif
              ">
            <i class="nav-icon fas fa-eye"></i>
            <p>Data Visualization</p>
          </a>
        </li>
        <li class="nav-header">REPORT</li>
        <li class="nav-item">
          <a  href="{{ url('users/Collection/report') }}"
              class="nav-link
                    @if (url('') == url('users/Collection/report'))
                        {{ 'active' }}
                    @endif
                    ">
            <i class="nav-icon fas fa-book"></i>
            <p>Data Collection Report</p>
          </a>
        </li>
        <li class="nav-item">
          <a  href="{{ url('users/Collection/hourly') }}"
              class="nav-link
                    @if (url('') == url('users/Collection/hourly'))
                        {{ 'active' }}
                    @endif
                    ">
            <i class="nav-icon fas fa-clock"></i>
            <p>Hourly Defect Report</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
