<table width="680" align="center">
    <?php
function limit_text($text, $limit)
{
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}
$SWlat      = $_POST["SWlat"];
$SWlng      = $_POST["SWlng"];
$NElat      = $_POST["NElat"];
$NElng      = $_POST["NElng"];
$start_time = $_POST["starttime"];
$end_time   = $_POST["endtime"];
$event_date = $_POST["event_date"];

$return_arr = array();

//==============================PAGINATION START SCRIPT=======================================//
  $sql ="SELECT * from events where event_lat > '$SWlat' and event_lat < '$NElat' and event_long < '$NElng' and event_long > '$SWlng' and start_time >= '$start_time' and end_time <= '$end_time' and start_date = '$event_date'";
//$stmt = $pdo->prepare("SELECT * from event_locations where event_lat > ? and event_lat < ? and event_long < ? and event_long > ? limit 10");
/*
$stmt->bindValue(1, $SWlat, PDO::PARAM_STR);
$stmt->bindValue(2, $NElat, PDO::PARAM_STR);
$stmt->bindValue(3, $NElng, PDO::PARAM_STR);
$stmt->bindValue(4, $SWlng, PDO::PARAM_STR);
$stmt->bindValue(5, $start_time, PDO::PARAM_STR);
$stmt->bindValue(6, $end_time, PDO::PARAM_STR);
$stmt->bindValue(7, $event_date, PDO::PARAM_STR);
$stmt->execute();*/
$res = $DB->RunSelectQuery($sql);
if(is_array($res))
{
	$a   = count($res);
}
else
{
	$a = 0;
}


$numrows     = $a;
// number of rows to show per page
$rowsperpage = 20;
// find out total pages
$totalpages  = ceil($numrows / $rowsperpage);

// get the current page or set a default
if (isset($_POST['currentpage']) && is_numeric($_POST['currentpage'])) {
    // cast var as int
    $currentpage = (int) $_POST['currentpage'];
} else {
    // default page num
    $currentpage = 1;
} // end if

// if current page is greater than total pages...
if ($currentpage > $totalpages) {
    // set current page to last page
    $currentpage = $totalpages;
} // end if
// if current page is less than first page...
if ($currentpage < 1) {
    // set current page to first page
    $currentpage = 1;
} // end if

// the offset of the list, based on current page
$offset = ($currentpage - 1) * $rowsperpage;
 $sql1 = "SELECT * from events where event_lat > '$SWlat' and event_lat < '$NElat' and event_long < '$NElng' and event_long > '$SWlng' and start_time >= '$start_time' and end_time <= '$end_time' and start_date = '$event_date' LIMIT $offset, $rowsperpage";

$res_data = $DB->RunSelectQuery($sql1);

$i = 1;

?>

    <tr><td colspan="2"><table align="center"><tr><td><div style="background:#C33; padding:3px; border-radius:3px; color:#FFF; font-family: Arial; font-size:15px; display:inline-block; margin:0 auto"><?
if ($SWlat !== 0) {
    if ($a > 0) {
?>Showing events and pings <strong><?= ($offset + 1) ?> - <?
        $lastnumber = $currentpage * $rowsperpage;
        if ($lastnumber < $a) {
            echo $lastnumber;
        } else if ($lastnumber > $a) {
            echo $a;
        }
?></strong> of <?= $a ?> records<?
    } else {
?>No events or pings found within the displayed location area, time range and date.<br />Please search again <strong>OR</strong> see our suggested events and pings below.<?
    }
}
?></div><br /><br /></td></tr></table></td></tr><tr>
        <?

foreach ($res_data as $result) {
    $result = (array) $result;
    $userid = $result["user_id"];
?>
       <td width="660">

            <!----------------------IF EVENT IS AN EVENT---------------------------------->
            <?php
    if ($result["entry_type"] == "") {
?>
               <table class="tableshadowbox" style="padding:10px" cellpadding="0" cellspacing="0" width="315" align="center" onclick="window.open('<?php print CreateURL('index.php',"mod=event&do=eventdetails&eventid=".$result["event_id"]);?>')">
                    <tr><td>
                            <?php
        $sql2     = "SELECT * from public_users where id=$userid";
        $res_user = $DB->RunSelectQuery($sql2);
        
        foreach ($res_user as $resultuser) {
            $resultuser = (array) $resultuser;
?>
                               <table cellpadding="0" cellspacing="0" width="315" style="cursor:pointer">
                                    <tr><td width="40px" align="left">
                                            <?php
            if ($resultuser["profile_pic"] == "") {
?>
                                               <img width="35" height="35" style="border-radius:17.5px" src="images/no_profile_pic.gif" />
                                            <?php
            } else {
?>
                                               <img width="35" height="35" style="border-radius:17.5px" src="<?
                echo ROOTURL.'/'.$resultuser["profile_pic"];
?>" />
                                            <?php
            }
?>
                                       </td><td width="200">
                                            <font class="ArialVeryDarkGreyBold15">&nbsp;&nbsp;&nbsp;<?
            echo $resultuser["firstname"] . " " . $resultuser["lastname"];
?></font><br />
                                            <div style="height:4px"></div>
                                            <?php
            $sql3    = "SELECT * from event_types where id=" . $result["event_category"];
            $res_cat = $DB->RunSelectQuery($sql3);      foreach ($res_cat as $resultcat) {
                $resultcat = (array) $resultcat;
?>
                                               <font class="ArialVeryDarkGrey13" style="color:#666">&nbsp;&nbsp;&nbsp;is organising a <?= $resultcat["event_type"] ?> event</font>
                                            <?
            }
?>
                                       </td>
                                        <td></td>
                                    </tr>
                                </table>
                            <?
        }
?>
                       </td></tr>
                    <tr><td height="60" valign="top"><br /><font class="ArialVeryDarkGrey18">
                                <?
        $str = wordwrap($result["event_name"], 50);
        $str = explode("\n", $str);
        $str = $str[0] . '...';
        echo $str;
?></font>
                        </td></tr>
                    <tr>
                    <?php
        
        if (file_exists(ROOTURL.'/'.$result["event_photo"])) {
            $event_image = ROOTURL.'/'.$result["event_photo"];
        } else {
            $event_image = ROOTURL.'/'.'images/noeventimage.jpg';
        }
?>
                       <td height="250" valign="middle"><img width="310" src="<?php
        echo $event_image;
?>" /><br />
                        </td></tr>
                    <tr><td>
                            <table cellpadding="0" cellspacing="0" width="315">
                                <tr>
                                    <td align="left" width="25%" valign="middle">
                                        <font class="ArialOrange18" style="font-size:30px"><?
        if ($result["event_price"] < 1) {
            echo "Free";
        } else {
            echo "S$" . $result["event_price"];
        }
?></font>&nbsp;&nbsp;<br />
                                    <td align="left" valign="middle">
                                        <font class="ArialVeryDarkGreyBold15">&nbsp;&nbsp;&nbsp;<?= date("j F Y", strtotime($result["start_date"])) ?></font><br />
                                        <font class="ArialVeryDarkGrey15">&nbsp;&nbsp;&nbsp;<?
        echo date("g:ia", strtotime($result["start_time"])) . " - " . date("g:ia", strtotime($result["end_time"]));
?></font><br />
                                    </td></tr>
                                <tr><td height="100" colspan="3" valign="top">
                                        <div style="height:10px"></div>
                                        <?
        $sql4          = "SELECT * from event_locations where event_id=" . $result["event_id"];
        $res_event_loc = $DB->RunSelectQuery($sql4);
        foreach ($res_event_loc as $resultloc) {
            $resultloc = (array) $resultloc;
?>
                                           <table cellpadding="0" cellspacing="0"><tr><td><img src="images/marker_pin.jpg" /></td><td><font class="ArialVeryDarkGrey13" style="color:#666">&nbsp;&nbsp;<?= $resultloc["event_location"] ?></font>
                                                    </td></tr></table>
                                        <?
        }
?>
                                       <div style="height:10px"></div><font class="ArialVeryDarkGrey15">
                                            <?
        $str = wordwrap($result["event_description"], 100);
        $str = explode("\n", $str);
        $str = $str[0] . '...';
        echo $str;
?></font>
                                    </td></tr>
                            </table>
                        </td>
                    </tr></table>

                <!----------------------IF EVENT IS A PING---------------------------------->
            <?
    } else if ($result["entry_type"] == "Ping") {
?>
               <table class="tableshadowbox" style="padding:10px" cellpadding="0" cellspacing="0" width="315" align="center" onclick="window.open('<?php print CreateURL('index.php',"mod=ping&do=pingdetails&eventid=".$result["event_id"]);?>')">
<!--                   onclick="window.open('pingdetails.php?eventid=--><?//= $result["event_id"] ?><!--')">-->
                    <tr><td>
                            <?
        $sql5     = "SELECT * from public_users where id=$userid";
        $res_user = $DB->RunSelectQuery($sql5);
        foreach ($res_user as $resultuser) {
            $resultuser = (array) $resultuser;
?>
                               <table cellpadding="0" cellspacing="0" width="315" style="cursor:pointer">
                                    <tr><td width="40px" align="left">
                                            <?
            if ($resultuser["profile_pic"] == "") {
?>
                                               <img width="35" height="35" style="border-radius:17.5px" src="images/no_profile_pic.gif" />
                                            <?
            } else {
?>
                                               <img width="35" height="35" style="border-radius:17.5px" src="<?
                echo ROOTURL.'/'.$resultuser["profile_pic"];
?>" />
                                            <?
            }
?>
                                       </td><td width="200">
                                            <font class="ArialVeryDarkGreyBold15">&nbsp;&nbsp;&nbsp;<?
            echo $resultuser["firstname"] . " " . $resultuser["lastname"];
?></font><br />
                                            <div style="height:4px"></div>
                                            <?
            $sql6 = "SELECT * from event_types where id=" . $result["event_category"];
            
            $res_event_type = $DB->RunSelectQuery($sql6);
            foreach ($res_event_type as $resultcat) {
                $resultcat = (array) $resultcat;
?>
                                               <font class="ArialVeryDarkGrey13" style="color:#666">&nbsp;&nbsp;&nbsp;has pinged a <?= $resultcat["event_type"] ?> meetup</font>
                                            <?
            }
?>
                                       </td>
                                        <td></td>
                                    </tr>
                                </table>
                            <?
        }
?>
                       </td></tr>
                    <tr>
                        <td height="250" valign="middle"><img width="310" src="<?php
        echo ROOTURL.'/'.$result["event_photo"];
?>" /><br />
                        </td></tr>
                    <tr><td>
                            <table cellpadding="0" cellspacing="0" width="315">
                                <tr>
                                    <td height="80" align="left" valign="middle"><font class="ArialVeryDarkGrey18">
                                            <?
        $str = wordwrap($result["event_name"], 50);
        $str = explode("\n", $str);
        $str = $str[0] . '...';
        echo $str;
?>
                                       </font>
                                </tr>
                                <tr>
                                    <td align="left" valign="middle">&nbsp;&nbsp;&nbsp;<font class="ArialVeryDarkGreyBold15"><?= date("j F Y", strtotime($result["start_date"])) ?></font><br />
                                        <font class="ArialVeryDarkGrey15">&nbsp;&nbsp;&nbsp;<?
        echo date("g:ia", strtotime($result["start_time"])) . " - " . date("g:ia", strtotime($result["end_time"]));
?></font></tr>
                                <tr><td height="40" colspan="2" valign="top">
                                        <div style="height:10px"></div>
                                        <?
        $sql7 = "SELECT * from ping_locations where event_id=" . $result["event_id"];
        
        $res_ping_loc = $DB->RunSelectQuery($sql7);
        
        
        foreach ($res_ping_loc as $resultloc) {
            $resultloc = (array) $resultloc;
?>
                                           <table cellpadding="0" cellspacing="0"><tr><td><img src="images/marker_pin.jpg" /></td><td><font class="ArialVeryDarkGrey13" style="color:#666">&nbsp;&nbsp;<?php
            echo $resultloc["event_location"];
?></font>
                                                    </td></tr></table>
                                        <?php
        }
?></td></tr>
                                <tr>
                                    <td height="40" colspan="2" align="right" valign="middle"><input class="standardbutton" style="cursor:pointer" type="submit" name="joinmeetupbtn" id="joinmeetupbtn" value="Join meetup" />
                                        &nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr></table>

            <?
    }
?>

            <br />
            <?
    if ($i % 2 == 0) {
?>
       </td></tr><tr>
        <?
        $i = 1;
    } else {
?>
           </td>
            <?
        $i++;
    }
}


?>
   </tr>
    <tr>
        <td colspan="2" align="center">
            <?
if ($a > 0) {
    /******  build the pagination links ******/
    // range of num links to show
    $range = 3;
    
    // if not on page 1, don't show back links
    if ($currentpage > 1) {
        // show << link to go back to page 1
        //echo '<div class="tableshadowbox" style="background:#FFF; color:#333; font-family:Arial; font-size:15px; height:20px; width:90px" onclick="show_more_events(1)"><div style="height:5px"></div>First page</div> ';
        // get previous page num
        $prevpage = $currentpage - 1;
        // show < link to go back to 1 page
        echo '<div class="pagebutton" style="cursor:pointer; display:inline-block; height:25px; width:60px" onclick="show_more_events(' . $prevpage . ')"><div style="height:3px"></div>Previous</div>&nbsp;&nbsp;&nbsp;';
    } // end if
    
    // loop to show links to range of pages around current page
    for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
        // if it's a valid page number...
        if (($x > 0) && ($x <= $totalpages)) {
            // if we're on current page...
            if ($x == $currentpage) {
                // 'highlight' it but don't make a link
                echo '<div style="display:inline-block; background:#D93600; color:#FFF; font-family:Arial; font-size:15px; height:30px; width:30px; border-radius:3px"><div style="height:5px"></div>' . $x . '</div>&nbsp;&nbsp;&nbsp;';
                // if not current page...
            } else {
                // make it a link
                echo '<div class="pagebutton" style="cursor:pointer; display:inline-block; height:25px; width:20px" onclick="show_more_events(' . $x . ')"><div style="height:3px"></div>' . $x . '</div>&nbsp;&nbsp;&nbsp;';
            } // end else
        } // end if
    } // end for
    
    // if not on last page, show forward and last page links
    if ($currentpage != $totalpages) {
        // get next page
        $nextpage = $currentpage + 1;
        // echo forward link for next page
        echo '<div class="pagebutton" style="cursor:pointer; display:inline-block; height:25px; width:90px" onclick="show_more_events(' . $nextpage . ')"><div style="height:3px"></div>More Events</div>&nbsp;&nbsp;&nbsp;';
        // echo forward link for lastpage
        //echo '<div class="tableshadowbox" style="background:#FFF; color:#333; font-family:Arial; font-size:15px; height:20px; width:70px" onclick="show_more_events('.$totalpages.')">Last page</div> ';
    } // end if
    /****** end build pagination links ******/
}
?>
           <div style="height:10px"></div>
        </td></tr>
</table>
<p></p>
<table width="680" align="center"><tr><td>
            <?php
$sql8                = "SELECT * from events where start_date = $event_date order by rand() limit 3";
$res_suggested_event = $DB->RunSelectQuery($sql8);
if(is_array($res_suggested_event))
{
$a = count($res_suggested_event);
}
else
{
	$a =0;
}
$i = 1;
?>
           <table align="center"><tr><td><font class="ArialVeryDarkGreyBold18">Suggested events</font></td></tr></table>
            <br /></td></tr><tr><td>
            <?
if ($a > 0) {
    $recordcount = 0;
    foreach ($res_suggested_event as $result) {
        $result = (array) $result;
        $recordcount++;
        $userid = $result["user_id"];
?>

                <div style="display:inline-block; width:220px"><table class="tableshadowbox" style="padding:10px" cellpadding="0" cellspacing="0" width="200" align="left" onclick="window.open('<?php print CreateURL('index.php',"mod=event&do=eventdetails&eventid=".$result["event_id"]);?>eventdetails.php?eventid=<?= $result["event_id"] ?>')">
                        <tr><td>
                                <?php
        $sql5     = "SELECT * from public_users where id=$userid";
        $res_user = $DB->RunSelectQuery($sql5);
        foreach ($res_user as $resultuser) {
            $resultuser = (array) $resultuser;
?>
                                   <table width="195" align="center" cellpadding="0" cellspacing="0" style="cursor:pointer">
                                        <tr>
                                            <td width="35" align="left">
                                                <?
            if ($resultuser["profile_pic"] == "") {
?>
                                                   <img width="30" height="30" style="border-radius:17.5px" src="images/no_profile_pic.gif" />
                                                <?
            } else {
?>
                                                   <img width="30" height="30" style="border-radius:17.5px" src="<?
                echo ROOTURL.'/'.$resultuser["profile_pic"];
?>" />
                                                <?
            }
?>
                                           </td><td width="200">
                                                <font class="ArialVeryDarkGreyBold15"><?
            echo $resultuser["firstname"] . " " . $resultuser["lastname"];
?></font><br /></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                <?
        }
?>
                           </td></tr>
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr><td valign="top"><font class="ArialVeryDarkGrey15">
                                    <?
        $str = wordwrap($result["event_name"], 50);
        $str = explode("\n", $str);
        $str = $str[0] . '...';
        echo $str;
?></font>
                            </td></tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <tr>
                            <td height="170" align="center" valign="middle"><img width="200" src="http://www.locoyolo.com/<?= $result["event_photo"] ?>" /></td></tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <tr><td>
                                <table width="200" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="left" width="25%" valign="middle">
                                            <font class="ArialOrange18" style="font-size:20px"><?
        if ($result["event_price"] < 1) {
            echo "Free";
        } else {
            echo "S$" . $result["event_price"];
        }
?></font>&nbsp;&nbsp;<br />
                                        <td align="left" valign="middle">
                                            <font class="ArialVeryDarkGreyBold15">&nbsp;&nbsp;&nbsp;<?= date("j F Y", strtotime($result["start_date"])) ?></font><br />
                                            <font class="ArialVeryDarkGrey15">&nbsp;&nbsp;&nbsp;<?
        echo date("g:ia", strtotime($result["start_time"])) . " - " . date("g:ia", strtotime($result["end_time"]));
?></font><br />
                                        </td></tr>
                                    <tr><td height="40" colspan="3" valign="top">
                                            <div style="height:10px"></div>
                                            <?
        $sql9      = "SELECT * from event_locations where event_id=" . $result["event_id"];
        $event_loc = $DB->RunSelectQuery($sql9);
        foreach ($event_loc as $resultloc) {
            $resultloc = (array) $resultloc;
?>
                                               <table cellpadding="0" cellspacing="0"><tr><td valign="top"><img src="images/marker_pin.jpg" /></td>
                                                        <td valign="top">&nbsp;</td>
                                                        <td valign="top"><font class="ArialVeryDarkGrey13" style="color:#666"><?= $resultloc["event_location"] ?></font>
                                                        </td></tr></table>
                                            <?
        }
?>
                                       </td></tr>
                                </table>
                            </td>
                        </tr></table></div>
                <?
    }
?></td><?
} else {
?>
   <tr><td align="center"><font class="ArialVeryDarkGrey15">There are no suggested events available for the stated date.</font></td>
        <?
}
?>
   </tr>
</table>
