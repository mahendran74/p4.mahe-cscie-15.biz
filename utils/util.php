<?php
/**
 *
 * @author Mahendran Sreedevi
 *         Utility class that does the following
 *         - Checks if a string is empty
 *         - Checks if the email is already registered
 *         - Checks if the email and password are valid
 *         - Gets the keywords in a post and updates the database
 */
/**
 * Checks whether the given string is empty
 * 
 * @param unknown $string
 *         String to check
 * @return boolean True if it's blank and false if not
 */
function check_for_empty_string($string) {
 return (! isset ( $string ) || trim ( $string ) === '');
}
/**
 * Checks whether the emal is already used
 * 
 * @param unknown $email
 *         Email to check
 * @param string $user_id
 *         Optional user id
 * @return boolean True if is used already and false if it's not.
 */
function email_not_used($email, $user_id = NULL) {
 // Check if the user id is null or not
 if (empty ( $user_id )) {
  // User id is null, so request from the sign up view
  // Check whether the email is used by any signed up user
  $q = "SELECT *
				FROM users
    			WHERE UPPER(email) = UPPER('" . $email . "')";
 } else {
  // User id is not null, so request from the update profile view
  // Check whether the email is used by any other signed up user
  // other than the current one
  $q = "SELECT *
                FROM users
    		    WHERE UPPER(email) = UPPER('" . $email . "') AND
    			   		 user_id != " . $user_id;
 }
 // Execute the query to get all the email.
 // Store the result array in the variable $users
 $users = DB::instance ( DB_NAME )->select_rows ( $q );
 return (empty ( $users ));
}
/**
 * Function takes the user's email and password and checks the database
 * for a token
 * 
 * @param String $email         
 * @param String $password         
 * @return String token of the user
 */
function check_login($email, $password) {
 // Hash submitted password so we can compare it against one in the db
 $password = sha1 ( PASSWORD_SALT . $password );
 
 // Search the db for this email and password
 // Retrieve the token if it's available
 $q = "SELECT token, status
         FROM users
        WHERE email = '" . $email . "'
          AND password = '" . $password . "'";
 
 $token = DB::instance ( DB_NAME )->select_row ( $q );
 return $token;
}

/**
 * Function takes the user's email and checks the database
 * for all the roles
 * 
 * @param String $email         
 * @param String $password         
 * @return String token of the user
 */
function check_roles($email) {
 
 // Search the db for this email
 // Retrieve the roles if it's available
 $q = "SELECT role_types_role_type_id, user_role_id
         FROM users
   INNER JOIN users_roles
           ON users_user_id = user_id
        WHERE email = '" . $email . "'";
 $roles = DB::instance ( DB_NAME )->select_kv ( $q, 'role_types_role_type_id', 'user_role_id' );
 $log = Log::instance(APP_PATH.'logs/');
 $log->logInfo(var_export($roles, true));
 foreach ( $db_res as $role ) {
  $roles[] = $role['role_types_role_type_id'];
 }
 return $roles;
}

/**
 * Gets all the list of all the projects for this user
 * 
 * @param unknown $content
 *         Post to be scanned for keywords
 * @param unknown $post_id
 *         Post id
 */
function get_project_list ($user_id) {
 
 // Retrieve the projects for this user_id if it's available
 $q = "SELECT *
         FROM projects
   INNER JOIN users_roles
           ON pm_id = user_role_id
        WHERE users_user_id = '" . $user_id . "' ".
         "AND role_types_role_type_id = 2";
 
  $project_list = DB::instance ( DB_NAME )->select_rows ( $q );
  return  $project_list;
}

/**
 * Gets the details of this project
 *
 * @param unknown $project_id
 *         Project id
 * @param unknown $project
 *         Project
 */
function get_project_details ($project_id) {

 // Retrieve the projects for this user_id if it's available
 $q = "SELECT *
         FROM projects
        WHERE project_id = '" . $project_id . "' ";

 $project = DB::instance ( DB_NAME )->select_row ( $q );
 return  $project;
}

/**
 * Gets the details of this task
 *
 * @param unknown $project_id
 *         Project id
 * @param unknown $project
 *         Project
 */
function get_task_details ($task_id) {

  $q = "SELECT *
         FROM tasks
        WHERE task_id = '" . $task_id . "' ";

  $project = DB::instance ( DB_NAME )->select_row ( $q );
  return  $project;
}


/**
 * Gets the details of this group
 *
 * @param unknown $group_id
 *         Group id
 * @param unknown $group
 *         Group
 */
function get_group_details ($group_id) {

  $q = "SELECT *
         FROM groups
        WHERE group_id = '" . $group_id . "' ";

  $group = DB::instance ( DB_NAME )->select_row ( $q );
  return  $group;
}

/**
 * Gets the details of this milestone
 *
 * @param unknown $milestone_id
 *         Milestone id
 * @param unknown $milestone
 *         Milestone
 */
function get_milestone_details ($milestone_id) {

  $q = "SELECT *
         FROM milestones
        WHERE milestone_id = '" . $milestone_id . "' ";

  $milestone = DB::instance ( DB_NAME )->select_row ( $q );
  return  $milestone;
}
function get_status ($status_string) {
  if ($status_string == "#7bd148")
    return "green";
  elseif ($status_string == "#ffb878")
    return "yellow";
  elseif ($status_string == "#dc2127")
    return "red";
}

function get_users_list() {
  $q = "SELECT  A . *, 
                group_concat(B.role_types_role_type_id) AS roles
          FROM  users AS A
    INNER JOIN  users_roles AS B 
            ON  A.user_id = B.users_user_id
      GROUP BY  A.user_id";
  
  $users_list = DB::instance(DB_NAME)->select_rows($q);
  return  $users_list;
}

function get_user($user_id) {
  $q = "SELECT  A . *
          FROM  users AS A
         WHERE  user_id = " . $user_id;
  $user = DB::instance (DB_NAME)->select_row($q);
  return  $user;
}

function get_user_with_token($token) {
  $q = "SELECT  A . *
          FROM  users AS A
         WHERE  token = '" . $token . "'";
  $user = DB::instance (DB_NAME)->select_row($q);
  return  $user;
}

function send_email($user, $subject, $body, $log) {
  $to[] = Array("name" => $user['first_name']." ".$user['last_name'], "email" => $user['email']);
  $from = Array("name" => APP_NAME, "email" => APP_EMAIL);
  $cc  = "";
  $bcc = "";
  $email = Email::send($to, $from, $subject, $body, true, $cc, $bcc);
}

function send_email_alt($email, $first_name, $last_name, $subject, $body, $log) {
  $to[] = Array("name" => $first_name." ".$last_name, "email" => $email);
  $from = Array("name" => APP_NAME, "email" => APP_EMAIL);
  $cc  = "";
  $bcc = "";
  $email = Email::send($to, $from, $subject, $body, true, $cc, $bcc);
}

function check_project_owner($user_id, $project_id) {
  $q = "SELECT COUNT(*) AS COUNT
          FROM projects AS A 
    INNER JOIN users_roles AS B 
            ON A.pm_id = B.user_role_id
    INNER JOIN users AS C 
            ON B.users_user_id = C.user_id
         WHERE A.project_id = " . $project_id .
         " AND C.user_id = " . $user_id;
  $count = DB::instance (DB_NAME)->select_row($q);
  return ($count['COUNT'] == 1 ? true : false);
}

function get_project_groups($project_id) {
  $q = "SELECT group_id as id, 
               group_desc as text
          FROM groups A
         WHERE A.projects_project_id = ". $project_id;
  $all_groups = DB::instance (DB_NAME)->select_rows($q);
  return json_encode($all_groups);
}

function get_project_tasks($project_id) {
  $q = "SELECT task_id AS id, 
               task_desc AS text 
          FROM tasks AS A 
    INNER JOIN groups AS B 
            ON A.groups_group_id = B.group_id
    INNER JOIN projects AS C 
            ON B.projects_project_id = C.project_id
         WHERE C.project_id = ". $project_id;
  $all_groups = DB::instance (DB_NAME)->select_rows($q);
  return json_encode($all_groups);
}

function get_all_tm() {
  $q = "SELECT B.user_role_id AS id, 
               CONCAT(A.first_name, ' ', A.last_name) AS text
          FROM users AS A
    INNER JOIN users_roles AS B
            ON B.users_user_id = A.user_id
         WHERE B.role_types_role_type_id IN (3)";
  $all_groups = DB::instance (DB_NAME)->select_rows($q);
  return json_encode($all_groups);  
}

function get_project_xml_data($project_id, $log) {
  $xml_string = "<project>";
  // Get all groups ordered by start date
  $q_get_all_groups = "SELECT *
                         FROM groups
                        WHERE projects_project_id = " . $project_id .
                   " ORDER BY start_date";

  $all_groups = DB::instance (DB_NAME)->select_rows($q_get_all_groups);

  foreach ($all_groups as $group) {
    //$log->logInfo($group);
    // Add the group XML to the string
    $xml_string = $xml_string . get_group_XML($group);

    // Get all tasks for this group ordered by start date
    $q_get_all_tasks = "SELECT *
                          FROM tasks
                         WHERE groups_group_id = " . $group['group_id'] .
                    " ORDER BY start_date";
    $all_tasks = DB::instance (DB_NAME)->select_rows($q_get_all_tasks);
    foreach ($all_tasks as $task) {
      $xml_string = $xml_string . get_task_XML($task);
    }

    // Get all milestones for this group ordered by start date
    $q_get_all_milestones = "SELECT *
                               FROM milestones
                              WHERE groups_group_id = " . $group['group_id'] .
                         " ORDER BY milestone_date";
    $all_milestones = DB::instance (DB_NAME)->select_rows($q_get_all_milestones);
    foreach ($all_milestones as $milestone) {
      $xml_string = $xml_string . get_milestone_XML($milestone);
    }
  }
  $xml_string = $xml_string."</project>";
  $log->logInfo($xml_string);
  return $xml_string;
}

function get_group_XML($group) {
  $xml_string = "<task><pID>".$group['group_id']."</pID>";
  $xml_string = $xml_string."<pName>".$group['group_desc']."</pName>";
  $xml_string = $xml_string."<pStart>".date('m/d/Y', strtotime($group['start_date']))."</pStart>";
  $xml_string = $xml_string."<pEnd>".date('m/d/Y', strtotime($group['end_date']))."</pEnd>";
  $xml_string = $xml_string."<pColor>0000ff</pColor><pLink /><pMile>0</pMile><pRes/>";
  $xml_string = $xml_string."<pComp>".$group['per_complete']."</pComp><pGroup>1</pGroup>";
  if ($group['parent_group_id']) {
    $xml_string = $xml_string."<pParent>".$group['parent_group_id']."</pParent>";
  } else {
    $xml_string = $xml_string."<pParent>0</pParent>";
  }
  $xml_string = $xml_string."<pOpen>1</pOpen><pDepend/></task>";
  return $xml_string;
}

function get_milestone_XML($milestone) {
  $xml_string = "<task><pID>".$milestone['milestone_id']."</pID>";
  $xml_string = $xml_string."<pName>".$milestone['milestone_desc']."</pName>";
  $xml_string = $xml_string."<pStart>".$milestone['milestone_date']."</pStart>";
  $xml_string = $xml_string."<pEnd>".$milestone['milestone_date']."</pEnd>";
  $xml_string = $xml_string."<pColor>0000ff</pColor><pLink /><pMile>1</pMile>";
  $user = get_assigned_user($milestone['assigned_to_id']);
  $xml_string = $xml_string."<pRes>".$user['first_name']." ".$user['last_name']."</pRes>";
  $xml_string = $xml_string."<pComp/><pGroup>0</pGroup>";
  if ($group['groups_group_id']) {
    $xml_string = $xml_string."<pParent>".$group['groups_group_id']."</pParent>";
  } else {
    $xml_string = $xml_string."<pParent>0</pParent>";
  }
  $xml_string = $xml_string."<pOpen>0</pOpen><pDepend/></task>";
  return $xml_string;
}

function get_task_XML($task) {
  $xml_string = "<task><pID>".$task['task_id']."</pID>";
  $xml_string = $xml_string."<pName>".$task['task_desc']."</pName>";
  $xml_string = $xml_string."<pStart>".date('m/d/Y', strtotime($task['start_date']))."</pStart>";
  $xml_string = $xml_string."<pEnd>".date('m/d/Y', strtotime($task['end_date']))."</pEnd>";
  $xml_string = $xml_string."<pColor>".$task['color']."</pColor><pLink /><pMile>0</pMile>";
  $user = get_assigned_user($task['assigned_to_id']);
  $xml_string = $xml_string."<pRes>".$user['first_name']." ".$user['last_name']."</pRes>";
  $xml_string = $xml_string."<pComp>".$task['per_complete']."</pComp><pGroup>0</pGroup>";
  if ($task['groups_group_id']) {
    $xml_string = $xml_string."<pParent>".$task['groups_group_id']."</pParent>";
  } else {
    $xml_string = $xml_string."<pParent>0</pParent>";
  }
  $xml_string = $xml_string."<pOpen>1</pOpen>";
  if ($task['depends_on']) {
    $xml_string = $xml_string."<pDepend>".$task['depends_on']."</pDepend>";
  } else {
    $xml_string = $xml_string."<pDepend/>";
  }
  $xml_string = $xml_string."</task>";
  return $xml_string;
}

function get_assigned_user($assigned_to_id) {
  $q = "SELECT A . *
          FROM users A
    INNER JOIN users_roles B ON A.user_id = B.users_user_id
    INNER JOIN tasks C ON B.user_role_id = C.assigned_to_id
         WHERE C.assigned_to_id = " . $assigned_to_id;
  $user = DB::instance (DB_NAME)->select_row($q);
  return  $user;
}

function url(){
  return sprintf(
      "%s://%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['HTTP_HOST']
  );
}

?>