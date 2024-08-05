<?php
class Login extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		if($this->staff->is_logged_in())
		{
			redirect('home');
		}
		else
		{
			$this->form_validation->set_rules('username', 'lang:login_undername', 'callback_login_check');
    	    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() == FALSE)
			{
				$this->load->view('login');
			}
			else
			{
				redirect('home');
			}
		}
	}
	
	function login_check($username)
	{
		$password = $this->input->post("password");	
		
		if(!$this->staff->login($username,$password))
		{
			$this->form_validation->set_message('login_check', 'Invalid username or password!');
			return false;
		}
		return true;		
	}
}
?>