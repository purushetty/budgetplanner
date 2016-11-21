<?php
// Model for handling all the data related to user management
class User_model extends CI_Model
{
	// Declaration of variables for table and primary key..
	private $table_name;
	private $primary_key;
	
	// To Initialize data in model..
	function __construct()
	{
		 parent::__construct();
		 
		 // Defining table name and Primay key..
		 $this->table_name = 'user';
		 $this->primary_key = 'id';
		 $this->table_data = array();
		 
		$rec = $this->db->query($this->config_db('budget_planner'));

		if(!$rec)
		{
		 	return DB_ERROR; 
		}
	}
	
	// To insert data into DB..
	function add($data, $table='')
	{
		try
		{
			$data = CTH_addslashes($data);
			
			if(!empty($table))
				$this->table_name = $table;
				
			if( $this->db->insert($this->table_name, $data) )
				return $this->db->insert_id();
			else
				throw new Exception();
		}
		catch(Exception $e)
		{
			CTH_log_db_error();
			return DB_ERROR;
		}
	}

	function category_edit($param=array(), $tbl='', $action) {
		try
		{
			switch($action)
			{
				case "delete":				
					$sql = "DELETE FROM ".$tbl." WHERE 1";
					if(isset($params['category_id']) && $params['category_id']!='')
						$sql .= " AND id = ".$params['id'];
					if(isset($params['category_id']) && $params['category_id']!='')
						$sql .= " AND id = ".$params['id'];
					$sql;
					if( $this->db->query($sql) )
						return true;
					else
						return false;
					break;
				case "edit":
				
					break;				
			}
		}
		catch(Exception $e)
		{
			CTH_log_db_error();
			return DB_ERROR;
		}
			
	}
	
	// To Delete user by thier user_id/status..  
	function delete($params=array())
	{
		try
		{
			$sql = "DELETE FROM ".$this->table_name." WHERE 1";
			if(isset($params['id']) && $params['id']!='')
				$sql .= " AND id = ".$params['id'];
			if(isset($params['status']) && $params['status']!='')
				$sql .= " AND status = '".$params['status']."'";
			$sql;
			if( $this->db->query($sql) )
				return true;
			else
				return false;
		}
		catch(Exception $e)
		{
			CTH_log_db_error();
			return DB_ERROR;
		}
	}
	
	// To Update edited data into DB..
	function update($user_id, $data)
	{
		try
		{
			$where = $this->primary_key." = $user_id "; 
			$data = CTH_addslashes($data);
			if( $this->db->update( $this->table_name , $data, $where) )
				return true;
			else
				throw new Exception();
		}
		catch(Exception $e)
		{
			CTH_log_db_error();
			return DB_ERROR;
		}
	}
	
	// To check if a username and/or email address already exist in the database
	function chk_user_exist($user_id, $username='', $password='',  $email='', $status='', $action='')
	{    
		try
		{
			$sql = "SELECT * FROM ". $this->table_name." WHERE 1 ";
			if( $user_id != '' )
				$sql .= " AND ".$this->primary_key." = $user_id ";
			if( $username != '' )
				$sql .= " AND username = '".$username."'";
			if( $password != '' )
				$sql .= " AND password = ".$this->db->escape(md5($password));
			if( $email != '' )
				$sql .= " AND email = ".$this->db->escape($email);
			if( $status != '' )
				$sql .= " AND status = '".$status."'";
			$sql;
				
			$rs = $this->db->query($sql);
			if( $rs )
			{
				if( $rs->num_rows()>0 )
					return TRUE;
				elseif($action == 'edit')
				{
					$sql = "SELECT * FROM ". $this->table_name." WHERE 1 ";
					if( $email != '' )
						$sql .= " AND email = ".$this->db->escape($email);
					$sql;			
					
					$rs = $this->db->query($sql);
					if( $rs )
					{
						if( $rs->num_rows()>0 )
							return "exist";
						else
							return FALSE;	
					}
				}
				else
					return FALSE;
			}
			else
				throw new Exception();
		}
		catch(Exception $e)
		{
			CTH_log_db_error();
			return DB_ERROR;
		}
	} 

	function get_all($tab='')
	{    
		try
		{
			$sql = "SELECT * FROM ".$tab;
				
			$rs = $this->db->query($sql);
			if( $rs )
			{
				if( $rs->num_rows()>0 )					
				{
					return $rs->result();
				}
				else
					return FALSE;
			}
			else
				throw new Exception();
		}
		catch(Exception $e)
		{
			CTH_log_db_error();
			return DB_ERROR;
		}
	}
	
	// To get a single row of user data based on the defined parameters..
	function get_row($user_id='', $first_name='', $last_name='', $username='',  $password='', $email='', $status='')
	{    
		try
		{
			$sql = "SELECT * FROM ". $this->table_name." WHERE 1 ";
			if( $user_id != '' )
				$sql .= " AND ".$this->primary_key." = $user_id ";
			if( $first_name != '')
				$sql .= " AND first_name = '".$first_name."'";
			if( $last_name != '')
				$sql .= " AND last_name = '".$last_name."'";
			if( $username != '' )
				$sql .= " AND username = '".$username."'";
			if( $email != '' )
				$sql .= " AND email = ".$this->db->escape($email);
			if( $password != '' )
				$sql .= " AND password = ".$this->db->escape(md5($password));
			if( $status != '' )
				$sql .= " AND status = '".$status."'";
			$sql;
				
			$rs = $this->db->query($sql);
			if( $rs )
			{
				if( $rs->num_rows()>0 )
					return CTH_stripslashes($rs->row_array());
				else
					return FALSE;
			}
			else
				throw new Exception();
		}
		catch(Exception $e)
		{
			CTH_log_db_error();
			return DB_ERROR;
		}
	}
	
	/* Added by Puru on 10/13/2016
	
	- Creating a non existent table
	
	function create_table($sel) { 
	
		switch($sel) 
		{
			// Table "category"
			case "category":
				$sql = "CREATE TABLE `category` (
				  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
				  `category_name` varchar(50) NOT NULL,
				  `category_item_count` int(20) NOT NULL,
				  `category_creator` varchar(20) NOT NULL,
				  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
				break;
			// Table "category items"	
			case "category_items":
				$sql = "CREATE TABLE `category_items` (
				  `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				  `item_category_id` int(20) NOT NULL,
				  `item_name` varchar(20) NOT NULL,
				  `item_value` float NOT NULL,
				  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
				break;
			//Table "user"	
			case "user":
				$sql = "CREATE TABLE `user` (
				  `id` int(20)  UNSIGNED NOT NULL AUTO_INCREMENT,
				  `first_name` varchar(20) NOT NULL,
				  `last_name` varchar(20) NOT NULL,
				  `username` varchar(50) NOT NULL,
				  `password` varchar(50) NOT NULL,
				  `email` varchar(50) NOT NULL,
				  `status` varchar(10) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";	
				break;	
		}
		
		$rec = $this->db->query($sql);
		
		if($rec)
		{
			
		}
	}   */
	
	private function add_db_table($sel) {
		
		switch($sel) {		
			case "category":
				$fields = array(
					'category_id' => array(
						'type' => 'INT',
						'constraint' => 10,
						'unsigned' => TRUE,
						'auto_increment' => TRUE
					),
					'category_name' => array(
						'type' => 'VARCHAR',
						'constraint' => '20',
						'unique' => TRUE
					),
					'category_creator_id' => array(
						'type' =>'INT',
						'constraint' => '10'
					),
					'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
				);
				$this->dbforge->add_key('category_id', TRUE);				
				break;
			case "category_items":
				$fields = array(
					'category_item_id' => array(
							'type' => 'INT',
							'constraint' => 10,
							'unsigned' => TRUE,
							'auto_increment' => TRUE
					),
					'category_id' => array(
							'type' => 'INT',
							'constraint' => '10',
							'unique' => TRUE,
					),
					'category_item_name' => array(
							'type' =>'VARCHAR',
							'constraint' => '50',
					),
					'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
				);
				$this->dbforge->add_key('category_item_id', TRUE);								
				break;
			case "category_item_values":
				$fields = array(
					'item_value_id' => array(
							'type' => 'INT',
							'constraint' => 10,
							'unsigned' => TRUE,
							'auto_increment' => TRUE
					),
					'category_id' => array(
							'type' => 'INT',
							'constraint' => '10',
							'unique' => TRUE,
					),					
					'category_item_id' => array(
							'type' => 'INT',
							'constraint' => '10',
							'unique' => TRUE,
					),
					'item_value' => array(
							'type' =>'FLOAT',
							'constraint' => '20',
					),
					'category_total' => array(
							'type' =>'FLOAT',
							'constraint' => '30',
					),					
					'month_total' => array(
							'type' =>'FLOAT',
							'constraint' => '30',
					),										
					'budget_month' => array(
							'type' => 'VARCHAR',
							'constraint' => '30',
					),										
					'budget_year' => array(
							'type' => 'VARCHAR',
							'constraint' => '30',
					),										
					'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
				);
				$this->dbforge->add_key('item_value_id', TRUE);								
				break;
			case "user":
				$fields = array(
					'id' => array(
							'type' => 'INT',
							'constraint' => 10,
							'unsigned' => TRUE,
							'auto_increment' => TRUE
					),
					'first_name' => array(
							'type' => 'VARCHAR',
							'constraint' => '50'
					),
					'last_name' => array(
							'type' =>'VARCHAR',
							'constraint' => '50'
					),
					'username' => array(
							'type' =>'VARCHAR',
							'constraint' => '50'
					),
					'password' => array(
							'type' =>'VARCHAR',
							'constraint' => '100'
					),
					'email' => array(
							'type' =>'VARCHAR',
							'constraint' => '50'
					),
					'status' => array(
							'type' => 'VARCHAR',
							'constraint' => '10',
					)
				);
				$this->dbforge->add_key('id', TRUE);								
				break;					
		}
		
		$this->dbforge->add_field($fields);
		$attributes = array('ENGINE' => 'InnoDB');
		
		if($this->dbforge->create_table($sel, FALSE, $attributes))
		{
			return "Table created";	
		}
		else
			echo 'There was a problem. Please try again later';
	}
	
	function create_db_structure($dbname) {

		$this->load->dbutil();

		if(!$this->dbutil->database_exists($dbname))
		{
			echo 'Database created<br>';
			// Initializing the database forge class 	
			$this->load->dbforge();				 
			
			if ($this->dbforge->create_database($dbname))
			{
				$rec = $this->db->query($this->config_db($dbname));
				
				if($rec)
				{		
					$this->add_db_table('user');
					$this->add_db_table('category');
					$this->add_db_table('category_items');
					$this->add_db_table('category_item_values');
					echo 'Database and table structure created!';
				}
				else
					echo 'There was a problem. Please try again later';
			}
			else
				echo 'There was a problem. Please try again later';
		}
		else
			echo "Database already exists";	
	}
	
	function drop_db($db) {
		
		$this->load->dbutil();

		if($this->dbutil->database_exists($db))
		{		
			 // Initializing the database forge class 	
			 $this->load->dbforge();				 
	
			if ($this->dbforge->drop_database($db))
			{
				echo 'Database deleted!';
			}	
			else
				echo 'There was a problem. Please try again later';
		}
		else
			echo "The said database does not exist";
		
	}
	
	private function config_db($dbname)
	{
		$config['default']['hostname'] = 'localhost';
		$config['default']['username'] = 'pshetty';
		$config['default']['password'] = 'dN2yebnrABWSZawR';
		$config['default']['database'] = $dbname;
		$config['default']['dbdriver'] = 'mysqli';
		$config['default']['dbprefix'] = 'budget_planner';
		$config['default']['pconnect'] = FALSE;
		$config['default']['db_debug'] = TRUE;
		$config['default']['cache_on'] = FALSE;
		$config['default']['cachedir'] = '';
		$config['default']['char_set'] = 'utf8';
		$config['default']['dbcollat'] = 'utf8_general_ci';				

		$this->load->database($config);
				
		return 'USE ' .$dbname;		
	}
		
} // End of class

?>