<?php
set_error_handler('myHandler');
function myHandler() {include "error.php";}
$venueid = $_GET['venueid'];
$showid = $_GET['showid'];
?>

<!--  -->
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1" />
<title>venue info | bayareamusicguide.com</title>
<link href="mpasciucco.css" rel="stylesheet" type="text/css" />
</head>
<body>
<a name="top"></a>
<div class="border"><div align="center"><a href="/"><img src="logo5a.png" /></a></div></div>
<div class="background">
<h2><a href="allshows.php?page=1">all shows</a> / <a href="venueinfo.php?venueid=0&showid=0">venue info</a> / <a href="other.php">other</a></h2><br /><br />

<div align="center">
<form method="get" action="search.php">
	<input STYLE="color: #000; font-family: Verdana; font-size: 14px; background-color: #fff;" id="textField" type="text" name="band" maxlength="25" placeholder="band name..." />
</form>
</div><br /></div>

<?php
$today = date("Y-m-d");
$startdate = strtotime ("+0 day", strtotime ($today)) ;
$startdate = date ('Y-m-d' , $startdate);

//include_once("db_connect.php");


//***** venueinfo ONLY
if ($venueid=="0" & $showid=="0") {

//adding DB items to webpage
$check1 = mysql_query("SELECT * FROM venue_info where active=1")or die(mysql_error());


//display venue info
while($venue_info = mysql_fetch_array($check1)) {

echo "<a href=\"venueinfo.php?venueid=" . $venue_info['venueid'] . "&showid=0\">";
echo "<div class=\"post_meta\"><table><tr><td style=\"width:400px;\">". $venue_info['venue_name'];
echo "</td><td><img src=arrow2.png /></td></tr></table></div></a>";
}//while


}//if
//***** venueinfo ONLY


else {
//adding DB items to webpage
$check1 = mysql_query("SELECT * FROM venue_info where venue_name=\"$venueid\"")or die(mysql_error());
if ($showid=="0") $check2 = mysql_query("SELECT * FROM show_info where venue_name=\"$venueid\" and show_date >= \"$startdate\" ORDER BY show_date")or die(mysql_error());
else $check2 = mysql_query("SELECT * FROM show_info where venue_name=\"$venueid\" and showid=$showid and show_date >= \"$startdate\" ORDER BY show_date")or die(mysql_error());


//***display venue info
while($venue_info = mysql_fetch_array($check1)) {

echo "<div class=\"post_meta\"><table><tr><td style=\"width:60px;\">";
echo "<img src=\"" . $venue_info['img_url'] . "\" width=\"60\" height=\"75\" /></td><td>";
echo "<a name=\"" . $venue_info['venue_name'] . "\"></a><b>" . $venue_info['venue_name'] . "</b><br />";
echo $venue_info['venue_addr'] . "<br /></td></tr><tr><td><br />";
echo "<img src=\"info1.png\" width=\"58\" height=\"58\" /><td><hr />";
echo "<img src=\"www.jpg\" width=\"16\" height=\"16\" /> " . $venue_info['venue_url_a'] . "<br />";
echo "<img src=\"yelp.jpg\" width=\"16\" height=\"16\" /> " . $venue_info['yelp_url'] . "<br />";
echo "<img src=\"google.jpg\" width=\"16\" height=\"16\" /> " . $venue_info['google_url'] . "<br />";
echo "<img src=\"apple.jpg\" width=\"16\" height=\"16\" /> " . $venue_info['apple_url'] . "";
echo "</td></tr></table></div><hr /><br />";
//***display venue info


//***display show info for venue - list all or just one show
while($show_info = mysql_fetch_array($check2)) {
if ($showid=="0") echo "<div class=\"post_meta\"><table><tr><td style=\"height:10px; width:70px;background-color:#808080;\">";
else echo "<div class=\"post_meta\"><table><tr><td style=\"height:10px; width:70px;background-color:#900;\">";

$day = date("D",strtotime($show_info['show_date']));
$day_full = date("l",strtotime($show_info['show_date']));
$date = date("d",strtotime($show_info['show_date']));
$month = date("M",strtotime($show_info['show_date']));
$year = date("Y",strtotime($show_info['show_date']));

echo "<div class=\"date\">$date</div><div class=\"month\">" . strtoupper($month) . " </div><div class=\"day\">$day</td>";
echo "<td>" . $show_info['bands'] . "<br /><img src=\"www.jpg\" width=\"16\" height=\"16\" /> ";
echo "<a href=\"venueinfo.php?venueid=" . $show_info['venueid'] . "&showid=" . $show_info['showid'] .  "\">link to show</a><br />";
echo "<img src=\"email.jpg\" width=\"16\" height=\"16\" /> ";


//email link
$email_date = strtotime ("+0 day", strtotime ($show_info['show_date'])) ;
$email_date = date ('F d, Y' , $email_date);

$linereturn="%0A";
echo "<a href=\"mailto:?subject=check out this event&body=" . $email_date . $linereturn . $linereturn;
//echo "<a href=\"mailto:?subject=look who's playing @venue, [date]&body=" . $email_date . $linereturn . $linereturn;//'
echo "[" . $show_info['venue_name'] . "]" . $linereturn . $show_info['bands']. $linereturn . $venue_info['venue_url'];
echo "\">tell a friend</a>";
echo "<br /><td></tr></table>";
echo "</div><br />";
//***display show info for venue - list all or just one show

}//while


//if ($venue_info['cash_only'] == true) echo "<img src=\"cash.png\" width=\"16\" height=\"16\" /> - cash only<br />";
//if ($venue_info['atm'] == true) echo "<img src=\"atm.jpg\" width=\"16\" height=\"16\" /> - atm<br />";
//if ($venue_info['food'] == true) echo "<img src=\"food2.png\" width=\"16\" height=\"16\" /> - food<br />";

echo "</td></tr></table></div>";
}//while


//***display show info for venue - list all shows, if showid NOT 0
if ($showid!="0") {
	$check2 = mysql_query("SELECT * FROM show_info where venue_name=\"$venueid\" and show_date >= \"$startdate\" ORDER BY show_date")or die(mysql_error());

	echo "<br /><br /><div class=\"weekof\"><b>[all shows]</b></div><br />";

	//***display show info for venue
	while($show_info = mysql_fetch_array($check2)) {
	echo "<div class=\"post_meta\"><table><tr><td style=\"height:10px; width:70px;background-color:#808080;\">";

	$day = date("D",strtotime($show_info['show_date']));
	$day_full = date("l",strtotime($show_info['show_date']));
	$date = date("d",strtotime($show_info['show_date']));
	$month = date("M",strtotime($show_info['show_date']));
	$year = date("Y",strtotime($show_info['show_date']));

	echo "<div class=\"date\">$date</div><div class=\"month\">" . strtoupper($month) . " </div><div class=\"day\">$day</td>";
	echo "<td>" . $show_info['bands'] . "<br /><img src=\"www.jpg\" width=\"16\" height=\"16\" /> ";
	echo "<a href=\"venueinfo.php?venueid=" . $show_info['venueid'] . "&showid=" . $show_info['showid'] .  "\">link to show</a><br />";
	echo "<img src=\"email.jpg\" width=\"16\" height=\"16\" /> ";


	//email link
	$email_date = strtotime ("+0 day", strtotime ($show_info['show_date'])) ;
	$email_date = date ('F d, Y' , $email_date);

	$linereturn="%0A";
	echo "<a href=\"mailto:?subject=check out this event&body=" . $email_date . $linereturn . $linereturn;
	echo "[" . $show_info['venue_name'] . "]" . $linereturn . $show_info['bands']. $linereturn . $venue_info['venue_url'];
	echo "\">tell a friend</a>";
	echo "<br /><td></tr></table>";
	echo "</div><br />";
//***display show info for venue - list all shows, if showid NOT 0
}//while

}//if
//***list rest of shows



}//else

mysql_close($db_handle);

?>
<br /><br />

<div class="footer"><a href="#top">TOP</a><hr /></div>
<div class="footer"><a href="mailto:mario@bayareamusicguide.com?">mario@bayareamusicguide.com</a><br />
*optimized for iOS, droid</div>

<script type="text/javascript">
function hideAddressBar()
{
    if(!window.location.hash)
    {
        if(document.height <= window.outerHeight + 10)
        {
            document.body.style.height = (window.outerHeight + 50) +'px';
            setTimeout( function(){ window.scrollTo(0, 1); }, 50 );
        }
        else setTimeout( function(){ window.scrollTo(0, 1); }, 0 );
    }
}
window.addEventListener("load", hideAddressBar );
</script>

</body>
</html>
