<?php
$gtcurrenttime = date('Y-m-d H:i:s');
function checkadminlogin()
{
	global $baseurl;
	if(!isset($_SESSION['GTadminuserID']) && $_SESSION['GTadminuserID'] =="")
	{
		echo "<script>document.location.href='$baseurl'</script>";
	}
}

function checkuserlogin()
{
	$pagename = $_SERVER["REQUEST_URI"];
	global $baseurl, $gtpage, $db;
	if(!isset($_SESSION['GTUserID']) && $_SESSION['GTUserID'] =="")
	{
		$_SESSION["GTsecureLoginMsg"] = '<div id="gt-formfeedback"><p>Seems like your session expired. Please login once again.</p></div>';
		echo "<script>document.location.href='$baseurl'</script>";
	}
	else
	{
		$query_login="SELECT * FROM `ss_users` WHERE `user_id`='".$_SESSION['GTUserID']."' ";			
		$result = $db->query($query_login);
		$row = $result->row;
		
		$_SESSION['GTAdminValidate']		=	$row["admin_validate"];	
		
		$_SESSION['GTFrentorEditP']=togetusereditprofile($_SESSION['GTUserID']);
		
		
		if(empty($_SESSION['GTUserMobile']))
		{
			if($_SESSION['GTUserType']=="C")
			{
				if($gtpage!="editprofile")
				{
					echo "<script>document.location.href='".$baseurl."edit-profile.php'</script>";
				}
			}			
			else
			{
				if($gtpage!="editprofile")
				{
					echo "<script>document.location.href='".$baseurl."edit-profile-sp.php'</script>";
				}
			}
		}
		else
		{
			if($_SESSION['GTFrentorEditP']=="Yes")
			{
				if($gtpage!="editprofile")
				{
					$_SESSION["GtThanksMsg"] = '<div id="rws-formsuccess">Kindly Update your Frentor profile so that Admin will check review it and activate it to use frentor section.</div>';
					
					echo "<script>document.location.href='".$baseurl."edit-profile-sp.php'</script>";
				}
			}
		}
	}

}



function checkroles($roles)
{
	global $baseurl;

	/*echo $roles;

	print_r($_SESSION['userroles']);*/

		if (isset($_SESSION['usergroupid']) && in_array($roles, $_SESSION['userroles']))
		{
			//
		}
		else
		{
			$_SESSION["AdminErrorMSG"] ='<div id="gt-formfeedback">Sorry, You don\'t have enough permission to view page. </div>';
			/*echo "<script>document.location.href='".$baseurl."master/dashboard.php'</script>";	
			exit;*/
		}
}

function checkadminroles($roles)
{
	global $baseurl;

	/*echo $roles;

	print_r($_SESSION['GtAdminuserroles']);*/

		if (isset($_SESSION['usergroupid']) && in_array($roles, $_SESSION['GtAdminuserroles']))
		{
			//
		}
		else
		{
			$_SESSION["AdminErrorMSG"] ='<div id="gt-formfeedback">Sorry, You don\'t have enough permission to view page.</div>';
			echo "<script>document.location.href='".$baseurl."master/dashboard.php'</script>";	
			exit;
		}
}



function cleandatafromspam($data) {
	$data = htmlspecialchars(trim(stripslashes(strip_tags($data))));
	return $data;
}

function cleandatafromspam_desc($data) {
	global $db;
	$data = htmlspecialchars(trim($data));	
	return $data;
}




function tocheckspam($postdata)

{

$arraydata = array();

	global $gt_exploits, $gt_profanity, $gt_spamwords;

	foreach ($postdata as $key => $val) {

		$arraydata["$key"] = cleandatafromspam($val);

	

		if (preg_match($gt_exploits, $val)) {

			exit("<p>Exploits/malicious scripting attributes aren't allowed.</p>");

		} elseif (preg_match($gt_profanity, $val) || preg_match($gt_spamwords, $val)) {

			exit("<p>That kind of language is not allowed through our form.</p>");

		}

	}

	return $arraydata;

}



/*function sendmail($mailto,$sub,$mailby,$mailby2,$body,$path,$resumefilename,$replyto="",$replytoname="")
{
	global $basedir;
	require_once($basedir."includes/class.phpmailer.php");	
	require_once("class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->From     = $mailby;
	$mail->FromName = $mailby2;
	if($replyto!="" && $replytoname!="")
	{
		$mail->AddReplyTo($replyto,$replytoname); 
	}
	if(!empty($path))
	{
		$mail->AddAttachment("$path","$resumefilename","base64","application/octet-stream");
	}
	$mail->WordWrap = 50;
	$mail->IsHTML(true);
	$mail->AddAddress($mailto,$mailto);
	$mail->Subject  =  $sub;
	$mail->Body     =  $body;
	$mail->Send();
}*/

/*function sendmail($mailto,$sub,$mailby,$mailby2,$body,$path,$resumefilename,$replyto="",$replytoname="")
{
	global $basedir;
	require_once($basedir."includes/class.phpmailer.php");
	$mail = new PHPMailer();
		
	$mail->CharSet = 'UTF-8';
	$mail->IsSMTP(); // send via SMTP
	$mail->Mailer = "smtp";
	$mail->Host = "smtp-relay.sendinblue.com"; // SMTP servers
	$mail->Port = 587;
	$mail->SMTPAuth = true; // turn on SMTP authentification
	$mail->Username = "admin@shapingsteps.com"; // SMTP username
	$mail->Password = "r8xXFZwjVgOabs7W"; // SMTP password 	

	$mail->From     = $mailby;
	$mail->FromName = $mailby2;	

	if($replyto!="" && $replytoname!="")
	{
		$mail->AddReplyTo($replyto,$replytoname); 
	}	

	if(!empty($path))
	{
		$mail->AddAttachment("$path","$resumefilename","base64","application/octet-stream");
	}
	$mail->WordWrap = 50;
	$mail->IsHTML(true);
	$mail->AddAddress($mailto,$mailto);
	$mail->Subject  =  $sub;
	$mail->Body     =  $body;
	$mail->Send();

}
*/
function sendmail($mailto,$sub,$mailby,$mailby2,$body,$path,$resumefilename)
{
	global $basedir;
	
	require_once($basedir."includes/smtpmail.php");	
	
	$mailin = new Mailin('admin@shapingsteps.com', 'r8xXFZwjVgOabs7W');
	$mailin->
	addTo($mailto, $mailto)->
	setFrom($mailby, $mailby2)->
	setReplyTo($mailby,$mailby2)->
	setSubject($sub)->
	setText('')->
	setHtml($body);
	$res = $mailin->send();
	
}



function toshowdatetime($date)

{

	$str="";

	if($date!="0000-00-00 00:00:00")

	{

		$str=date("d M Y", strtotime($date)); 

	}
	
	return $str;	

}



function toshowdatewithtime($date)

{

	$str="";

	if($date!="0000-00-00 00:00:00")

	{

		$str=date("M d, Y @ H:i:s", strtotime($date)); 

	}

	else 

	{

		//$str='Never*';

	}

	return $str;	

}



function toshowdatewithtimewall($date)

{

	$str="";

	if($date!="0000-00-00 00:00:00")

	{

		$str=date("M d, h:i A", strtotime($date)); 

	}

	else 

	{

		//$str='Never*';

	}

	return $str;	

}

function toshowdateformated($date)

{

	$str="";

	if($date!="0000-00-00")

	{

		$str=date("M d, Y", strtotime($date)); 

	}

	else 

	{

		//$str='Never*';

	}

	return $str;	

}

function gtcleanstring($string) {
   $string = str_replace('-', '', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
   return trim(str_replace('-', '', $string)); // Replaces multiple hyphens with single one.
}



function toshowformateddate($date)

{

	$str="";

	if($date!="0000-00-00 00:00:00")

	{

		$str=date("d F Y", strtotime($date)); 

	}

	else 

	{

		//$str='Never*';

	}

	return $str;	

}



function tocheckoldpwd($pwd, $userid)
{
	global $db;
	$password = md5($pwd);
	$query = "SELECT user_id FROM `ss_adminuser` WHERE `user_id` = '$userid' AND `password` = '$password'";
	$result = $db->query($query);
	$total = $result->num_rows;
	$string = '';
	if($total>0)
	{
		$string = 1;	
	}
	else
	{
		$string = 0;
	}
	return $string;

}



function togetfieldvalue($field, $table, $where)
{
	global $db;
	$query = "SELECT `$field` FROM `$table` WHERE $where";
	$result = $db->query($query);
	$row = $result->row;
	return $row["$field"];
}

function isUnique($str_field_name, $str_field_value, $str_table)

{

	global $db;

	

	$query = "SELECT `$str_field_name` FROM  `$str_table` WHERE  `$str_field_name` =  '$str_field_value'";

	$result = $db->query($query);

	if($result->num_rows)

	{

		return(0);

	}

	return(1);

}



function isUniqueREG($str_field_name, $str_field_value, $str_table, $enrollment)

{

	global $db;

	

	$query = "SELECT `$str_field_name` FROM  `$str_table` WHERE  `$str_field_name` =  '$str_field_value'";

	$result = $db->query($query);

	if($result->num_rows==0)

	{

		$string =0;

	}

	else

	{

		$string =1;	

	}

	return $string;

}

function selectforeachoptions($array, $select='')
{
	


	foreach($array as $key => $val) 

	{ 	

		if($key==$select)

		{

			$string .='<option value="'.$val.'" selected>'.$val.'</option>';

		}

		else

		{

			$string .='<option value="'.$val.'">'.$val.'</option>';

		}

	}

	

	

	return $string;	


}

function todisplay($array, $name, $firstoption, $selected="", $onchange="")
{
	$arrayprint = '<select name="'.$name.'" id="'.$name.'" class="form-control" '.$onchange.'>
					<option value="0">'.$firstoption.'</option>';
	foreach($array as $key=>$val)
	{
		if($selected == $key)
		{
		$arrayprint .= "<option value=$key selected>$val</option>";
		}
		else
		{
		$arrayprint .= "<option value=$key>$val</option>";
		}
	}
	return $arrayprint.'</select>';

}

function todisplaycheckbox($array, $name, $firstoption, $selected="", $onchange="")
{
	$arrayprint = '';
	foreach($array as $key=>$val)
	{
		if(in_array($key, $editcatid))
		{
			$arrayprint .='<input type="checkbox" name="'.$name.'" value="'.$key.'" checked="checked"> '.$val.'&nbsp;&nbsp;';
		}
		else
		{
			$arrayprint .='<input type="checkbox" name="'.$name.'" value="'.$key.'"> '.$val.'&nbsp;&nbsp;';
		}
	}
	return $arrayprint.'';

}


function togetyearlist($fieldname,$editcatid=0,$period=0,$others="")

{

	

	$month = date('n');

	$others = "";

	if($month<7){ $year1	= date('Y')-1; } else { $year1	= date('Y'); }

	

	if($period==0) { $year2 	= 1901; } else { $year2 	= $year1-($period-1); }

	

	if($editcatid==0 || $editcatid=="") { $topselect = 'selected';  $selected = "";} else { $topselect = ''; $selected = $editcatid; }

	

	$string = '<select name="'.$fieldname.'" id="'.$fieldname.'" class="form-control" '.$others.'><option value="0" '.$topselect.'> Start Year </option>';

	

	for($i = $year1; $i >= $year2; $i--) 

	{ 	

		if($selected==$i)

		{

			$string .='<option value="'.$i.'" selected>'.$i.'</option>';

		}

		else

		{

			$string .='<option value="'.$i.'">'.$i.'</option>';

		}

	}

	$string .= '</select>';

	return $string;	

}



function generate_pagination_new($pageurl, $max_pages, $pagenum, $foundnum, $per_page, $pageshow, $start)

	{

		$string = '<ul class="pagination">';

		

		$nav = $pageshow;  

		$prev = $nav - 1;

		$next = $nav + 1;

							   

		$adjacents = 3;

		$last = $max_pages - 1;

		  

		if($max_pages > 1)

		{   

		//previous button

		if (!($start<=0)) 

		$string .='<li class="prev"><a href="'.$pageurl.'&PageNo=$prev">← Previous</a></li>';    

				  

		//pages 

		if ($max_pages < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up

		{

		$i = 0;   

		for ($counter = 1; $counter <= $max_pages; $counter++)

		{

		if ($i == $start){

		$count = $counter - 1;

		$string .="<li><a href='".$pageurl."&PageNo=$counter'><b>$counter</b></a></li>";

		}

		else {

		$count = $counter - 1;

		$string .="<li><a href='".$pageurl."&PageNo=$counter'>$counter</a></li>";

		}  

		$i = $i + $per_page;                 

		}

		}

		elseif($max_pages > 5 + ($adjacents * 2))    //enough pages to hide some

		{

		//close to beginning; only hide later pages

		if(($start/$per_page) < 1 + ($adjacents * 2))        

		{

		$i = 0;

		for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

		{

		if ($i == $start){

		$count = $counter - 1;

		$string .="<li><a href='".$pageurl."&PageNo=$counter'><b>$counter</b></a></li>";

		}

		else {

		$count = $counter - 1;

		$string .="<li><a href='".$pageurl."&PageNo=$counter'>$counter</a></li>";

		} 

		$i = $i + $per_page;                                       

		}

								  

		}

		//in middle; hide some front and some back

		elseif($max_pages - ($adjacents * 2) > ($start / $per_page) && ($start / $per_page) > ($adjacents * 2))

		{

		$string .="<li><a href='".$pageurl."&PageNo=1'>1</a></li>";

		$string .="<li><a href='".$pageurl."&PageNo=2'>2</a> ....</li>";

		 

		$i = $start;                 

		for ($counter = ($start/$per_page)+1; $counter < ($start / $per_page) + $adjacents + 2; $counter++)

		{

		if ($i == $start){

		$count = $counter - 1;

		$string .="<li><a href='".$pageurl."&PageNo=$counter'><b>$counter</b></a></li>";

		}

		else {

		$count = $counter - 1;

		$string .="<li><a href='".$pageurl."&PageNo=$counter'>$counter</a></li>";

		}   

		$i = $i + $per_page;                

		}

										  

		}

		//close to end; only hide early pages

		else

		{

		$string .="<li><a href='".$pageurl."&PageNo=1'>1</a></li>";

		$string .="<li><a href='".$pageurl."&PageNo=2'>2</a>...</li>";

		 

		$i = $start;                

		for ($counter = ($start / $per_page) + 1; $counter <= $max_pages; $counter++)

		{

		if ($i == $start){

		$count = $counter - 1;

		$string .="<li><a href='".$pageurl."&PageNo=$counter'><b>$counter</b></a></li>";

		}

		else {

		$count = $counter - 1;

		$string .="<li><a href='".$pageurl."&PageNo=$counter'>$counter</a></li>";   

		} 

		$i = $i + $per_page;              

		}

		}

		}

				  

		//next button

		if (!($start >=$foundnum-$per_page))

			$string .='<li class="next"><a href="'.$pageurl.'&PageNo=$next">Next → </a></li>';    

		}

		$string .='</ul>';

		

		return $string;

}



function dobdatelist($val="")

{																					            																									    if($val=="01") { $string .= '<option value="01" selected="selected">01</option>'; } else {  $string .= '<option value="01">01</option>'; }		

	if($val=="02") { $string .= '<option value="02" selected="selected">02</option>'; } else {  $string .= '<option value="02">02</option>'; }

	if($val=="03") { $string .= '<option value="03" selected="selected">03</option>'; } else {  $string .= '<option value="03">03</option>'; }

	if($val=="04") { $string .= '<option value="04" selected="selected">04</option>'; } else {  $string .= '<option value="04">04</option>'; }

	if($val=="05") { $string .= '<option value="05" selected="selected">05</option>'; } else {  $string .= '<option value="05">05</option>'; }

	if($val=="06") { $string .= '<option value="06" selected="selected">06</option>'; } else {  $string .= '<option value="06">06</option>'; }

	if($val=="07") { $string .= '<option value="07" selected="selected">07</option>'; } else {  $string .= '<option value="07">07</option>'; }

	if($val=="08") { $string .= '<option value="08" selected="selected">08</option>'; } else {  $string .= '<option value="08">08</option>'; }

	if($val=="09") { $string .= '<option value="09" selected="selected">09</option>'; } else {  $string .= '<option value="09">09</option>'; }

	if($val=="10") { $string .= '<option value="10" selected="selected">10</option>'; } else {  $string .= '<option value="10">10</option>'; }

	

	if($val=="11") { $string .= '<option value="11" selected="selected">11</option>'; } else {  $string .= '<option value="11">11</option>'; }

	if($val=="12") { $string .= '<option value="12" selected="selected">12</option>'; } else {  $string .= '<option value="12">12</option>'; }

	if($val=="13") { $string .= '<option value="13" selected="selected">13</option>'; } else {  $string .= '<option value="13">13</option>'; }

	if($val=="14") { $string .= '<option value="14" selected="selected">14</option>'; } else {  $string .= '<option value="14">14</option>'; }

	if($val=="15") { $string .= '<option value="15" selected="selected">15</option>'; } else {  $string .= '<option value="15">15</option>'; }

	if($val=="16") { $string .= '<option value="16" selected="selected">16</option>'; } else {  $string .= '<option value="16">16</option>'; }

	if($val=="17") { $string .= '<option value="17" selected="selected">17</option>'; } else {  $string .= '<option value="17">17</option>'; }

	if($val=="18") { $string .= '<option value="18" selected="selected">18</option>'; } else {  $string .= '<option value="18">18</option>'; }

	if($val=="19") { $string .= '<option value="19" selected="selected">19</option>'; } else {  $string .= '<option value="19">19</option>'; }

	if($val=="20") { $string .= '<option value="20" selected="selected">20</option>'; } else {  $string .= '<option value="20">20</option>'; }

	

	if($val=="21") { $string .= '<option value="21" selected="selected">21</option>'; } else {  $string .= '<option value="21">21</option>'; }		

	if($val=="22") { $string .= '<option value="22" selected="selected">22</option>'; } else {  $string .= '<option value="22">22</option>'; }

	if($val=="23") { $string .= '<option value="23" selected="selected">23</option>'; } else {  $string .= '<option value="23">23</option>'; }

	if($val=="24") { $string .= '<option value="24" selected="selected">24</option>'; } else {  $string .= '<option value="24">24</option>'; }

	if($val=="25") { $string .= '<option value="25" selected="selected">25</option>'; } else {  $string .= '<option value="25">25</option>'; }

	if($val=="26") { $string .= '<option value="26" selected="selected">26</option>'; } else {  $string .= '<option value="26">26</option>'; }

	if($val=="27") { $string .= '<option value="27" selected="selected">27</option>'; } else {  $string .= '<option value="27">27</option>'; }

	if($val=="28") { $string .= '<option value="28" selected="selected">28</option>'; } else {  $string .= '<option value="28">28</option>'; }

	if($val=="29") { $string .= '<option value="29" selected="selected">29</option>'; } else {  $string .= '<option value="29">29</option>'; }

	if($val=="30") { $string .= '<option value="30" selected="selected">30</option>'; } else {  $string .= '<option value="30">30</option>'; }

	if($val=="31") { $string .= '<option value="31" selected="selected">31</option>'; } else {  $string .= '<option value="31">31</option>'; }

	

	

	return $string;	

}

	

	function dobmonthlist($val="")

	{																					            																									        if($val=="01") { $string .= '<option value="01" selected="selected">January</option>'; } else {  $string .= '<option value="01">January</option>'; }		

		if($val=="02") { $string .= '<option value="02" selected="selected">February</option>'; } else {  $string .= '<option value="02">February</option>'; }

		if($val=="03") { $string .= '<option value="03" selected="selected">March</option>'; } else {  $string .= '<option value="03">March</option>'; }

		if($val=="04") { $string .= '<option value="04" selected="selected">April</option>'; } else {  $string .= '<option value="04">April</option>'; }

		if($val=="05") { $string .= '<option value="05" selected="selected">May</option>'; } else {  $string .= '<option value="05">May</option>'; }

		if($val=="06") { $string .= '<option value="06" selected="selected">June</option>'; } else {  $string .= '<option value="06">June</option>'; }

		if($val=="07") { $string .= '<option value="07" selected="selected">July</option>'; } else {  $string .= '<option value="07">July</option>'; }

		if($val=="08") { $string .= '<option value="08" selected="selected">August</option>'; } else {  $string .= '<option value="08">August</option>'; }

		if($val=="09") { $string .= '<option value="09" selected="selected">September</option>'; } else {  $string .= '<option value="09">September</option>'; }

		if($val=="10") { $string .= '<option value="10" selected="selected">October</option>'; } else {  $string .= '<option value="10">October</option>'; }

		if($val=="11") { $string .= '<option value="11" selected="selected">November</option>'; } else {  $string .= '<option value="11">November</option>'; }

		if($val=="12") { $string .= '<option value="12" selected="selected">December</option>'; } else {  $string .= '<option value="12">December</option>'; }

		

		return $string;	

	}

	

	function dobyearlist($val="")

	{

		$year = date('Y')-0;

		

		for($i=$year; $i>=1950; $i--)

		{

			if($val==$i)

			{

				$string .='<option value="'.$i.'" selected="selected">'.$i.'</option>';

			}

			else

			{

				$string .='<option value="'.$i.'">'.$i.'</option>';

			}

		}

	

	return $string;	

	}
		

	function check_url($value)

	{

		$value = trim($value);

		if (get_magic_quotes_gpc()) 

		{

			$value = stripslashes($value);

		}

		$value = strtr($value, array_flip(get_html_translation_table(HTML_ENTITIES)));

		$value = strip_tags($value);

		$value = htmlspecialchars($value);

		return $value;

	}


function tocheckoldpwdusers($pwd,$id)
{
	global $db;
	$password = md5($pwd);
	$query = "SELECT * FROM `ss_users` WHERE `user_id` = '$id' AND `password` = '$password'";
	$result = $db->query($query);
	$total = $result->num_rows;
	$string = '';
	if($total>0)
	{
		$string = 1;	
	}
	else
	{
		$string = 0;
	}
	return $string;
}
function togetlistofactivedefaultgroupsids($id)
{
	global $db, $baseurl;
	
	$groupid = $_GET["gid"];
	
	$query_gc = "SELECT t1.id, t1.name, t1.subtitle, t2.group_catid, t3.college_id, t1.showinalumni, t1.nameinalumnisection,t1.askbrachname,t1.groupuser FROM  `groups` as t1 INNER JOIN `groups_category_relation` as t2 ON t1.id=t2.group_id INNER JOIN `groups_college` as t3 ON t1.id=t3.group_id WHERE (t1.groupuser = '".$_SESSION['GTUserType']."' OR t1.groupuser = 'B' OR t1.groupuser = 'G') AND t1.status='1' AND t2.group_catid = '".$id."'  AND t3.college_id = '".$_SESSION['GTUserCollegeID']."' GROUP BY t1.id ORDER BY t1.sort_order ASC"; 
	$result_gc = $db->query($query_gc);	
	$totalrows_gc = $result_gc->num_rows;
	$rowlist_gc = $result_gc->rows;
	$j=1; 
	if($totalrows_gc>0)
	{
		$string = array();
		foreach($rowlist_gc as $key => $rowgc) 
		{
			
			$string []= $rowgc["id"];
		}
	
	}
	return $string;
}

function getmoderateuser($gid)
{
	global $db;
	$queryjoin = "SELECT id FROM group_user_join WHERE `status`='0' AND `usertype`='U' AND group_id=".$gid;
	$resultjoin = $db->query($queryjoin);
	return $resultjoin->num_rows;
}


function togetvalidtdl($gid)
{
	global $db;
	$tlds = strtolower($gid);
	
	$queryjoin = "SELECT id FROM user_verification_block_tlds WHERE `tlds`='$tlds' ";
	$resultjoin = $db->query($queryjoin);
	return $resultjoin->num_rows;
}

function togetsubcategorylist($id,$title='')
{
	global $chkvalue, $rwscategory_path, $db;

	$string = '';

	$query="SELECT category_id, name, status FROM category WHERE `parent_id` = '$id' ORDER BY sort_order ";

	$result = $db->query($query);
	$total = $result->num_rows;

	if($total>0)
	{
		$count=1; 
		$rowlist = $rs->rows;
		foreach($rowlist as $key => $row)
		{			
			$status = ($row['status']==1)?"Enable":"Disable";
			$string .= '<tr align="center" class="style22">
			<td>'.$row['category_id'].'</td>
			<td>
			  <input type="checkbox" name="chkuserid['.$row['category_id'].']" value="'.$row['category_id'].'" '.$chkvalue.'></td><td align="left">'.$title.' >> '.$row['name'].'</td>
			<td>'.$status.'</td>
			<td width="10%"><a href="index.php?p=catalog/category-update&id='.$row['category_id'].'">Edit</a></td>
			</tr>';
			
	$rwscategory_path = array();
	getCategoryNameForParentId($row['category_id']);
	$temp_array = array_reverse($rwscategory_path);
	$arraystrtitle = implode(' >> ',$temp_array);
		$string .=togetsubcategorylist($row['category_id'],$arraystrtitle);
		$count++; 
		}
	}
	else
	{
		$string = '';	
	}
	return $string;
}

function togetsubcategorylist2($id,$title='')
{
	global $chkvalue, $rwscategory_path, $db;
	getCategoryNameForParentId($row['id']);
	$temp_array = array_reverse($rwscategory_path);
	$arraystrtitle = implode(' >> ',$temp_array);
	return $arraystrtitle;
}

function todisplaypath($id)
{
    global $rwscategory_path, $db;
	getCategoryNameForParentId($id);
	$temparr = $rwscategory_path;
	/*	print("<pre>");
	print_r($rwscategory_path);
	print("</pre>");*/
	$temp_array = array_reverse($rwscategory_path);
	$string = "";
	$count = count ($temp_array);
	$inc = 1;
	foreach($temp_array as $val)
	{
	 $string .= $val;
	 if($inc < $count)
	 {
	 	 $string .= ' > ';
	 }
	 $inc++;
	}
	return $string;
}

function getCategoryNameForParentId($id = 0) 
{
  global $rwscategory_path, $db;

	$query = 'SELECT service_id, name, parent_id FROM ss_services WHERE service_id="'.$id.'"';
	$result = $db->query($query);
	$total = $result->num_rows;
	$name ='';

	if($total>0)	
	{
		$rowlist = $result->rows;
		foreach($rowlist as $key => $row)
		{
			$rwscategory_path['name_'.$id] = $row['name'];
			$name = $row['name'];
		 	getCategoryNameForParentId($row['parent_id']);
	   }	
	 }
  	return $name;
}

function categorylistforaproducts($package_id)
{
	global $db;
	
	$query = "select c.service_id, c.name from `ss_services` as c inner join `ss_package_services`  as pc on c.service_id = pc.category_id where package_id='$package_id'";
	
    $result = $db->query($query);
	$total = $result->num_rows;
	
	$data = array();

	if($total>0)
	{
		$rowlist = $result->rows;
		foreach($rowlist as $key => $row)
		{

		  $name = todisplaypath($row['service_id']);

		  $data[] = array(
				'name' => $name ,
				'category_id' => $row['service_id']
			);
		}
	}
	return $data;
}

function togetpackagelistadmin($fieldname, $editcatid=0, $others="")
{
	global $db;

	$query = "SELECT package_id as id, package_name FROM ss_packages WHERE package_id>0 ORDER BY package_name ASC";
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	$rowlist = $result->rows;	

	if($editcatid==0 || $editcatid=="") { $topselect = 'selected';  $catid = "";} else { $topselect = 'selected'; $catid = $editcatid; }	

	$string = '<select name="'.$fieldname.'" id="'.$fieldname.'" class="form-control" '.$others.'><option value="" '.$topselect.'> Package Name </option>';

	foreach($rowlist as $key => $row) 
	{ 	
		if($catid==$row["id"])
		{
			$string .='<option value="'.$row["id"].'" selected>'.$row["package_name"].'</option>';
		}
		else
		{
			$string .='<option value="'.$row["id"].'">'.$row["package_name"].'</option>';
		}
	}
	$string .= '</select>';
	return $string;	
}

function togetuseradminrole($fieldname, $editcatid=0, $others="")
{
	global $db;

	$query = "SELECT user_group_id as id, name FROM ss_adminuser_groups WHERE user_group_id>0 ORDER BY name ASC";
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	$rowlist = $result->rows;	

	if($editcatid==0 || $editcatid=="") { $topselect = 'selected';  $catid = "";} else { $topselect = 'selected'; $catid = $editcatid; }	

	$string = '<select name="'.$fieldname.'" id="'.$fieldname.'" class="form-control" '.$others.'><option value="" '.$topselect.'> User Role </option>';

	foreach($rowlist as $key => $row) 
	{ 	
		if($catid==$row["id"])
		{
			$string .='<option value="'.$row["id"].'" selected>'.$row["name"].'</option>';
		}
		else
		{
			$string .='<option value="'.$row["id"].'">'.$row["name"].'</option>';
		}
	}
	$string .= '</select>';
	return $string;	
}

function getservicename($id)
{
	global $db;
	
	$query = "SELECT name FROM ss_services WHERE service_id=$id";
	$result = $db->query($query);
	$row = $result->row;	
	return $row["name"];
}

function getcatdetailshome($id)
{
	global $db;
	
	$query = "SELECT name, service_image FROM ss_services WHERE service_id=$id";
	$result = $db->query($query);
	$row = $result->row;	
	return '<img src="images/servicebg/'.$row["service_image"].'" alt="" />
                <h4>'.$row["name"].'</h4>';
}

function getcatdetailshome2($id)
{
	global $db;
	
	$query = "SELECT name, service_image, description FROM ss_services WHERE service_id=$id";
	$result = $db->query($query);
	$row = $result->row;	
	return '<img src="images/servicebg/'.$row["service_image"].'" alt="" />
                <h2>'.$row["name"].'</h2>
				'.$row["description"].'';
}

function getlistofsubservices($parent_id=0)
{
	global $db, $baseurl;

	$query = "SELECT service_id, name FROM ss_services WHERE parent_id=$parent_id ORDER BY name ASC LIMIT 0, 5";
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	$rowlist = $result->rows;

	$string = '';
	
	if($total_rows>0)
	{
		$string .= '<ul>';
		foreach($rowlist as $key => $row) 
		{ 	
			$string .='<li><a href="'.$baseurl.'services-list.php?service_id='.$row["service_id"].'">'.$row["name"].'</a></li>';			
		}
		$string .= '</ul>';
	}
	return $string;	
}

function getrecentitems()
{
	global $db, $baseurl;

	$query = "SELECT * FROM ss_services_package WHERE services_package_id>0 ORDER BY services_package_id DESC LIMIT 0, 5";
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	$rowlist = $result->rows;

	$string = '';
	
	if($total_rows>0)
	{
		$string .= '';
		foreach($rowlist as $key => $row) 
		{ 	
			$string .='<div class="rws-htsritem">
                	<div class="row"><div class="col-3">
                        	<img src="images/recipeimg/'.$row["image_1"].'" alt="'.$row["title"].'" />                
                        </div>
                        <div class="col-9">
                        	<h5><a href="#">'.$row["title"].'</a></h5>
                        </div></div></div>';			
		}
		$string .= '';
	}
	return $string;	
}

function getrecentitemshome()
{
	global $db, $baseurl;

	$query = "SELECT * FROM ss_services_package WHERE services_package_id>0 ORDER BY services_package_id DESC LIMIT 0, 24";
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	$rowlist = $result->rows;

	$string = '';
	
	if($total_rows>0)
	{
		$string .= '<div class="rws-htsritems">
                	<div class="row">';
		foreach($rowlist as $key => $row) 
		{ 	
			$string .='<div class="col-md-3">
                        	<img src="images/recipeimg/'.$row["image_1"].'" alt="'.$row["title"].'" /> 
							<h5><a href="#">'.$row["title"].'</a></h5>
							<p>'.substr(strip_tags($row["description"]),0,70).'...</p>
							<div class="rws-recipeby">By '.$row["author"].'</div>               
                        </div>';			
		}
		$string .= '</div></div>';
	}
	return $string;	
}

function getlistofsubservicesall($parent_id=0)
{
	global $db, $baseurl;

	$query = "SELECT service_id, name FROM ss_services WHERE parent_id=$parent_id ORDER BY name ASC";
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	$rowlist = $result->rows;

	$categorylist = '';
	
	if($total_rows>0)
	{
		
		foreach($rowlist as $key => $row) 
		{ 	
			$categorylist .="'".$row["service_id"]."',";	
			$categorylist .=getlistofsubservicesall($row["service_id"]);	
		}
		
	}
	return $categorylist;	
}

function getlistofsubservicesalllatcategory($parent_id=0)
{
	global $db, $baseurl;

	$query = "SELECT service_id, name FROM ss_services WHERE parent_id=$parent_id ORDER BY name ASC";
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	$rowlist = $result->rows;

	$categorylist = '';
	
	if($total_rows>0)
	{		
		foreach($rowlist as $key => $row) 
		{ 	
			if(tocheckparentcategory($row["service_id"])==0)
			{
				$categorylist .="'".$row["service_id"]."',";
			}
			else
			{
				$categorylist .=getlistofsubservicesalllatcategory($row["service_id"]);	
			}
		}
		
	}
	return $categorylist;	
}

function tocheckparentcategory($id) 
{
  	global $db;

	$query = 'SELECT service_id FROM ss_services WHERE parent_id="'.$id.'"';
	//echo '<br/>';
	$result = $db->query($query);
	$total = $result->num_rows;
	//echo '<br/>';
	
  	return $total;
}

function tocheckorderschedule($id) 
{
  	global $db;
	$query = 'SELECT service_provider_hour_tracking_id FROM ss_services_provider_hour_tracking WHERE order_id="'.$id.'"';
	$result = $db->query($query);
	$total = $result->num_rows;
  	return $total;
}


function getlistofsubservicesalllavel2($parent_id=0)
{
	global $db, $baseurl;

	$query = "SELECT service_id, name FROM ss_services WHERE parent_id=$parent_id AND status=1 ORDER BY name ASC";
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	$rowlist = $result->rows;

	$categorylist = '';
	
	if($total_rows>0)
	{
		
		foreach($rowlist as $key => $row) 
		{ 	
			$categorylist .="'".$row["service_id"]."',";	
		}
		
	}
	return $categorylist;	
}

function togetcreatecategory($category_name, $parent_id, $level)
{
	global $db, $baseurl;
	

	$query = "SELECT service_id, name FROM ss_services WHERE name='$category_name' AND parent_id=$parent_id AND level=$level";
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	$row = $result->row;
	//echo "<br/>";
	$category_id = '';
	
	if($total_rows>0)
	{		
		$category_id = $row["service_id"];
	}
	else
	{
		// Insert Data to database for unique category name
		$update_query = "INSERT INTO `ss_services` SET `name` = '$category_name', `description`='$category_name', `status` = '1', `parent_id` = '$parent_id', `level` = '$level', `date_added`='$gtcurrenttime'";
		$update_result = $db->query($update_query);
		
		$category_id = $db->getLastId();		
	}
	
	return $category_id;	
}

function togetusereditprofile($userid)
{
	global $db, $baseurl;
	
	$query_check="SELECT signinas FROM `ss_service_provider` WHERE `user_id`=".$userid;
	$rscheck = $db->query($query_check);
	$row = $rscheck->row;
	if($_SESSION['GTUserType']=="C")
	{
		$checkoption = "No";
	}
	else
	{
		if(trim($row["signinas"])!="")
		{
			$checkoption = "No";
		}
		else
		{
			$checkoption = "Yes";
		}
	}
	return $checkoption;
		
}

function togetslotidalreadyscheduled($givendate,$start_time,$end_time)
{
	global $db, $baseurl;
	
	$query = "SELECT service_provider_hour_tracking_id FROM ss_services_provider_hour_tracking WHERE dateofclass='$givendate' AND starttime='$start_time' AND endtime='$end_time'";
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	return $total_rows;	
}

function togetclassschedulestatus($order_id)
{
	global $db, $baseurl;
	
	$query = "SELECT * FROM `ss_services_provider_hour_tracking` WHERE `sp_user_id`='".$_SESSION['GTUserID']."' and `order_id`='$order_id' and `status`!='1' ";
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	return $total_rows;	
}

function togetclassdetails($order_id, $status=1)
{
	global $db, $baseurl;
	
	$query = "SELECT * FROM `ss_services_provider_hour_tracking` WHERE `sp_user_id`='".$_SESSION['GTUserID']."' and `order_id`='$order_id' and `status`='$status' ";
	$result = $db->query($query);
	$rowlist = $result->rows;
	
	$stringhtml = "";
	
	foreach($rowlist as $key => $value) 
	{
		$stringhtml .= '<div style="padding-bottom:5px; width:100%; clear:both; overflow:hidden;">'.$value["dateofclass"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From&nbsp;&nbsp;<em>'.date("h A", strtotime($value["dateofclass"].' '.$value["starttime"])).'</em>&nbsp;&nbsp;To&nbsp;&nbsp;<em>'.date("h A", strtotime($value["dateofclass"].' '.$value["endtime"])).'</em></div>';		
	}
	
	return $stringhtml;
							
}

function togetclassdetailscompleted($order_id, $status=1)
{
	global $db, $baseurl;
	
	$query = "SELECT * FROM `ss_services_provider_hour_tracking` WHERE `sp_user_id`='".$_SESSION['GTUserID']."' and `order_id`='$order_id' and `status`='$status' ";
	$result = $db->query($query);
	
	$total_rows = $result->num_rows;
	
	$query1 = "SELECT * FROM `ss_services_provider_hour_tracking` WHERE `sp_user_id`='".$_SESSION['GTUserID']."' and `order_id`='$order_id'";
	$result1 = $db->query($query1);
	
	$total_rows1 = $result1->num_rows;
	
	if($total_rows==$total_rows1)
	{
		$sendmail = 1;	
	}
	else
	{
		$sendmail = 0;	
	}
	
	return $sendmail;
							
}


function tocheckorderreviewstatus($order_id)
{
	global $db, $baseurl;
	
	$query = "SELECT * FROM `ss_services_provider_ratings` WHERE `order_id`='$order_id' ";
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	return $total_rows;	
}

function togetuserlistcriteria($usertype)
{
	global $db, $baseurl;
	if($usertype!="") 
	{ 
		if($usertype=="B")
		{
			$query = "SELECT user_id FROM `ss_users` WHERE `user_type`='$usertype' "; 
		}
		else
		{
			$query = "SELECT user_id FROM `ss_users` WHERE `user_type`='$usertype' OR `user_type`='B' "; 
		}
	
	} 
	else { $query = "SELECT user_id FROM `ss_users` "; }
	
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	return $total_rows;	
}

function togetorderlistcriteria($condition)
{
	global $db, $baseurl;
	$query = "SELECT order_id FROM `ss_consumer_order` $condition ";
	
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	return $total_rows;	
} 

function togetorderhourscriteria($condition)
{
	global $db, $baseurl;
	$query = "SELECT sum(totalhours) as totalhours FROM `ss_consumer_order` $condition ";
	
	$result = $db->query($query);
	$row = $result->row;
	return $row["totalhours"];	
} 

function togetorderhourschedule($condition)
{
	global $db, $baseurl;
	$query = "SELECT service_provider_hour_tracking_id FROM `ss_services_provider_hour_tracking` $condition ";
	
	$result = $db->query($query);
	$total_rows = $result->num_rows;
	return $total_rows;	
} 
		
?>