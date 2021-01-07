<?php session_start();
error_reporting('E_WARNING & ~E_NOTICE');
include("database.php");
// get the driver and include the class file
if(DB_DRIVER=='mysqli'){
	include("db/drivermysqli.php");
}
$db = new database(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// mysql char set
//mysql_set_charset('utf8');
date_default_timezone_set('Asia/Calcutta');
$basedir = 'E:/xampp/htdocs/allrecepies/website/';
$baseurl = 'http://localhost/allrecepies/website/';
$baseurl_img = 'http://localhost/allrecepies/website/';

/* SPAM Check Code */

$gt_exploits = "/(content-type|bcc:|cc:|document.cookie|onclick|onload|javascript|alert)/i";
$gt_profanity = "/(beastial|bestial|blowjob|clit|cum|cunilingus|cunillingus|cunnilingus|cunt|ejaculate|fag|felatio|fellatio|fuck|fuk|fuks|gangbang|gangbanged|gangbangs|hotsex|jism|jiz|orgasim|orgasims|orgasm|orgasms|phonesex|phuk|phuq|porn|pussies|pussy|spunk|xxx)/i";
$gt_spamwords = "/(viagra|phentermine|tramadol|adipex|advai|alprazolam|ambien|ambian|amoxicillin|antivert|blackjack|backgammon|texas|holdem|poker|carisoprodol|ciara|ciprofloxacin|debt|dating|porn)/i";
$bots = "/(Indy|Blaiz|Java|libwww-perl|Python|OutfoxBot|User-Agent|PycURL|AlphaServer)/i";

if (preg_match($bots, $_SERVER['HTTP_USER_AGENT'])) {
	exit("<p>Known spam bots are not allowed.</p>");
}

/* SPAM Check Code */

include("functions.php");
include("infoarray.php");

/* Admin Panel Config Starts*/
	$sitename = 'All Recipes';
	$admin_name = 'All Recipes';
	$admin_title = 'All Recipes - Admin';
	$admin_copyright = '';
	$admin_copyright = '';
	$admin_toemail = 'wdrangnath@gmail.com';
	$admin_toname = 'All Recipes Buy';
	$admin_fromemail = 'admin@clientsdisplay.com';
	$admin_fromname = 'All Recipes - Admin';
	$invoice_prefix = 'SS-';
	$admin_support_mobile = '+91-95558 88610';
	$copyrightmsg = '<a href="'.$baseurl.'" title="All Recipes">&copy; All Recipes</a>';
/* Admin Panel Config Ends*/

$emailheader = '<div style="padding:30px; text-align:center; width:800px; max-width:800px; min-width:600px; background:#e0e4e5;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background:#FFF; width:600px;" align="center";>
  <tr>
    <td style="padding-bottom:10px; border-bottom:1px solid #ddd; height:100px; font-size:40px; background:url('.$baseurl.'images/LogoText1.png) no-repeat center top;">All Recipes</td>
  </tr>';

$emailfooter = '<tr>
    <td style="padding-bottom:10px; padding-top:10px; border-top:1px solid #ddd; height:29px;"><a href="'.$baseurl.'" title="All Recipes">&copy; All Recipes</a></td>
  </tr>
</table>

</div>';

?>