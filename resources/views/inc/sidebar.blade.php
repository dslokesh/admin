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
                  <p>Countries</p>
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
                  <p>States</p>
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
                  <p>Cities</p>
                </a>
              </li>
			   @php
          $class=''; $active='';
          if($controller == 'ZonesController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('zones.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-chart-area"></i>
                  <p>Zones</p>
                </a>
              </li>
			   @php
          $class=''; $active='';
          if($controller == 'VehiclesController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('vehicles.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-car"></i>
                  <p>Vehicles</p>
                </a>
              </li>
			  @php
          $class=''; $active='';
          if($controller == 'HotelCategoryController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('hotelcategories.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-star"></i>
                  <p>Hotel Category</p>
                </a>
              </li>
			  @php
          $class=''; $active='';
          if($controller == 'HotelController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('hotels.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-hotel"></i>
                  <p>Hotels</p>
                </a>
              </li>
			  
			  
			   @php
          $class=''; $active='';
          if($controller == 'AirlinesController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('airlines.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-plane"></i>
                  <p>Airlines</p>
                </a>
              </li>
			   @php
          $class=''; $active='';
          if($controller == 'TransfersController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('transfers.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-exchange-alt"></i>
                  <p>Transfers</p>
                </a>
              </li>
			   @php
          $class=''; $active='';
          if($controller == 'ActivitiesController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('activities.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-tasks"></i>
                  <p>Activities</p>
                </a>
              </li>
			   @php
          $class=''; $active='';
          if($controller == 'CustomersController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('customers.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-user"></i>
                  <p>Cutomers</p>
                </a>
              </li>
			
			 @php
          $class=''; $active='';
          if($controller == 'SuppliersController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('suppliers.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-user"></i>
                  <p>Suppliers</p>
                </a>
              </li>
			   @endrole    
              @php
          $class=''; $active='';
          if($controller == 'UsersController' and in_array($action,array('index','create','edit','show'))){
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
			   @php
          $class=''; $active='';
          if($controller == 'AgentsController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			 <li class="nav-item">
                <a href="{{ route('agents.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-user"></i>
                  <p>Agents</p>
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
                  <p>Permissions</p>
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