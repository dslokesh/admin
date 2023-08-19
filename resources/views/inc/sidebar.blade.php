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
      <a href="#" class="d-block">
	  @if(auth()->user()->role_id == '3')
		  {{auth()->user()->company_name}}
	  @else
	  {{auth()->user()->full_name}}
	@endif
  </a>
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
		           
        @permission('list.countries')
		 @php
          $class=''; $active='';
          if($controller == 'CountryController' and in_array($action,array('index','create','edit'))){
            $class = 'menu-open';
            $active = 'active';
          }
		  
          @endphp  
              <li class="nav-item">
                <a href="{{ route('countries.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-flag"></i>
                  <p>Countries</p>
                </a>
              </li>
	@endpermission
	 @permission('list.state')
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
			  @endpermission
	 @permission('list.city')
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
			    @endpermission
	 @permission('list.zone')
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
			   @endpermission
	 @permission('list.vehicle')
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
			   @endpermission
	 @permission('list.hotlecat')
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
		@endpermission
	 @permission('list.hotel')
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
			  
			  @endpermission
	 @permission('list.airline')
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
			   @endpermission
	 @permission('list.transfer')
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
			   @endpermission
	 @permission('list.activity')
			   @php
          $class=''; $active='';
          if($controller == 'ActivitiesController' and in_array($action,array('index','create','edit','show','editPriceForm','createPriceForm'))){
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
			   @endpermission
	 @permission('list.voucher')
			   @php
          $class=''; $active='';
          if($controller == 'VouchersController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('vouchers.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-gift"></i>
                  <p>Vouchers</p>
                </a>
              </li>
			   @endpermission
	 @permission('list.customer')
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
			 @endpermission
	 @permission('list.supplier')
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
			   @endpermission
	 @permission('list.subadmin')   
              @php
          $class=''; $active='';
          if($controller == 'UsersController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp          
        
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-user"></i>
                  <p>Sub Admins</p>
                </a>
              </li>
			  @endpermission
	 @permission('list.agent')  
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
			  @endpermission
			  @permission('agency.voucher.booking') 

        @if(auth()->user()->role_id == '3')
        @php
        $class=''; $active='';
        if($controller == 'AgentVouchersController' and in_array($action,array('index','edit','agentVoucherView'))){
          $class = 'menu-open';
          $active = 'active';
        }
   
    
        @endphp 
		
     <li class="nav-item ">
              <a href="{{ route('agent-vouchers.index') }}" class="nav-link {{$active}}">
                 <i class="nav-icon fas fa-gift"></i>
                <p>My Booking</p>
              </a>
            </li>
			@php
        $class=''; $active='';
        if($controller == 'AgentVouchersController' and in_array($action,array('create','addActivityList','show'))){
          $class = 'menu-open';
          $active = 'active';
        }
   
    
        @endphp 
			 <li class="nav-item ">
              <a href="{{ route('agent-vouchers.create') }}" class="nav-link {{$active}}">
                 <i class="nav-icon fas fa-file"></i>
                <p>Book Now</p>
              </a>
            </li>
			@endif

@endpermission
	 @permission('list.agentamount') 
			   @php
          $class=''; $active='';
          if($controller == 'AgentAmountController' and in_array($action,array('index','create','edit','show'))){
            $class = 'menu-open';
            $active = 'active';
          }
		 
		  
          @endphp     
			 <li class="nav-item">
                <a href="{{ route('agentamounts.index') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-money-bill"></i>
                  <p>Agent Amounts</p>
                </a>
              </li>
		@endpermission
		@permission('list.logisticreport') 
			    @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('voucherReport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp     
			  <li class="nav-item">
                <a href="{{ route('voucherReport') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-file"></i>
                  <p>Logistic Report</p>
                </a>
              </li>
		@endpermission
		@permission('list.accountsreceivables') 
			  @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('soaReport'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp    
			   <li class="nav-item">
                <a href="{{ route('soaReport') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-file"></i>
                  <p>Accounts Receivables</p>
                </a>
              </li>
	@endpermission
		@permission('list.agent.ledger') 
			  @php
          $class=''; $active='';
          if($controller == 'ReporsController' and in_array($action,array('agentLedgerReportWithVat'))){
            $class = 'menu-open';
            $active = 'active';
          }
          @endphp    
			   <li class="nav-item">
                <a href="{{ route('agentLedgerReportWithVat') }}" class="nav-link {{$active}}">
                   <i class="nav-icon fas fa-file"></i>
                  <p>Agent Ledger</p>
                </a>
              </li>
			  
		@endpermission
		@role(1)
        @php
        $class=''; $active='';
        if($controller == 'TicketsController' and in_array($action,array('index','create','edit','show','csvUploadForm'))){
          $class = 'menu-open';
          $active = 'active';
        }
   
    
        @endphp 
		
     <li class="nav-item ">
              <a href="{{ route('tickets.index') }}" class="nav-link {{$active}}">
                <i class="nav-icon fas fa-ticket-alt"></i>
                <p>Tickets</p>
              </a>
            </li>
			@php
        $class=''; $active='';
        if($controller == 'TicketsController' and in_array($action,array('generatedTickets'))){
          $class = 'menu-open';
          $active = 'active';
        }
   
    
        @endphp 
			  <li class="nav-item ">
              <a href="{{ route('tickets.generated.tickets') }}" class="nav-link {{$active}}">
                <i class="nav-icon fas fa-ticket-alt"></i>
                <p>Generated Tickets</p>
              </a>
            </li>

            @php
		 
            $class=''; $active='';
            if($controller == 'PagesController' and in_array($action,array('index','create','edit'))){
              $class = 'menu-open';
              $active = 'active';
            }
            @endphp          
           
                <li class="nav-item">
                  <a href="{{ route('pages.index') }}" class="nav-link {{$active}}">
                    <i class="nav-icon fas fa-list"></i>
                    <p>Content Settings</p>
                  </a>
                </li>
		
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