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
class pm_controller extends base_controller {
  
  /**
   * Constuctor
   */
  public function __construct() {
    parent::__construct ();
  }
  /**
   * Show the PM home page
   */
  public function home() {

    if ($this->user && array_key_exists(2, $this->roles)) {
      $this->template->content = View::instance ( 'v_pm_home' ); // Set view
      $this->template->title = "QPM : PM Home"; // Set title
      $this->template->content->roles = $this->roles;
      $this->template->content->projects = get_project_list ( $this->user->user_id );
      
      echo $this->template; // Render view
    } else {
      Router::redirect ( "/" );
    }
  }
  
  /**
   * Show the project page
   */
  public function project_details($project_id) {
    if ($this->user && array_key_exists(2, $this->roles) && $project_id) {
      if (check_project_owner($this->user->user_id, $project_id)) {
        $this->template->content = View::instance ( 'v_pm_project' ); // Set view
        $this->template->title = "QPM : PM Gantt Chart"; // Set title
        $this->template->content->roles = $this->roles;
        $this->template->content->project = get_project_details($project_id);
        $this->template->content->project_xml_data = get_project_xml_data($project_id, $this->log);
        $this->template->content->project_groups = get_project_groups($project_id); 
        $this->template->content->project_tasks = get_project_tasks($project_id);
        $this->template->content->resource_list = get_all_tm();
        echo $this->template; // Render view
      } else {
        // Redirect to home page
        Router::redirect ("/pm/home");
      }
    } else {
      Router::redirect ( "/" );
    }
  }
  /**
   * Process the new project request
   */
  public function p_newproject() {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Sanitize data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    $_POST ['created'] = Time::now (); // Set created datetime
    $_POST ['modified'] = Time::now (); // Set modified datetime
    $_POST ['start_date'] = date('Y-m-d', strtotime ($_POST['start_date']));
    $_POST ['end_date'] = date('Y-m-d', strtotime ($_POST['end_date']));
    $_POST ['actual_start_date'] = $_POST ['start_date'];
    $_POST ['actual_end_date'] = $_POST ['end_date'];
    $_POST ['status'] = 'green';
    $_POST ['pm_id'] = $this->roles [2];
    $this->log->logInfo ( var_export ( $_POST, true ) );
    // Insert this user into the database
    $project_id = DB::instance ( DB_NAME )->insert ( "projects", $_POST );
    // Redirect to home page
    Router::redirect ("/pm/home");
  }
  public function get_project($project_id) {
    echo json_encode (get_project_details($project_id));
  }
  
  public function get_task($task_id) {
    echo json_encode (get_task_details($task_id));
  }
  
  public function get_group($group_id) {
    echo json_encode (get_group_details($group_id));
  }
  
  public function get_milestone($milestone_id) {
    echo json_encode (get_milestone_details($milestone_id));
  }
  
  public function p_add_task() {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Sanitize data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    $_POST ['created'] = Time::now (); // Set created datetime
    $_POST ['modified'] = Time::now (); // Set modified datetime
    $_POST ['start_date'] = date('Y-m-d', strtotime ($_POST['start_date']));
    $_POST ['end_date'] = date('Y-m-d', strtotime ($_POST['end_date']));
    $_POST ['status'] = get_status($_POST ['status']);
    if (check_for_empty_string($_POST['depends_on']))
      unset ( $_POST ['depends_on'] );
    // Insert this user into the database
    DB::instance ( DB_NAME )->insert ( "tasks", $_POST );
    echo "Task added successfully.";
  }
  
  public function p_update_task() {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Sanitize data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    $_POST ['modified'] = Time::now (); // Set modified datetime
    $_POST ['start_date'] = date('Y-m-d', strtotime ($_POST['start_date']));
    $_POST ['end_date'] = date('Y-m-d', strtotime ($_POST['end_date']));
    $_POST ['status'] = get_status($_POST ['status']);
    if (check_for_empty_string($_POST['depends_on']))
      unset ( $_POST ['depends_on'] );
    DB::instance (DB_NAME)->update( "tasks", $_POST, "WHERE task_id = " . $_POST ['task_id'] );
    echo "Task updated successfully.";
  }
  
  public function delete_task($task_id) {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    DB::instance (DB_NAME)->delete( "tasks", "WHERE task_id = " . $task_id );
    echo "Task deleted successfully.";
  }
  
  public function p_add_group() {
    $this->log->logInfo($_POST);
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Sanitize data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    $_POST ['created'] = Time::now (); // Set created datetime
    $_POST ['modified'] = Time::now (); // Set modified datetime
    $_POST ['start_date'] = date('Y-m-d', strtotime ($_POST['start_date']));
    $_POST ['end_date'] = date('Y-m-d', strtotime ($_POST['end_date']));
    if (check_for_empty_string($_POST['parent_group_id']))
      unset ( $_POST ['parent_group_id'] );
    // Insert this user into the database
    DB::instance ( DB_NAME )->insert ( "groups", $_POST );
    echo "Group added successfully.";
  }
  
  public function p_update_group() {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Sanitize data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    $_POST ['modified'] = Time::now (); // Set modified datetime
    $_POST ['start_date'] = date('Y-m-d', strtotime ($_POST['start_date']));
    $_POST ['end_date'] = date('Y-m-d', strtotime ($_POST['end_date']));
    if (check_for_empty_string($_POST['parent_group_id']))
      unset ( $_POST ['parent_group_id'] );
    DB::instance (DB_NAME)->update( "groups", $_POST, "WHERE group_id = " . $_POST ['group_id'] );
    echo "Group updated successfully.";
  }
  
  public function delete_group($group_id) {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    DB::instance (DB_NAME)->delete( "groups", "WHERE group_id = " . $group_id );
    echo "Task deleted successfully.";
  }
  
  public function p_add_milestone() {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Sanitize data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    $_POST ['created'] = Time::now (); // Set created datetime
    $_POST ['modified'] = Time::now (); // Set modified datetime
    $_POST ['milestone_date'] = date('Y-m-d', strtotime ($_POST['milestone_date']));
    // Insert this user into the database
    DB::instance ( DB_NAME )->insert ( "milestones", $_POST );
    echo "Milestone added successfully.";
  }
  
  public function p_update_milestone() {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Sanitize data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    // Sanitize data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    $_POST ['modified'] = Time::now (); // Set modified datetime
    $_POST ['milestone_date'] = date('Y-m-d', strtotime ($_POST['milestone_date']));
    DB::instance (DB_NAME)->update( "milestones", $_POST, "WHERE milestone_id = " . $_POST ['milestone_id'] );
    echo "Milestone updated successfully.";
  }
  
  public function delete_milestone($milestone_id) {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Sanitize data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    DB::instance (DB_NAME)->delete( "milestones", "WHERE milestone_id = " . $milestone_id );
    echo "Milestone deleted successfully.";
  }
  /**
   * Process the update project request
   */
  public function p_updateproject() {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Sanitize the data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ( $_POST );
    $this->log->logInfo($_POST);
    $data = Array (
    	"modified" => Time::now (),
        "project_name" => $_POST ['project_name'],
        "project_desc" => $_POST ['project_desc'],
        "actual_start_date" => date('Y-m-d', strtotime ($_POST['start_date'])),
        "actual_end_date" => date('Y-m-d', strtotime ($_POST['end_date'])),
        "status" => get_status($_POST ['status'])
    );
    
    DB::instance (DB_NAME)->update( "projects", $data, "WHERE project_id = " . $_POST ['project_id'] );
    // Redirect to home page
    Router::redirect ("/pm/home");
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
   * Process the upload request.
   * Saves the image to the /upload/avatar folder
   * Update the user's profile with the avatar
   */
  public function p_upload() {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Check if the user selected any image
    if ($_FILES ['avatar'] ['error'] != 0) {
      // If not, show an error message
      $messages ['avatar_error_message'] = "Please select a image file and try again.";
      $this->profile ( $messages );
      return;
    }
    // Upload the file in the /upload/avatar and rename it to <user_id>_avatar.<extension>
    $file_name = Upload::upload ( $_FILES, "/uploads/avatars/", array (
        "jpg",
        "jpeg",
        "gif",
        "png" 
    ), $this->user->user_id . "_avatar" );
    // Create where clause
    $where_condition = 'WHERE user_id = ' . $this->user->user_id;
    // Set array to inser
    $data = Array (
        "avatar" => "/uploads/avatars/" . $file_name,
        "modified" => Time::now () 
    );
    // Updates the user info
    DB::instance ( DB_NAME )->update ( 'users', $data, $where_condition );
    $messages = array ();
    // Show success message
    $messages ['avatar_message'] = "Your avatar has been sucessfully changed.";
    $this->profile ( $messages ); // Render view
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
