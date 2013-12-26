<?php
include ($_SERVER ['DOCUMENT_ROOT'] . '/utils/util.php'); // Include utility class
/**
 *
 * @author Mahendran Sreedevi
 *         This controller does the following functions
 *         - Login in a user
 *         - Log out the user
 *         - Update the user's profile
 *         - Change the user's password
 *         - Upload user's avatar
 *         - Sign up the user
 *         - Follow another user
 *         - Unfollow another user
 */
class users_controller extends base_controller {
  
  /**
   * Constuctor
   */
  public function __construct() {
    parent::__construct ();
  }
  /**
   * Show the sign up page
   */
  public function signup() {
    $this->template->content = View::instance ( 'v_users_signup' ); // Set view
    $this->template->title = "Sign Up"; // Set title
    echo $this->template; // Render view
  }
  /**
   * Process the sign up request
   */
  public function p_signup() {
    // Sanitize data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    
    $this->template->content = View::instance ( 'v_index_index' ); // Set view
    $this->template->title = "Sign Up"; // Set title
    $this->template->content->user = $_POST; // Set data
                                             // Check for blank first name
    if (empty ( $_POST ['first_name'] )) {
      // Show error message
      $this->template->content->profile_error_message = "The first name is a required field.";
      echo $this->template; // Render view
      return;
    }
    // Check for blank last name
    if (empty ( $_POST ['last_name'] )) {
      // Show error message
      $this->template->content->profile_error_message = "The last name is a required field.";
      echo $this->template; // Render template
      return;
    }
    // Check for blank email
    if (empty ( $_POST ['email'] )) {
      // Show error message
      $this->template->content->profile_error_message = "The email address is a required field.";
      echo $this->template; // Render template
      return;
    }
    // Check for blank password
    if (empty ( $_POST ['password'] )) {
      // Show error message
      $this->template->content->profile_error_message = "Please enter the password.";
      echo $this->template; // Render template
      return;
    }
    // Check for blank password confirmation
    if (empty ( $_POST ['confirm_password'] )) {
      // Show error message
      $this->template->content->profile_error_message = "Please confirm the password by entering it again.";
      echo $this->template; // Render template
      return;
    }
    // Check if password and it's confirmation matches
    if ($_POST ['password'] != $_POST ['confirm_password']) {
      // Show error message
      $this->template->content->profile_error_message = "The new password and it's confirmation does not match. Please make sure enter the same password while confirming it.";
      echo $this->template; // Render template
      return;
    }
    // All validations passed
    $_POST ['created'] = Time::now (); // Set created datetime
    $_POST ['modified'] = Time::now (); // Set modified datetime
                                        
    // Encrypt the password
    $_POST ['password'] = sha1 ( PASSWORD_SALT . $_POST ['password'] );
    
    // Create an encrypted token via their email address and a random string
    $_POST ['token'] = sha1 ( TOKEN_SALT . $_POST ['email'] . Utils::generate_random_string () );
    // Set the default avatar. The user can change it later.
    $_POST ['avatar'] = "\uploads\avatars\default.gif";
    // Remove the password confirmation from the array
    unset ( $_POST ['confirm_password'] );
    // Insert this user into the database
    $user_id = DB::instance ( DB_NAME )->insert ( "users", $_POST );
    // Set the users default role to Project Manager
    $role_data = Array (
        "created" => Time::now (),
        "modified" => Time::now (),
        "users_user_id" => $user_id,
        "role_types_role_type_id" => 2 
    );
    $user_role_id = DB::instance ( DB_NAME )->insert ( "users_roles", $role_data );
    $roles = Array (
        2 => $user_role_id
    );
    // Set the cookie
    setcookie ( "token", $_POST ['token'], strtotime ( '+1 year' ), '/' );
    setcookie ( "roles", serialize ( $roles ), strtotime ( '+1 year' ), '/' );
    // Redirect to home page
    Router::redirect ( "/pm/home" );
  }
  
  /**
   * Checks whether the emal is already used
   *
   * @param unknown $email
   *          Email to check
   * @param string $user_id
   *          Optional user id
   * @return boolean True if is used already and false if it's not.
   */
  function check_email($email, $user_id = NULL) {
    // Check if the user id is null or not
    if (empty ( $user_id )) {
      // User id is null, so request from the sign up view
      // Check whether the email is used by any signed up user
      $q = "SELECT COUNT(*) AS count
		      FROM users
    		 WHERE UPPER(email) = UPPER('" . $email . "')";
    } else {
      // User id is not null, so request from the update profile view
      // Check whether the email is used by any other signed up user
      // other than the current one
      $q = "SELECT COUNT(*) AS count
              FROM users
    		 WHERE UPPER(email) = UPPER('" . $email . "')
               AND user_id != " . $user_id;
    }
    $this->log->logInfo($q);
    // Execute the query to get all the email.
    // Store the result array in the variable $users
    $users = DB::instance (DB_NAME)->select_row($q);
    $this->log->logInfo($users['count']);
    if ($users['count'] == 0)
      echo "Email is available";
    else
      echo "Email is in use";
  }
  
  /**
   * Process the update profile request
   */
  public function p_update() {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Sanitize the data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    $messages = array ();
    // Check for blank first name
    if (empty ( $_POST ['first_name'] )) {
      $messages ['profile_error_string'] = "The first name is a required field.";
      $this->profile ( $messages );
      return;
    }
    // Check for blank last name
    if (empty ( $_POST ['last_name'] )) {
      $messages ['profile_error_string'] = "The last name is a required field.";
      $this->profile ( $messages );
      return;
    }
    // Check for blank email
    if (empty ( $_POST ['email'] )) {
      $messages ['profile_error_string'] = "The email address is a required field.";
      $this->profile ( $messages );
      return;
    }
    // Check if the email is already registered by someone else. The email should be unique
    if (email_not_used ( $_POST ['email'], $this->user->user_id )) {
      // All validations passed
      $_POST ['modified'] = Time::now (); // Set modified date time
                                          // Insert this user into the database
      DB::instance ( DB_NAME )->update ( "users", $_POST, "WHERE user_id = " . $this->user->user_id );
      $messages ['profile_message'] = "Your profile was updated successfully"; // Set success message
      $this->profile ( $messages ); // Call the profile function with the message
      return;
    } else {
      // Set the error message
      $messages ['profile_error_string'] = "This email address (" . $_POST ['email'] . ") is already registered. Please try another one.";
      $this->profile ( $messages ); // Call the profile function with the message
      return;
    }
  }
  /**
   * Logs out the user
   */
  public function logout() {
    // Generate new token
    $new_token = sha1 (TOKEN_SALT . $this->user->email . Utils::generate_random_string());
    // Add it to an array
    $data = Array (
        "token" => $new_token 
    );
    // Update the user info with the array
    DB::instance ( DB_NAME )->update ( "users", $data, "WHERE token = '" . $this->user->token . "'" );
    
    // Delete their token cookie by setting it to a date in the past - effectively logging them out
    setcookie ( "token", "", strtotime ( '-1 year' ), '/' );
    
    // Send them back to the home page
    Router::redirect ( "/" );
  }
  
  public function set_temp_token($user_id) {
    $user = get_user($user_id);
    // Generate new token
    $new_token = sha1 (TOKEN_SALT . $user_id . Utils::generate_random_string());
    // Add it to an array
    $data = Array (
        "token" => $new_token
    );
    // Update the user info with the array
    DB::instance ( DB_NAME )->update ( "users", $data, "WHERE user_id = " . $user_id);
    // Send out the email
    send_email($user, "Password reset", "Your password has been reset. 
        Please click the following link to create a new password. \n". 
        url() . "/users/reset_password/" . $new_token , 
    $this->log);
    
    echo "The password reset url has been emailed to " . $user['email'];
    
  }
  
  public function reset_password($token) {
      $user = get_user_with_token($token);
    // Check to see if the user id logged in.
    if (! $user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    $this->template->content = View::instance ( 'v_user_password_reset' ); // Set view
    $this->template->title = "QPM : Reset password"; // Set title
    $this->template->content->user = $user;
    echo $this->template; // Render view
  }
  
  public function p_reset_password() {
    // Sanitize data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    // Encrypt the password
    $password = sha1 ( PASSWORD_SALT . $_POST ['login_password'] );
    // Create an encrypted token via their email address and a random string
    $token = sha1 ( TOKEN_SALT . $_POST ['login_email'] . Utils::generate_random_string () );
    // Set where condition
    $where_condition = 'WHERE email = "' . $_POST ['login_email'] . '"';
    // Set array to update
    $data = Array (
        "password" => $password,
        "token" => $token,
        "modified" => Time::now ()
    );
    DB::instance ( DB_NAME )->update ( 'users', $data, $where_condition );
    // Check the roles
    $roles = check_roles ( $_POST ['login_email'] );

    // Token is validated. Store the cookie
    setcookie("token", $token, strtotime('+1 year'), '/');
    setcookie("roles", serialize($roles), strtotime('+1 year'), '/');
    
    if (array_key_exists ( 2, $roles )) {
      Router::redirect ( "/pm/home" ); // Redirect to pm home page
    } else if (array_key_exists ( 1, $roles )) {
      Router::redirect ( "/admin/home" ); // Redirect to admin home page
    } else if (array_key_exists ( 3, $roles )) {
      Router::redirect ( "/tm/home" ); // Redirect to tm home page
    } else {
      Router::redirect ( "/" ); // Redirect to home page
    }
  }
  /**
   * Deactivates  the user
   */
  public function deactivate($user_id) {
    $user = get_user($user_id);

    // Change status to Inactive
    $data = Array (
        "status" => "Inactive" 
    );
    // Update the user info with the array
    DB::instance ( DB_NAME )->update ( "users", $data, "WHERE user_id = " . $user_id );
    
    // Send out the email
    send_email($user, "Account deactivated", "Your account has been deactivated. Please contact the admin for more details.", $this->log);
    
    // Send them back to the home page
    echo "Account has been deactivated.";
  }  
  
  /**
   * Activates  the user
   */
  public function activate($user_id) {
    $user = get_user($user_id);
  
    // Change status to Inactive
    $data = Array (
        "status" => "Active"
    );
    // Update the user info with the array
    DB::instance ( DB_NAME )->update ( "users", $data, "WHERE user_id = " . $user_id );
  
    // Send out the email
    send_email($user, "Account deactivated", "Your account has been activated.", $this->log);
  
    // Send them back to the home page
    echo "Account has been activated.";
  }
  
  public function p_add_user() {
    // Sanitize data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ($_POST);
    $new_token = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
    $data = Array (
        "first_name" => $_POST ['first_name'],
        "last_name" => $_POST ['last_name'],
        "email" => $_POST ['email'],
        "avatar" => "\uploads\avatars\default.gif",
    	"created" => Time::now (),
        "modified" => Time::now (),
        "token" => $new_token
    );
    
    // Insert this user into the database
    $user_id = DB::instance(DB_NAME)->insert ("users", $data);
    
    // Set the users default role to Project Manager
    $role_data = Array (
        "created" => Time::now (),
        "modified" => Time::now (),
        "users_user_id" => $user_id,
        "role_types_role_type_id" => 2
    );
    $user_role_id = DB::instance ( DB_NAME )->insert ( "users_roles", $role_data );
    if (array_key_exists ('admin_access', $_POST)) {
      // Add user as an admin
      $role_data = Array (
          "created" => Time::now (),
          "modified" => Time::now (),
          "users_user_id" => $user_id,
          "role_types_role_type_id" => 1
      );
      $user_role_id = DB::instance ( DB_NAME )->insert ( "users_roles", $role_data );
    }
    if (array_key_exists ('tm_access', $_POST)) {
      // Add user as a TM
      $role_data = Array (
          "created" => Time::now (),
          "modified" => Time::now (),
          "users_user_id" => $user_id,
          "role_types_role_type_id" => 3
      );
      $user_role_id = DB::instance ( DB_NAME )->insert ( "users_roles", $role_data );
    }
    // Send out the email
    send_email_alt($_POST ['email'], $_POST ['first_name'], $_POST ['last_name'], 
        "Account created", "Your account has been created.
        Please click the following link to create a new password. \n".
            url() . "/users/reset_password/" . $new_token ,
            $this->log);
    
    echo "<strong>Account Created</strong>. The password reset URL has been emailed to " . $_POST ['email'];
  }
  
  public function p_update_user(){
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Sanitize data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    // Create an encrypted token via their email address and a random string
    $token = sha1 ( TOKEN_SALT . $_POST ['email'] . Utils::generate_random_string () );
    $user_id = $_POST ['user_id'];
    $data = Array (
        "modified" => Time::now (),
        "first_name" => $_POST['first_name'],
        "last_name" => $_POST['last_name'],
        "email" => $_POST['email'],
        "token" => $token
    );

    DB::instance (DB_NAME)->update( "users", $data, "WHERE user_id = " . $user_id);
    
    if (array_key_exists ('admin_access', $_POST)) {
      // Add user as an admin
      $role_data = Array (
          "created" => Time::now (),
          "modified" => Time::now (),
          "users_user_id" => $user_id,
          "role_types_role_type_id" => 1
      );
      $user_role_id = DB::instance (DB_NAME)->insert ("users_roles", $role_data);
    } else {
      DB::instance(DB_NAME)->delete('users_roles', "WHERE users_user_id = ". $user_id . " AND role_types_role_type_id = 1");
    }
    if (array_key_exists ('tm_access', $_POST)) {
      // Add user as a TM
      $role_data = Array (
          "created" => Time::now (),
          "modified" => Time::now (),
          "users_user_id" => $user_id,
          "role_types_role_type_id" => 3
      );
      $user_role_id = DB::instance (DB_NAME)->insert ("users_roles", $role_data);
    } else {
      DB::instance(DB_NAME)->delete('users_roles', "WHERE users_user_id = ". $user_id . " AND role_types_role_type_id = 3");
    }
    echo "Task updated successfully.";
  }
  
  public function get_user($user_id) {
    echo json_encode(get_user($user_id));
  }
  
  /**
   * Shows the login view
   *
   * @param string $message
   *          Error message to be displayed
   */
  public function login($email, $message = "") {
    $this->template->content = View::instance ( 'v_user_login' ); // Set view
    $this->template->title = "QPM : Login failed"; // Set title
    $this->template->content->login_error_message = $message; // Set login error message
    $this->template->content->user_email = $email;
    echo $this->template; // Render view
  }
  /**
   * Processes the login request
   */
  public function p_login() {
    // Sanitize the data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );;
    
    // Check the database for a token with the user's email and password
    $token = check_login ( $_POST ['login_email'], $_POST ['login_password'] );

    // Check if the token is present or not
    if (! $token) {
      // Token not found.
      $this->login ( $_POST ['login_email'], "<strong>Invalid username or password.</strong><br> Please try again" ); // Render the login view with error message
    } else if ($token['status'] == "Inactive") {
      // Token not found.
      $this->login ( $_POST ['login_email'], "<strong>Your account has been deactivated.</strong><br> Please contact the admin." ); // Render the login view with error message
    } else {
      // Update last login
      DB::instance ( DB_NAME )->update ( "users", Array (
          "last_login" => Time::now () 
      ), "WHERE token = '" . $token['token'] . "'" );
      // Check the roles
      $roles = check_roles ( $_POST ['login_email'] );

      if ($_POST ['login_remember']) {
        // Token is validated. Store the cookie
        setcookie ( "token", $token['token'], strtotime ( '+1 year' ), '/' );
        setcookie ( "roles", serialize ( $roles ), strtotime ( '+1 year' ), '/' );
      }

      if (array_key_exists ( 2, $roles )) {
        Router::redirect ( "/pm/home" ); // Redirect to pm home page
      } else if (array_key_exists ( 1, $roles )) {
        Router::redirect ( "/admin/home" ); // Redirect to admin home page
      } else if (array_key_exists ( 3, $roles )) {
        Router::redirect ( "/tm/home" ); // Redirect to tm home page
      } else {
        Router::redirect ( "/" ); // Redirect to home page
      }
    }
  }
  /**
   * Show the profile view with any messages
   *
   * @param unknown $messages
   *          message to display
   */
  public function profile($messages = array()) {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Set the script to open the first blind
    $client_files_body = Array (
        "/js/option1.js"  // Script to open second blind
        );
    $this->template->content = View::instance ( 'v_users_profile' ); // Set view
    $this->template->title = "Profile"; // Set title
                                        
    // Query to get the user's profile
    $q = "SELECT * FROM users WHERE user_id = " . $this->user->user_id;
    $profile = DB::instance ( DB_NAME )->select_row ( $q );
    
    $this->template->content->profile = $profile; // Set template data
                                                  // Set the error or success message to display and the script to display the right blind
    if (isset ( $messages ['profile_message'] )) {
      $this->template->content->profile_message = $messages ['profile_message'];
    } else if (isset ( $messages ['profile_error_string'] )) {
      $this->template->content->profile_error_string = $messages ['profile_error_string'];
    } else if (isset ( $messages ['avatar_message'] )) {
      $this->template->content->avatar_message = $messages ['avatar_message'];
      $client_files_body = Array (
          "/js/option2.js"  // Script to open second blind
            );
    } else if (isset ( $messages ['avatar_error_message'] )) {
      $this->template->content->avatar_error_message = $messages ['avatar_error_message'];
      $client_files_body = Array (
          "/js/option2.js"  // Script to open second blind
            );
    } else if (isset ( $messages ['password_message'] )) {
      $this->template->content->password_message = $messages ['password_message'];
      $client_files_body = Array (
          "/js/option3.js"  // Script to open third blind
            );
    } else if (isset ( $messages ['password_error_message'] )) {
      $this->template->content->password_error_message = $messages ['password_error_message'];
      $client_files_body = Array (
          "/js/option3.js"  // Script to open second blind
            );
    }
    // Add script to fade nessage
    array_push ( $client_files_body, "/js/fadeout.js" );
    // Load the script
    $this->template->client_files_body = Utils::load_client_files ( $client_files_body );
    echo $this->template; // Render view
  }

  /**
   * Process update password request
   */
  public function p_updatepassword() {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Sanitize the data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    $messages = array ();
    // Check if the old password is empty
    if (empty ( $_POST ['old_password'] )) {
      $messages ['password_error_message'] = "Please enter the old password.";
      $this->profile ( $messages );
      return;
    }
    // Check if the new password is empty
    if (empty ( $_POST ['password'] )) {
      $messages ['password_error_message'] = "Please enter the new password.";
      $this->profile ( $messages );
      return;
    }
    // Check if the password confirmation is empty
    if (empty ( $_POST ['new_password'] )) {
      $messages ['password_error_message'] = "Please confirm the password by entering it again.";
      $this->profile ( $messages );
      return;
    }
    // Check if the password matches it's confirmation
    if ($_POST ['password'] != $_POST ['new_password']) {
      $messages ['password_error_message'] = "The new password and it's confirmation does not match. Please make sure enter the same password while confirming it.";
      $this->profile ( $messages );
      return;
    }
    // Check to see if the old password is a valid one
    $token = check_login ( $this->user->email, $_POST ['old_password'] );
    if (! $token) {
      // If not, show the message
      $messages ['password_error_message'] = "The old password failed to authenticatio. Please re-enter the old password.";
      $this->profile ( $messages );
      return;
    }
    // All validations passed
    // Encrypt the password
    $password = sha1 ( PASSWORD_SALT . $_POST ['new_password'] );
    // Create an encrypted token via their email address and a random string
    $token = sha1 ( TOKEN_SALT . $this->user->email . Utils::generate_random_string () );
    // Set where condition
    $where_condition = 'WHERE user_id = ' . $this->user->user_id;
    // Set array to update
    $data = Array (
        "password" => $password,
        "token" => $token,
        "modified" => Time::now () 
    );
    DB::instance ( DB_NAME )->update ( 'users', $data, $where_condition );
    $messages = array ();
    $messages ['password_message'] = "Your password has been sucessfully changed."; // Show message
    setcookie ( "token", $token, strtotime ( '+1 year' ), '/' ); // Set cookie
    $this->profile ( $messages ); // Call the profile function to render the v_user_profile view
  }
}
?>