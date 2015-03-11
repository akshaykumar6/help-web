
<div class="col-md-12 col-sm-12 col-xs-12">
	<h2>
		Needs
	</h2>
	<div class="">
		<button class="btn btn-primary add-need-btn">Add Need</button>
	</div>
	<hr>
	<% console.log(needs)
	for(var need in needs){
		%>
	<div class="row well need-box-item">
		<div class="col-md-2 col-sm-2 col-xs-4">
			<img src="assets/images/avatar-female.png" alt="Add Picture" class="img-thumbnail event-user-avatar">
		</div>
		<div class="col-md-8 col-sm-8 col-xs-8">
			<h4>
				<%= needs[need].needTitle%>
			</h4>
			
			<p>
				<%= needs[need].needDesc%>
			</p>
		</div>
		<div class="col-md-2 col-sm-2 col-xs-12">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 need-action-cnt">
					<button class="btn btn-primary">
						<span class="glyphicon glyphicon-pencil"></span> Edit
					</button>
				</div>
				<br>
				<div class="col-md-12 col-sm-12 col-xs-12 need-action-cnt">
					<button class="btn btn-danger">
						<span class="glyphicon glyphicon-trash"></span> Delete
					</button>
				</div>
			</div>
		</div>
	</div>

	<%
	}

	%>
</div>
