<?php
//print_r($_POST);exit;

include_once("../../config.php");
include_once(INC."/commonfunction.php");
include_once(INC.'/dbfilter.php');
include_once(INC.'/dbqueries.php');
include_once(INC.'/dbhelper.php');

error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;

if($post)
{

    $errorcheck = false;

    $number_of_records = $_POST['number_of_records'];
    $user_id = $_POST['user_id'];
    $event_id = $_POST['event_id'];

    $sql = "Select * from comments where event_id=$event_id order by id desc limit 10 offset ".$number_of_records."";
    $query = $DB->RunSelectQuery($sql);

    foreach ($query as $data){
        $result = (array)$data;
        ?>
        <div><table width="100%" align="left" cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="3" height="15"></td>
                </tr>
                <tr>
                    <td valign="top" align="left" width="35">
                        <div style="display:inline-block; vertical-align:top; width:35px">
                            <?
                            $userId = $result["user_id"];
                            $sql2 = "SELECT * from public_users where id=$userId";
                           $query =$DB->RunSelectQuery($sql2);
                            foreach ($query as $data){
                                $resultuser = (array)$data;
                                $profilepic = $resultuser['profile_pic'];
                                $user_name = $resultuser['firstname']." ".$resultuser['lastname'];
                                if ($profilepic == "") {
                                    ?>
                                    <img width="30" height="30" valign="middle" style="border-radius:100px" src="<? echo ROOTURL . '/'?>.images/no_profile_pic.gif" />
                                <? }else{ ?>
                                    <img width="30" height="30" valign="middle" style="border-radius:100px" src="<? echo ROOTURL . '/'.$profilepic; ?>" />
                                <? }
                            }?>
                        </div></td><td valign="top" align="left" width="10">
                        <div style="display:inline-block; width:10px; vertical-align:top;"><div style="height:5px"></div><img src="images/speech_triangle.gif" width="10" /></div></td><td valign="top" align="left"><div style="display:inline-block;"><div style="height:5px"></div><div style="background:#FFFAEA; border-radius:0px 3px 3px 3px; padding:5px" id="comment_content<?=$result["id"] ?>"><font class="ArialVeryDarkGreyBold15"><? echo $user_name; ?></font> <font class="ArialVeryDarkGrey15"> <? echo $result["comment"] ?></font><br /><div style="display:inline-block;"><font class="ArialVeryDarkGrey15" style="color:#999; font-size:13px"> <?=date("j M", strtotime($result["entry_date"])) ?>, <?=date("h:i a", strtotime($result["entry_date"])) ?></font></div>&nbsp;&nbsp;<div style="display:inline-block; cursor:pointer" onclick="delete_comment(<?=$result["id"] ?>, '<?=$user_name ?>')"><font class="ArialVeryDarkGrey15" style="color:#F63; font-size:13px">Delete</font></div></div></div>
                    </td></tr>
            </table>
        </div>
        <?
    } }else{ ?>
    <div style="height:40px; width:100% margin: 0 auto; text-align:center"><div style="height:20px"></div><font class="ArialVeryDarkGrey15">No comments yet...</font></div>
    <?
}
?>