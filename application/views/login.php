<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url() ?>assets/css/admin/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url() ?>assets/css/admin/sb-admin-2.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/custom.css" rel="stylesheet">    

    <!-- Custom Fonts -->
    <link href="<?php echo base_url() ?>assets/css/admin/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row spacer100">
            <div class="col-md-5 col-md-offset-4">
                <div class="login-panel panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                    <?php echo isset($error_message)? '<p>'.$error_message.'</p>':'' ?></p>
                        <form role="form" method="post" id="login" action="<?php echo base_url() ?>login/verify" name="login">
                            <fieldset>
                                <div class="form-group">
                                <?php echo form_error('username'); ?>
                                    <input class="form-control" placeholder="username" name="username" id="username" type="username" value="<?php echo set_value('username') ?>" autofocus>
                                </div>
                                <div class="form-group">
                                <?php echo form_error('password'); ?>
                                    <input class="form-control" placeholder="Password" name="password" id="password" type="password" value="<?php echo set_value('password') ?>">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using th is as a form -->
                                <button class="btn btn-lg btn-success btn-block" type="submit" id="lbtn">Login</button>
                                <input type="hidden" name="ulogin" id="ulogin" value="ulogin">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="loader">
                <div class="modal-dialog">
                    <div class="modal-content" id="mod-upload">
                    <img src="<?php echo base_url()?>assets/images/loading_30x30.gif" width="30" height="30" alt="Loading gif" title="Loader">
                    </div>
                    
                </div>
            </div>

    <!-- jQuery -->
    <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
    
	<script src="<?php echo base_url();?>assets/js/bootbox.min.js" type="text/javascript"></script>    

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url() ?>assets/js/admin/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url() ?>assets/js/admin/sb-admin-2.js"></script>

</body>

</html>
