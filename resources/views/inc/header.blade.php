<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
	<ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">	
		<!-- Messages Dropdown Menu -->
		@if(auth()->user()->role_id == '3')
		<li class="nav-item dropdown">
		<a class="nav-link" data-toggle="dropdown" href="#">
				<span class="hidden-xs"><i class="fa fa-wallet" aria-hidden="true"></i> <b>AED {{\Auth::user()->agent_amount_balance}}</b></span>
			</a>
		</li> 
	@endif		
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<span class="hidden-xs">{{\Auth::user()->name}} <i class="fa fa-caret-down" aria-hidden="true"></i></span>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<div class="card m-0">
					<div class="card-body text-center">
						<div class="dropdown-divider my-2"></div>
						<a href="{{ route('profile-edit',Auth::user()->id) }}" class="btn btn-default d-block">Profile</a>
						<a href="{{ route('change-password') }}" class="btn btn-default d-block">Change Password</a>
						<div class="dropdown-divider my-2"></div>
						<a href="{{route('logout')}}" class="btn btn-default d-block">Sign out</a>
					</div>
				</div>
			</div>
		</li>        
    </ul>
</nav>