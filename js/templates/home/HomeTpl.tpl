<div class="home-img-cnt col-md-12 col-sm-12 col-xs-12">
	<div class="row">
		<div class="home-login-cnt col-md-4 col-sm-6 col-xs-12 col-md-offset-4 col-sm-offset-3">
			<ul class="nav nav-tabs login-tabs-list" role="tablist">
				<li class="active"><a href="#signin-tab" role="tab" data-toggle="tab">Sign In</a></li>
				<li><a href="#signup-tab" role="tab" data-toggle="tab">Sign Up</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane active login-tabs" id="signin-tab">
					<form role="form">
						<br>
						<div class="form-group">
							<label for="txt-signin-email">Email address</label>
							<input type="text" class="form-control" id="txt-signin-email" placeholder="Enter email" required>
						</div><br>
						<div class="form-group">
							<label for="txt-signin-password">Password</label>
							<input type="password" class="form-control" id="txt-signin-password" placeholder="Password" required>
						</div><br>
						
						<button type="button" class="btn btn-success signin-btn">Sign In</button>
					</form>
				</div>

				<div class="tab-pane login-tabs" id="signup-tab">
					<form role="form">
						<div class="form-group">
							<label for="txt-ngo-name">NGO Name</label>
							<input type="text" class="form-control" id="txt-ngo-name" placeholder="Enter name of your NGO" required>
						</div>
						<div class="form-group">
							<label for="txt-signup-email">Email address</label>
							<input type="text" class="form-control" id="txt-signup-email" placeholder="Enter email" required>
						</div>
						<div class="form-group">
							<label for="txt-signup-password">Password</label>
							<input type="password" class="form-control" id="txt-signup-password" placeholder="Password" required>
						</div>
						
						<button type="button" class="btn btn-success signup-btn"> Join </button>
					</form>			
				</div>
				
			</div>
		</div>
	</div>
</div>