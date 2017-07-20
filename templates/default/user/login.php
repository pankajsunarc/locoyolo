<?php include_once (TEMPPATH."/header.php")?>
    <style>
        @media screen and (max-width:680px) {
            .display860{
                display:none;
            }
            .display320{
                display:block;
            }
        }

        @media screen and (min-width:680px) {
            .display860{
                display:block;
            }
            .display320{
                display:none;
            }
        }
        .modal.fade.in {
            text-align: center;
        }
    </style>

<div class='container main'>

        <table width="900" align="center"><tr>
                <?php if(isset($_SESSION['error'])||isset( $_SESSION['success']))
                {
//        print_r($_SESSION['error']);exit();
                    echo'<div id="msg" style="min-height: 25px; width: 90%; background: none repeat scroll 0% 0% rgb(255,204,103); position: relative; box-shadow: 0px 0px 2px rgb(0, 0, 0); margin:0 auto; opacity: 0.7; color: #000000; font-weight: bold; padding: 8px; text-align: center; top:82px">';
                    echo $_SESSION['error'];
                    echo $_SESSION['success'];

                    unset($_SESSION['error']);
                    unset($_SESSION['success']);
                }

                ?>
                <td width="50%" valign="top"><img src="images/front_page_clip.jpg" width="90%" /></td>
                <td valign="top" class="ArialVeryDarkGrey30"><table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td valign="middle" class="ArialVeryDarkGrey30">Join us at </td>
                            <td valign="middle"><img src="images/locoyolo_word(30).jpg" width="148" height="39" /></td>
                        </tr>
                    </table>
                    <p class="ArialVeryDarkGrey18">Whether you're at home or at work, there is always something to do near you!<br />
                        <br />
                    </p>
                    <form id="signup-form" method="post" action="" >
                        <table width="95%" border="0" cellpadding="0" cellspacing="0" class="tableorangeborder">
                            <tr>
                                <td height="40" colspan="2" class="ArialOrange18">&nbsp;&nbsp;&nbsp;Sign up<div id="result"></div></td>
                            </tr>
                            <tr>
                                <td height="40" colspan="2" class="ArialVeryDarkGrey15"><span class="ArialOrange18">&nbsp;&nbsp;&nbsp;</span>          <input name="firstname" type="text" class="textboxbottomborder" id="firstname" size="17" placeholder="First name" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input name="lastname" type="text" class="textboxbottomborder" id="lastname" size="17" placeholder="Last name" /></td>
                            </tr>
                            <tr>
                                <td height="40" colspan="2" class="ArialVeryDarkGrey15"><span class="ArialOrange18">&nbsp;&nbsp;</span><span class="ArialVeryDarkGrey15">&nbsp;&nbsp;</span>          <input name="email" type="text" class="textboxbottomborder" id="email" size="35" placeholder="Email" /></td>
                            </tr>
                            <tr>
                                <td height="40" colspan="2" class="ArialVeryDarkGrey15"><span class="ArialOrange18">&nbsp;&nbsp;&nbsp;</span>          <input name="password1" type="password" class="textboxbottomborder" id="password1" size="35" placeholder="Enter password" /></td>
                            </tr>
                            <tr>
                                <td height="40" colspan="2" class="ArialVeryDarkGrey15"><span class="ArialOrange18">&nbsp;&nbsp;&nbsp;</span>          <input name="password2" type="password" class="textboxbottomborder" id="password2" size="35" placeholder="Re-enter password" /></td>
                            </tr>
                            <tr>
                                <td width="25%" height="40" class="ArialVeryDarkGrey15"><span class="ArialOrange18">&nbsp;&nbsp;&nbsp;</span>Birth date:</td>
                                <td height="40">
                                    <select
                                            name="birth_day" class="textboxbottomborder" id="birth_day">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                    </select>
                                    &nbsp;
                                    <select
                                            name="birth_month" class="textboxbottomborder" id="birth_month">
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                    &nbsp;
                                    <select
                                            name="birth_year" class="textboxbottomborder" id="birth_year">
                                        <? $a = 1950;
                                        while ($a < (date("Y") +1)){ ?>
                                            <option value="<?=$a ?>"><?=$a ?></option>
                                            <? $a++; } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr height="10">
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td height="40" colspan="2" align="center">
                                    <input class="standardbutton" style="cursor:pointer" type="submit"  name="signUp_submit" value="Sign up" href='<?php print CreateURL('index.php','mod=user&do=login');?>'">
                                </td>
                            </tr>
                        </table>
                    </form>
                </td></tr></table> </div>
        <?php include_once (TEMPPATH.'/footer.php')?>
