<?php include('header.php'); $gtpage = 'package-list'; $rwseditor=1; $gtdateopt="on"; checkadminroles('package');
unset($_SESSION['myForm']);

if(isset($_GET["fid"]))
{
	$select_query = 'SELECT t1.*, t3.name as service_name FROM ss_services_package as t1 INNER JOIN ss_services as t3 ON t1.service_id=t3.service_id WHERE t1.services_package_id = "'.$_GET["fid"].'"';
	$select_result = $db->query($select_query);
	$row = $select_result->row;

	$_SESSION['myForm']['services_package_id'] 		= stripslashes($row['services_package_id']);

	$_SESSION['myForm']['title'] 					= stripslashes($row['title']);
	$_SESSION['myForm']['description'] 				= stripslashes($row['description']);
	$_SESSION['myForm']['image_1'] 					= stripslashes($row['image_1']);
	$_SESSION['myForm']['image_2'] 					= stripslashes($row['image_2']);
	$_SESSION['myForm']['image_3'] 					= stripslashes($row['image_3']);
	$_SESSION['myForm']['image_4'] 					= stripslashes($row['image_4']);
	$_SESSION['myForm']['author'] 					= stripslashes($row['author']);
	$_SESSION['myForm']['prep'] 					= stripslashes($row['prep']);
	$_SESSION['myForm']['cook'] 					= stripslashes($row['cook']);
	$_SESSION['myForm']['servings'] 				= stripslashes($row['servings']);
	$_SESSION['myForm']['yield'] 					= stripslashes($row['yield']);
	$_SESSION['myForm']['nutrition_info'] 			= stripslashes($row['nutrition_info']);
	$_SESSION['myForm']['ingredients'] 				= stripslashes($row['ingredients']);
	$_SESSION['myForm']['directions'] 				= stripslashes($row['directions']);
	$_SESSION['myForm']['cook_notes'] 				= stripslashes($row['cook_notes']);
	$_SESSION['myForm']['status'] 					= stripslashes($row['status']);
	
	$_SESSION['myForm']['path'] 					= todisplaypath($row['service_id']);
	
	$_SESSION['myForm']['service_id'] 				= stripslashes($row['service_id']);

	$product_categories = categorylistforaproducts($row['service_id']);


	$reg_title = 'Edit Recipe';
	$reg_subtitle = 'Recipe Edit Page';
	$reg_breadcrumb = 'Edit Recipe';
	$reg_button = 'Update';
}
else
{	
	$reg_title = 'Add New Recipe';
	$reg_subtitle = 'Recipe Add Page';
	$reg_breadcrumb = 'Add New Recipe';
	$reg_button = 'Save';
	if($_SESSION['myForm']['status']=="")
	{
		$_SESSION['myForm']['status'] = '1';
	}
}

//print_r($_SESSION['myForm']);

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
                        <li><a href="<?php echo $baseurl; ?>master/services-list.php"><i class="fa fa-leaf"></i> Package List </a></li>
                        <li class="active"><?php echo $reg_breadcrumb; ?></li>
                    </ol>
                </section>



                <!-- Main content -->
                <section class="content">
                <form role="form" name="rwsglobalform"  id="rwsglobalform" action="package-post-form.php" method="post" enctype="multipart/form-data">

                	<div class="row">

                        <div class="col-md-12">

                        <?php if(!empty($errors)) {

                            echo '<div id="gt-formfeedback"><b><font size="4">WHOOPS! Please review the following issues:</font></b><ul>';
                                foreach ($errors as $msg) { //prints each error
                                echo "<li>$msg</li>";
                                } // end of foreach
                                echo '</ul></div>'; }                                

                                if($msg_result !="") { echo $msg_result; }
								if($_SESSION["gtThanksMSG"] !="") { echo $_SESSION["gtThanksMSG"]; unset($_SESSION["gtThanksMSG"]); }
                        ?>

                        </div>

                    </div>

					<div class="row">
                    	<div class="col-md-12">
                        	<div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Package Details</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                	<?php if($_GET['fid']!="") { ?>
                                    	<input name="post_id" type="hidden" value="<?php echo $row['services_package_id']; ?>" />
                                        <input name="oldimage_1" type="hidden" value="<?php echo $_SESSION['myForm']['image_1']; ?>" />
                                        <input name="oldimage_2" type="hidden" value="<?php echo $_SESSION['myForm']['image_2']; ?>" />
                                        <input name="oldimage_3" type="hidden" value="<?php echo $_SESSION['myForm']['image_3']; ?>" />
                                        <input name="oldimage_4" type="hidden" value="<?php echo $_SESSION['myForm']['image_4']; ?>" />
                                    <?php } ?>
                                    <div class="box-body">

                                        <div class="form-group row">

                                            <div class="col-md-2"><label for="exampleInputEmail1">Recipe<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="text" name="title" placeholder="Recipe" id="title" class="form-control" value="<?php echo $_SESSION['myForm']['title']; ?>" required="required"></div>

                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Author<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="text" name="author" placeholder="Author" id="author" class="form-control" value="<?php echo $_SESSION['myForm']['author']; ?>" required="required">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Prep Time(in minutes)<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="number" name="prep" placeholder="Prep Time" id="prep" class="form-control" value="<?php echo $_SESSION['myForm']['prep']; ?>" min="1" max="1000" required="required"></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Cook Time(in minutes)<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="number" name="cook" placeholder="Cook Time" id="cook" class="form-control" value="<?php echo $_SESSION['myForm']['cook']; ?>" min="1" max="1000" required="required"></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Servings (Total people)<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="number" name="servings" placeholder="Servings" id="servings" class="form-control" value="<?php echo $_SESSION['myForm']['servings']; ?>" min="1" max="200" required="required"></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Yield<span class="error">*</span></label></div>
                                            <div class="col-md-10"><input type="number" name="yield" placeholder="Yield" id="yield" class="form-control" value="<?php echo $_SESSION['myForm']['yield']; ?>" min="1" max="10000" required="required"></div>
                                        </div>
                                        
                                        <?php if(isset($_GET["fid"])) { ?>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Category<span class="error">*</span></label></div>
                                            <div class="col-md-10">
                                                <div class="ui-widget">
                                                    <input type="text" name="path" value="<?php echo $_SESSION['myForm']['path']; ?>" class="form-control ui-autocomplete-input" size="100" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                                                    <input type="hidden" name="parent_id" value="<?php echo $_SESSION['myForm']['service_id']; ?>">
    
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <?php } else { ?> 
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Category<span class="error">*</span></label></div>
                                            <div class="col-md-10">
                                                <div class="ui-widget">
                                                    <input type="text" name="category" class="form-control ui-autocomplete-input" size="100" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" placeholder="Type Category Name">    
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">&nbsp;</label></div>
                                            <div class="col-md-10">                                                
                                                <div id="product-category" class="scrollbox">
												  <?php $class = 'odd'; ?>                                
                                                  <?php foreach ($product_categories as $product_category) { ?>                                
                                                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>                                
                                                  <div id="product-category<?php echo $product_category['category_id']; ?>" class="<?php echo $class; ?>"><?php echo $product_category['name']; ?>&nbsp;&nbsp;<img src="img/delete.png" alt="" style="cursor:pointer;" />                                
                                                    <input type="hidden" name="product_category[]" value="<?php echo $product_category['category_id']; ?>" />                                                  </div>                                
                                                  <?php } ?>
                                
                                                </div>                                                
                                            </div>
                                        </div>   
                                        
                                        <?php } ?>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Image 1</label></div>
                                            <div class="col-md-10">
                                            <input name="image_1" id="image_1" type="file" /><br />
                                            <?php if($_SESSION['myForm']['image_1']!="") { ?><a href="<?php echo $baseurl.'images/recipeimg/'.$_SESSION['myForm']['image_1']; ?>" title="View Image" target="_blank">View Image</a><?php } else { echo "<strong>No image added yet!</strong>"; } ?>
                                            </div>
                                        </div>
                                        
                                         <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Image 2</label></div>
                                            <div class="col-md-10">
                                            <input name="image_2" id="image_2" type="file" /><br />
                                            <?php if($_SESSION['myForm']['image_2']!="") { ?><a href="<?php echo $baseurl.'images/recipeimg/'.$_SESSION['myForm']['image_2']; ?>" title="View Image" target="_blank">View Image</a><?php } else { echo "<strong>No image added yet!</strong>"; } ?>
                                            </div>
                                        </div>
                                        
                                         <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Image 3</label></div>
                                            <div class="col-md-10">
                                            <input name="image_3" id="image_3" type="file" /><br />
                                            <?php if($_SESSION['myForm']['image_3']!="") { ?><a href="<?php echo $baseurl.'images/recipeimg/'.$_SESSION['myForm']['image_3']; ?>" title="View Image" target="_blank">View Image</a><?php } else { echo "<strong>No image added yet!</strong>"; } ?>
                                            </div>
                                        </div>
                                        
                                         <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Image 4</label></div>
                                            <div class="col-md-10">
                                            <input name="image_4" id="image_4" type="file" /><br />
                                            <?php if($_SESSION['myForm']['image_4']!="") { ?><a href="<?php echo $baseurl.'images/recipeimg/'.$_SESSION['myForm']['image_4']; ?>" title="View Image" target="_blank">View Image</a><?php } else { echo "<strong>No image added yet!</strong>"; } ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputPassword1">Status</label></div>
                                            <div class="col-md-10"><input type="radio" name="status" value="1" id="RadioGroup1_0" <?php if($_SESSION['myForm']['status']=='1') { echo 'checked="checked"'; } ?>  /> Published &nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="radio" name="status" value="0" id="RadioGroup1_1" <?php if($_SESSION['myForm']['status']=='0') { echo 'checked="checked"'; } ?>  />  Unpublished  
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Description<span class="error">*</span></label></div>
                                            <div class="col-md-10"><textarea name="description" id="rwscontenteditor" placeholder="Package Description" style="width:100%;"><?php echo $_SESSION['myForm']['description']; ?></textarea></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Nutrition Info<span class="error">*</span></label></div>
                                            <div class="col-md-10"><textarea name="nutrition_info" id="nutrition_info" placeholder="Nutrition Info" style="width:100%;"><?php echo $_SESSION['myForm']['nutrition_info']; ?></textarea></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Ingredients<span class="error">*</span></label></div>
                                            <div class="col-md-10"><textarea name="ingredients" id="ingredients" placeholder="Ingredients" style="width:100%;"><?php echo $_SESSION['myForm']['ingredients']; ?></textarea></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Directioons<span class="error">*</span></label></div>
                                            <div class="col-md-10"><textarea name="directions" id="directions" placeholder="Directioons" style="width:100%;"><?php echo $_SESSION['myForm']['directions']; ?></textarea></div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-2"><label for="exampleInputEmail1">Cook Notes<span class="error">*</span></label></div>
                                            <div class="col-md-10"><textarea name="cook_notes" id="cook_notes" placeholder="Cook Notes" style="width:100%;"><?php echo $_SESSION['myForm']['cook_notes']; ?></textarea></div>
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

                                          <button class="btn btn-primary" type="button" name="rws-back" onclick="document.location.href='package-list.php'"> Back </button>

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