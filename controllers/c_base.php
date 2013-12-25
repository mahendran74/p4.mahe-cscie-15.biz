<?php

class base_controller {
	
	public $user;
	public $userObj;
	public $template;
	public $email_template;
	public $roles;
	public $log;

	/*-------------------------------------------------------------------------------------------------

	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
						
		# Instantiate User obj
			$this->userObj = new User();
			
		# Authenticate / load user
			$this->user = $this->userObj->authenticate();					
		# Load user roles
			$this->roles = $this->userObj->get_roles();						
		# Set up templates
			$this->template 	  = View::instance('_v_template');
			$this->email_template = View::instance('_v_email');			
								
		# So we can use $user in views			
			$this->template->set_global('user', $this->user);
			$this->log = Log::instance(APP_PATH.'logs/');
	}
	
} # eoc
