<?php include('header.php'); $gtpage = 'dashboard'; ?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php include('sidebar.php'); ?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Dashboard <small>Control panel</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                	<h2 style="margin:0 0 15px;" >Welcome <?php echo $_SESSION['GTadminuserName']; ?> !</h2>
                    
                    <?php if(!empty($_SESSION["AdminErrorMSG"])) { echo $_SESSION["AdminErrorMSG"]; unset($_SESSION["AdminErrorMSG"]); } ?>
                    
                    <div class="box box-danger">
                                <div class="box-header" style="cursor: move;">
                                    <h3 class="box-title">Shaping Steps Member's Statistics</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body no-padding">
                                    
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <table class="table table-bordered">
                                        <tbody><tr>
                                        	<th>Total Number Of Consumers</th>
                                            <th>Total Number Of Frentors</th>
                                            <th>Total Number Of Both Type User</th>
                                            <th>Total Users</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo togetuserlistcriteria('C'); ?> Consumers</td>
                                            <td><?php echo togetuserlistcriteria('S'); ?> Frentors</td>
                                            <td><?php echo togetuserlistcriteria('B'); ?> Consumers &amp; Frentors</td>
                                            <td><?php echo togetuserlistcriteria(''); ?> Members</td>
                                        </tr>                                        
                                    </tbody></table>
                                </div><!-- /.box-footer -->
                            </div>	
                            
                            <!-- SECTION ENDS -->
                            
                            <div class="box box-success">
                                <div class="box-header" style="cursor: move;">
                                    <h3 class="box-title">Shaping Steps Order Statistics</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body no-padding">
                                    
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <table class="table table-bordered">
                                        <tbody><tr>
                                        	<th>Pending Orders</th>
                                            <th>Successfull Orders</th>
                                            <th>Complted Orders</th>
                                            <th>Failed Orders</th>
                                            <th>Assigned Orders</th>
                                            <th>Not Assigned Orders</th>
                                            <th>Pending Orders(Frentor)</th>
                                            <th>Accepted Orders(Frentor)</th>
                                            <th>Complted Orders(Frentor)</th>
                                            <th>Total Orders</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo togetorderlistcriteria(" WHERE order_status='0' "); ?> Order(s)</td>
                                            <td><?php echo togetorderlistcriteria(" WHERE order_status='1' OR order_status='2' "); ?> Order(s)</td>
                                            <td><?php echo togetorderlistcriteria(" WHERE order_status='2' "); ?> Order(s)</td>
                                            <td><?php echo togetorderlistcriteria(" WHERE order_status>2 "); ?> Order(s)</td>
                                            <td><?php echo togetorderlistcriteria(" WHERE service_provider_id>0 "); ?> Order(s)</td>
                                            <td><?php echo togetorderlistcriteria(" WHERE service_provider_id='0' "); ?> Order(s)</td>
                                            <td><?php echo togetorderlistcriteria(" WHERE order_acceped='0' "); ?> Order(s)</td>
                                            <td><?php echo togetorderlistcriteria(" WHERE order_acceped='1' OR order_acceped='2' "); ?> Order(s)</td>
                                            <td><?php echo togetorderlistcriteria(" WHERE order_acceped='2' "); ?> Order(s)</td>
                                            <td><?php echo togetorderlistcriteria(""); ?> Order(s)</td>
                                        </tr>                                        
                                    </tbody></table>
                                </div><!-- /.box-footer -->
                            </div>	
                            
                            <!-- SECTION ENDS -->
                            
                            <div class="box box-info">
                                <div class="box-header" style="cursor: move;">
                                    <h3 class="box-title">Shaping Steps Hour's Statistics</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body no-padding">
                                    
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <table class="table table-bordered">
                                        <tbody><tr>
                                        	<th>Total Number Of Hours Sold</th>
                                            <th>Total Number Of Hours Scheduled(Consumer)</th>
                                            <th>Total Number Of Hours Scheduled Accepted(Frentor)</th>
                                            <th>Total Number Of Hours Scheduled Completed(Consumer)</th>                                            
                                        </tr>
                                        <tr>
                                            <td><?php echo togetorderhourscriteria(" WHERE order_status<3 "); ?> Hour(s)</td>
                                            <td><?php echo togetorderhourschedule(" "); ?> Hour(s)</td>
                                            <td><?php echo togetorderhourschedule(" WHERE status>1 "); ?> Hour(s)</td>
                                            <td><?php echo togetorderhourschedule(" WHERE status='3' "); ?> Hour(s)</td>
                                        </tr>                                        
                                    </tbody></table>
                                </div><!-- /.box-footer -->
                            </div>	
                            
                            <!-- SECTION ENDS -->			               	


              </section><!-- /.content -->


              


              <footer>


              		<?php include('footer-copyright.php'); ?>


              </footer>


            </aside><!-- /.right-side -->


        </div><!-- ./wrapper -->        


<?php include('footer.php'); ?>