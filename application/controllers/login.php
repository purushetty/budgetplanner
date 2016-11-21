<?php
/*
*Controller definition for shape calculator project
*Company: Bombayworks
*Created: 31-07-2016
*Author: Puru Shetty
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	private $un;				// Private property for storing username
	private $pw;				// Private property for storing password
	private $eml; 				// Private property for storing email				
	private $uid;				// Private property for storing session data
	private $data = array();	// Private array for temp storage of data to be written to the 
								// database
	function __construct() {
		
		parent::__construct();
		
		$this->load->library('session');
		$this->load->library('form_validation');		
		$this->load->helper(array('form', 'url'));		
		$this->load->model('user_model');
	}

	public function index()
	{			
		$this->uid = $this->session->userdata('user_id');
		
		// Check if the user is already logged in
		if(isset($this->uid) && !empty($this->uid))
		{			
			$this->load->view('expense');
		}
		else
		{
			$this->load->view('login');
		}
	}
	
    public function verify()
    {
			// Custom error messages
			$config = array(
					'required' => '<span class="rednbold">* The {field} input is a required field!</span>',
					'min_length' => '<span class="rednbold">* The {field} input must be greater than 6 characters</span>'		
			);
			$this->form_validation->set_message($config);		
			
			// Input field validation rules 
			$config = array(
					array(
					'field' => 'username',
					'label'	=> 'Username',
					'rules'	=> 'trim|required|min_length[6]'
					),
					
					array(
					'field' => 'password',
					'label'	=> 'Password',
					'rules'	=> 'trim|required'
					
					)
			);
			$this->form_validation->set_rules($config);		
				
			if(isset($_POST['ulogin']) && !empty($_POST['ulogin']))
			{
				$this->un = $this->input->post('username');
				$this->pw	= $this->input->post('password');
		
				if ($this->form_validation->run() != FALSE)
				{
					$rec      = $this->user_model->get_row('', '', '', trim($this->un), trim($this->pw), '', '');
					if (!empty($rec)) {
						if ($rec['status'] == 'Active') {
							$this->session->set_userdata('user_id', $rec['id']);
							$this->session->set_userdata('username', $rec['username']);
							$this->session->set_userdata('first_name', $rec['first_name']);
							$this->session->set_userdata('last_name', $rec['last_name']);
			
							$this->load->view('expense');
						}
					}
					else
					{
						$data['error_message'] = '<span class="rednbold">This user does not exist!</span>';
						$this->load->view('login', $data);						
					}
				}
				else
				{
					$this->load->view('login');	
				}		
			}
			elseif($this->session->userdata('user_id'))
			{
				$this->load->view('expense');			
			}
			else
			{
				$this->load->view('login');
			}
	}

	public function get_cat_ajax() {

		if(isset($_POST['cat']) && ($_POST['cat'] == 'delete'))
		{ 
			$d_usr = array();
			$d_usr['category_creator_id'] = $this->session->userdata('user_id');
			$d_usr['category_id'] = $_POST['ecat'];
			
			echo $this->user_model->delete($d_usr);
		}
		elseif(isset($_POST['cat']) && ($_POST['cat'] == 'edit'))
		{
			
			
		}
	}
	
	public function verifyajax() {
		$this->un = trim($_POST['un']);
		$this->pw	= trim($_POST['pwd']);
		
		$rec  = $this->user_model->get_row('', '', '', $this->un, $this->pw, '', '');

		if (!empty($rec)) {
			if ($rec['status'] == 'Active') {
				echo 'active';
			}	
			else
			{
				echo 'blocked';
			}
		}
		else
		{
			echo 'missing';
		}
	}
	
	public function del_user_ajax() {
		
		$d_usr = array();
		$d_usr['id'] = trim($_POST['user']);		
		$d_usr['status'] = 'Active';
		
		echo $this->user_model->delete($d_usr);
	}
	
	public function dashboard() {
	
		if(!empty($this->session->userdata('user_id')))
		{  
			// Get all users from the user table	
			$rec = $this->user_model->get_all('user');
			
			if($rec) {		
				foreach ($rec as $row)
				{
					$this->data['user'][$row->id] = $row->first_name.' '.$row->last_name;
				}
			}
			
			// Get all category data from category table
			$rec = $this->user_model->get_all('category');		
			
			if($rec) {		
				foreach ($rec as $row)
				{
					$this->data['category'][$row->category_id] = $row->category_name;
				}
			}
									
			// Get all category item data from the category_item table
			$rec = $this->user_model->get_all('category_items');		
			
			if($rec) {		
				foreach ($rec as $row)
				{
					$this->data['category_items'][$row->category_item_id] = $row->first_name.' '.$row->last_name ;
				}
			}
			
			// Save queried data in session
			$this->session->set_userdata('data', $this->data);
			
			$this->load->view('dashboard', $this->data);
		}
		else
		{
			redirect(base_url());	
		}
	}

	public function selectuser() {

		if(!empty($this->session->userdata('user_id')))
		{  
			// Custom error messages
			$config = array(
				'required' => '<h4><span class="label label-warning">* Required field</span></h4>'
			);
			$this->form_validation->set_message($config);		
			
			$config = array(					
					'field' => 'ed-get-usr',
					'label'	=> 'Select',
					'rules'	=> 'required'
			);			
			$this->form_validation->set_rules($config);		
			
			if ($this->form_validation->run() == FALSE)
            {
				$this->session->set_userdata('select_user', $this->input->post('ed-get-usr'));	
				$this->load->view('dashboard');								
			}
			else
			{
				$this->data['select_error_message'] = '<div class="spacer20"><h4><span class="label label-danger">*** Please fix the following errors and try again! ***</span></h4></div>';
				$this->load->view('dashboard', $this->data);								
			}					
		}
		else
		{
			redirect(base_url());	
		}
	}
	
	public function edituser() {
	
		if(!empty($this->session->userdata('user_id')))
		{  
			// Custom error messages
			$config = array(
				'required' => '<h4><span class="label label-warning">* Required field</span></h4>',
				'valid_email' => '<h4><span class="label label-warning">* Invalid {field} format </span></h4>',
			);
			$this->form_validation->set_message($config);		
	
			$config = array(
					
				array(
					'field' => 'e-fname',
					'label'	=> 'First Name',
					'rules'	=> 'trim|required'
				),
					
				array(
					'field' => 'e-lname',
					'label'	=> 'Last Name',
					'rules'	=> 'trim|required'
				),
	
				array(
					'field' => 'e-eml',
					'label'	=> 'Email',
					'rules'	=> 'trim|required|valid_email'
				)					
			);
			$this->form_validation->set_rules($config);		
			
			if(isset($_POST['e-nusr']) && !empty($_POST['e-nusr']))
			{
				if ($this->form_validation->run() != FALSE)
				{
					$rec = $this->user_model->get_row('', '', '', '', '', $this->input->post('eml'), '');
					
					$comp_array = array();	
					$comp_array['first_name'] = $this->input->post('e-fname');
					$comp_array['last_name'] = $this->input->post('e-lname');				
					$comp_array['email'] = $this->input->post('e-eml');
					
					// Get stored user data for comparison with the entered data
					$rec  = $this->user_model->get_row($this->input->post('ed-usr-id'), '', '', '', '', '', '');	
		
					// Check if the fetched data is the same as the stored data
					$result = array();
					$result = array_diff_assoc($comp_array, $rec);
					
					// If the data are same, no database write happpens
					if(empty($result))
					{				
						$this->session->set_flashdata('no_change_message', true);
						$this->data = $this->session->userdata('data');
						$this->data['edit_error_message'] = '<div class="spacer20"><h4><span class="label label-danger">*** No new information detected. Database record remains unchanged. ***</span></h4></div>';
						$this->load->view('dashboard', $this->data);
					}
					else
					{
						$this->user_model->update($this->input->post('ed-usr-id'), $result);				
						$this->session->set_flashdata('edit_success_message', true);
						redirect(base_url().'login/dashboard');
					}
				}
				else
				{
					$this->data = $this->session->userdata('data');
					$this->data['edit_error_message'] = '<div class="spacer20"><h4><span class="label label-danger">*** Please fix the following errors and try again! ***</span></h4></div>';
					$this->load->view('dashboard', $this->data);
				}
			}
			else
			{
				redirect(base_url().'login/dashboard');
			}
		}
		else
		{
			redirect(base_url().'login/');	
		}
	}
	
	public function changepass() {
	
		if(!empty($this->session->userdata('user_id')))
		{  
			// Custom error messages
			$config = array(
					'required' => '<h4><span class="label label-warning">* Required field</span></h4>',
					'min_length' => '<h4><span class="label label-warning">* {field} must be minimum 6 characters</span></h4>',
					'regex_match' => '<h4><span class="label label-warning">* {field} does not meet the criteria</span></h4>',
					'matches' => '<h4><span class="label label-warning">* Passwords do not match</span></h4>',
					'differs' => '<h4><span class="label label-warning">* {field} cannot be same as the old password</span></h4>',						
			);
			$this->form_validation->set_message($config);		
	
			$config = array(
					
				array(
					'field' => 'e-opwd',
					'label'	=> 'Old Password',
					'rules'	=> 'trim|required'
				),
					
				array(
					'field' => 'e-npwd',
					'label'	=> 'New Password',
					'rules'	=> 'trim|required|min_length[8]|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z@#_-]{8,}$/]|differs[e-opwd]'				
				),
	
				array(
					'field' => 'e-cpwd',
					'label'	=> 'Confirm Password',
					'rules'	=> 'trim|required|matches[e-npwd]'				
				)					
			);
			$this->form_validation->set_rules($config);		
			
			if(isset($_POST['e-nusr']) && !empty($_POST['e-nusr']))
			{
				if ($this->form_validation->run() != FALSE)
				{
					$rec = $this->user_model->get_row('', '', '', '', '', $this->input->post('eml'), '');
					
					$comp_array = array();	
					$comp_array['first_name'] = $this->input->post('e-fname');
					$comp_array['last_name'] = $this->input->post('e-lname');				
					$comp_array['email'] = $this->input->post('e-eml');
					
					// Get stored user data for comparison with the entered data
					$rec  = $this->user_model->get_row($this->input->post('ed-usr-id'), '', '', '', '', '', '');	
		
					// Check if the fetched data is the same as the stored data
					$result = array();
					$result = array_diff_assoc($comp_array, $rec);
					
					// If the data are same, no database write happpens
					if(empty($result))
					{				
						$this->session->set_flashdata('no_change_message', true);
						$this->data = $this->session->userdata('data');
						$this->data['edit_error_message'] = '<div class="spacer20"><h4><span class="label label-danger">*** No new information detected. Database record remains unchanged. ***</span></h4></div>';
						$this->load->view('dashboard', $this->data);
					}
					else
					{
						echo $this->user_model->update($this->input->post('ed-usr-id'), $result);				
						$this->session->set_flashdata('edit_success_message', true);
						redirect(base_url().'login/dashboard');
					}
				}
				else
				{
					$this->data = $this->session->userdata('data');
					$this->data['edit_error_message'] = '<div class="spacer20"><h4><span class="label label-danger">*** Please fix the following errors and try again! ***</span></h4></div>';
					$this->load->view('dashboard', $this->data);
				}
			}
			else
			{
				redirect(base_url().'login/dashboard');
			}
		}
		else
		{
			redirect(base_url().'login/');	
		}
	}

	public function newuser() {
		
		if(!empty($this->session->userdata('user_id')))
		{  
			// Custom error messages
			$config = array(
					'required' => '<h4><span class="label label-warning">* Required field</span></h4>',
					'is_unique' => '<h4><span class="label label-warning">* The {field} entry must be a unique value</span></h4>',
					'min_length' => '<h4><span class="label label-warning">* {field} must be minimum 6 characters</span></h4>',
					'regex_match' => '<h4><span class="label label-warning">* {field} does not meet the criteria</span></h4>',
					'valid_email' => '<h4><span class="label label-warning">* Invalid {field} format </span></h4>',
					'matches' => '<h4><span class="label label-warning">* Passwords do not match</span></h4>'						
			);
			$this->form_validation->set_message($config);		
	
			$config = array(
					
					array(
					'field' => 'fname',
					'label'	=> 'First Name',
					'rules'	=> 'trim|required'
					),
					
					array(
					'field' => 'lname',
					'label'	=> 'Last Name',
					'rules'	=> 'trim|required'
					),
	
					array(
					'field' => 'uname',
					'label'	=> 'Username',
					'rules'	=> 'trim|required|min_length[6]|is_unique[user.username]'
					),
	
					array(
					'field' => 'eml',
					'label'	=> 'Email',
					'rules'	=> 'trim|required|valid_email|is_unique[user.email]'
					),
					
					array(
					'field' => 'pass',
					'label'	=> 'Password',
					'rules'	=> 'trim|required|min_length[8]|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z@#_-]{8,}$/]'				
					),
					
					array(
					'field' => 'cpass',
					'label'	=> 'Confirm Password',
					'rules'	=> 'trim|required|matches[pass]'				
					)				
			);
			$this->form_validation->set_rules($config);		
			
			if(isset($_POST['nusr']) && !empty($_POST['nusr']))
			{
				if ($this->form_validation->run() != FALSE)
				{
					$rec      = $this->user_model->get_row('', '', '', $this->input->post('uname'), '', $this->input->post('eml'), '');
						
					if (empty($rec)) 
					{
						$this->data['id'] = '';
						$this->data['first_name'] = $this->input->post('fname');
						$this->data['last_name'] = $this->input->post('lname');
						$this->data['username'] = $this->input->post('uname');
						$this->data['password'] = md5($this->input->post('pass'));
						$this->data['email'] = $this->input->post('eml');																
						$this->data['status'] = 'Active';
	
						$rec = $this->user_model->add($this->data, '');				
	
						if(is_int($rec))
						{
							$this->session->set_flashdata('success_message', true);
							redirect(base_url().'login/dashboard');
						}
						else
						{
							$this->session->set_flashdata('success_message', false);
							$this->data = $this->session->userdata('data');
							$this->data['error_message'] = '<div class="spacer20"><h4><span class="label label-danger">*** There was a problem writing to the database. Please try again later! ***</span></h4></div>';
							$this->load->view('dashboard', $this->data);				
						}
					}
					else
					{
						$this->session->set_flashdata('user_exist_message', true);
						$this->data = $this->session->userdata('data');
						$this->data['flash_message'] = false; 
						$this->data['error_message'] = '<div class="spacer20"><h4><span class="label label-danger">*** This user already exists. Please try again! ***</span></h4></div>';
						$this->load->view('dashboard', $this->data);
					}
				}
				else
				{
					$this->data = $this->session->userdata('data');
					$this->data['error_message'] = '<div class="spacer20"><h4><span class="label label-danger">*** Please fix the following errors and try again! ***</span></h4></div>';
					//$this->session->set_flashdata('error_message', true);
					$this->load->view('dashboard', $this->data);
				}
			}
			else
			{
				redirect(base_url().'login/dashboard');
			}
		}
		else
		{
			redirect(base_url().'login/');	
		}
	}
	
	public function logout() {
		$this->session->sess_destroy();
		redirect('http://localhost/budgcal/login');
	}
	
	function create_db() {
	    
		$this->user_model->create_db_structure('budget_planner');
	}

	function drop_db() {
	    
		$this->user_model->create_db_structure('budget_planner');
	}
	
	function add_db_table() {
		
	}
	
	function drop_db_table() {
		
	}
	
	function add_table_column() {
		
	}
	
	function drop_table_column() {
		
	}

	public function edit_user_ajax() {
				
		if(isset($_POST['nusr']) && !empty($_POST['nusr']))		
		{
			$this->data['id'] = '';
			$this->data['first_name'] = $_POST['fname'];
			$this->data['last_name'] = $_POST['lname'];
			$this->data['username'] = $_POST['uname'];
			$this->data['password'] = md5($_POST['pass']);
			$this->data['email'] = $_POST['eml'];																
			$this->data['status'] = 'Active';
			
			echo $this->user_model->add($this->data, '');
		}
		elseif(isset($_POST['eusr']) && !empty($_POST['eusr']))
		{
			$comp_array = array();
			$comp_array['first_name'] = $_POST['e-fname'];
			$comp_array['last_name'] = $_POST['e-lname'];				
			$comp_array['email'] = $_POST['e-eml'];
			
			$rec  = $this->user_model->get_row($_POST['ed-usr-id'], '', '', '', '', '', '');	

			$result = array();
			$result = array_diff_assoc($comp_array, $rec);
			
			if(empty($result))
			{				
				echo 'exist';
			}
			else
			{
				echo $this->user_model->update($_POST['ed-usr-id'], $result);				
			}
		}
		elseif(isset($_POST['add-cat-hd']) && !empty($_POST['add-cat-hd']))
		{
			
		}
		else
		{
			redirect(base_url().'login');
		}
	}

	public function change_pass_ajax() {
				
		if(isset($_POST['epwd']) && !empty($_POST['epwd']))
		{
			$comp_array = array();	
			$comp_array['password'] = trim(md5($_POST['e-npwd']));				

			echo $this->user_model->update($_POST['usr-pw-id'], $comp_array);							
		}
		else
		{
			redirect(base_url().'login');
		}
	}
	
	public function add_cat_ajax() {
				
		if(isset($_POST['add-cat-hd']) && !empty($_POST['add-cat-hd']))
		{
			$this->data['category_name'] = trim($_POST['a-c-name']);
			$this->data['category_creator_id'] = $this->session->userdata('user_id');				

			echo $this->user_model->add($this->data, 'category');
		}
		else
		{
			redirect(base_url().'login');
		}
	}
		
	public function user_exist_ajax() {
		
		if(isset($_POST['username']) && !empty($_POST['username']))
		{
			$this->un = trim($_POST['un']);
			$rec = $this->user_model->chk_user_exist('', $this->un, '', '', 'Active', 'username');
			
			if($rec)
			{
				echo 1;	
			}
			else
			{
				echo 0;
			}
		}
		elseif(isset($_POST['password']) && ($_POST['password'] == 'password'))
		{
			$this->un = trim($_POST['pw']);
			$usrid = $_POST['uid'];
			$rec = $this->user_model->chk_user_exist($usrid, '', $this->un, '', 'Active', 'password');
			
			if($rec)
			{
				echo 1;	
			}
			else
			{
				echo 0;
			}			
		}
		elseif(isset($_POST['email']) && ($_POST['email'] == 'add'))
		{
			$this->eml = trim($_POST['eml']);
			$rec = $this->user_model->chk_user_exist('', '', '', $this->eml, 'Active', 'add');
			
			if($rec)
			{
				echo 1;
			}
			else
			{
				echo 0;
			}			
		}
		elseif(isset($_POST['email']) && ($_POST['email'] == 'edit'))
		{
			$id = trim($_POST['usr_id']);
			$this->eml = trim($_POST['eml']);
			$rec = $this->user_model->chk_user_exist($id, '', '', $this->eml, 'Active', 'edit');
			
			if($rec)
			{
				echo $rec;
			}
		}
		elseif(isset($_POST['usr']) && ($_POST['usr'] == 'edit'))
		{
			$id = trim($_POST['e-usr']);
			
			$rec = $this->user_model->get_row($id, '', '', '', '', '', '');
			
			echo json_encode($rec);
		}
	}
}
