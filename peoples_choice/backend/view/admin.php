<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#user-admin">Student Administration</a></li>
	<li><a data-toggle="tab" href="#project-admin">Project Administration</a></li>
</ul>
<div class="tab-content">

	<div id="user-admin" class="tab-pane fade in active">
		<h2>Student Administration</h2>
		<div class="form-group">
		  <label for="user-select">Select Student:</label>
		  <select class="form-control" id="user-select">
		  	<option></option>
		    <?php 

		    	foreach ($data['students'] as $key => $student) {
		    		$username = $student->username;
		    		$realName = $student->realName;
		    		
		    		echo "<option value='$key'>$realName<option>";
		    	}
		     ?>
		  </select>
		</div>
		<div class="well">
			<div id="user-updated" class="alert alert-success hide">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
	     	  <div id="update-msg"></div>
		    </div>
			<div class="form-group">
			  <label for="new-name">Change Full Name:</label>
			  <input type="text" class="form-control" id="new-name">
			</div>
			<div class="form-group">
			  <label for="new-linux">Change Linux Username:</label>
			  <input type="text" class="form-control" id="new-linux">
			</div>
			<div class="well checkbox">
				<label><input id="update-admin-checkbox" type="checkbox" value="admin">Admin</label>
			</div>
			<button style="margin-left: 20px;" onclick="resetPassword(event)">Reset Password</button>
			<button onclick="deleteUser(event)">Delete User</button>
			<button onclick="updateUser(event)">Update</button>
		</div>
		


		<h2>User Add</h2>
		<div class="well">
			<div id="user-added" class="alert alert-success hide">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
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
			<div class="well checkbox">
					<label><input id="add-admin-checkbox" type="checkbox" value="admin">Admin</label>
				</div>
			<button onclick="addUser(event)">Add User</button>
		</div>
		
	</div>

	<div id="project-admin" class="tab-pane fade in">
		<h2>Project Administration</h2>
		<div class="well">
			<div class="form-group">
			  <label for="project-dropdown">Select Project:</label>
			  <select class="form-control" id="project-dropdown">
			    <option></option>
			    <?php 
			    	foreach ($data['projects'] as $project) {
			    		$name = $project->name;
			    		echo "<option value=$name'>$name<option>";
			    	}
			    ?>
			  </select>
			  <div class="well checkbox">
				<label class="inline-checkbox"><input type="checkbox" value="open">Open Project</label>
				<label class="inline-checkbox"><input type="checkbox" value="close">Close Project</label>
			  </div>
			  <button onclick="">Save</button>
			</div>
		</div>
		
	</div>
</div>