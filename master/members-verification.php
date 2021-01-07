<?php include('header.php'); $gtpage = 'course-list'; $rwseditor=1;  checkadminroles('members');
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

	
	$reg_title = 'Verify Users';
	$reg_subtitle = 'Verify Users Page';
	$reg_breadcrumb = 'Verify Users';
	$reg_button = 'Update';

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
                                    <h3 class="box-title">Course Details</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                	<div class="box-body">
                                        
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">User List</label></div>
                                            <div class="col-md-10">
                                            	<input name="image_1" id="image_1" type="file" /> CSV Files only
                                             </div>
                                        </div>                                 
                                        
                                    </div><!-- /.box-body -->                                    
                                
                            </div>
                        </div>
                        
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-warning">
                                    <div class="box-footer" style="text-align:center">
                                          <button class="btn btn-primary" type="submit" name="rws-submit"> <?php echo $reg_button; ?> </button>
                                          &nbsp;&nbsp;&nbsp;&nbsp;
                                          <button class="btn btn-primary" type="button" name="rws-back" onclick="document.location.href='member-list.php'"> Back </button>
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