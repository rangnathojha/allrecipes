<?php include('header.php'); $gtpage = 'newsletter-dummy'; $rwseditor=1; $gtdateopt = "on";
$_SESSION['myForm']=array();


if($_GET["college_id"]>0)
{
	// Empty Code Starts 
	$query_empty = "TRUNCATE TABLE `newsletter_dumpitems`";										
	$result_empty = $db->query($query_empty);	
	// Empty Code Starts
	
	$college_id = $_GET["college_id"];
	$start_date = $_GET["start_date"].' 00:00:00';
	$end_date = $_GET["end_date"].' 00:00:00';
	
	$query = "SELECT t1.*, IFNULL(t2.total_likes,0) as total_likes, IFNULL(t3.total_comments,0) as total_comments, (t2.total_likes+(t3.total_comments*5)) as grandtotal, u.firstname, u.lastname, u.email, u.profile_pic, u.start_year, c.shortname, b.branch_short_name, g.name as groupname FROM wall as t1 LEFT JOIN (SELECT wall_id, COUNT(*) AS total_likes FROM wall_post_like GROUP BY wall_id ) AS t2 ON t1.wall_id = t2.wall_id LEFT JOIN (SELECT wall_id, COUNT(*) AS total_comments FROM wall_post_comments GROUP BY wall_id ) AS t3 ON t1.wall_id = t3.wall_id LEFT JOIN users as u ON u.id = t1.user_id LEFT JOIN college_name AS c ON c.id = u.college LEFT JOIN branch AS b ON b.id = u.branch LEFT JOIN groups AS g ON g.id = t1.group_id WHERE t1.id > 0 AND t1.college_id = '$college_id' AND t1.created_date BETWEEN '$start_date' AND '$end_date' ORDER BY grandtotal DESC LIMIT 0, 50 ";
	
	$result = $db->query($query);	
	$rowlist = $result->rows;
	$orderid = 1;
	foreach($rowlist as $key => $row) 
	{										
	// Insert INTO Dump Data
	if($row["grouptable"]==0)
	{
		$groupcatid = togetfieldvalue('group_catid', 'groups', 'id='.$row['group_id']); 
		$groupcategory = togetfieldvalue('name', 'group_categories', 'id='.$groupcatid);
		$groupname = $row["groupname"];
		
	}
	else
	{
		$groupcategory = "Dummy Group";
		$groupname = togetfieldvalue('name', 'groups_dummy', 'id='.$row['group_id']);
	}
	
	$query_insert = "INSERT INTO `newsletter_dumpitems` (`id`, `wall_id`, `datatype`, `user_id`, `college_id`, `course_id`, `branch_id`, `group_id`, `group_type`, `created_date`, `reach_alumni_advice_new`, `heading`, `grouptable`, `total_likes`, `total_comments`, `grandtotal`, `firstname`, `lastname`, `email`, `profilepic`, `start_year`, `shortname`, `branch_short_name`, `groupname`, `groupcategory`, `orderid`, `status`, `add_date`) VALUES (NULL, '".$row["wall_id"]."', '".$row["datatype"]."', '".$row["user_id"]."', '".$row["college_id"]."', '".$row["course_id"]."', '".$row["branch_id"]."', '".$row["group_id"]."', '".$row["group_type"]."', '".$row["created_date"]."', '".$row["reach_alumni_advice_new"]."', '".$row["heading"]."', '".$row["grouptable"]."', '".$row["total_likes"]."', '".$row["total_comments"]."', '".$row["grandtotal"]."', '".$row["firstname"]."', '".$row["lastname"]."', '".$row["email"]."', '".$row["profilepic"]."', '".$row["start_year"]."', '".$row["shortname"]."', '".$row["branch_short_name"]."', '".$groupname."', '".$groupcategory."', '".$orderid."', '1', '$gtcurrenttime')";
	$result_insert = $db->query($query_insert);	
	
	$orderid++;
	
	}
	echo "<script>document.location.href='newsletter-dummy.php';</script>";
	exit;
}

// send mail code 

if($_GET["email_id_1"]!="")
{
	$email_id_1 = $_GET["email_id_1"];
	$email_id_2 = $_GET["email_id_2"];
	$email_id_3 = $_GET["email_id_4"];
	$limit_items = $_GET["limit_items"];
	
	$query = "SELECT * FROM newsletter_dumpitems WHERE id > 0 ORDER BY orderid ASC LIMIT 0, $limit_items";	
	$result = $db->query($query);
	$totalrows = $result->num_rows;
	$rowlist = $result->rows;
	
	foreach($rowlist as $key => $row) 
	{
		if($row["datatype"]==1) { $datatype = "Text Image"; }
		elseif($row["datatype"]==2) { $datatype = "Notifications"; }
		elseif($row["datatype"]==3) { $datatype = "Video"; }
		elseif($row["datatype"]==4) { $datatype = "File"; }
		 elseif($row["datatype"]==5) { $datatype = "Event"; }							
		 elseif($row["datatype"]==6) { $datatype = "Poll";	 }											
		 elseif($row["datatype"]==7) { $datatype = "IIT Projects"; }											
		 elseif($row["datatype"]==8) { $datatype = "Foreign Projects"; }											
		 elseif($row["datatype"]==9) { $datatype = "Interview Questions"; }											
		 elseif($row["datatype"]==10) { $datatype = "Link"; }											
		 elseif($row["datatype"]==11) { $datatype = 'Bazaar'; }											
		 elseif($row["datatype"]==12) { $datatype = 'Internship'; } 
		 if($row["firstname"]!="") { $showname		=	$row["firstname"].' '.$row["lastname"];	 } 
		 else { if($row["email"]!="") { $showname		=	$row["email"]; } else {  $showname = 'CollegeDots'; } }
		 
		 
		
		$newslettercontent .='<p style="text-align:left; padding:0 20px;">'.$showname.' posted a <a href="'.$baseurl.'post-details.php?pid='.$row["wall_id"].'&ptype='.$row["datatype"].'" target="_blank">'.$datatype.'</a> in '.$row["groupname"].' on '.toshowdatewithtimewall($row["created_date"]).'</p>';
	}
	
	$body = $emailheader.'
  <tr>
    <td style="padding:20px;margin:0;line-height:1px;font-size:1px;font-family:\'Helvetica Neue Light\',Helvetica,Arial,sans-serif;color:#66757f;font-size:14px;font-weight:300;line-height:23px;text-align:left;">
	<div style="text-align:left;  padding:20px 20px 0 20px;"">Dear '.$email_id_1.'<br/><br/></div>
   '.$newslettercontent.'   
</td>
  </tr>
  '.$emailfooter;
  
  $subject = 'CollegeDots - Weekly Updates';
	
	sendmail($email_id_1,$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename);
	
	if(trim($email_id_2)!="") { sendmail($email_id_2,$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename); }
	if(trim($email_id_3)!="") { sendmail($email_id_3,$subject,$admin_fromemail,$admin_fromname,$body,$path,$resumefilename); }
	
	$_SESSION["GTMessageAdmin"] = '<div id="gt-formsuccess">Test Email has been sent successfully to given email id\'s.</div>';
	
	echo "<script>document.location.href='newsletter-dummy.php';</script>";
	exit;
}

if($_GET["schedule"]==1)
{
	$send_date = $_GET["send_date"];
	$subject = addslashes($_GET["subject"]);
	$limit_items = $_GET["limit_items"];	
	
	$query = "SELECT * FROM newsletter_dumpitems WHERE id > 0 ORDER BY orderid ASC LIMIT 0, $limit_items";	
	$result = $db->query($query);
	$totalrows = $result->num_rows;
	$rowlist = $result->rows;
	
	foreach($rowlist as $key => $row) 
	{
		if($row["datatype"]==1) { $datatype = "Text Image"; }
		elseif($row["datatype"]==2) { $datatype = "Notifications"; }
		elseif($row["datatype"]==3) { $datatype = "Video"; }
		elseif($row["datatype"]==4) { $datatype = "File"; }
		elseif($row["datatype"]==5) { $datatype = "Event"; }							
		elseif($row["datatype"]==6) { $datatype = "Poll";	 }											
		elseif($row["datatype"]==7) { $datatype = "IIT Projects"; }											
		elseif($row["datatype"]==8) { $datatype = "Foreign Projects"; }											
		elseif($row["datatype"]==9) { $datatype = "Interview Questions"; }											
		elseif($row["datatype"]==10) { $datatype = "Link"; }											
		elseif($row["datatype"]==11) { $datatype = 'Bazaar'; }											
		elseif($row["datatype"]==12) { $datatype = 'Internship'; } 
		if($row["firstname"]!="") { $showname		=	$row["firstname"].' '.$row["lastname"];	 } 
		else { if($row["email"]!="") { $showname		=	$row["email"]; } else {  $showname = 'CollegeDots'; } }
		 
		 
		
		$newslettercontent .='<p style="text-align:left; padding:0 20px;">'.$showname.' posted a <a href="'.$baseurl.'post-details.php?pid='.$row["wall_id"].'&ptype='.$row["datatype"].'" target="_blank">'.$datatype.'</a> in '.$row["groupname"].' on '.toshowdatewithtimewall($row["created_date"]).'</p>';
		
		$college_id = $row["college_id"];
		$college_name = $row["shortname"];
	}
	
	$body = $emailheader.'<tr><td style="padding:20px;margin:0;line-height:1px;font-size:1px;font-family:\'Helvetica Neue Light\',Helvetica,Arial,sans-serif;color:#66757f;font-size:14px;font-weight:300;line-height:23px;text-align:left;">
	<div style="text-align:left;  padding:20px 20px 0 20px;"">Dear CollegeDot Member,<br/><br/></div>
   '.$newslettercontent.'</td></tr>'.$emailfooter;
  
  	// Schedule Email to Newsletter Table 
 	$update_query = "INSERT INTO `newsletter` (`id`, `subject`, `message`, `college_id`, `college_name`, `status`, `start_date`, `add_date`) VALUES (NULL, '$subject', '".addslashes($body)."', '$college_id', '$college_name', '1', '$send_date', '$gtcurrenttime')";
	$update_result = $db->query($update_query);
	
	$newsletter_id = $db->getLastId();
	
	// Insert Users 
	
	$query2 = "SELECT firstname, lastname, email FROM users WHERE college = '$college_id' AND status = '1' ";	
	$result2 = $db->query($query2);
	$rowlist2 = $result2->rows;
	
	foreach($rowlist2 as $key => $row) 
	{
		$name = $row["firstname"].' '.$row["lastname"];
		$email = $row["email"];
		
		$update_query = "INSERT INTO `newsletter_users` (`id`, `name`, `email`, `newsletter_id`, `send_status`) VALUES (NULL, '$name', '$email', '$newsletter_id','0')";
		$update_result = $db->query($update_query);
	
	}
  
  	// Schedule Email to Newsletter Table 
  
	$_SESSION["GTMessageSchedule"] = '<div id="gt-formsuccess">'.$subject.' has been scheduled successfully.</div>';
	
	echo "<script>document.location.href='newsletter-dummy.php';</script>";
	exit;
}



$rwscid=$_GET["rwscid"];
foreach($rwscid as $key => $val)
{
	$sql="UPDATE `newsletter_dumpitems` SET `orderid`='".$_GET["rwsorder".$val]."'  WHERE `id` ='$val'";
	mysql_query($sql);
	
}									
	
	$reg_title = 'Newsletter';
	$reg_subtitle = 'Newsletter';
	$reg_breadcrumb = 'Newsletter';
	$reg_button = 'Save';
	
	$orderfield = $_GET["field"];
	$orderby = $_GET["order"];	
	
	if($orderfield !="") {	
		$query = "SELECT * FROM newsletter_dumpitems WHERE id > 0 ORDER BY $orderfield $orderby LIMIT 0, 55 ";
	}
	else
	{
		$query = "SELECT * FROM newsletter_dumpitems WHERE id > 0 ORDER BY orderid ASC LIMIT 0, 55 ";
	}
	
	$result = $db->query($query);	

	$totalrows = $result->num_rows;

	$rowlist = $result->rows;
	
	
	if($orderby != "" && $orderby == "ASC")

	{

		$show_group = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=groupname&order=DESC" title="Click to Sort in desending order.">Group</a>';

		$show_groupcat = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=groupcategory&order=DESC" title="Click to Sort in desending order.">Group Category</a>';

		$show_user = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=firstname&order=DESC" title="Click to Sort in desending order.">Posted By</a>';
		
		$show_email = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=email&order=DESC" title="Click to Sort in desending order.">Email</a>';	

		$show_walltype = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=datatype&order=DESC" title="Click to Sort in desending order.">Wall Type</a>';	

		$show_date = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=created_date&order=DESC" title="Click to Sort in desending order.">Add Date</a>';		

		$show_likes = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=total_likes&order=DESC" title="Click to Sort in desending order.">Likes</a>';

		$show_comments = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=total_comments&order=DESC" title="Click to Sort in desending order.">Comments</a>';

		$show_total = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=grandtotal&order=DESC" title="Click to Sort in desending order.">Total</a>';
		
		$show_order = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=orderid&order=DESC" title="Click to Sort in desending order.">Oder</a>';
		
		$show_branch = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=branch_short_name&order=DESC" title="Click to Sort in desending order.">Branch</a>';
		
		$show_year = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=start_year&order=DESC" title="Click to Sort in desending order.">Year</a>';

		

	}

	else

	{

		$show_group = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=groupname&order=ASC" title="Click to Sort in desending order.">Group</a>';

		$show_groupcat = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=groupcategory&order=ASC" title="Click to Sort in desending order.">Group Category</a>';
		$show_user = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=firstname&order=ASC" title="Click to Sort in desending order.">Posted By</a>';
		
		$show_email = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=email&order=ASC" title="Click to Sort in desending order.">Email</a>';	

		$show_walltype = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=datatype&order=ASC" title="Click to Sort in desending order.">Wall Type</a>';	

		$show_date = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=created_date&order=ASC" title="Click to Sort in desending order.">Add Date</a>';		

		$show_likes = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=total_likes&order=ASC" title="Click to Sort in desending order.">Likes</a>';

		$show_comments = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=total_comments&order=ASC" title="Click to Sort in desending order.">Comments</a>';

		$show_total = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=grandtotal&order=ASC" title="Click to Sort in desending order.">Total</a>';
		
		$show_order = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=orderid&order=ASC" title="Click to Sort in desending order.">Oder</a>';
		
		$show_branch = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=branch_short_name&order=ASC" title="Click to Sort in desending order.">Branch</a>';
		
		$show_year = '<a href="newsletter-dummy.php?page=gclt&PageNo='.$pagenum.'&field=start_year&order=ASC" title="Click to Sort in desending order.">Year</a>';

	}

?>

<style type="text/css">
.gtiitprojects td{background:#edbf47 !important;}
.gtforeginprojects td{background:#89ce8f !important;}
.gtinterview td{background:#74cee4 !important;}
.gtinternship td{background:#ec774b !important;}
</style>

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php include('sidebar.php'); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo $reg_title; ?>
                        <small><?php echo $reg_subtitle; ?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $baseurl; ?>master/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo $baseurl; ?>master/newsletter-dummy.php"><i class="fa fa-leaf"></i> News Letter </a></li>
                        <li class="active"><?php echo $reg_breadcrumb; ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12"><!-- /.box -->
                        	<?php if(!empty($msg)) { ?>
                              <div id="gt-formsuccess">                                
                                  <?php echo $msg; ?>
                              </div>
                              <?php } ?>
                              <form action="" method="get" name="gtrecreateform" id="gtrecreateform" style="padding:0 10px 10px 10px; margin-bottom:20px; border:1px solid #ccc; background:#eee;">
                              <h4>Recreate Newsletter</h4>
                              <div class="row">
                              	<div class="col-md-3">
                                	<input type="text" name="start_date" placeholder="Start Date" id="start_date" class="form-control gtdatedropdown" value="" required="required">
                                </div>
                                <div class="col-md-3">
                                	<input type="text" name="end_date" placeholder="End Date" id="end_date" class="form-control gtdatedropdown" value="" required="required">                     </div>
                                <div class="col-md-3"><?php echo togetcollegelistadmin('college_id', $_SESSION['myForm']['college_id'], 'required'); ?></div>
                            	<div class="col-md-3" style="text-align:right">                                
                                	<button class="btn btn-primary" type="submit" name="recreate" id="recreate" > Recreate </button>
                                </div>
                            </div>
                              </form>
                              
                              <form action="" method="get" name="gtsendtestmail" id="gtsendtestmail" style="padding:0 10px 10px 10px; margin-bottom:20px; border:1px solid #ccc; background:#eee;">
                              <h4>Send Test Mail</h4>
                              <?php if($_SESSION["GTMessageAdmin"]!="") { echo $_SESSION["GTMessageAdmin"]; unset($_SESSION["GTMessageAdmin"]); } ?>
                              <div class="row">
                              	<div class="col-md-3">
                                	<input type="email" name="email_id_1" placeholder="*Email ID 1" id="email_id_1" class="form-control" value="" required="required">
                                </div>
                                <div class="col-md-3">
                                	<input type="email" name="email_id_2" placeholder="Email ID 2" id="email_id_2" class="form-control" value="">
                                </div>
                                <div class="col-md-3">
                                	<input type="email" name="email_id_3" placeholder="Email ID 3" id="email_id_3" class="form-control" value="">
                                </div>
                                <div class="col-md-1" style="text-align:right">
                                	<input type="number" name="limit_items" placeholder="*Limit" id="limit_items" class="form-control" value="" required="required" style="float:right">
                                </div>
                            	<div class="col-md-2" style="text-align:right">                                
                                	<button class="btn btn-primary" type="submit" name="sendmail" id="sendmail" > Send Mail </button>
                                </div>
                            </div>
                              </form>
                              
                              <form action="" method="get" name="gtschedule" id="gtschedule" style="padding:0 10px 10px 10px; margin-bottom:20px; border:1px solid #ccc; background:#eee;">
                              <h4>Schedule Email</h4>
                              <?php if($_SESSION["GTMessageSchedule"]!="") { echo $_SESSION["GTMessageSchedule"]; unset($_SESSION["GTMessageSchedule"]); } ?>
                              <div class="row">
                              	<div class="col-md-4">
                                	<input name="schedule" id="schedule" type="checkbox" value="1" required="required"/> Please confirm before you schedule this newsletter. 
                                </div>
                                <div class="col-md-2">
                                	<input type="text" name="send_date" placeholder="Send Date" id="send_date" class="form-control gtdatedropdown" value="" required="required">
                                </div>
                                <div class="col-md-3">
                                	<input type="text" name="subject" placeholder="Subject" id="subject" class="form-control" value="" required="required">
                                </div>
                                <div class="col-md-1"  style="text-align:right">
                                	<input type="number" name="limit_items" placeholder="*Limit" id="limit_items" class="form-control" value="" required="required" style="float:right">
                                </div>
                            	<div class="col-md-2" style="text-align:right">                                
                                	<button class="btn btn-primary" type="submit" name="Schedule" id="Schedule" > Schedule </button>
                                </div>
                            </div>
                            </form>
                              
                            <form action="" method="get" name="form4" id="form4">
                            
                            <div class="box"><!-- /.box-header -->
                                <div class="box-body table-responsive">                                	
                                    <?php if($totalrows>0) { $sno=1; ?>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="10">#</th>
                                                <th>S. No.</th>
                                                <th><?php echo $show_group; ?></th>
                                                <th><?php echo $show_groupcat; ?></th>
                                                <th><?php echo $show_user; ?></th>
                                                <th><?php echo $show_walltype; ?></th>
                                                <th><?php echo $show_date; ?></th>
                                                <th><?php echo $show_likes; ?></th>
                                                <th><?php echo $show_comments; ?></th>
                                                <th><?php echo $show_total; ?></th>
                                                <th><?php echo $show_order; ?> <button class="btn btn-primary" type="submit" name="rws-submit2"> Update </button></th>
                                                <th>College</th>
                                                <th><?php echo $show_branch; ?></th>
                                                <th><?php echo $show_year; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php  $j=1; foreach($rowlist as $key => $row) 
											{
												if($row["datatype"]==1)
												{
													$datatype = "Text Image";
													$trbgcolor = "";
												}
												elseif($row["datatype"]==2)
												{
													$datatype = "Notifications";
													$trbgcolor = "";
												}
												elseif($row["datatype"]==3)
												{
													$datatype = "Video";	
													$trbgcolor = "";
												}
												elseif($row["datatype"]==4)
												{
													$datatype = "File";
													$trbgcolor = "";
												}
												elseif($row["datatype"]==5)
												{
													$datatype = "Event";
													$trbgcolor = "";	
												}							
												elseif($row["datatype"]==6)							
												{
													$datatype = "Poll";	
													$trbgcolor = "";						
												}											
												elseif($row["datatype"]==7)							
												{
													$datatype = "IIT Projects";	
													$trbgcolor = " gtiitprojects";						
												}											
												elseif($row["datatype"]==8)
												{
													$datatype = "Foreign Projects";	
													$trbgcolor = " gtforeginprojects";							
												}											
												elseif($row["datatype"]==9)							
												{
													$datatype = "Interview Questions";	
													$trbgcolor = " gtinterview";							
												}											
												elseif($row["datatype"]==10)
												{
													$datatype = "Link";
												}											
												elseif($row["datatype"]==11)
												{
													$datatype = 'Bazaar';
												}											
												elseif($row["datatype"]==12)
												{
													$datatype = 'Internship';
													$trbgcolor = " gtinternship";	
												} 
												
												if($row["firstname"]!="")
												{
													$showname		=	$row["firstname"].' '.$row["lastname"];													
												}
												else
												{
													$showname		=	$row["email"];
												}
											
										 ?>
                                            <tr class="<?php echo $trbgcolor; ?>">
                                                <td><input name="chkid[<? echo $j; ?>]" type="checkbox" id="chkid[<? echo $j; ?>]" value="<? echo $row['id']; ?>" /></td>
                                                <td><?php echo $sno; ?></td>
                                                <td><?php echo $row["groupname"]; ?></td>
                                                <td><?php echo $row["groupcategory"]; ?></td>
                                                <td><?php echo $showname; ?></td>
                                                <td><?php echo '<a href="'.$baseurl.'post-details.php?pid='.$row["wall_id"].'&ptype='.$row["datatype"].'" target="_blank">'.$datatype.'</a>'; ?></td>
                                                <td><?php echo toshowdatewithtime($row["created_date"]); ?></td>
                                                <td><?php echo $row["total_likes"]; ?></td>
                                                <td><?php echo $row["total_comments"]; ?></td>
                                                <td><?php echo $row["grandtotal"]; ?></td>
                                                <td>
                                                <input name="rwsorder<?php echo $row['id']; ?>" type="text" value="<?php echo $row['orderid']; ?>" />
                                                <input name="rwscid[]" type="hidden" value="<?php echo $row['id']; ?>" /></td>
                                                <td><?php echo $row["shortname"]; ?></td>
                                                <td><?php echo $row["branch_short_name"]; ?></td>
                                                <td><?php echo $row["start_year"]; ?></td>
                                            </tr> 
                                         <?php $sno++;  $j++; } ?>                                              
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th width="10">#</th>
                                                <th>S. No.</th>
                                                <th>Group</th>
                                                <th>Group Category</th>
                                                <th>User</th>
                                                <th>Type Of Post</th>
                                                <th>Publish Date</th>
                                                <th>Likes</th>
                                                <th>Comments</th>
                                                <th>Total</th>
                                                <th>Order</th>
                                                <th>College</th>
                                                <th>Branch</th>
                                                <th>Year</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <?php } ?>                            
                                    <!-- /.Pagination Ends -->
                              </div><!-- /.box-body -->
                          </div><!-- /.box -->
                          </form>
                      </div>
                    </div>

                </section><!-- /.content -->
              
              <footer>
              		<?php include('footer-copyright.php'); ?>
              </footer>
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->        
<?php include('footer.php'); ?>