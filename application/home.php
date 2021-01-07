<div class="rws-hometopsec">
	<div class="row">
    	<div class="col-md-3">
        	<div class="htsmodule">
            	<?php echo getcatdetailshome(1);?>
            </div>
            <div class="htsmodule">
            	<?php echo getcatdetailshome(3);?>
            </div>
        </div>
        <div class="col-md-6">
        	<div class="htsmodule">
            	<?php echo getcatdetailshome2(4);?>
            </div>
        </div>
        <div class="col-md-3">
        	<div class="rws-htsrmodule">
            	<h3>Fresh Recipes for New Year</h3>
            	<?php echo getrecentitems(); ?>
                <!-- Item Ends -->                
            </div>
        </div>
    </div>
</div>

<div class="rws-homerecentitems">
	<h2>Recent Recipes</h2>
	<?php echo getrecentitemshome(); ?>
</div>