
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Quick CM : TM Home</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/qpm.css" rel="stylesheet">
    <!-- Custom themes for this template -->
    <link href="../css/qpm-tm-theme.css" rel="stylesheet">
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
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Quick PM <small><small>Team Member</small></small></a>
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
              <?php if(array_key_exists( 2, $roles)): ?>
              <li class="pm-interface"><a href="/pm/home"><span class="glyphicon glyphicon-user"></span> Project Manager </a></li>
              <?php endif;?>
              <li class="divider"></li>
              <li><a href="#"><span class="glyphicon glyphicon-edit"></span> Edit Profile </a></li>
              <li><a href="/users/logout"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
            </ul></li>
        </ul>
      </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">



        <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List of Users</h3>

  </div>
  <div class="panel-body">
<form role="form">


<div class="row">
  <div class="col-xs-10">
     <label class="sr-only" for="search">Search</label>
    <input type="email" class="form-control" id="search" placeholder="Start typing to search...">
  </div>
  <div class="col-xs-2">
      <button type="button" class="btn btn-small btn-success" data-toggle="tooltip" title="Add New User">
                  <span class="glyphicon glyphicon-user"></span> Add New User
                </button>
  </div>
</div>
  </div>
</form>
<table class="table table-hover" id="userList">
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email Address</th>
            <th>Status</th>
             <th>Actions</th>           
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Mark</td>
            <td>Otto</td>
            <td>mark@otto.com</td>
            <td><span class="label label-success">Active</span></td>
            <td>

                <button type="button" class="btn btn-xs btn-danger left-button" data-toggle="tooltip" title="Deactivate">
                  <span class="glyphicon glyphicon-thumbs-down"></span>
                </button>
                <button type="button" class="btn btn-xs btn-primary right-button" data-toggle="tooltip" title="Reset Password">
                  <span class="glyphicon glyphicon-lock"></span>
                </button>

            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Sam</td>
            <td>Adams</td>
            <td>sam@adams.com</td>
            <td><span class="label label-success">Active</span></td>
            <td>

                <button type="button" class="btn btn-xs btn-danger left-button" data-toggle="tooltip" title="Deactivate">
                  <span class="glyphicon glyphicon-thumbs-down"></span>
                </button>
                <button type="button" class="btn btn-xs btn-primary right-button" data-toggle="tooltip" title="Reset Password">
                  <span class="glyphicon glyphicon-lock"></span>
                </button>

            </td>
          </tr>
          <tr>
            <td>3</td>
            <td>Don</td>
            <td>Draper</td>
            <td>don@draper.com</td>
            <td><span class="label label-success">Active</span></td>
            <td>

                <button type="button" class="btn btn-xs btn-danger left-button" data-toggle="tooltip" title="Deactivate">
                  <span class="glyphicon glyphicon-thumbs-down"></span>
                </button>
                <button type="button" class="btn btn-xs btn-primary right-button" data-toggle="tooltip" title="Reset Password">
                  <span class="glyphicon glyphicon-lock"></span>
                </button>

            </td>
          </tr>
          <tr>
            <td>4</td>
            <td>Betty</td>
            <td>Cooper</td>
            <td>betty@cooper.com</td>
            <td><span class="label label-danger">Inactive</span></td>
            <td>

                <button type="button" class="btn btn-xs btn-success left-button" data-toggle="tooltip" title="Activate">
                  <span class="glyphicon glyphicon-thumbs-up"></span>
                </button>
                <button type="button" class="btn btn-xs btn-primary right-button" data-toggle="tooltip" title="Reset Password">
                  <span class="glyphicon glyphicon-lock"></span>
                </button>

            </td>
          </tr>
        </tbody>
      </table>

  </div>
</div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
var $rows = $('#userList tbody tr');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
$('.left-button').tooltip({
  'placement':'left'
});
$('.right-button').tooltip({
  'placement':'right'
});


        $(document).ready(function() {
        
            $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
    // Avoid following the href location when clicking
    event.preventDefault(); 
    // Avoid having the menu to close when clicking
    event.stopPropagation(); 
    // If a menu is already open we close it
    //$('ul.dropdown-menu [data-toggle=dropdown]').parent().removeClass('open');
    // opening the one you clicked on
    $(this).parent().addClass('open');

    var menu = $(this).parent().find("ul");
    var menupos = menu.offset();
  
    if ((menupos.left + menu.width()) + 30 > $(window).width()) {
        var newpos = - menu.width();      
    } else {
        var newpos = $(this).parent().width();
    }
    menu.css({ left:newpos });

});
        
        });
    </script>
  </body>
</html>
