<div class="container-fluid" style="background-color: #000;">
<ul class="nav navbar-nav navbar-right panel-group" id="accordion">
	@if (!Request::input('location'))
	  	<li>
			<a href="{{url('login').'?location='.url($_SERVER['REQUEST_URI'])}}">Log in</a>
		</li>
	@endif
	<li>
		<a href="{{url('signup').'?location='.url($_SERVER['REQUEST_URI'])}}">Sign up</a>
	</li>
</ul>
</div>