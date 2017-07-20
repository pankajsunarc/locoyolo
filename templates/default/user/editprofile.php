<?php

include_once(TEMPPATH . "/header.php");

?>




    <div class="editProfile">
        <div class="col-md-12 errors">
            <?php if(isset($_SESSION['error'])||isset( $_SESSION['success']))
            {
                echo'<div id="msg" style="margin:0 auto; opacity: 0.7; color: #ff0000; font-weight: bold; padding: 8px; text-align: center; top:82px">';
                echo $_SESSION['error'];
                echo $_SESSION['success'];

                unset($_SESSION['error']);
                unset($_SESSION['success']);
            }
            ?>
        </div>
    </div>
        <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
        <td height="40" colspan="2" valign="middle" class="ArialVeryDarkGreyBold20">Edit your profile<br />
    <br /></td>
    </tr>
    <tr>
    <td rowspan="7" valign="top" class="ArialVeryDarkGrey15">
        <form id="editprofile-photo-form"  method="post" action="" enctype="multipart/form-data">
        <table width="200" border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td><span class="ArialOrange18">Update profile photo<br />
    </span><br /></td>
    </tr>
    <tr>
    <td><?

//print_r($userData);exit;
    if ($userData->profile_pic !== "") {
    ?>
    <img style="border-radius:100px" src="<?php echo ROOTURL."/".$userData->profile_pic ; ?>" width="200" />
        <?
        }else{
        ?>
        <img style="border-radius:100px" src="images/no_profile_pic.gif" width="200" />
        <?
        }
        ?></td>
        </tr>
        <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
    <td>Change profile photo:<br />
    <br />
    <input name="profile_photo" type="file" class="textboxbottomborder" id="profile_photo" />
        <input type="hidden" id="user_email_forphoto" name="user_email_forphoto" value="<?php echo $userData->email; ?>" /></td>
        </tr>
        <tr>
        <td><br />
        <br /></td>
        </tr>
        <tr>
        <td><table align="center">
        <tr>
        <td><input class="standardbutton" style="cursor:pointer" type="submit" id="update_photo_submit" value="Update photo" name="update_photo_submit" >
        </td>
        </tr>
        </table></td>
        </tr>
        </table>
        </form>
        <p>&nbsp;</p></td>

    </tr>
    <tr>
    <td height="20" valign="top">


        <form id="editprofile-details-form" method="post" action="">
        <table width="300" border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td valign="top" class="ArialVeryDarkGrey15"><span class="ArialOrange18">Update profile details<br />
    <br />
                <?php if(isset($message)){?><div id="result"><?php echo $message ?></div><?php }?>
        </span></td>
        </tr>
        <tr>
        <td height="40" valign="top" class="ArialVeryDarkGrey15">First name:&nbsp;
    <input name="firstname" type="text" class="textboxbottomborder" id="event_name4" value="<?php echo $userData->firstname; ?>" size="30" />
        &nbsp;</td>
    </tr>
    <tr>
    <td height="20" valign="top">&nbsp;</td>
    </tr>
    <tr>
    <td height="40" valign="top" class="ArialVeryDarkGrey15">Last name:&nbsp;
    <input name="lastname" type="text" class="textboxbottomborder" id="lastname" value="<?php echo $userData->lastname;?>" size="30" />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br /></td>
    </tr>
    <tr>
    <td height="20" valign="top">&nbsp;</td>
    </tr>
    <tr>
    <td height="40" valign="top">
        <span class="ArialVeryDarkGrey15">Birth date:</span>
    <select
    name="birth_day" class="textboxbottomborder" id="birth_day">
        <? $i = 1;
        while ($i < 32){ ?>
        <option <? if (date("j", strtotime($userData->birthdate)) == $i){ ?> selected="selected" <? } ?> value="<?=sprintf("%02d", $i) ?>"><?=$i ?></option>
        <? $i++; } ?>
        </select>
        &nbsp;&nbsp;
    <select
    name="birth_month" class="textboxbottomborder" id="birth_month">
        <? $i = 1;
        while ($i < 13){ ?>
        <option <? if (date("n", strtotime($userData->birthdate)) == $i){ ?> selected="selected" <? } ?> value="<?=sprintf("%02d", $i) ?>">
        <? $monthName = date("F", mktime(0, 0, 0, $i, 10));
        echo $monthName; // Output: May
        ?>
        </option>
        <? $i++; } ?>
        </select>
        &nbsp;&nbsp;
    <select
    name="birth_year" class="textboxbottomborder" id="birth_year">
        <? $i = 1950;
        $currentyear = date("Y");
        while ($i < ($currentyear+1)){ ?>
        <option <? if (date("Y", strtotime($userData->birthdate)) == $i){ ?> selected="selected" <? } ?> value="<?=$i ?>"><?=$i ?></option>
        <? $i++; } ?>
        </select></td>
        </tr>
        <tr>
        <td height="20" valign="top">&nbsp;</td>
    </tr>
    <tr>
    <td height="20" valign="top"><span class="ArialVeryDarkGrey15">About me:<br />
    </span><br />
    <textarea name="mood_statement" cols="50" rows="10" class="textboxbottomborder" id="mood_statement" placeholder="Describe yourself..."><?php echo $userData->mood_statement; ?></textarea>
        <br />
        <br />
        <table align="center">
        <tr>
        <td><input class="standardbutton" style="cursor:pointer" type="submit" name="update_details_submit" id="update_details_submit" value="Update details">
        <input type="hidden" id="user_email_fordetails" name="user_email_fordetails" value="<?php $userData->email; ?>" /></td>
        </tr>
        </table></td>
        </tr>
        </table>
        </form>

        <p>&nbsp;</p></td>
    </tr>
    </table>

    </div>