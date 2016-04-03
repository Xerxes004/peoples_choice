<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#user-admin">User Administration</a></li>
	<li><a data-toggle="tab" href="#project-admin">Project Administration</a></li>
</ul>
<div class="tab-content">

	<div id="user-admin" class="tab-pane fade in active">
		<h2>User Administration</h2>
		<form>
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
			<div class="well">
				<div class="form-group">
				  <label for="new-name">Change Full Name:</label>
				  <input type="text" class="form-control" id="new-name">
				</div>
				<div class="form-group">
				  <label for="new-linux">Change Linux Username:</label>
				  <input type="text" class="form-control" id="new-linux">
				</div>
				<div class="well checkbox">
					<label><input type="checkbox" value="admin">Admin</label>
				</div>
				<button style="margin-left: 20px;">Reset Password</button>
				<button>Delete User</button>
			</div>
			<p><button>Save</button><p>
		</form>

		<h2>User Add</h2>
		<div id="user-added" class="alert alert-success hide">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     	  <div id="msg"></div>
	    </div>
		<div class="form-group">
		  <label for="usr">Name:</label>
		  <input type="text" class="form-control" id="add-user">
		</div>
		<div class="form-group">
		  <label for="usr">Linux Username:</label>
		  <input type="text" class="form-control" id="add-linux">
		</div>
		<button onclick="addUser(event)">Add User</button>
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
		  <div class="well checkbox">
			<label class="inline-checkbox"><input type="checkbox" value="admin">Open Project</label>
		  </div>
		  <button onclick="">Save</button>
		</div>
	</div>
</div>