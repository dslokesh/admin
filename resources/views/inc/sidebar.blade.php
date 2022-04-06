@php
$currentAction = \Route::currentRouteAction();		
list($controller, $action) = explode('@', $currentAction);
$controller = preg_replace('/.*\\\/', '', $controller);
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
      <img src="../../dist/img/MyQuip_logo.png" alt="MyQuip Logo" class="brand-image elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">MyQuip Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <!--div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div-->

      <!-- SidebarSearch Form -->
      <!--div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div-->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @php
          $class='';
          if($controller == 'AuthController' and $action=='dashboard')
            $class = 'active';
          @endphp 
          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link {{$class}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          @php
          $class=''; $active='';
          if($controller == 'CategoryController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp          
          <li class="nav-item {{$class}}">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-list"></i>
              <p>
              Categories
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('categories.index') }}" class="nav-link @php if($controller=='CategoryController' && $action=='index'){ echo 'active';}@endphp">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('categories.create') }}" class="nav-link @php if($controller=='CategoryController' && $action=='create'){ echo 'active';}@endphp">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Category</p>
                </a>
              </li>
            </ul>
          </li>

          @php
          $class=''; $active='';
          if($controller == 'CompanyController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp          
          <li class="nav-item {{$class}}">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-building"></i>
              <p>
              Companies
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('companies.index') }}" class="nav-link @php if($controller=='CompanyController' && $action=='index'){ echo 'active';}@endphp">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Companies</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('companies.create') }}" class="nav-link @php if($controller=='CompanyController' && $action=='create'){ echo 'active';}@endphp">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Company</p>
                </a>
              </li>
            </ul>
          </li>

          @php
          $class=''; $active='';
          if($controller == 'ModulesController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp          
          <li class="nav-item {{$class}}">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-th-large"></i>
              <p>
              Modules
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('modules.index') }}" class="nav-link @php if($controller=='ModulesController' && $action=='index'){ echo 'active';}@endphp">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Modules</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('modules.create') }}" class="nav-link @php if($controller=='ModulesController' && $action=='create'){ echo 'active';}@endphp">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Module</p>
                </a>
              </li>
            </ul>
          </li>

          @php
          $class=''; $active='';
          if($controller == 'AreasController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp          
          <li class="nav-item {{$class}}">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-map-marker"></i>
              <p>
              Areas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('areas.index') }}" class="nav-link @php if($controller=='AreasController' && $action=='index'){ echo 'active';}@endphp">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Areas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('areas.create') }}" class="nav-link @php if($controller=='AreasController' && $action=='create'){ echo 'active';}@endphp">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Area</p>
                </a>
              </li>
            </ul>
          </li>

          @php
          $class=''; $active='';
          if($controller == 'RolesController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp          
          <li class="nav-item {{$class}}">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-user-circle"></i>
              <p>
              Roles
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link @php if($controller=='RolesController' && $action=='index'){ echo 'active';}@endphp">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Roles</p>
                </a>
              </li>
              <!--li class="nav-item">
                <a href="{{ route('roles.create') }}" class="nav-link @php if($controller=='RolesController' && $action=='create'){ echo 'active';}@endphp">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Role</p>
                </a>
              </li-->
            </ul>
          </li>

          @php
          $class=''; $active='';
          if($controller == 'UsersController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp          
          <li class="nav-item {{$class}}">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-user"></i>
              <p>
              Manage Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link @php if($controller=='UsersController' && $action=='index'){ echo 'active';}@endphp">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('users.create') }}" class="nav-link @php if($controller=='UsersController' && $action=='create'){ echo 'active';}@endphp">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create User</p>
                </a>
              </li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="{{route('logout')}}" class="nav-link">
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