
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="img/favicon.png">

<title>Quick CM : Admin Home</title>

<!-- Bootstrap core CSS -->
<link href="../css/bootstrap.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="../css/qpm.css" rel="stylesheet">
<!-- Custom themes for this template -->
<link href="../css/qpm-admin-theme.css" rel="stylesheet">
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
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">Quick PM <small><small>Administrator</small></small></a>
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
                <?php if(array_key_exists( 2, $roles)): ?>
                <li class="pm-interface"><a href="/pm/home"><span class="glyphicon glyphicon-user"></span> Project Manager</a></li>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h4 class="panel-title">Users <span class="badge"><?=count($users)?></span></h4>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="pull-right">
              <a href="#" id="addNewUser" class="btn btn-xs btn-success" data-toggle="tooltip" title="Add New User"> 
                <span class="glyphicon glyphicon-tasks"></span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="panel-body">
        <form role="form">
          <label class="sr-only" for="search">Search</label> <input type="email" class="form-control" id="search" placeholder="Start typing to search...">
        </form>
        <table class="table table-hover" id="userList">
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email Address</th>
              <th>Status</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($users as $user): ?>
          <tr>
              <td><?=$user['first_name']?></td>
              <td><?=$user['last_name']?></td>
              <td><?=$user['email']?></td>
            <?php if($user['status'] == 'Inactive'): ?>
            <td><span class="label label-danger">Inactive</span></td>
            <?php else: ?>
            <td><span class="label label-success">Active</span></td>
            <?php endif; ?>
            <td>
              <?php if(in_array("1", str_getcsv($user['roles']))): ?>
              <span class="glyphicon glyphicon-user admin-icon" data-toggle="tooltip" title="Administrator"></span>
              <?php endif; ?>
              <?php if(in_array("2", str_getcsv($user['roles']))): ?> 
              <span class="glyphicon glyphicon-user pm-icon" data-toggle="tooltip" title="Project Manager"></span>
              <?php endif; ?>
              <?php if(in_array("3", str_getcsv($user['roles']))): ?>  
              <span class="glyphicon glyphicon-user tm-icon" data-toggle="tooltip" title="Team Member"></span>
              <?php endif; ?>
            </td>
              <td>
                <?php if($user['status'] == 'Active'): ?>
                <a href="#" id="<?=$user['user_id']?>" type="button" class="btn btn-xs btn-danger left-button deactivate-user" data-toggle="tooltip" title="Deactivate">
                  <span class="glyphicon glyphicon-thumbs-down"></span>
                </a>
                <?php else: ?>
                <a href="#" id="<?=$user['user_id']?>" type="button" class="btn btn-xs btn-success left-button activate-user" data-toggle="tooltip" title="Activate">
                  <span class="glyphicon glyphicon-thumbs-up"></span>
                </a>
                <?php endif; ?>
                <a href="#" id="_<?=$user['user_id']?>" type="button" class="btn btn-xs btn-primary right-button reset-password" data-toggle="tooltip" title="Reset Password">
                  <span class="glyphicon glyphicon-lock"></span>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        </table>

      </div>
    </div>

  </div>
  <!-- /container -->

    <!-- START THE SIGN UP MODAL -->

    <!-- Change Project Name Modal -->
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
                 data-rule-email="true" 
                 data-rule-required="true" 
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
                 data-rule-email="true" 
                 data-rule-required="true" 
                 data-rule-maxlength="255" 
                 data-rule-equalTo="#email" />
              </div>
              <div class="form-group">
                <div class="col-sm-offset-0 col-sm-10">
                  <div class="checkbox">
                    <label for="admin_access"> <input type="checkbox" id="admin_access" name= "admin_access" checked> <strong>Provide Administrator access.</strong>
                    </label>
                  </div>
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

    <!-- /END THE SIGN UP MODAL -->

  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/jquery.validate.js"></script>
  <script src="../js/bootbox.min.js"></script>
  <script src="../js/p4-admin.js"> </script>
</body>
</html>
