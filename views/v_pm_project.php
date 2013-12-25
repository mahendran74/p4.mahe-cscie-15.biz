
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../img/favicon.png">

<title>Quick CM : PM Home</title>

<!-- Bootstrap core CSS -->
<link href="../../css/bootstrap.css" rel="stylesheet">
<link href="../../css/select2.css" rel="stylesheet" />
<link href="../../css/select2-bootstrap.css" rel="stylesheet" />
<link href="../../css/datepicker.css" rel="stylesheet">
<link href="../../css/slider.css" rel="stylesheet">
<link href="../../css/jquery-simplecolorpicker.css" rel="stylesheet">
<link href="../../css/jquery.simplecolorpicker-glyphicons.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="../../css/qpm.css" rel="stylesheet">
<!-- Custom themes for this template -->
<link href="../../css/qpm-pm-theme.css" rel="stylesheet">
<link href="../../css/jsgantt.css" rel="stylesheet">
<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>

  <!-- Fixed navbar -->
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">Quick PM <small><small>Project Manager</small></small></a>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="/">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?=$user->first_name?>  <?=$user->last_name?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li class="dropdown-header">Switch Role To ...</li>
              <?php if(array_key_exists( 1, $roles)): ?>
              <li class="admin-interface"><a href="/admin/home"><span class="glyphicon glyphicon-user"></span> Administrator </a></li>
              <?php endif;?>
              <?php if(array_key_exists( 3, $roles)): ?>
              <li class="tm-interface"><a href="/tm/home"><span class="glyphicon glyphicon-user"></span> Team Member</a></li>
              <?php endif;?>
              <li class="divider"></li>
              <li><a href="#"><span class="glyphicon glyphicon-edit"></span> Edit Profile </a></li>
              <li><a href="/users/logout"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
            </ul></li>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 class="panel-title"><?=$project['project_name']?></h3>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="pull-right">
                  <a id="addNewGroup" type="button" class="btn btn-xs btn-success right-button" data-toggle="tooltip" title="New Group">
                    <span class="glyphicon glyphicon-bookmark"></span>
                  </a>
                  <a id="addNewTask" type="button" class="btn btn-xs btn-success right-button" data-toggle="tooltip" title="New Task">
                    <span class="glyphicon glyphicon-minus"></span>
                  </a>
                  <a id="addNewMilestone" type="button" class="btn btn-xs btn-success right-button" data-toggle="tooltip" title="New Milestone">
                    <span class="glyphicon glyphicon-map-marker"></span>
                  </a>
                  <a id="addNewUser" type="button" class="btn btn-xs btn-success right-button" data-toggle="tooltip" title="New User">
                    <span class="glyphicon glyphicon-user"></span>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="panel-body">
            <div class="gantt" id="GanttChartDIV"></div>
            <input type="hidden" id="project_id" value="<?=$project['project_id']?>" />
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- /container -->

  <!-- START NEW USER MODAL -->

  <!-- New User Modal -->
  <div class="modal fade" id="addNewUserWindow" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method='POST' action='' id="addNewUserForm">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="addNewUserModalLabel">Add New User</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" id="alertAddNewUser">
              <strong>Oh snap!</strong>
            </div>
            <input type="hidden" name="tm_access" value="on" />
            <div class="form-group">
              <label for="first_name">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="" 
                data-msg-required="Please enter a first name." 
                data-msg-maxlength="The first name cannot be more than 255 characters." 
                data-rule-required="true" 
                data-rule-maxlength="255" />
            </div>
            <div class="form-group">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="" 
                data-msg-required="Please enter a last name." 
                data-msg-maxlength="The last name cannot be more than 255 characters." 
                data-rule-required="true" 
                data-rule-maxlength="255" />
            </div>
            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="" 
                data-msg-email="Please enter a valid email." 
                data-msg-required="Please enter a valid email." 
                data-msg-maxlength="Your email cannot be more than 255 characters" 
                data-rule-email="true" data-rule-required="true" 
                data-rule-maxlength="255" />
              <div id="message"></div>
            </div>
            <div class="form-group">
              <label for="confirm_email">Confirm Email Address</label>
              <input type="text" class="form-control" id="confirm_email" name="confirm_email" placeholder="Confirm Email" value="" 
                data-msg-email="Please confirm the email above." 
                data-msg-required="Please confirm the email above." 
                data-msg-maxlength="Your email cannot be more than 255 characters" 
                data-msg-equalTo="The email confirmation has to match the email above." 
                data-rule-email="true" data-rule-required="true"
                data-rule-maxlength="255" 
                data-rule-equalTo="#email" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success btn-primary" id="saveButton">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /END NEW USER MODAL -->

  <!-- START NEW TASK MODAL -->

  <!-- New Task Modal -->
  <div class="modal fade" id="addNewTaskWindow" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method='POST' action='' id="addNewTaskForm">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="addNewTaskModalLabel">Add New Task</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" id="alertAddNewTask">
              <strong>Oh snap!</strong>
            </div>
            <div class="form-group">
              <label for="task_desc">Task Description</label>
              <input type="text" class="form-control" id="task_task_desc" name="task_desc" placeholder="Task Description" value="" 
                data-msg-required="Please enter the task description." 
                data-msg-maxlength="The task description cannot be more than 255 characters." 
                data-rule-required="true" 
                data-rule-maxlength="255" />
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="start_date">Start Date</label>
                  <input type="text" class="form-control" id="task_start_date" name="start_date" value="" 
                    data-msg-date="Please enter a valid date as start date." 
                    data-msg-required="Please enter a valid date as start date." 
                    data-rule-date="true" 
                    data-rule-required="true" />
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="end_date">End Date</label>
                  <input type="text" class="form-control" id="task_end_date" name="end_date" value="" 
                    data-msg-date="Please enter a valid date as end date." 
                    data-msg-required="Please enter a valid date as end date." 
                    data-rule-date="true" 
                    data-rule-required="true" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="status">Status</label> 
                  <select name="status" id="task_status">
                    <option value="#7bd148">Green</option>
                    <option value="#ffb878">Yellow</option>
                    <option value="#dc2127">Red</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="color">Color</label> 
                  <select name="color" id="task_color">
                    <option value="#7bd148">Green</option>
                    <option value="#5484ed">Bold blue</option>
                    <option value="#a4bdfc">Blue</option>
                    <option value="#46d6db">Turquoise</option>
                    <option value="#7ae7bf">Light green</option>
                    <option value="#51b749">Bold green</option>
                    <option value="#fbd75b">Yellow</option>
                    <option value="#ffb878">Orange</option>
                    <option value="#ff887c">Red</option>
                    <option value="#dc2127">Bold red</option>
                    <option value="#dbadff">Purple</option>
                    <option value="#e1e1e1">Gray</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="assigned_to_id">Task Assigned To</label>
              <input type="hidden" class="form-control" id="task_assigned_to_id" name="assigned_to_id" placeholder="Select a team member" value="" 
                data-msg-required="Please select a team mamber." 
                data-rule-required="true"/>
            </div>
            <div class="form-group">
              <label for="groups_group_id">Task Group</label>
              <input type="hidden" class="form-control" id="task_groups_group_id" name="groups_group_id" placeholder="Select a task group" value=""
                data-msg-required="Please select a team group." 
                data-rule-required="true"/>
            </div>
            <div class="form-group">
              <label for="depends_on">Depended On</label>
              <input type="hidden" class="form-control" id="task_depends_on" name="depends_on" placeholder="Select a dependent task" value="" />
            </div>
            <div class="form-group">
              <label for="per_complete">Percentage Complete</label>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <input type="text" value="0" id="task_per_complete" name="per_complete" data-slider-min="0" data-slider-max="100" data-slider-value="0" data-slider-step="1"/>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div id="addTaskAction">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="taskSaveButton">Save task</button>
            </div>
            <div id="editTaskAction">
              <input type="hidden" id="task_id" name="task_id" />
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-danger" id="taskDelButton">Delete task</button>
              <button type="button" class="btn btn-primary" id="taskEditButton">Save task</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /END NEW TASK MODAL -->
  
<!-- START NEW GROUP MODAL -->

  <!-- New Group Modal -->
  <div class="modal fade" id="addNewGroupWindow" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method='POST' action='' id="addNewGroupForm">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="addNewGroupModalLabel">Add New Group</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" id="alertAddNewGroup">
              <strong>Oh snap!</strong>
            </div>
            <div class="form-group">
              <label for="group_desc">Group Description</label>
              <input type="text" class="form-control" id="group_group_desc" name="group_desc" placeholder="Group Description" value="" 
                data-msg-required="Please enter the group description." 
                data-msg-maxlength="The group description cannot be more than 255 characters." 
                data-rule-required="true" 
                data-rule-maxlength="255" />
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="start_date">Start Date</label>
                  <input type="text" class="form-control" id="group_start_date" name="start_date" value="" 
                    data-msg-date="Please enter a valid date as start date." 
                    data-msg-required="Please enter a valid date as start date." 
                    data-rule-date="true" 
                    data-rule-required="true" />
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="end_date">End Date</label>
                  <input type="text" class="form-control" id="group_end_date" name="end_date" value="" 
                    data-msg-date="Please enter a valid date as end date." 
                    data-msg-required="Please enter a valid date as end date." 
                    data-rule-date="true" 
                    data-rule-required="true" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="parent_group_id">Parent Group</label>
              <input type="hidden" class="form-control" id="group_parent_group_id" name="parent_group_id" placeholder="Select a group" value=""/>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success btn-primary" id="saveButton">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /END NEW GROUP MODAL -->
  
  <!-- START NEW MILESTONE MODAL -->

  <!-- New Milestone Modal -->
  <div class="modal fade" id="addNewMilestoneWindow" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method='POST' action='' id="addNewMilestoneForm">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="addNewMilestoneModalLabel">Add New Milestone</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" id="alertAddNewMilestone">
              <strong>Oh snap!</strong>
            </div>
            <div class="form-group">
              <label for="milestone_desc">Milestone Description</label>
              <input type="text" class="form-control" id="milestone_milestone_desc" name="milestone_desc" placeholder="Group Description" value="" 
                data-msg-required="Please enter the milestone description." 
                data-msg-maxlength="The milestone description cannot be more than 255 characters." 
                data-rule-required="true" 
                data-rule-maxlength="255" />
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="start_date">Milestone Date</label>
                  <input type="text" class="form-control" id="milestone_milestone_date" name="milestone_date" value="" 
                    data-msg-date="Please enter a valid date as milestone date." 
                    data-msg-required="Please enter a valid date as milestone date." 
                    data-rule-date="true" 
                    data-rule-required="true" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="parent_group_id">Parent Group</label>
              <input type="hidden" class="form-control" id="milestone_groups_group_id" name="groups_group_id" placeholder="Select a group" value=""/>
            </div>
            <div class="form-group">
              <label for="depends_on">Percentage Complete</label>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <input type="text" value="0" id="milestone_per_complete" name="per_complete" data-slider-min="0" data-slider-max="100" data-slider-value="0" data-slider-step="1"/>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success btn-primary" id="saveButton">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /END NEW MILESTONE MODAL -->
  
  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/bootbox.min.js"></script>
  <script src="../../js/bootstrap-datepicker.js"></script>
  <script src="../../js/bootstrap-slider.js"></script>
  <script src="../../js/jquery.validate.js"></script>
  <script src="../../js/jquery.simplecolorpicker.js"></script>
  <script src="../../js/select2.js"></script>
  <script src="../../js/jsgantt.js"></script>

  <script type="text/javascript">
    var d = "<?=$project_xml_data?>";
    var resList = <?=$resource_list?>;
    var groupList = <?=$project_groups?>;
    var dependList = <?=$project_tasks?>;
    var vGanttChart = new JSGantt.GanttChart('vGanttChart', document
        .getElementById('GanttChartDIV'), 'day');
    vGanttChart.setShowRes(1);
    vGanttChart.setShowDur(1);
    vGanttChart.setShowComp(1);
    vGanttChart.setCaptionType('Resource');
    if (vGanttChart) {
      JSGantt.loadXMLString(d, vGanttChart);
      vGanttChart.Draw();
      vGanttChart.DrawDependencies();
    } else {
      alert("not defined");
    }
  </script>
    <script src="../../js/p4-pp.js"></script>
</body>
</html>
