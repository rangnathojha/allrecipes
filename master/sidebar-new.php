<aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="img/avatar5.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, Admin</p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li <?php if($gtpage=="dashboard") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/dashboard.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
						
                        <li <?php if($gtpage=="college-list") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/college-list.php">
                              <i class="fa fa-pagelines"></i>  <span>Manage College</span>
                            </a>							
                        </li>
                        
                        <li <?php if($gtpage=="course-list") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/course-list.php">
                              <i class="fa fa-pagelines"></i>  <span>Manage Course</span>
                            </a>							
                        </li>
                        
                        <li <?php if($gtpage=="branch-list") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/branch-list.php">
                              <i class="fa fa-pagelines"></i>  <span>Manage Branch</span>
                            </a>							
                        </li>
                        <li <?php if($gtpage=="group-category-list") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/group-category-list.php">
                              <i class="fa fa-pagelines"></i>  <span>Manage Group Category</span>
                            </a>							
                        </li>
                        
                        <li <?php if($gtpage=="group-list") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/group-list.php">
                              <i class="fa fa-pagelines"></i>  <span>Manage Groups</span>
                            </a>							
                        </li>
                        
                           <li <?php if($gtpage=="group-list-admin") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/group-list-admin.php">
                              <i class="fa fa-pagelines"></i>  <span>Manage Dummy Groups</span>
                            </a>							
                        </li>
                        
                        
                           <li <?php if($gtpage=="member-list") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/member-list.php">
                              <i class="fa fa-pagelines"></i>  <span>Member List</span>
                            </a>							
                        </li>
                       
                        <?php if (isset($_SESSION['usergroupid']) && in_array('system', $_SESSION['userroles'])) { ?> 
                         <li <?php if($gtpage=="change-password") { echo 'class="active"'; }?>>
                            <a href="#">
                                <i class="fa fa-key"></i> <span>System Admin</span>
                            </a>
                        </li>   
                                      <ul class="dropdown">                                                                   
                    
                        <li <?php if($gtpage=="content-list") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/content-list.php">
                                <span>Content List</span>
                            </a>
                        </li>      
                          <li <?php if($gtpage=="general-setting") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/general-setting.php">
                               <span>General Setting</span>
                            </a>
                        </li>     
                           <li <?php if($gtpage=="general-setting") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/users.php">
                               <span>Users</span>
                            </a>
                        </li>  
                           <li <?php if($gtpage=="general-setting") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/users-group.php">
                               <span>Users Group</span>
                            </a>
                        </li>  
                        </ul>  
                         <?php
						  }
						  ?>
                          
                             <?php if (isset($_SESSION['usergroupid']) && in_array('system', $_SESSION['userroles'])) { ?> 
                            <li <?php if($gtpage=="general-setting") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/general-setting.php">
                              <i class="fa fa-cog"></i>   <span>Settings</span>
                            </a>
                        </li>  
                         <?php
						  }
						  ?>
                        
                            <li <?php if($gtpage=="change-password") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/change-password.php">
                              <i class="fa fa-sign-out"></i>   <span>Change Password</span>
                            </a>
                        </li>  
                        <li <?php if($gtpage=="newsletter") { echo 'class="active"'; }?>>
                            <a href="<?php echo $baseurl; ?>master/newsletter.php">
                                <i class="fa fa-sign-out"></i> <span>Newsletter</span>
                            </a>
                        </li>                                  
                        <li>
                            <a href="<?php echo $baseurl; ?>master/logout.php">
                                <i class="fa fa-sign-out"></i> <span>Sign out</span>
                            </a>
                        </li>   
                                             
                    </ul>
                </section>
                <!-- /.sidebar -->
</aside>