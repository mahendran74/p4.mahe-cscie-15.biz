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
class admin_controller extends base_controller {
	
	/**
	 * Constuctor 
	 */
	public function __construct() {
		parent::__construct ();
	}
	/**
	 * Show the sign up page
	 */
	public function home() {
	 if ($this->user && array_key_exists(1, $this->roles)) {
		$this->template->content = View::instance ('v_admin_home'); // Set view
		$this->template->title = "QPM : Admin Home"; // Set title
		$this->template->content->roles = $this->roles;
		$this->template->content->users = get_users_list();
		
		echo $this->template; // Render view
	 } else {
	  Router::redirect ( "/" );
	 }
	}
}
?>