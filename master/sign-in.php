<?php include('../includes/config.php'); 
if(isset($_COOKIE["GTadminusername"]) && $_COOKIE["GTAdminPassword"]!="")
{
	$rwsusername=$_COOKIE["GTadminusername"];
	$rwspassword=$_COOKIE["GTAdminPassword"];
	$checked="checked";
}
	if(isset($_POST['gtsignin']))
	{
		$_SESSION['myForm'] = $_POST;
		if (empty($_POST["gtusername"])) {$errors[]='Username field can\'t be blank!';}
		if (empty($_POST["gtpassword"])) {$errors[]='Password field can\'t be blank!';}

		if(empty($errors)) {
		$gtusername=trim($_POST['gtusername']);
		$gtpassword=md5($_POST['gtpassword']);
		$sql="SELECT * FROM `ss_adminuser` WHERE `username`='$gtusername' and `password`='$gtpassword'";
		$query = $db->query($sql);
		$rowl = $query->row;
		$numrows=$query->num_rows;
		//print_r($rowl);
		if ($numrows > 0)
		{
			unset($_SESSION['myForm']);
			
			$_SESSION['GTadminuserID']=$rowl["user_id"];
			$_SESSION['GTadminuserName']=$rowl["firstname"].'&nbsp;'.$rowl["lastname"];
			$_SESSION['GTadminuserPackage']=$rowl["username"];
			$_SESSION['GTadminuserEmail']=$rowl["email"];
			$_SESSION['usergroupid']=$rowl["user_group_id"];
			$_SESSION['GTUserGroupname']=$rowl["user_group_name"];
			
			
			
			$sql2="SELECT permission FROM `ss_adminuser_groups` WHERE `user_group_id`='".$rowl["user_group_id"]."'";
			$query2 = $db->query($sql2);
			$row2 = $query2->row;
			
			$_SESSION['GtAdminuserroles']=explode(',', $row2["permission"]);
						
			$query_login = $db->query("UPDATE  `ss_adminuser` SET  `last_login` =  '$gtcurrenttime' WHERE `user_id` =".$_SESSION['GTadminuserID']);
			
			if(isset($_POST["remember_me"]))
			{
				// generate cooked of username and password
				setcookie("GTadminusername", $gtusername);
				setcookie("GTAdminPassword", $gtpassword);
			}
			else
			{
				setcookie("GTadminusername", "");
				setcookie("GTAdminPassword", "");
			}
			echo "<script>document.location.href='dashboard.php'</script>";
			//header("Location:dashboard.php");
		}
		else
		{
			$msg_login="Sorry! Username/Passowrd doesn't matches.";
		}
		}
	}	
?>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $admin_title; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo $baseurl; ?>master/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo $baseurl; ?>master/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo $baseurl; ?>master/css/style.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header">All Recipes - Admin Login</div>            
            <form action="" method="post" name="gtlogin" id="gtlogin">
                <div class="body bg-gray">
                	
                    <?php if(!empty($errors)) { ?>
                        <div class="alert alert-danger alert-dismissable">
                            <i class="fa fa-ban"></i>
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <b>WHOOPS! PLEASE REVIEW THE FOLLOWING ISSUES:</b>
                            <ul>
                            <?php 
                            foreach ($errors as $msg) 
                            { 
                                echo "<li>$msg</li>\n";
                            }
                            ?>
                            </ul>
                        </div>
                    <?php } ?>
                    
                    <?php if(!empty($msg_login)) { ?>
                    	<div class="alert alert-danger alert-dismissable">
                            <i class="fa fa-ban"></i>
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <b><?php echo $msg_login; ?></b>                            
                        </div>
                    <?php } ?>
               
                    <div class="form-group">
                        <input type="text" name="gtusername" id="gtusername" class="form-control" placeholder="Username" value="<?php (isset( $_SESSION['myForm']['gtusername'])? ( $_SESSION['myForm']['gtusername']):'');?>"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="gtpassword" id="gtpassword" class="form-control" placeholder="Password"/>
                    </div>          
                    <div class="form-group">
                    <input type="hidden" name="remember_me" id="remember_me" class="form-control" placeholder="Username" value="<?php (isset( $_SESSION['myForm']['gtusername'])? ( $_SESSION['myForm']['gtusername']):'');?>"/>
                   
                  </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block" name="gtsignin"  id="gtsignin">Sign me in</button> 
                </div>
            </form>            
        </div>
        <!-- jQuery 2.0.2 -->
        <script src="<?php echo $baseurl; ?>master/js/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo $baseurl; ?>master/js/bootstrap.min.js" type="text/javascript"></script>        
    </body>
</html>