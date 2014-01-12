
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../img/favicon.png">

<title>Navbar Template for Bootstrap</title>

<!-- Bootstrap core CSS -->
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/qpm.css" rel="stylesheet">
<style type="text/css">
.about-qpm {
  width: 597px;
  height: 600px;
  overflow: auto;
}
.qpm-center {
  text-align: center;
}
</style>
<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>

  <div class="container">

    <div class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Quick PM</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/">Home</a></li>
            <li><a href="#signup" id="signUp">Sign Up</a></li>
            <li><a href="#about" id="about">About</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">Login</h4>
          </div>
          <div class="panel-body">
            <?php if(isset($login_error_message)): ?>
            <div class="alert alert-danger"><?=$login_error_message?></div>
            <?php endif; ?>
            <form method='POST' class="form-horizontal" id="loginForm" action="/users/p_login">
              <div class="form-group">
                <label for="login_email" class="col-sm-4 control-label">Email</label>
                <div class="col-sm-8">
                  <input id="login_email" name="login_email" type="text" placeholder="Email" class="form-control" value="<?=$user_email?>" autofocus 
                   data-msg-email="Please enter a valid email." 
                   data-msg-required="Please enter a valid email." 
                   data-msg-maxlength="Your email cannot be more than 255 characters" 
                   data-rule-email="true" 
                   data-rule-required="true" 
                   data-rule-maxlength="255" />
                </div>
              </div>

              <div class="form-group">
                <label for="login_password" class="col-sm-4 control-label">Password</label>
                <div class="col-sm-8">
                  <input id="login_password" name="login_password" type="password" placeholder="Password" class="form-control" value="" 
                   data-msg-required="Please enter the password." 
                   data-msg-maxlength="Your password cannot be more than 20 characters." 
                   data-msg-minlength="Your password cannot be less than 5 characters." 
                   data-rule-required="true" 
                   data-rule-maxlength="20" 
                   data-rule-minlength="5" />
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-4 col-sm-10">
                  <div class="checkbox">
                    <label> <input type="checkbox" id="login_remember" name= "login_remember" checked> Remember me
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-4 col-sm-10">
                  <button type="submit" class="btn btn-primary">Sign in</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- /container -->

  <!-- START THE SIGN UP MODAL -->

  <!-- Change Project Name Modal -->
  <div class="modal fade" id="signUpWindow" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method='POST' action='/users/p_signup' id="signUpForm">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="signUpModalLabel">Sign Up</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" id="alertSignUp">
              <strong>Oh snap!</strong>
            </div>

            <div class="form-group">
              <label for="first_name">First Name</label> 
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="" autofocus 
               data-msg-required="Please enter your first name." 
               data-msg-maxlength="Your first name cannot be more than 255 characters." 
               data-rule-required="true" 
               data-rule-maxlength="255" />
            </div>
            <div class="form-group">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="" 
              data-msg-required="Please enter your last name." 
              data-msg-maxlength="Your last name cannot be more than 255 characters." 
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
              data-rule-maxlength="255" 
              data-rule-notUsed="true"/>
              <div id="message"></div>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="" 
              data-msg-required="Please enter the password." 
              data-msg-maxlength="Your password cannot be more than 20 characters." 
              data-msg-minlength="Your password cannot be less than 5 characters." 
              data-rule-required="true" 
              data-rule-maxlength="20" 
              data-rule-minlength="5" />
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm Password</label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Comfirm password" value="" 
              data-msg-required="Please confirm your password." 
              data-msg-maxlength="Your password cannot be more than 20 characters." 
              data-msg-minlength="Your password cannot be less than 5 characters." 
              data-msg-equalTo="The password confirmation has to match the password above." 
              data-rule-required="true"
              data-rule-maxlength="20" 
              data-rule-minlength="5" 
              data-rule-equalTo="#password" />
            </div>

          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success btn-primary" id="saveButton">Sign Up</button>
          </div>
        </form>
      </div>
    </div>
  </div>

      <!-- About Modal -->
    <div class="modal fade" id="aboutWindow" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="aboutWindowModalLabel">About</h4>
          </div>
          <div class="modal-body about-qpm">
            <h1><a href="http://p4.mahe-cscie-15.biz">CSCIE-15 P4 - Quick Project Management (QPM)</a></h1>
            <p>The QPM is a project management tool. It helps users manage small projects like a Agile sprint. It has 3 different user interfaces for the 3 different roles that it supports.</p>
            <h2>Project Manager Interface</h2>
            <p>This is the default interface. The user signing in to the website will be given this role by default. This interface provides the user with the following privileges.</p>
            <ol>
                <li>Create new projects. </li>
                <li>Edit projects details like</li>
                <ol type="a">
                    <li>Project Description</li>
                    <li>Start and End date</li>
                    <li>Project Status - Green/Yellow/Red</li>
                </ol>
                <li>View the Gantt chart of the project</li>
                <li>Add, edit and delete tasks, task groups and milestones.</li>
                <li>Add team members for the projects.</li>
            </ol>
            <h2>Administrator Interface</h2>
            <p>This is the administrator's interface. This lets users to</p>
            <ol>
                <li>Add new users.</li>
                <li>Edit user details like</li>
                <ol type="a">
                    <li> First name</li>
                    <li> Last name</li>
                    <li> Email address.</li>
                </ol>
                <li>Change user's privileges and provide users with administrator access.</li>
                <li>Activate/deactivate users. </li>
                <li>Reset passwords of users.</li>
            </ol>
            <h2>Team Member Interface</h2>
            <p>This is interface allows users to</p>
            <ol>
                <li>View task list</li>
                <li>Edit task details</li>
                <li>Change task status/start date and end date</li>
            </ol>
            <p>Here are the main features of this site</p>
            
            <h3>1. Dynamic Gantt chart</h3>
            <p>The PM interface allows the user to see a dynamic Gantt Chart of the project. When the user creates a project, QPM creates a Gantt chart for the project with a root task group with the same name and parameters of the project. The root task group cannot be edited. The PM can then add, edit, and delete the tasks, milestones and task groups. Once a task group is deleted, all the tasks and milestones in that group is also deleted.</p>
            
            <h3>2. Email notifications</h3>
            <p>QPM sends out email notifications when a user is activated or deactivated. Those emails are just notifications that the user receives. QPM also sends out email notification when the password is reset. That email contains a URL that the user can use to reset his/her password.</p>
            
            <h3>3. Calendar view task list</h3>
            <p>The TM interface has a interactive calendar view of the task list along with a regular task list. The calendar interface allows the user to edit the task details by clicking on the task on the calendar. They can also drag and drop the task to change the task dates and also resize the task to change it's duration.</p>
            
            <h3>4. Admin interface</h3>
            <p>The admin interface allows the admin to manage all the users of QPM. All users who sign up has the Project Manager access. But the Admin can create Team Member users and other admins. The admin can also provide and revoke admin access to other users. There is no single admin user and the admin user cannot created using the UI. The admin user either has to be inserted directly using the database or using one of the following user ids. The password for all of them are 'password'.</p>
            <ul>
                <li>barney.stinson@sharklasers.com</li>
                <li>bettywhite@sharklasers.com</li>
                <li>jerryseinfeld@sharklasers.com</li>
                <li>mahendran.nair@gmail.com</li>
                <li>vimal.nair@sharklasers.com</li>
            </ul>
            <p>The email notifications send out to the 'sharklasers.com' email addresses can be viewed at the www.guerillamail.com</p>
            
            <h3>Multiple User Interfaces</h3>
            <p>As it's already mentioned there are 3 different interfaces for the 3 different roles that QPM supports. These interfaces are easily distinguishable since there are captioned and color coded differently from eah other. QPM also lets the user switch between the roles without additional logins.</p>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

      <!-- Contact Modal -->
      <div class="modal fade" id="contactWindow" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="contatModalLabel">About Quick Gantt</h4>
          </div>
          <div class="modal-body">
			<div class="jumbotron qpm-center">
			  <h1>QPM</h1>
			  <p class="lead">Quick Project Management</p>
			</div>
			<div class="row marketing">
			  <div class="col-lg-12">
				<p>Developed as part of CSCIE-15 - P4 by <a href="mailto:mahendran.sreedevi@gmail.com">Mahendran Sreedevi</a></p>
			  </div>
			</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
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
  <script src="../js/p4-home.js"></script>
</body>
</html>
