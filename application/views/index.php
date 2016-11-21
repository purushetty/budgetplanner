<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>The Shetty's Monthly Budget Planner</title>

    <!-- Bootstrap Core CSS -->
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="<?php echo base_url();?>assets/css/bootstrap-3.3.4.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets/css/2-col-portfolio.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div> 
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">The Monthly Budget Planner
                </h1>
            </div>
            <div class="col-lg-12">
            <div class="col-lg-2 form-group">
              <label for="select">Select Expense Month:</label>
              <select name="select" id="select" class="form-control">
              <option>January</option>
              <option>February</option>
              <option>March</option>
              <option>April</option>
              <option>May</option>
              <option>June</option>
              <option>July</option>
              <option>August</option>
              <option>September</option>
              <option>October</option>
              <option>November</option>
              <option>December</option>                            
              </select>
            </div>
            <div class="col-lg-2">
              <div class="form-group">
              <label for="textfield4">Enter Year:</label>
              <input type="text" name="textfield4" id="textfield4" class="form-control">
              </div>
            </div>
            <div class="col-lg-3">&nbsp;</div>
            <div class="col-lg-5">
            <form class="form-inline">
            <div class="form-group">
              <label for="textfield5">GRAND TOTAL:</label>
              <input type="text" name="textfield5" id="textfield5" class="form-control" disabled>
              <button type="button" class="btn btn-default">SUBMIT</button>
            </div>
            </form>
            </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- Projects Row -->
        <div class="row">
            <div class="col-md-4 portfolio-item">
                <h3>
                    <a href="#">Fixed Expenses</a>
                </h3>
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title">&nbsp;</h3>
                  </div>
                  
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="textfield">Text Field:</label>
                      <input type="text" name="textfield" id="textfield" class="form-control">
                    </div>

                    <div class="form-group">
                      <label for="textfield2">Text Field:</label>
                      <input type="text" name="textfield2" id="textfield2" class="form-control">
                    </div>
                    
                    <div class="form-group">
                      <label for="textfield3">Text Field:</label>
                      <input type="text" name="textfield3" id="textfield3" class="form-control">
                    </div>                   
                  </div>
                  <div class="panel-footer"><strong>Total:</strong></div>
                </div>
<p>&nbsp;</p>
                
          </div>
            <div class="col-md-4 portfolio-item">
                <h3>
                    <a href="#">Variable Expenses</a>
                </h3>
                <div class="panel panel-info">
                  <div class="panel-heading">
        			<h3 class="panel-title">&nbsp;</h3>
                  </div>
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="textfield">Text Field:</label>
                      <input type="text" name="textfield" id="textfield" class="form-control">
                    </div>
                    
                    <div class="form-group">
                      <label for="textfield2">Text Field:</label>
                      <input type="text" name="textfield2" id="textfield2" class="form-control">
                    </div>
                    
                    <div class="form-group">
                      <label for="textfield3">Text Field:</label>
                      <input type="text" name="textfield3" id="textfield3" class="form-control">
                    </div>                    
                  </div>
                 <div class="panel-footer"><strong>Total:</strong></div>
                </div>
<p>&nbsp;</p>
                
          </div>

          <div class="col-md-4 portfolio-item">
                <h3>
                    <a href="#">Travel Expenses</a>
                </h3>
            <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title">&nbsp;</h3>
                  </div>
              <div class="panel-body">
                <div class="form-group">
                      <label for="textfield">Text Field:</label>
                      <input type="text" name="textfield" id="textfield" class="form-control">
                    </div>
                    
                <div class="form-group">
                      <label for="textfield2">Text Field:</label>
                      <input type="text" name="textfield2" id="textfield2" class="form-control">
                    </div>
                    
                    <div class="form-group">
                      <label for="textfield3">Text Field:</label>
                      <input type="text" name="textfield3" id="textfield3" class="form-control">
                </div>           
                  </div>
               <div class="panel-footer"><strong>Total:</strong></div>   
              </div>
                
          </div>
        </div>          
        <!-- /.row -->

        <!-- Projects Row -->
        <div class="row">
          
            <div class="col-md-4 portfolio-item">
                <h3>
                    <a href="#">Family Vacation Expenses</a>
                </h3>
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title">&nbsp;</h3>
                  </div>
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="textfield">Text Field:</label>
                      <input type="text" name="textfield" id="textfield" class="form-control">
                    </div>
                    
                    <div class="form-group">
                      <label for="textfield2">Text Field:</label>
                      <input type="text" name="textfield2" id="textfield2" class="form-control">
                    </div>
                    
                    <div class="form-group">
                      <label for="textfield3">Text Field:</label>
                      <input type="text" name="textfield3" id="textfield3" class="form-control">
                    </div>                    
                  </div>
                  <div class="panel-footer"><strong>Total:</strong></div>                  
                </div>
<p>&nbsp;</p>
                
          </div>
          <div class="col-md-4 portfolio-item">
                <h3>
                    <a href="#">Baby's Expenses</a>
                </h3>
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title">&nbsp;</h3>
                  </div>
                  <div class="panel-body">
                    <div class="form-group">
                      <label for="textfield">Text Field:</label>
                      <input type="text" name="textfield" id="textfield" class="form-control">
                    </div>
                    
                    <div class="form-group">
                      <label for="textfield2">Text Field:</label>
                      <input type="text" name="textfield2" id="textfield2" class="form-control">
                    </div>
                    
                    <div class="form-group">
                      <label for="textfield3">Text Field:</label>
                      <input type="text" name="textfield3" id="textfield3" class="form-control">
                    </div>       
                  </div>
                  <div class="panel-footer"><strong>Total:</strong></div>                  
                </div>
<p>&nbsp;</p>
                
          </div>
          <div class="col-md-4 portfolio-item">
              <h3>
                  <a href="#">Misc Expenses</a>
                </h3>
              <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title">&nbsp;</h3>
                  </div>
                <div class="panel-body">
                  <div class="form-group">
                      <label for="textfield">Text Field:</label>
                      <input type="text" name="textfield" id="textfield" class="form-control">
                    </div>
                    
                  <div class="form-group">
                      <label for="textfield2">Text Field:</label>
                      <input type="text" name="textfield2" id="textfield2" class="form-control">
                    </div>
                    
                  <div class="form-group">
                      <label for="textfield3">Text Field:</label>
                      <input type="text" name="textfield3" id="textfield3" class="form-control">
                    </div>                  
                  </div>
                  <div class="panel-footer"><strong>Total:</strong></div> 
            </div>
<p>&nbsp;</p>
                
          </div>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
              <div class="col-lg-12">
                    <?php /*?><p>Copyright &copy; Your Website 2014</p><?php */?>
                </div>
            </div>
            <!-- /.row -->
        </footer>

</div>
    <!-- /.container -->

    <!-- jQuery -->
<script src="<?php echo base_url();?>js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
<!-- <script src="js/bootstrap.min.js"></script> -->
<script src="<?php echo base_url();?>js/bootstrap-3.3.4.js" type="text/javascript"></script>
</body>

</html>
