<!-- -->
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1" />
<title>all shows | bayareamusicguide.com</title>
<link href="mpasciucco.css" rel="stylesheet" type="text/css" />
</head>
<body>
<a name="top"></a>
<div class="border"><div align="center"><a href="/"><img src="logo5a.png" /></a></div></div>
<div class="background">
<h2>all shows / <a href="venueinfo.php?venueid=0&showid=0">venue info</a> / <a href="other.php">other</a></h2><br /><br />

<div align="center">
<form method="get" action="search.php">
	<input STYLE="color: #000; font-family: Verdana; font-size: 14px; background-color: #fff;" id="textField" type="text" name="band" maxlength="25" placeholder="band name..." />
</form>
</div><br /><br />

<?php
include_once("db_connect.php");

//adding DB items to webpage
$week1 = "+" . "0" . " week";
$week2 = "+" . "1" . " week";

$today = date("Y-m-d");

$newdate1 = strtotime ($week1, strtotime ($today)) ;
$newdate1 = date ('Y-m-d' , $newdate1);

$newdate1a = strtotime ($week1, strtotime ($today)) ;
$newdate1a = date ('m-d-Y' , $newdate1a);

$newdate2 = strtotime ($week2, strtotime ($today)) ;
$newdate2 = date ('Y-m-d' , $newdate2);

echo "<div class=\"weekof\">week of: [" . $newdate1a . "]</div></div>";

$check2 = mysql_query("SELECT * FROM show_info where show_date >= \"$newdate1\" and show_date < \"$newdate2\" ORDER BY show_date,venue_name")or die(mysql_error());

while($show_info = mysql_fetch_array($check2)) {
	$test = $show_info['venue_name'];
	$check1 = mysql_query("SELECT active FROM venue_info where venue_name=\"$test\"")or die(mysql_error());
	$venue_info = mysql_fetch_array($check1);

	if ($venue_info['active']==1) {
		echo "<a href=\"venueinfo.php?venueid=" . $show_info['venueid'] . "&showid=" . $show_info['showid'] . "\"><div class=\"post_meta\"><table><tr><td style=\"height:10px; width:70px;background-color:#808080;\">";

		$day = date("D",strtotime($show_info['show_date']));
		$date = date("d",strtotime($show_info['show_date']));
		$month = date("M",strtotime($show_info['show_date']));
		$year = date("Y",strtotime($show_info['show_date']));

		echo "<div class=\"date\">$date</div><div class=\"month\">" . strtoupper($month) . " </div><div class=\"day\">$day</div></td>";
		//echo $show_info['show_ttime'] . "</div></td>";
		echo "<td style=\"width:400px;\"><b>[" . $show_info['venue_name'] . "]</b><br />" . $show_info['bands'];

		echo "</td><td><img src=arrow2.png /></td></tr></table>";
		echo "</div></a>";

	}//

}//while

$prev = 0;
$next = 2;

echo "<table width=\"100%\"><tr><td align=\"left\" width=\"50%\"></td>";
echo "<td align=\"right\" width=\"50%\"><a class=\"yellowBtn\" href=\"allshows.php?page=$next\">NEXT week ></a></td></tr></table>";
mysql_close($db_handle);

?>
<br /><br />

<div class="footer"><a href="#top">TOP</a><hr /></div>

<div class="footer"><a href="mailto:mario@bayareamusicguide.com">mario@bayareamusicguide.com</a><br />
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
