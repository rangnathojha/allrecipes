<?php include('../includes/config.php'); checkadminlogin();  ?>
<?php 
if (isset($_SESSION['usergroupid']) &&  $_SESSION['usergroupid']!=1)
{
	$sql = "SELECT * FROM `ss_adminuser_groups` WHERE user_group_id=".$_SESSION['usergroupid'];
	$rs = mysql_query($sql);
	$row = mysql_fetch_assoc($rs);
	$_SESSION['userroles']=explode(',',$row['permission']);	
	
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $admin_title; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo $baseurl; ?>master/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo $baseurl; ?>master/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo $baseurl; ?>master/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php echo $baseurl; ?>master/css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?php echo $baseurl; ?>master/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="<?php echo $baseurl; ?>master/css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo $baseurl; ?>master/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo $baseurl; ?>master/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="<?php echo $baseurl; ?>master/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Jquery UI style -->
        <link href="<?php echo $baseurl; ?>master/css/jquery-ui.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo $baseurl; ?>master/css/style.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo $baseurl; ?>master/dashboard.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <?php echo $_SESSION['GTadminuserName']; ?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar" role="navigation">
         
                <div class="navbar-right">
                    <ul class="nav navbar-nav">                        
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $_SESSION['GTadminuserName']; ?> <i class="caret"></i></span>
                            </a>
                            
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="img/avatar5.png" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $_SESSION['GTadminuserName']; ?> - <?php echo $_SESSION['GTUserGroupname']; ?>                                       
                                    </p>
                                </li>
                                <!-- Menu Body -->                                
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left" style="display:none;">
                                        <a href="<?php echo $baseurl; ?>master/edit-profile.php" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo $baseurl; ?>master/logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            
            
        </header>
        <div class="row">
                    <div class="col-md-12 gt-mainmenu">
                        <nav class="navbar navbar-default">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                              </button>      
                            </div>
                        
                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                              <ul class="nav navbar-nav navbar-center">        
                                       <li <?php if($gtpage=="dashboard") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/dashboard.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        
                        
                         <?php if (isset($_SESSION['usergroupid']) && in_array('services', $_SESSION['GtAdminuserroles'])) { ?> 
                         <li <?php if($gtpage=="services-list") { echo 'class="active"'; }?>>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
                                <i class="fa fa-list"></i> <span>Category</span>
                            </a>
                           
                     <ul class="dropdown-menu">                                                                   
                      <li <?php if($gtpage=="services-list") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/services-list.php">
                              <i class="fa fa-pagelines"></i>  <span>Manage Category</span>
                            </a>							
                        </li>                        
                        </ul>  
                         </li><?php
						  }
						  ?>
                          
                          
                           <?php if (isset($_SESSION['usergroupid']) && in_array('package', $_SESSION['GtAdminuserroles'])) { ?> 
                            <li <?php if($gtpage=="package-list") { echo 'class="active"'; }?>>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
                                	<i class="fa fa-list"></i> <span>Recipes</span>
                                </a>                                
                                <ul class="dropdown-menu">                                                                   
                                    <li <?php if($gtpage=="package-list") { echo 'class="active"'; }?>>
                                        <a href="<?php echo $baseurl; ?>master/package-list.php">
                                        	<i class="fa fa-pagelines"></i>  <span>Recipe List</span>
                                        </a>							
                                    </li>                        
                                </ul>  
                            </li>
						 <?php
						  }
						  ?>
                          
                           <?php if (isset($_SESSION['usergroupid']) && in_array('order', $_SESSION['GtAdminuserroles'])) { ?> 
                            <li <?php if($gtpage=="order-list") { echo 'class="active"'; }?>>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
                                	<i class="fa fa-list"></i> <span>Order</span>
                                </a>                                
                                <ul class="dropdown-menu">                                                                   
                                    <li <?php if($gtpage=="ca-order-list") { echo 'class="active"'; }?>>
                                        <a href="<?php echo $baseurl; ?>master/category-order-list.php">
                                        	<i class="fa fa-pagelines"></i>  <span>Order List</span>
                                        </a>							
                                    </li>                       
                                </ul>  
                            </li>
						 <?php
						  }
						  ?>
                          
                          <?php if (isset($_SESSION['usergroupid']) && in_array('reports', $_SESSION['GtAdminuserroles'])) { ?> 
                            <li <?php if($gtpage=="export-order" OR $gtpage=="export-frentor") { echo 'class="active"'; }?>>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
                                	<i class="fa fa-list"></i> <span>Reports</span>
                                </a>                                
                                <ul class="dropdown-menu">                                                                   
                                    <li <?php if($gtpage=="export-order") { echo 'class="active"'; }?>>
                                        <a href="<?php echo $baseurl; ?>master/export-orders.php">
                                        	<i class="fa fa-pagelines"></i>  <span>Export Orders</span>
                                        </a>							
                                    </li>
                                    <li <?php if($gtpage=="export-frentor") { echo 'class="active"'; }?>>
                                        <a href="<?php echo $baseurl; ?>master/export-frentor.php">
                                        	<i class="fa fa-pagelines"></i>  <span>Export Users</span>
                                        </a>							
                                    </li>                       
                                </ul>  
                            </li>
						 <?php
						  }
						  ?>
                          
                          
                         <?php if (isset($_SESSION['usergroupid']) && in_array('members', $_SESSION['GtAdminuserroles'])) { ?> 
                         <li <?php if($gtpage=="member-list" || $gtpage=="member-list-sp") { echo 'class="active"'; }?>>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
                                <i class="fa fa-list"></i> <span>Members</span>
                            </a>
                           
                       <ul class="dropdown-menu">                                                                   
                      	<li <?php if($gtpage=="member-list") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/member-list.php">
                              <i class="fa fa-pagelines"></i>  <span>Member List</span>
                            </a>							
                        </li> 
                                              
                       
                        </ul>  
                         </li>
						 <?php
						  }
						  ?>
                          
                          <?php if (isset($_SESSION['usergroupid']) && in_array('admin_users', $_SESSION['GtAdminuserroles'])) { ?> 
                         <li <?php if($gtpage=="admin-user-list") { echo 'class="active"'; }?>>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
                                <i class="fa fa-list"></i> <span>Admin Users</span>
                            </a>
                           
                       <ul class="dropdown-menu">                                                                   
                      	<li <?php if($gtpage=="admin-user-list") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/admin-user-list.php">
                              <i class="fa fa-pagelines"></i>  <span>Admin User List</span>
                            </a>							
                        </li> 
                        
                        </ul>  
                         </li>
						 <?php
						  }
						  ?>                          
                        
                         
                        
                        <li <?php if($gtpage=="change-password") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/change-password.php">
                              <i class="fa fa-sign-out"></i>   <span>Change Password</span>
                            </a>
                        </li>                                   
                        <li>
                            <a href="<?php echo $baseurl; ?>master/logout.php">
                                <i class="fa fa-sign-out"></i> <span>Sign out</span>
                            </a>
                        </li>       
                              </ul>
                            </div><!-- /.navbar-collapse -->
                        </nav>
                    </div>
                </div>