
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="img/favicon.ico">

<title>Quick PM</title>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.css" rel="stylesheet">

<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

<!-- Custom styles for this template -->
<link href="css/carousel.css" rel="stylesheet">
</head>
<!-- NAVBAR
================================================== -->
<body>
  <div class="navbar-wrapper">
    <div class="container">

      <div class="navbar navbar-inverse navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Quick PM</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="/">Home</a></li>
              <li><a href="#signup" id="signUp">Sign Up</a></li>
              <li><a href="#contact">About</a></li>
            </ul>

            <form method='POST' class="navbar-form navbar-right" id="loginForm" action="/users/p_login">
              <div class="form-group">
                <input  id="login_email" name="login_email" type="text" placeholder="Email" class="form-control" value="" autofocus 
                 data-msg-email="Please enter a valid email." 
                 data-msg-required="Please enter a valid email." 
                 data-msg-maxlength="Your email cannot be more than 255 characters" 
                 data-rule-email="true" 
                 data-rule-required="true" 
                 data-rule-maxlength="255" />
              </div>
              <input type="hidden" name="login_remember" id="login_remember" value="on"/>
              <div class="form-group">
                <input  id="login_password" name="login_password" type="password" placeholder="Password" class="form-control" value=""
                 data-msg-required="Please enter the password." 
                 data-msg-maxlength="Your password cannot be more than 20 characters." 
                 data-msg-minlength="Your password cannot be less than 5 characters." 
                 data-rule-required="true" 
                 data-rule-maxlength="20"
                 data-rule-minlength="5" />
              </div>
              <button type="submit" id="login_submit" class="btn btn-primary">Sign in</button>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>


  <!-- Carousel
    ================================================== -->
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="item active">
        <img data-src="holder.js/900x500/auto/#555:#5a5a5a/text:Third slide" alt="First slide">
        <div class="container">
          <div class="carousel-caption">
            <h1>Example headline.</h1>
            <p>
              Note: If you're viewing this page via a
              <code>file://</code>
              URL, the "next" and "previous" Glyphicon buttons on the left and right might not load/display properly due to web browser security rules.
            </p>
            <p>
              <a class="btn btn-lg btn-primary" href="#">Sign up today</a>
            </p>
          </div>
        </div>
      </div>
      <div class="item">
        <img data-src="holder.js/900x500/auto/#666:#6a6a6a/text:Second slide" alt="Second slide">
        <div class="container">
          <div class="carousel-caption">
            <h1>Another example headline.</h1>
            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p>
              <a class="btn btn-lg btn-primary" href="#">Learn more</a>
            </p>
          </div>
        </div>
      </div>
      <div class="item">
        <img data-src="holder.js/900x500/auto/#555:#5a5a5a/text:Third slide" alt="Third slide">
        <div class="container">
          <div class="carousel-caption">
            <h1>One more for good measure.</h1>
            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p>
              <a class="btn btn-lg btn-primary" href="#">Browse gallery</a>
            </p>
          </div>
        </div>
      </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
  </div>
  <!-- /.carousel -->



  <!-- Marketing messaging and featurettes
    ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

  <div class="container marketing">

    <!-- Three columns of text below the carousel -->
    <div class="row">
      <div class="col-lg-4">
        <img class="img-circle" data-src="holder.js/140x140" alt="Generic placeholder image">
        <h2>Heading</h2>
        <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
        <p>
          <a class="btn btn-default" href="#">View details &raquo;</a>
        </p>
      </div>
      <!-- /.col-lg-4 -->
      <div class="col-lg-4">
        <img class="img-circle" data-src="holder.js/140x140" alt="Generic placeholder image">
        <h2>Heading</h2>
        <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.</p>
        <p>
          <a class="btn btn-default" href="#">View details &raquo;</a>
        </p>
      </div>
      <!-- /.col-lg-4 -->
      <div class="col-lg-4">
        <img class="img-circle" data-src="holder.js/140x140" alt="Generic placeholder image">
        <h2>Heading</h2>
        <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p>
          <a class="btn btn-default" href="#">View details &raquo;</a>
        </p>
      </div>
      <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->


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
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value=""
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
                 data-rule-maxlength="255" />
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


    <!-- FOOTER -->
    <footer>
      <p class="pull-right">
        <a href="#">Back to top</a>
      </p>
      <p>
        &copy; 2013 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a>
      </p>
    </footer>

  </div>
  <!-- /.container -->


  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.validate.js"></script>
  <script src="js/p4-home.js"></script>
</body>
</html>
