
<div class="col-md-12 col-sm-12 col-xs-12">
	<h2>
		Events	
	</h2>
	<div class="">
		<button class="btn btn-primary add-event-btn">Add Event</button>
	</div>
	<hr>
	<% console.log(events)
	for(var event in events){
		%>

		<div class="row well event-box-item">
		<div class="col-md-2 col-sm-2 col-xs-4">
			<img src="assets/images/avatar-male.png" alt="Add Picture" class="img-thumbnail event-user-avatar">
		</div>
		<div class="col-md-8 col-sm-8 col-xs-8">
			<h4>
				<%= events[event].eventTitle%>
			</h4>
			<p>
			<strong>Date - Time : </strong> <%= events[event].eventDate%> <%= events[event].eventTime%>
			</p>
			<p>
				<strong>Venue : </strong> <%= events[event].eventVenueDesc%>
			</p>
			<p>
				<%= events[event].eventDesc%>
			</p>
		</div>
		<div class="col-md-2 col-sm-2 col-xs-12">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 evnt-action-cnt">
					<button class="btn btn-primary">
						<span class="glyphicon glyphicon-pencil"></span> Edit
					</button>
				</div>
				<br>
				<div class="col-md-12 col-sm-12 col-xs-12 evnt-action-cnt">
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
