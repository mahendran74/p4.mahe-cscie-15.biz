
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
<link href="../../css/bootstrap.css" rel="stylesheet">
<link href="../../css/qpm.css" rel="stylesheet">

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
            <li><a href="#contact">About</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">Reset password</h4>
          </div>
          <div class="panel-body">
            <?php if(isset($login_error_message)): ?>
            <div class="alert alert-danger"><?=$login_error_message?></div>
            <?php endif; ?>
            <form method='POST' class="form-horizontal" id="passwordResetForm" action="/users/p_reset_password">
              <div class="form-group">
                <label for="login_email" class="col-sm-4 control-label">Email</label>
                <div class="col-sm-8">
                  <p id="actual_end_date" class="form-control-static"><?=$user['email']?></p>
                  </div>
                <input type="hidden" id="login_email" name="login_email" value="<?=$user['email']?>" />
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
                <label for="confirm_password" class="col-sm-4 control-label">Confirm Password</label>
                <div class="col-sm-8">
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Comfirm password" value=""
                   data-msg-required="Please confirm your password." 
                   data-msg-maxlength="Your password cannot be more than 20 characters." 
                   data-msg-minlength="Your password cannot be less than 5 characters."
                   data-msg-equalTo="The password confirmation has to match the password above."
                   data-rule-required="true" 
                   data-rule-maxlength="20"
                   data-rule-minlength="5"
                   data-rule-equalTo="#login_password" />
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-4 col-sm-10">
                  <button type="submit" class="btn btn-primary">Change Password</button>
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
        <form method='POST' action='' id="signUpForm">
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
              data-rule-notUsed="true" />
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

  <!-- /END THE SIGN UP MODAL -->
  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/jquery.validate.js"></script>
  <script src="../../js/p4-home.js"></script>
</body>
</html>
