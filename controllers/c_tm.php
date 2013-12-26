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
class tm_controller extends base_controller {
  
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
      $this->template->content = View::instance ( 'v_tm_home' ); // Set view
      $this->template->title = "QPM : TM Home"; // Set title
      $this->template->content->roles = $this->roles;
      $this->template->content->tasks = get_tasks( $this->user->user_id );
      $this->log->logInfo(get_tasks( $this->user->user_id ));
      echo $this->template; // Render view
    } else {
      Router::redirect ( "/" );
    }
  }
  
  public function get_task_details($task_id) {
    echo json_encode(get_task_details($task_id));
  }
  
  public function change_task_time($task_id, $field, $interval) {
    // Check to see if the user id logged in.
    if (! $this->user) {
      // If not redirect it back to the home page for login.
      Router::redirect ( "/" );
    }
    // Sanitize data for SQL injection attacks
    $_POST = DB::instance ( DB_NAME )->sanitize ($_POST);
    $sql = "UPDATE tasks 
               SET ". $field . " = DATE_ADD(". $field . ", INTERVAL ". $interval . " DAY),
                   modified = " . Time::now () .
           " WHERE task_id = ". $task_id;

    DB::instance ( DB_NAME )->query ($sql);
    echo "Task updated successfully.";
  }
  
  public function get_tasks_json($user_id) {
    $ret = array();
    
    $tasks = get_tasks($user_id);
    foreach ($tasks as $task) {
      $ret[] = array (
      	'id' => "t". $task['task_id'],
		'title' => $task['task_desc'],
		'start' => $task['start_date'],
		'end' => $task['end_date'],
		'url' => '#',
        'color' => $task['color'],
        'backgroundColor' => $task['color']
      );
    }
    
    $milestones = get_milestones($user_id);
    foreach ($milestones as $milestone) {
      $ret[] = array (
        'id' => "m".$milestone['milestone_id'],
        'title' => $milestone['milestone_desc'],
        'start' => $milestone['milestone_date'],
        'url' => '#',
        'color' => '#f83a22',
        'backgroundColor' => '#f83a22'
      );
    }
    echo json_encode($ret);
  }
  
  public function p_update_task() {
    $this->log->logInfo($_POST);
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
    unset ( $_POST ['per_complete_slide'] );
    DB::instance (DB_NAME)->update( "tasks", $_POST, "WHERE task_id = " . $_POST ['task_id'] );

    echo "Task updated successfully.";
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
}
?>
