<div class="panel panel-default">
	<div class="panel-heading">
		<ul class="nav nav-pills nav-justified">
			<li class="active"><a data-toggle="tab" href="#user-admin">User</a></li>
			<li><a data-toggle="tab" href="#project-admin">Project</a></li>
			<li><a data-toggle="tab" href="#team-admin">Team</a></li>
			<li><a data-toggle="tab" href="#danger-admin">Danger</a></li>
		</ul>
	</div>
		<div class="tab-content panel-body">
			<div id="user-admin" class="tab-pane fade in active">
				<h3>User Administration</h3>
				<div class="form-group">
				  <label for="user-select">Select User:</label>
				  <select class="form-control" id="user-select">
				  	<option></option>
				    <?php 
				    	foreach ($data['students'] as $key => $student) {
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

				<h3>User Add</h3>
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

			<div id="project-admin" class="tab-pane fade in panel panel-default">
				<div class="row panel-body">
					<div class="col-sm-6">
						<h3>Project Administration</h3>
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
						  <div class="well radio">
						  	<div class="row">
									<div class="col-sm-6">
										<label class="radio"><input type="radio" name="project-open" value="open">Open Project</label>
									</div>
									<div class="col-sm-6">
										<label class="radio"><input type="radio" name="project-open" value="close" checked="checked">Close Project</label>
									</div>
						    </div>
						  </div>
						  <button onclick="">Save</button>
						</div>	
					</div>
					<div class="col-sm-6">
						<h3>Set number of projects</h3>
		                <div class="form-group">
						  <label for="usr">Project Name:</label>
						  <input type="text" class="form-control" id="add-project">
						</div>
						<button onclick="">Add</button>
					</div>
				</div>
			</div>

			<div id="team-admin" class="tab-pane fade in panel panel-default">
				<div class="row panel-body">
					<div class="col-sm-12">
						<label for="team-project-dropdown">Select Project:</label>
					    <select class="form-control" id="team-project-dropdown">
					    	<option></option>
						    <?php 
						    	foreach ($data['projects'] as $project) {
						    		$name = $project->name;
						    		echo "<option value=$name'>$name<option>";
						    	}
						    ?>
					    </select>
					</div>
				</div>

				<div class="row panel-body">
					<div class="col-md-3">
					  <h3>Students</h3>
					  <p>
					  	<button onclick="addOneStudentPerTeam()" id="one-per-team">One Student Per Team</button>
					  </p>
					  <div class="well droppable" ondrop="drop(event)" ondragover="allowDrop(event)" id="team-select">
					    <?php 
					    	foreach ($data['students'] as $student) {
					    		$name = $student->realName;
					    		$linux_user = $student->username;
					    		echo "<div ondragstart='drag(event)' draggable='true' class='student draggable' id='$linux_user'><b>$name</b></div>";
					    	}
					    ?>
					  </div>
					</div>
					<div class="col-md-9">
						<h3>Teams</h3>
				        <button onclick="makeTeamDiv()">Add Team</button>
				        <button onclick="saveTeams()">Save Teams</button>
						<div id="team-area" data-numteams="0">
							
				    </div>
					</div>
				</div>
			</div>

			<div id="danger-admin" class="tab-pane fade in panel panel-default">
				<div class="panel panel-default">
					<div class="panel-heading">
					</div>

					<div class="panel-body">
					</div>
				</div>
			</div>
		</div>
	</div>