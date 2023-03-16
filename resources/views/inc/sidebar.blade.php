@php
$currentAction = \Route::currentRouteAction();		
list($controller, $action) = explode('@', $currentAction);
$controller = preg_replace('/.*\\\/', '', $controller);
@endphp

<aside class="main-sidebar sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!--<a href="{{route('dashboard')}}" class="brand-link">
      <img src="../../dist/img/MyQuip_logo.png" alt="MyQuip Logo" class="brand-image elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-bold">Admin</span>
    </a>-->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @if(isset(auth()->user()->image) && !empty(auth()->user()->image))
      <img src="{{asset('uploads/users/thumb/'.auth()->user()->image)}}" style="height: 30px;width: 30px;"  class="img-circle elevation-2" alt="User Image">
      @else
      <img src="{{asset('dist/img/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
      @endif  
    </div>
      <div class="info">
      <a href="#" class="d-block">{{auth()->user()->full_name}}</a>
      </div>
  </div>
    <!-- Sidebar -->
    <div class="sidebar">
     
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
              <p class="text-bold">
                Dashboard
              </p>
            </a>
          </li>
		    @php
          $class=''; $active='';
          if($controller == 'CountryController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp          
         @role('1|2')
              <li class="nav-item">
                <a href="{{ route('countries.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-flag"></i>
                  <p>Country</p>
                </a>
              </li>
			  @php
          $class=''; $active='';
          if($controller == 'StateController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('states.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-flag"></i>
                  <p>State</p>
                </a>
              </li>
			  @php
          $class=''; $active='';
          if($controller == 'CityController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('cities.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-city"></i>
                  <p>City</p>
                </a>
              </li>
			   @endrole    
              @php
          $class=''; $active='';
          if($controller == 'UsersController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp          
         @role('1|2')
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-user"></i>
                  <p>Sub Admins</p>
                </a>
              </li>
			  
			  
			   @endrole
		@role(1)
		@php
		 
          $class=''; $active='';
          if($controller == 'RoleController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp          
         
              <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link {{$active}}">
                  <i class="nav-icon fas fa-list"></i>
                  <p>Roles</p>
                </a>
              </li>
          @php
		 
          $class=''; $active='';
          if($controller == 'PermissionRoleController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp          
         
              <li class="nav-item">
                <a href="{{ route('permrole.index') }}" class="nav-link {{$active}}">
                  <i class="nav-icon fas fa-list"></i>
                  <p>Roles & Permissions</p>
                </a>
              </li>
              
		@endrole 
		
        
			  
            
		

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