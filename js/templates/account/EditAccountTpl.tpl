<div class="row">
	<div class="edit-cnt col-md-12 col-sm-12 col-xs-12">
		<h3>Edit Profile</h3>
		<hr>
		<form role="form">
			<div class="form-group">
				<label for="txt-input-name">Organization Name</label>
				<input type="text" class="form-control" id="txt-input-name" placeholder="" value="<%= ngoUserName%>">
			</div>

			<div class="form-group">
				<label for="txt-input-desc">Motto</label>
				<textarea class="form-control" rows="3" id="txt-input-desc">
					<%= userDesc%>
				</textarea>
			</div>

			<div class="form-group">
				<label for="txt-input-">Category</label>
				<select class="form-control chosen-select" id="txt-input-category" multiple>
					<%

						if(category != null)
							$.each( category ,function(i,item){
								%><option selected value="<%= item.categoryID %>">
								<%= item.categoryName %>
							</option><%
						});
						%>
						
					</select>
				</div>

				<div class="form-group">
					<label for="txt-input-address">Address</label>
					<textarea class="form-control" rows="3" id="txt-input-address">
						<%= userAddress%>
					</textarea>
				</div>
				<div class="form-group">
					<label for="txt-input-">City</label>
					<select class="form-control" id="txt-input-city">
						<option selected><%=userCity%></option>
						<option>Bengaluru, India</option>
						<option>Mumbai, India</option>
						<option>Kolkatta, India</option>
						<option>Chennai, India</option>
						<option>Delhi, India</option>
					</select>
				</div>


				<div class="form-group">
					<label for="txt-input-contact">Contact Number</label>
					<input type="number" class="form-control" id="txt-input-contact" placeholder="" value="<%= contact%>">
				</div>

				<div class="form-group">
					<label for="txt-input-email">Email address</label>
					<input type="email" class="form-control" id="txt-input-email" placeholder="" value="<%= email%>" >
				</div>

				<div class="form-group">
					<label for="txt-input-website">Website URL</label>
					<input type="url" class="form-control" id="txt-input-website" placeholder="" value="<%= website%>" >
				</div>

				<button class="btn btn-default edit-save-btn">Save</button>
				<button class="btn btn-danger edit-cancel-btn">Cancel</button>
			</form>
		</div><br><br>
	</div>