<div class="row">
	<div class="col-md-4 col-sm-4 col-xs-4">
		<img src="assets/images/avatar-male.png" alt="Add Picture" class="img-thumbnail user-avatar">
	</div>
	<div class="col-md-8 col-sm-8 col-xs-8">
		<h2>
			<%= ngoUserName%>
		</h2>
		<h4><%= userCity%></h4>

		<h4>
			<a href="" class="edit-profile-btn">
				<span class="glyphicon glyphicon-pencil"></span> Edit Profile
			</a>
		</h4>
	</div>
	
</div>
<hr>
<div class="row">
	<div class="col-md-10 col-sm-10 col-xs-10 ">
		<div class="">
			<h3>
				Motto
			</h3>
			<%= userDesc%>
		</div>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<h3>
			Contact Details
		</h3>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-6">
		<div>
			<strong><h4>Address</h4></strong>
			<span><%= userAddress%></span>
		</div>
		<div>
			<strong><h4>Phone</h4></strong>
			<span><%= contact%></span>
		</div>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-6">
		<div>
			<strong><h4>Email</h4></strong>
			<span><%= email%></span>
		</div>
		<div>
			<strong><h4>Website</h4></strong>
			<span><%= website%></span>
		</div>
	</div>
	
</div>
