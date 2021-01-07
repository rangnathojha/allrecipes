<?php $websiteurl ="https://www.shapingsteps.com/"; ?>
<div id="mySidenav" class="sidenav">
	<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
    <ul class="rws-mobilenav">
    	<?php if(!empty($_SESSION["GTUserID"])) { ?> 
        <li class="active"><a href="<?php echo $websiteurl; ?>">Home</a></li>
        <li><a href="<?php echo $websiteurl; ?>app/services-list.php?search_txt=&service_id=1">Browse Frentor</a></li>
        <li><a href="<?php echo $websiteurl; ?>submit-events/">Submit Event</a></li>
        <li><a href="<?php echo $websiteurl; ?>submit-articles/">Submit Articles</a></li>
        <li><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">FAQs</a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo $websiteurl; ?>faqs-service-provider/">Frentor</a></li>
                <li><a href="<?php echo $websiteurl; ?>faqs-consumer/">Consumer</a></li>
            </ul>
        </li>
        <li><a href="<?php echo $websiteurl; ?>contact-us/">Contact</a></li> 
        <li><a href="<?php echo $websiteurl; ?>app/logout.php">Logout</a></li> 
        <?php } else { ?>
        <li class="active"><a href="<?php echo $websiteurl; ?>">Home</a></li>
        <li><a href="<?php echo $websiteurl; ?>app/services-list.php?search_txt=&service_id=1">Browse Frentor</a></li>
        <li><a href="<?php echo $websiteurl; ?>app/login.php">Login</a></li>
        <li><a href="<?php echo $websiteurl; ?>app/register-as-service-provider.php">Become a Frentor</a></li>
        <li><a href="<?php echo $websiteurl; ?>submit-events/">Submit Event</a></li>
        <li><a href="<?php echo $websiteurl; ?>submit-articles/">Submit Articles</a></li>
        <li><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">FAQs</a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo $websiteurl; ?>faqs-service-provider/">Frentor</a></li>
                <li><a href="<?php echo $websiteurl; ?>faqs-consumer/">Consumer</a></li>
            </ul>
        </li>
        <li><a href="<?php echo $websiteurl; ?>contact-us/">Contact</a></li> 
        <?php } ?>
    </ul>
</div>
<div class="rws-header animated fadeInDown">

    	<div class="container">

        	<div class="row">

            	<div class="col-sm-2 col-xs-4"><a href="<?php echo $websiteurl; ?>"><img src="<?php echo $websiteurl; ?>app/images/logo12.png" alt="Shaping Steps" title="Shaping Steps" /></a> </div>

                <!-- Logo Ends -->

                <div class="col-sm-10  col-xs-8">
                <div class="gtmenuinner">
                	<div class="row">
                        <div class="<?php if($hidesearch==0) { ?>col-sm-9<?php } else { echo 'col-sm-9'; } ?>">
 <div class="gtmenusection">
        	<!-- Static navbar -->

              <nav class="navbar navbar-default">

                  <!--<div class="navbar-header">

                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">

                      <span class="sr-only">Toggle navigation</span>

                      <span class="icon-bar"></span>

                      <span class="icon-bar"></span>

                      <span class="icon-bar"></span>

                    </button>            

                  </div>-->
                  
                  <span class="rws-mobilemunuopen" onclick="openNav()">☰ MENU</span>

                  <div id="navbar" class="navbar-collapse collapse">

                    <ul class="nav navbar-nav">
                        <?php if(!empty($_SESSION["GTUserID"])) { ?> 
                        <li class="active"><a href="<?php echo $websiteurl; ?>">Home</a></li>
                        <li><a href="<?php echo $websiteurl; ?>app/services-list.php?search_txt=&service_id=1">Browse Frentor</a></li>
						<li><a href="<?php echo $websiteurl; ?>submit-events/">Submit Event</a></li>
                        <li><a href="<?php echo $websiteurl; ?>submit-articles/">Submit Articles</a></li>
                        <li><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">FAQs</a>
                        	<ul class="dropdown-menu">
                            	<li><a href="<?php echo $websiteurl; ?>faqs-service-provider/">Frentor</a></li>
                                <li><a href="<?php echo $websiteurl; ?>faqs-consumer/">Consumer</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo $websiteurl; ?>contact-us/">Contact</a></li> 
                      	<li><a href="<?php echo $websiteurl; ?>app/logout.php">Logout</a></li> 
                      	<?php } else { ?>
                        <li class="active"><a href="<?php echo $websiteurl; ?>">Home</a></li>
                        <li><a href="<?php echo $websiteurl; ?>app/services-list.php?search_txt=&service_id=1">Browse Frentor</a></li>
                        <li><a href="<?php echo $websiteurl; ?>app/login.php">Login</a></li>
                        <li><a href="<?php echo $websiteurl; ?>app/register-as-service-provider.php">Become a Frentor</a></li>
                        <li><a href="<?php echo $websiteurl; ?>submit-events/">Submit Event</a></li>
                        <li><a href="<?php echo $websiteurl; ?>submit-articles/">Submit Articles</a></li>
                        <li><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">FAQs</a>
                        	<ul class="dropdown-menu">
                            	<li><a href="<?php echo $websiteurl; ?>faqs-service-provider/">Frentor</a></li>
                                <li><a href="<?php echo $websiteurl; ?>faqs-consumer/">Consumer</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo $websiteurl; ?>contact-us/">Contact</a></li> 
                        <?php } ?>
                    </ul>                            

                  </div><!--/.nav-collapse -->

              </nav>
              </div></div>
              <?php if($hidesearch==0) { ?>
                  <!--<div <?php if(!empty($_SESSION["GTUserID"])) { ?> class="col-sm-3 gtloggedinsearch hidden-xs" <?php } else { ?>class="col-sm-4 hidden-xs"<?php } ?>>
					<form action="<?php echo $websiteurl;?>app/service-search-result.php" method="get" name="rws-search" id="rws-search" class="rws-search">
                        <div class="gt-headsearchform">        
                      		<input name="hidsearchtype" id="hidsearchtype" value="s" type="hidden">     
                            <input name="search_txt" id="search_txt" class="gtsearchtext" autocomplete="off" placeholder="Keyword..." value="<?php echo $_GET["search_txt"];?>" type="text">  
                            <select name="gtsearchcategory2" id="gtsearchcategory2">
                            	<option value="6">Mentors</option>
                                <option value="4">People</option>
                                <option value="5">Counselling</option>
                                <option value="1">Events</option>
                                <option value="2">Buzz</option>
                                <option value="3">Global Feed</option>                                                                
                            </select> 
                            <button type="submit" name="gtsearchdata" id="gtsearchdata"><i class="fa fa-search"></i></button> 
                        </div>
                	</form>
                    <ul class="rwssearchcontentlist"></ul>
        </div>-->
        <?php } else {
			?>
                      <ul class="gtsociallinks"><li id="" class=""><a target="_blank" href="https://www.facebook.com/Shaping-Steps-1013095438713694/?fref=ts"><i class="_mi dashicons dashicons-facebook" aria-hidden="true" style="font-size:2.0em;"></i><span class="visuallyhidden">Facebook</span></a></li>
<li id="" class=""><a href="https://twitter.com/shaping_steps" target="_blank" ><i class="_mi dashicons dashicons-twitter" aria-hidden="true" style="font-size:2.0em;"></i><span class="visuallyhidden">Twitter</span></a></li>
<li id="menu-item-3297" class=""><a href="https://plus.google.com/u/0/107035931279814110063" target="_blank" ><i class="_mi dashicons dashicons-googleplus" aria-hidden="true" style="font-size:2.0em;"></i><span class="visuallyhidden">Google</span></a></li>
</ul>
            <?php
			} ?>
        <?php if(!empty($_SESSION["GTUserID"])) { ?> 
        <div class="col-sm-1 hidden-xs">
        	<div class="dropdown">
                    		<a href="#" title="Setting" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false"  id="gtdLabel1" class="gtlebellink1"><?php if(!empty($_SESSION['GTUserphotograph'])) { ?>
                    <img src="<?php echo $baseurl.$_SESSION['GTUserphotograph']; ?>" alt="" title="" width="26" height="26" />
                    <?php } else { ?>
                    <div class="gtprofileicon2"><?php echo substr($_SESSION['GTUserFirstName'],0,1); ?></div>
                    <?php } ?> <i class="fa fa-caret-down" aria-hidden="true"></i></a>
  							<ul class="dropdown-menu" aria-labelledby="gtdLabel1">
								<?php if($_SESSION["GTUserType"]=="C") { ?>
                                    <li><a href="<?php echo $websiteurl; ?>app/dashboard-consumer.php">Dashboard</a></li> 
                                    <li><a href="<?php echo $websiteurl; ?>app/order-history-consumer.php">Orders</a></li>
                                <?php } else { ?>
                                    <li><a href="<?php echo $websiteurl; ?>app/dashboard-service-provider.php">Dashboard</a></li>
                                    <li><a href="<?php echo $websiteurl; ?>app/sp-services-list.php">Services</a></li>
                                    <li><a href="#">Earnings</a></li>
                                    <li><a href="<?php echo $websiteurl; ?>app/order-history-service-provider.php">Orders</a></li>
                                <?php } ?>                                                                
                                    <li><a href="<?php echo $websiteurl; ?>app/user-inbox.php">Inbox</a></li>
                                    <li><a href="<?php echo $websiteurl; ?>app/user-settings.php">Settings</a></li>  
                                    <li><a href="<?php echo $websiteurl; ?>app/logout.php">Logout</a></li> 
                            </ul>
                        </div>
        </div>
	<?php } ?>
    
                </div> 
                </div>
                
                </div>

                <!-- Top Menu Ends Here -->

            </div>
            
            <div class="gtsearchmobile hidden-sm hidden-md hidden-lg">
            	<div class="row">
                <div <?php if(!empty($_SESSION["GTUserID"])) { ?> class="col-xs-10" <?php } else { ?>class="col-xs-12"<?php } ?>>
            	<!--<form action="<?php echo $websiteurl;?>app/service-search-result.php" method="get" name="rws-search" id="rws-search" class="rws-search">
                    <div class="gt-headsearchform">       
                        <input name="search_txt" id="search_txt" class="gtsearchtext" autocomplete="off" placeholder="Keyword..." value="<?php echo $_GET["search_txt"];?>" type="text">  
                        <select name="gtsearchcategory2" id="gtsearchcategory2">
                            <option value="6">Mentors</option>
                            <option value="4">People</option>
                            <option value="5">Counselling</option>
                            <option value="1">Events</option>
                            <option value="2">Buzz</option>
                            <option value="3">Global Feed</option>                                                                
                        </select> 
                        <button type="submit" name="gtsearchdata" id="gtsearchdata"><i class="fa fa-search"></i></button> 
                    </div>
                </form>
                <ul class="rwssearchcontentlist"></ul>-->&nbsp;
                </div>
                
                <?php if(!empty($_SESSION["GTUserID"])) { ?> 
                <div class="col-xs-2">
        	<div class="dropdown">
                    		<a href="#" title="Setting" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false"  id="gtdLabel1" class="gtlebellink1"><?php if(!empty($row["photograph"])) { ?>
                    <img src="<?php echo $row["photograph"]; ?>" alt="" title="" width="26" height="26" />
                    <?php } else { ?>
                    <div class="gtprofileicon2"><?php echo substr($_SESSION['GTUserFirstName'],0,1); ?></div>
                    <?php } ?> <i class="fa fa-caret-down" aria-hidden="true"></i></a>
  							<ul class="dropdown-menu" aria-labelledby="gtdLabel1">
								<?php if($_SESSION["GTUserType"]=="SP") { ?>
                                    <li><a href="<?php echo $websiteurl; ?>app/dashboard-service-provider.php">Dashboard</a></li>
                                    <li><a href="<?php echo $websiteurl; ?>app/sp-services-list.php">Services</a></li>
                                    <li><a href="#">Earnings</a></li>
                                    <li><a href="<?php echo $websiteurl; ?>app/order-history-service-provider.php">Orders</a></li>
                                <?php } else { ?>
                                    <li><a href="<?php echo $websiteurl; ?>app/dashboard-consumer.php">Dashboard</a></li> 
                                    <li><a href="<?php echo $websiteurl; ?>app/order-history-consumer.php">Orders</a></li>
                                <?php } ?>                                                                
                                    <li><a href="<?php echo $websiteurl; ?>app/user-inbox.php">Inbox</a></li>
                                    <li><a href="<?php echo $websiteurl; ?>app/user-settings.php">Settings</a></li> 
                                    <li><a href="<?php echo $websiteurl; ?>app/logout.php">Logout</a></li> 
                            </ul>
                        </div>
                        </div>
	<?php } ?>
                </div>
                
                </div>
                
            </div>
            
            

        </div>

    </div>