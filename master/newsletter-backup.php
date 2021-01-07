<?php include('header.php'); $gtpage = 'course-list'; $rwseditor=1;
$_SESSION['myForm']=array();
if(isset($_POST["rws-submit"]))
{
	
	$_SESSION['myForm'] = $_POST;
	
// Form Validation Code
	$errors = array(); //Initialize error array 
	
	if (empty($_FILES["image_1"]["name"]) ) 		{	$errors[]="File field can't be blank!";			}
		
	// Allowed file types. add file extensions WITHOUT the dot.
	$allowtypes=array("CSV", "csv");
	$max_file_size="20480";
	
	// checks that we have a file
	if((!empty($_FILES["image_1"])) && ($_FILES['image_1']['error'] == 0)) {
	// basename -- Returns filename component of path
	$filename = basename($_FILES['image_1']['name']);
	$ext = substr($filename, strrpos($filename, '.') + 1);
	$filesize=$_FILES['image_1']['size'];
	$max_bytes=$max_file_size*1024;
	
	//Check if the file type uploaded is a valid file type. 
	if (!in_array($ext, $allowtypes)) {
		$errors[]="File <strong>".$filename."</strong> has been rejected! Only the following corporate logo formats are allowed: .csv";	
	// check the size of each file
	} elseif($filesize > $max_bytes) {
		$errors[]= "Your file: <strong>".$filename."</strong> is to big. Max file size is ".$max_file_size." kb.";
	}
	
	} // if !empty FILES
	
	
	
	if(empty($errors)) {		
		
		// UPLOAD FILE CODE STARTS 
		
			$array_rand = array("rad", "dfd","met","axz", "yza", "tst", "tms", "lpg","art","mec","efc","mar","kar","lad","mah");
			$rand1 = mt_rand(100,999);
			$rand2 = mt_rand(100000,999999);
			$rand_keys = array_rand($array_rand, 2);
			
			$year = date("Y");
			$month = date("m");
			$date = date("d");
			
			$datefolder = 'temp/';
			
			$uploadfolder = $datefolder;
			
			for($k=1;$k<=2;$k++)
			{
				$img_name_rand[$k] = $array_rand[$rand_keys[0]]."_".$rand2."_".$array_rand[$rand_keys[1]]."_".$rand1."_".$k.".jpg";
				
				if(!empty($_FILES['image_'.$k]['name']))
				{
					$fileThumbnail = $_FILES['image_'.$k]['tmp_name'];
					$arrayimage[$k] = $_FILES['image_'.$k]['name'];
					$add_thumbnail=$uploadfolder."/".$k."_".$rand2."_".$arrayimage[$k];
					if (is_uploaded_file($fileThumbnail))
					{
						move_uploaded_file ($fileThumbnail, $add_thumbnail);
					}
					
					$imageuploadname[$k] = $k."_".$rand2."_".$arrayimage[$k];			
			
				}
				else
				{
					$imageuploadname[$k]="";
				}
			}
		
		// UPLOAD FILE CODE STARTS 
		
		$filename=$add_thumbnail;
	
		// open the text file
		$fd = fopen ($filename, "r");
		// initialize a loop to go through each line of the file
		$inc = 0;
		$queryy = "";
		
		while (!feof ($fd))
		{

			$buffer	 = fgetcsv($fd, 4096);
			if($inc > 0)
			{
				if($buffer[0]!='')
				{				
					$queryy.="";
					// this for loop to traverse thru the data cols
					// when this is re-created with MySQL use the mysql_num_fileds() function to get
					// this number
					$queryx="";
					for ($i = 0; $i < count($buffer); ++$i)
					{
						if ($buffer[$i] == ""){
						$buffer[$i] = " ";
						}
						
						$queryx =trim($buffer[$i]);
						
					}
					
					$update_query = "UPDATE `users` SET `verification` = '1' , `verifyby` = 'Admin'  WHERE `email`='".$queryx."'";
					$update_result = $db->query($update_query);
		
				}

			}
			$inc++;
		}

			
		fclose ($fd);
		
		
			
		$msg_result='<div id="gt-formsuccess">Account Verification status has been updated successfully!</div>';
		
				
		unset($_SESSION['myForm']);
	}
}

	
	$reg_title = 'Newsletter';
	$reg_subtitle = 'Newsletter';
	$reg_breadcrumb = 'Newsletter';
	$reg_button = 'Save';

?>

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
                        <li><a href="<?php echo $baseurl; ?>master/member-list.php"><i class="fa fa-leaf"></i> Member List </a></li>
                        <li class="active"><?php echo $reg_breadcrumb; ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form role="form" name="rwsglobalform"  id="rwsglobalform" action="" method="post" enctype="multipart/form-data">
                	<div class="row">
                        <div class="col-md-12">
                        <?php if(!empty($errors)) {
                            echo '<div id="gt-formfeedback"><b><font size="4">WHOOPS! Please review the following issues:</font></b><ul>';
                                foreach ($errors as $msg) { //prints each error
                                echo "<li>$msg</li>";
                                } // end of foreach
                                echo '</ul></div>'; }
                                
                                if($msg_result !="") { echo $msg_result; }
                        ?>
                        </div>
                    </div>
					<div class="row">
                    
                    	<div class="col-md-12">
                        	<div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Newsletter</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                	<div class="box-body">
                                        <?php  
										$query = "SELECT t1.*, IFNULL(t2.total_likes,0) as total_likes, IFNULL(t3.total_comments,0) as total_comments, (t2.total_likes+(t3.total_comments*3)) as grandtotal, u.firstname, u.lastname, u.email, u.profile_pic, u.start_year, c.shortname, b.branch_short_name, g.name as groupname FROM wall as t1 LEFT JOIN (SELECT wall_id, COUNT(*) AS total_likes FROM wall_post_like GROUP BY wall_id ) AS t2 ON t1.wall_id = t2.wall_id LEFT JOIN (SELECT wall_id, COUNT(*) AS total_comments FROM wall_post_comments GROUP BY wall_id ) AS t3 ON t1.wall_id = t3.wall_id LEFT JOIN users as u ON u.id = t1.user_id LEFT JOIN college_name AS c ON c.id = u.college LEFT JOIN branch AS b ON b.id = u.branch LEFT JOIN groups AS g ON g.id = t1.group_id WHERE t1.id > 0 ORDER BY grandtotal DESC LIMIT 0, 50 ";
										
										?>
                                        
                                        <div class="form-group">
                                            <?php
											$result = $db->query($query);	

		$totalrows = $result->num_rows;

		$rowlist = $result->rows;

		$j=1; 

		if($totalrows>0)

		{

			$string = '';

			foreach($rowlist as $key => $row) 

			{ 

			$profilepic = $row['profile_pic'];

			$cshortname = $row['shortname'];

			$branchname = $row['branch_short_name'];

			$start_year = $row['start_year'];

			$end_year = ($row['start_year']+4)-2000;

			if($end_year<10) { $end_year = '0'.$end_year; } else { $end_year = $end_year;}

			$created_date = toshowdatewithtimewall($row['created_date']);

			if(file_exists($profilepic)) { $showuserpic = $baseurl.'includes/rwsthumbs.php?src='.$baseurl_img.$profilepic.'&w=120&h=120&zc=2&q=80&a=t'; } else { $showuserpic = $baseurl_img.'images/no-photo.jpg'; }

			if($row['firstname']!="") { $showusername = $row['firstname'].' '.$row['lastname']; } else { $showusername = $row['email']; }

			/* Like Post Text */

			$getlikedbyuser = tocheckwalllikedbyuser($row['wall_id'], $row['datatype'], $byuser=1);

			$totaluserliked = tocheckwalllikedbyuser($row['wall_id'], $row['datatype']);	

			if($getlikedbyuser==0) { $addclass = ""; $addmessage = ""; if($totaluserliked>0) { $addmessage2 =  $totaluserliked." People like this post!"; } else { $addmessage2 = ""; } } else { $addclass = " gtactivelike"; $addmessage = " You, "; $addmessage2 = $totaluserliked." People like this post!"; }

			/* Like Post Text */

			// above part 
			
			

			if($_SESSION["GTUserID"]==$row["user_id"])

			{

				$editlinks = '<div class="dropdown gt-wallitemsettings">

                      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">

                        <i class="fa fa-angle-down"></i>

                      </button>

                      <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">

                        <!--<li><a href="'.$baseurl.'edit-wall-post.php?wallid='.$row['wall_id'].'&walltype='.$row['datatype'].'&lightbox[width]=600&lightbox[height]=500&lightbox[modal]=true" class="gtlightbox">Edit</a></li>-->

                        <li><a href="javascript:void(0)" onclick="togetdeletepost(\''.$row['wall_id'].'\',\''.$row['datatype'].'\');">Delete</a></li>

                      </ul>

                    </div>';

			}

			else

			{

				$editlinks = '<div class="dropdown gt-wallitemsettings">
                      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="fa fa-angle-down"></i>
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <li><a href="'.$baseurl.'cdpopdata/report-user-data.php?user_id='.$row['user_id'].'&wallid='.$row['wall_id'].'&walltype='.$row['datatype'].'&lightbox[width]=300&lightbox[height]=160&lightbox[modal]=true" class="gtlightbox">Report Post</a></li>
                      </ul>
                    </div>';

			}
			
			if($_GET["gid"]>0) { $showtopnav = ''; } else
			{
				$showtopnav = '<div class="gt-postedunder"><a href="'.$baseurl.'group-details-feed.php?gid='.$row['group_id'].'">'.$row["groupname"].'</a> <img src="'.$baseurl_img.'images/icon-arrow.jpg" class="gtarrowsap" alt="" title=""/> <a href="'.$baseurl.'user-profile-about.php?id='.$row['user_id'].'">'.$showusername.'</a> posted</div>';
			}
			
			//echo $showtopnav;
			
			if($_GET["gid"]==15) {
				$showtopnav = '<div class="gt-postedunder"><a href="'.$baseurl.'group-details-feed.php?gid='.$row['group_id'].'">'.$row["groupname"].'</a> <img src="'.$baseurl_img.'images/icon-arrow.jpg" class="gtarrowsap" alt="" title=""/> <a href="'.$baseurl.'user-profile-about.php?id='.$row['user_id'].'">'.$showusername.'</a> posted</div>';
			}
			
			if($row["datatype"]!=12) { 		

			$string .= '<div class="gt-middlemodule gt-walldisplay">'.$showtopnav.'
			<div class="gt-userinfowall">'.$editlinks.'<img src="'.$showuserpic.'" alt="" title="" class="gt-userprofilethumb"/><a href="'.$baseurl.'user-profile-about.php?id='.$row['user_id'].'">'.$showusername.'</a> <span class="gt-walldateshow">'.$created_date.'</span><br/><small>'.$cshortname.',&nbsp;'.$branchname.',&nbsp;'.$start_year.'-'.$end_year.'</small></div><div class="gt-walldismiddle">';
			
			}
			else
			{
				$string .= '<div class="gt-middlemodule gt-walldisplay">
			<div class="gt-userinfowall"><img src='.$baseurl.'images/college-dots.jpg alt="CollegeDots" title="CollegeDots" class="gt-userprofilethumb"/><a href="javascript:void(0);">CollegeDots</a></div><div class="gt-walldismiddle">';
			}

			

				if($row["datatype"]==1)

				{
					// Wall Type - TEXT	
					$string .= togetwalltextdata($row["wall_id"],$row["user_id"],$row["reach_alumni_advice_new"],$row["heading"],$loadextrafield);
				}
				elseif($row["datatype"]==2)
				{
					// Wall Type - IMAGE	
					$string .= togetwallimagedata($row["wall_id"],$row["user_id"],$row["reach_alumni_advice_new"],$row["heading"],$loadextrafield);
				}
				elseif($row["datatype"]==3)
				{
					// Wall Type - VIDEO
					$string .= togetwallvideodata($row["wall_id"],$row["user_id"],$row["reach_alumni_advice_new"],$row["heading"],$loadextrafield);	
				}
				elseif($row["datatype"]==4)
				{
					// Wall Type - FILE	
					$string .= togetwallfiledata($row["wall_id"],$row["user_id"],$row["reach_alumni_advice_new"],$row["heading"],$loadextrafield);
				}
				elseif($row["datatype"]==5)
				{
					// Wall Type - EVENT
					$string .= togetwalleventdata($row["wall_id"],$row["user_id"],$row["reach_alumni_advice_new"],$row["heading"],$loadextrafield);	
				}

				elseif($row["datatype"]==6)

				{

					// Wall Type - POLL	

					$string .= togetwallpolldata($row["wall_id"],$row["user_id"],$row["reach_alumni_advice_new"],$row["heading"],$loadextrafield);

				}
				
				elseif($row["datatype"]==7)

				{

					// Wall Type - POLL	

					$string .= togetwalliitprojectdata($row["wall_id"],$row["user_id"],$row["reach_alumni_advice_new"],$row["heading"],$loadextrafield);

				}
				
				elseif($row["datatype"]==8)

				{

					// Wall Type - POLL	

					$string .= togetwallforeignprojectdata($row["wall_id"],$row["user_id"],$row["reach_alumni_advice_new"],$row["heading"],$loadextrafield);

				}
				
				elseif($row["datatype"]==9)

				{

					// Wall Type - POLL	

					$string .= togetwallinterviewdata($row["wall_id"],$row["user_id"],$row["reach_alumni_advice_new"],$row["heading"],$loadextrafield);

				}
				
				elseif($row["datatype"]==10)
				{
					// Wall Type - Link Data	
					$string .= togetwalldataforlink($row["wall_id"],$row["user_id"],$row["reach_alumni_advice_new"],$row["heading"],$loadextrafield);
				}
				
				elseif($row["datatype"]==11)
				{
					// Wall Type - Link Data	
					$string .= togetwalldataforbazaar($row["wall_id"],$row["user_id"],$row["reach_alumni_advice_new"],$row["heading"],$loadextrafield);
				}
				
				elseif($row["datatype"]==12)
				{
					// Wall Type - Link Data	
					$string .= togetwalldataforinternship($row["wall_id"]);
				}
				
				// below part
			
					
		if($row["datatype"]==12) { $displaycomment = ' style="display:none;"'; } else { $displaycomment = ''; }			 
		
		$walltype = $row["datatype"];
					$string .= '<div class="gt-lcsformsection"><ul class="gt-lcsiformitems">
						<li><a href="javascript:void(0);"  class="gtlikewallinsert'.$addclass.'"><i class="fa fa-thumbs-up"></i>Like</a></li>
						<li '.$displaycomment.'><a href="javascript:void(0);"  class="gtcommentwallinsert"><i class="fa fa-commenting"></i>Comment</a></li>
						<!--<li><a href="javascript:void(0);"><i class="fa fa-share-square-o"></i>Share</a></li>-->
					 </ul><div class="gt-likedbyuserlist"><span>'.$addmessage.'</span> '.$addmessage2.'</div>
					 </div>';

		$walid = $row["wall_id"];	 	

		ob_start();

		include($basedir.'app/commentform.php');

		$outputcomment = ob_get_contents();

		ob_end_clean();	

		$string .= $outputcomment;
			

			$string .= '</div></div>';

				$j++;

			}
			echo $string;
		}	
		else
		{
			echo "Unable to find any records.";
		}
											?>
                                        </div>                                 
                                        
                                    </div><!-- /.box-body -->                                    
                                
                            </div>
                        </div>
                        
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-warning">
                                    <div class="box-footer" style="text-align:center">
                                          <!--<button class="btn btn-primary" type="submit" name="rws-submit"> <?php echo $reg_button; ?> </button>
                                          &nbsp;&nbsp;&nbsp;&nbsp;
                                          <button class="btn btn-primary" type="button" name="rws-back" onclick="document.location.href='member-list.php'"> Back </button>-->
                                     </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    
                    
                          	
              </section><!-- /.content -->
              
              <footer>
              		<?php include('footer-copyright.php'); ?>
              </footer>
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->        
<?php include('footer.php'); ?>