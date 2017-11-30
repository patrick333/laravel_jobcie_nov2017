<div class="container-fluid" style="background-color: #000;">

<ul class="nav navbar-nav navbar-left panel-group">
<li>
		<a style="color: #fff;" href="{{url('')}}">Index</a>
	</li>
</ul>

<ul class="nav navbar-nav navbar-right panel-group">
@if (Session::has('token'))
		<li>
			<a style="color: #fff;" href="{{url('logout')}}">Logout</a>
		</li>
@else
	@if (!Request::input('location'))
	  	<li>
			<a style="color: #fff;" href="{{url('login').'?location='.url($_SERVER['REQUEST_URI'])}}">Log in</a>
		</li>
		<li>
			<a style="color: #fff;" href="{{url('signup').'?location='.url($_SERVER['REQUEST_URI'])}}">Sign up</a>
		</li>
	@else
		<li>
			<a style="color: #fff;" href="{{url('login')}}">Log in</a>
		</li>
		<li>
			<a style="color: #fff;" href="{{url('signup')}}">Sign up</a>
		</li>
	@endif

@endif
</ul>

</div>