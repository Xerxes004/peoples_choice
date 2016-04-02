<div class="column">
	<div class="row">
		<div class="col-sm-2"></div>


		<div class="col-sm-8">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#user-admin">User Administration</a></li>
				<li><a data-toggle="tab" href="#project-admin">Project Administration</a></li>
			</ul>
			<div class="tab-content">

				<div id="user-admin" class="tab-pane fade in active">
					<h2>User Administration</h2>
					<div class="form-group">
					  <label for="user-select">Select User:</label>
					  <select class="form-control" id="user-select">
					  	<option></option>
					    <option>user1</option>
					    <option>user2</option>
					    <option>user3</option>
					    <option>user4</option>
					  </select>
					</div>
					<div class="well checkbox">
						<label><input type="checkbox" value="admin">Admin</label>
						<button style="margin-left: 20px;">Reset Password</button>
						<button>Delete User</button>
					</div>
					<p><button>Save</button><p>

					<h2>Add User</h2>
					<div class="form-group">
					  <label for="usr">Name:</label>
					  <input type="text" class="form-control" id="usr">
					</div>
					<button>Add User</button>
				</div>

				<div id="project-admin" class="tab-pane fade in">
					<h2>Project admin content</h2>
					<div class="form-group">
					  <label for="project-dropdown">Select Project:</label>
					  <select class="form-control" id="project-dropdown">
					    <option>Project1</option>
					    <option>Project2</option>
					    <option>Project3</option>
					    <option>Project4</option>
					  </select>
					</div>
				</div>

			</div>
		</div>


		<div class="col-sm-2"></div>
	</div>
</div>