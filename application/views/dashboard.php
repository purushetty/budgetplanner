<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Monthly Budget Planner - Admin Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>assets/css/bootstrap-3.3.4.css" rel="stylesheet" type="text/css">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url() ?>assets/css/admin/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url() ?>assets/css/admin/sb-admin-2.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/custom.css" rel="stylesheet">    
    
    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url() ?>assets/css/admin/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url() ?>assets/css/admin/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
    
    <!-- Bootbox Plugin Javascript -->
 	<script src="<?php echo base_url();?>assets/js/bootbox.min.js" type="text/javascript"></script>       

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
 
    <div id="wrapper">
     
    <?php 
	if(!empty($this->session->flashdata('success_message'))) { ?> 
	<script type="text/javascript">
	$(document).ready(function() {
			bootbox.alert({ message: "New user created successfully", backdrop: true });
	});
    </script>
    <?php }	elseif(!empty($this->session->flashdata('edit_success_message'))) { ?> 
	<script type="text/javascript">
	$(document).ready(function() {
			bootbox.alert({ message: "User info changes recorded successfully", backdrop: true });
	});
    </script>    
	<?php } elseif(!empty($this->session->flashdata('error_message'))) { ?>
	<script type="text/javascript">   
	$(document).ready(function() {	 
			bootbox.alert({ message: "There are errors in the form. Please fix them!", backdrop: true });
	});
    </script>
	<?php } elseif(!empty($this->session->flashdata('user_exist_message'))) { ?>
	<script type="text/javascript">   
	$(document).ready(function() {	 
			bootbox.alert({ message: "This user already exist!", backdrop: true });
	});
    </script>
    <?php } elseif(!empty($this->session->flashdata('no_change_message'))) { ?> 
	<script type="text/javascript">   
	$(document).ready(function() {	 
			bootbox.alert({ message: "No new information detected. Database record remains unchanged.", backdrop: true });
	});
	</script>
    <?php } ?>          
            
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Monthly Budget Planner</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url()?>login/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-4x"></i>
                                </div>                            
                                <div class="col-xs-9 text-right">
                                    <h3>Add / Delete Users</h3>
                                </div>
                            </div>
                        </div>
                        <a href="#" id="add-user">
                            <div class="panel-footer">
                                <span class="pull-left">Click Here</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-edit fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h3>Add / Edit Categories</h3>
                                </div>
                            </div>
                        </div>
                        <a href="#" id="edit-cat">
                            <div class="panel-footer">
                                <span class="pull-left">Click Here</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list-ul fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h3>Add / Edit Items</h3>
                                </div>
                            </div>
                        </div>
                        <a href="#" id="add-cat-item">
                            <div class="panel-footer">
                                <span class="pull-left">Click Here</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-excel-o fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h3>Expense Statement</h3>
                                </div>
                            </div>
                        </div>
                        <a href="#" id="exp-st">
                            <div class="panel-footer">
                                <span class="pull-left">Click Here</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
           	<div class="col-lg-9">                                                
                
                <div id="add-usr-blk">
				<div class="row col-lg-12 spacer40">
                <div class="col-lg-8 col-lg-offset-4">                
				<button class="btn btn-primary btn-lg" id="add-usr-btn">Add A New User</button>                
				<button class="btn btn-primary btn-lg" id="ed-usr-btn">Edit Existing User</button>                                
                </div>    			
                </div>
                            
                <div class="row">
                <div class="col-lg-10 col-lg-offset-1" id="new-usr-blk">                                
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Add New User 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <div class="row">
                        <div class="col-md-6 col-md-offset-2">
                        <?php echo isset($success_message)? $success_message:'' ?>
                        <?php echo isset($error_message)? $error_message:'' ?>
                        </div>
                        </div>
                        <form name="addnusr" id="addnusr" method="post" action="<?php echo base_url()?>login/newuser">
                        
                            <div class="row form-group">
                            	<div class="col-sm-2">
                                <label for="fname">First Name</label>
                                </div>
                                <div class="col-sm-5">
                                	<input class="form-control" type="text" placeholder="" name="fname" id="fname" value="<?php echo set_value('fname') ?>">
                                 </div>
                                 <div class="col-sm-5">
                                    <span id="fname-error"><?php echo form_error('fname'); ?></span>
                                 </div>                                
                            </div>        

                            <div class="row form-group">
                            <div class="col-sm-2">
                            	<label for="lname">Last Name</label>
                             </div>   
                                <div class="col-sm-5">
                                	<input class="form-control" type="text" placeholder="" name="lname" id="lname" value="<?php echo set_value('lname') ?>">
                                </div>
                                <div class="col-sm-5">    
                                	<span id="lname-error"><?php echo form_error('lname'); ?></span>
                                </div>    
                            </div>
                            
                            <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="eml">Email Address</label>
                            </div>    
                                <div class="col-sm-5">
                                	<input class="form-control" type="text" placeholder="" name="eml" id="eml" value="<?php echo set_value('eml') ?>">
                                </div>
                                <div class="col-sm-5">
                                <span id="eml-load"></span>    
                                	<span id="eml-error"><?php echo form_error('eml'); ?></span>
                                </div>    
                            </div>    

                            <div class="row form-group">
                            <div class="col-sm-2">
                            	<label for="uname">Username</label>&nbsp;
                                <a href="#" tabindex="0" data-toggle="popover" data-trigger="focus" data-container="body" data-placement="right" data-content="Should be minimum 6 characters long"><i class="fa fa-info-circle fa-lg text-left"></i></a>
                             </div>   
                                <div class="col-sm-5">
                                	<input class="form-control" type="text" placeholder="" name="uname" id="uname" value="<?php echo set_value('uname') ?>">
                                 </div>
                                 <div class="col-sm-5">   
                                    <span id="unl"><?php /*<img src="<?php echo base_url()?>assets/images/loading_30x30.gif" alt="loader"> */?></span>
                                	<span id="uname-error"><?php echo form_error('uname'); ?></span>
                                 </div>   
                            </div>
                            
                            <div class="row form-group">
                            <div class="col-sm-2">
                            	<label for="pass">Password</label>&nbsp;
                                <a href="#" tabindex="0" data-toggle="popover" data-trigger="focus" data-container="body" data-placement="right" 
                                data-content="Minimum 8 characters long
                                Atleast one digit
                                Atleast one uppercase character
                                Atleast one lowercase character
                                "@", "#" and "_" special characters allowed"><i class="fa fa-info-circle fa-lg text-left"></i></a>
                            </div>    
                                <div class="col-sm-5">
                                	<input type="password" class="form-control" placeholder="" name="pass" id="pass" value="<?php echo set_value('pass') ?>">                             
                                </div>
                                <div class="col-sm-5">    
                                	<span id="pass-error"><?php echo form_error('pass'); ?></span>
                            	</div>
							</div>
                            
                            <div class="row form-group">
                            	<label for="cpass" class="col-sm-2">Confirm Password</label>
                                <div class="col-sm-5">
                                	<input type="password" class="form-control" placeholder="" name="cpass" id="cpass" value="<?php echo set_value('cpass') ?>">
                                </div>
                                <div class="col-sm-5">    
                                	<span id="cpass-error"><?php echo form_error('cpass'); ?></span>
                                </div>    
                            </div>
                            
                            <div class="row form-group">
                            <div class="col-sm-5 col-sm-offset-2">
                            	<button class="btn btn-primary btn-med" id="add-new-usr-btn" >Add New User</button>&nbsp;
                                <button class="btn btn-med btn-danger" type="button" id="add-new-rst-btn">Reset Fields</button>
                                <input type="hidden" name="nusr" id="nusr" value="nusr">
                                <input type="hidden" name="fname-status" id="fname-status" value="">                                                                
                                <input type="hidden" name="lname-status" id="lname-status" value="">                                                                
                                <input type="hidden" name="eml-status" id="eml-status" value="">                                                                
                                <input type="hidden" name="uname-status" id="uname-status" value="">                                                                
                                <input type="hidden" name="pass-status" id="pass-status" value="">                                                                                                
                                <input type="hidden" name="cpass-status" id="cpass-status" value="">                                                                                                                                
                            </div>    
                            </div>
						</form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    
                </div>
                <!-- /.col-lg-8 -->

				<div class="col-lg-12" id="ed-usr-blk">                
                	<div class="row form-group spacer40">                      
                    <div class="col-lg-9 col-lg-offset-2">
		                 <div class="panel panel-default">
        		         	<div class="panel-heading">
                		    	<i class="fa fa-edit"></i>&nbsp;Edit User
                    		</div>
        	                <!-- /.panel-heading -->
                        <form name="sel-usr" id="sel-usr" method="post" action="<?php echo base_url()?>login/selectuser">                         
   		                    <div class="panel-body">                
							<?php echo isset($select_error_message)? $select_error_message:'' ?>                            
                         		<div class="col-sm-6 pull-left">
                                    <select class="form-control" id="ed-get-usr" name="ed-get-usr">
                                    <option value="">Select</option>
                                      <?php foreach($user as $key=>$val) { ?>
                                    <option value="<?php echo $key ?>"><?php echo $val ?></option>
                                      <?php } ?>                                    
                                    </select>
                                </div>
	                           	<div class="col-sm-1">    
    	                           <button class="btn btn-primary btn-med pull-left" id="ed-sel-usr">EDIT</button>
        	                    </div>
                            	<div class="col-sm-3">                        
		                        	<button class="btn btn-primary btn-med pull-right" id="ed-ch-pwd-usr">CHANGE PASSWORD</button>
                                </div>
                                 <div class="col-sm-1">    
 	                                <button class="btn btn-primary btn-med pull-left" id="ed-del-usr">DELETE</button>
                                 </div>                                                                
                            </div>
                         </form>   
                          </div>       
                   		</div>                                   
                   </div>

                    <div class="row" id="ed-blk">
                    <div class="col-lg-9 col-lg-offset-2" id="edusr-blk">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Edit User 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <?php echo isset($edit_success_message)? $edit_success_message:'' ?>
                        <?php echo isset($edit_error_message)? $edit_error_message:'' ?>
                        
                        <form name="edusr" id="edusr" method="post" action="<?php echo base_url()?>login/edituser">                         
                            <div class="row form-group">
                            	<div class="col-sm-2">
                                <label for="e-fname">First Name</label>
                                </div>
                                <div class="col-sm-4">
                                	<input class="form-control" type="text" placeholder="" name="e-fname" id="e-fname">
                                </div>
                                <div class="col-sm-6">    
                                    <span id="e-fname-error"></span><?php echo form_error('e-fname'); ?>
                                </div>    
                            </div>        

                            <div class="row form-group">
                            <div class="col-sm-2">
                            	<label for="e-lname">Last Name</label>
                             </div>   
                                <div class="col-sm-4">
                                	<input class="form-control" type="text" placeholder="" name="e-lname" id="e-lname">
                                </div>
                                <div class="col-sm-6">    
                                	<span id="e-lname-error"></span><?php echo form_error('e-lname'); ?>
                                </div>    
                            </div>
                            
                            <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="e-eml">Email Address</label>
                            </div>    
                                <div class="col-sm-4">
                                	<input class="form-control" type="text" placeholder="" name="e-eml" id="e-eml">
                                </div>
                                <div class="col-sm-6">
                                <span id="eml-load"></span>    
                                	<span id="e-eml-error"></span><?php echo form_error('e-eml'); ?>
                                </div>    
                            </div>
                            
                            <div class="row form-group">
                            <div class="col-sm-5 col-sm-offset-2">                            
                            	<button class="btn btn-med btn-primary" id="ed-usr-info-btn">Edit User</button>&nbsp;
                                <button class="btn btn-med btn-danger" type="button" id="ed-usr-rst-btn">Reset Fields</button>
                                <input type="hidden" name="eusr" id="eusr" value="eusr">
                                <input type="hidden" name="ed-usr-id" id="ed-usr-id">
                                <input type="hidden" name="e-fname-status" id="e-fname-status" value="">                                                                
                                <input type="hidden" name="e-lname-status" id="e-lname-status" value="">                                                                
                                <input type="hidden" name="e-eml-status" id="e-eml-status" value="">                                                                
                            </div>
                            </div>
						</form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    </div>
                    <!-- /.panel -->
                    <div class="col-lg-9 col-lg-offset-2" id="chpwd-blk">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Change Password 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        
                        <form name="edchpwd" id="edchpwd" method="post" action="<?php echo base_url()?>login/changepass">                         
                            <div class="row form-group">
                            	<div class="col-sm-3">
                                <label for="e-fname">Old Password</label>
                                </div>
                                <div class="col-sm-5">
                                	<input class="form-control" type="password" placeholder="" name="e-opwd" id="e-opwd" value="<?php echo set_value('e-opwd') ?>">
                                </div>
                                <div class="col-sm-4">    
                                    <span id="e-opwd-error"></span><?php echo form_error('e-opwd'); ?>
                                </div>    
                            </div>        

                            <div class="row form-group">
                            <div class="col-sm-3">
                            	<label for="e-lname">New Password</label>
                             </div>   
                                <div class="col-sm-5">
                                	<input class="form-control" type="password" placeholder="" name="e-npwd" id="e-npwd" value="<?php echo set_value('e-npwd') ?>">
                                </div>
                                <div class="col-sm-4">    
                                	<span id="e-npwd-error"></span><?php echo form_error('e-npwd'); ?>
                                </div>    
                            </div>
                            
                            <div class="row form-group">
                            <div class="col-sm-3">
                                <label for="e-eml">Confirm New Password</label>
                            </div>    
                                <div class="col-sm-5">
                                	<input class="form-control" type="password" placeholder="" name="e-cpwd" id="e-cpwd" value="<?php echo set_value('e-cpwd') ?>">
                                </div>
                                <div class="col-sm-4">
                                <span id="eml-load"></span>    
                                	<span id="e-cpwd-error"></span><?php echo form_error('e-cpwd'); ?>
                                </div>    
                            </div>
                            
                            <div class="row form-group">
                            <div class="col-sm-5 col-sm-offset-3">                            
                            	<button class="btn btn-med btn-primary" id="ed-usr-chpwd-btn">Submit</button>&nbsp;
                                <button class="btn btn-med btn-danger" type="button" id="ed-chpwd-rst-btn">Reset Fields</button>
                                <input type="hidden" name="epwd" id="epwd" value="epwd">
                                <input type="hidden" name="usr-pw-id" id="usr-pw-id">
                                <input type="hidden" name="e-opwd-status" id="e-opwd-status">                                                                
                                <input type="hidden" name="e-npwd-status" id="e-npwd-status">                                                                
                                <input type="hidden" name="e-cpwd-status" id="e-cpwd-status">                                                                                                                                
                            </div>    
                            </div>
						</form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    </div>
                    </div>
                    <!-- /.row -->
                </div>               
				
                    <!-- /.panel -->
                    </div>
                <!-- /.col-lg-4 -->
                </div>
                
                <div class="col-lg-12" id="ed-cat-blk">
                
                <div class="row">					
				<div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Add New Category
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <form action="" method="post" name="category-add" id="category-add">
                        
						<div class="col-lg-8 form-group pull-left">
                         	<input type="text" class="form-control" placeholder="Enter new category" name="a-c-name" id="a-c-name" value="<?php echo set_value('a-c-name'); ?>">
                        </div>    
                        <div class="col-lg-4 form-group pull-left">                            
                            <button class="btn btn-success btn-med" id="add-cat-btn">ADD</button>                                            
                            <button class="btn btn-success btn-med" id="add-cat-rst-btn">RESET</button>
                            <input type="hidden" name="add-cat-hd" id="add-cat-hd" value="add-cat-hd">                                            
                            <input type="hidden" name="a-c-name-status" id="a-c-name-status">
                        </div>   
                        <div class="col-sm-12">    
                             <?php echo form_error('a-c-name'); ?>
                        </div>                            
                        </form>                 
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>                
					<div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Edit Category 
                        </div>
                        <!-- /.
                        panel-heading -->
                        <div class="panel-body">
                        <form action="" method="post" name="category-edit" id="category-edit">
						<div class="col-sm-8 form-group">                        
                         	<select class="form-control" id="ed-sel-cat" name="ed-sel-cat">
                            	<option value="">Select</option>
                                <?php foreach($category as $key => $val) { ?>
                                <option value="<?php echo $key ?>"><?php echo $val ?></option>
                                <?php } ?>
                            </select>
                       </div>
                       <div class="col-sm-2 form-group">     
                            <button class="btn btn-success btn-med pull-right" id="edcat-blk-btn">Edit</button>                                            
                       </div>       
                       <div class="col-sm-2">     
                            <button class="btn btn-success btn-med pull-left" id="edcat-del-btn">Delete</button>                                            
                       </div>       
                       </form>                 
                       </div>   
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    </div>                                    
                	                                        
                </div>
                
                <div class="row">
					<div class="col-lg-9 col-lg-offset-2" id="edcat-blk-win">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Edit Category 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <?php echo isset($edit_success_message)? $edit_success_message:'' ?>
                        <?php echo isset($edit_error_message)? $edit_error_message:'' ?>
                        
                        <form name="edcat" id="edcat" method="post" action="<?php echo base_url()?>login/editcat">                         
                            <div class="row form-group">
                            	<div class="col-sm-2">
                                <label for="e-fname">Category Name</label>
                                </div>
                                <div class="col-sm-4">
                                	<input class="form-control" type="text" placeholder="" name="e-category" id="e-category">
                                </div>
                                <div class="col-sm-6">    
                                    <span id="e-category-error"></span><?php echo form_error('e-category'); ?>
                                </div>    
                            </div>                              
                            
                            <div class="row form-group">
                            <div class="col-sm-5 col-sm-offset-2">                            
                            	<button class="btn btn-med btn-primary" id="ed-cat-btn">Edit</button>&nbsp;
                                <button class="btn btn-med btn-danger" type="button" id="ed-cat-rst-btn">Reset</button>
                                <input type="hidden" name="ecat" id="ecat" value="ecat">
                                <input type="hidden" name="ed-cat-usr-id" id="ed-cat-usr-id" value="<?php echo $this->session->userdata('user_id');?>">
                                <input type="hidden" name="e-category-status" id="e-category-status" value="">                                                                
                            </div>
                            </div>
						</form>
                        </div>

                        <!-- /.panel-body -->
                    </div>
                    </div>                
                </div>
                
                </div>                
                
                <div class="col-lg-12" id="add-cat-item-blk">
                
                <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Add New Category Item
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <form action="" method="post" name="category-edit" id="category-edit">
						<div class="col-lg-10 form-group pull-left">
                        <div class="col-lg-6">
                         	<input type="text" class="form-control" placeholder="Enter item value" name="a-c-item" id="a-c-item" value="<?php echo set_value('a-c-item'); ?>">
                        </div>
                        <div class="col-lg-6">    
                            <select class="form-control">
                            	<option value="">Select</option>
                                <?php foreach($category as $val) { ?>
                                <option value="<?php echo $val ?>"><?php echo $val ?></option>
                                <?php } ?>                            
                            </select>
                        </div>    
                        </div>    
                        <div class="col-lg-2 form-group">                            
                            <button class="btn btn-warning btn-med">ADD</button>                                            
                        </div>       
                        </form>                 
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>Edit / Delete Category Item
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<div class="col-sm-8 form-group">                        
                         	<select class="form-control">
                            	<option>Select</option>
                                <?php foreach($category as $val) { ?>
                                <option value="<?php echo $val ?>"><?php echo $val ?></option>
                                <?php } ?>
                            </select>
                       </div>
                       <div class="col-sm-4">     
	                       <button class="btn btn-warning btn-med">EDIT</button>&nbsp;                                            
                            <button class="btn btn-warning btn-med">DELETE</button>                                            
                        </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>    
                </div>
                </div>
                </div>
                
				<div class="col-lg-3" id="sum-blk">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Expense Summary for the month of <?php ; ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-comment fa-fw"></i> Fixed Expense
                                    <span class="pull-right text-muted small"><em>10000</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-twitter fa-fw"></i> Variable Expense
                                    <span class="pull-right text-muted small"><em>5000</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-envelope fa-fw"></i> Travel Expense
                                    <span class="pull-right text-muted small"><em>6000</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-tasks fa-fw"></i> Family Vacation Expenses
                                    <span class="pull-right text-muted small"><em>7000</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-upload fa-fw"></i> Baby's Expenses
                                    <span class="pull-right text-muted small"><em>8000</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> Misc Expenses
                                    <span class="pull-right text-muted small"><em>7000</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> <strong>Grand Total</strong>
                                    <span class="pull-right text-muted small"><em></em>
                                    </span>
                                </a>
                            </div>
                            <!-- /.list-group -->
                            <a href="#" class="btn btn-default btn-block">View All Alerts</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    
                </div>                
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

		<div class="modal fade" id="password-info">
        	<div class="modal-dialog">
            	<div class="modal-content">
                    <ul type="square">
                    <li>Should be atleast 8 characters long</li>
                    <li>Should contain atleast one digit</li>
                    <li>Should contain atleast one uppercase character</li>
                    <li>Should contain atleast one lowercase character</li>
                    <li>Only "@", "#" and "_" special characters allowed</li>
                    </ul>
                </div>                    
            </div>
        </div>

		<div class="modal fade" id="add-usr-success">
        	<div class="modal-dialog">
            	<div class="modal-content">
                	<h3>User has been successfully created</h3>
		        </div>                    
            </div>
        </div>

    </div>
    <!-- /#wrapper -->
 
	<!-- jQuery UI CDN -->
	<script src="<?php echo base_url() ?>assets/js/jquery-ui-1.12.1/jquery-ui.min.js"></script>    
<!-- <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script> -->
    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url() ?>assets/js/admin/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url() ?>assets/js/admin/sb-admin-2.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url() ?>assets/js/admin/raphael/raphael.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/admin/morrisjs/morris.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/admin/data/morris-data.js"></script>

</body>

</html>
