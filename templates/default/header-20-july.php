<html>
<head>
    <script type="text/javascript" src="<?php echo JS; ?>/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="<?php echo JS; ?>/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo JS; ?>/functions.js"></script>
	<script src="<?php echo JS; ?>/all.js"></script>
    <link rel='stylesheet' type='text/css' href='<?php echo STYLE; ?>/local.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo STYLE; ?>/style.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo STYLE; ?>/style2.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo STYLE; ?>/locoyolo.css' />		
    <link rel='stylesheet' type='text/css' href='<?php echo STYLE; ?>/css.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo STYLE; ?>/custom_rahul.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo STYLE; ?>/bootstrap.min.css' />
</head>	

<div id="header-wrapper" class=" logged-in">
        <div class="row header">
            <div id="logo" class="logo_div col-md-2"><a href='<?php echo ROOTURL;?>'><img src="images/logo (height 40px).jpg" height="35" /></a></div>
        <div class="right-side-wrapper <?php if($user_id){?>col-md-10<?php }else {?> col-md-7<?php } ?>">
<?php
if($user_id!='')
{?>
<!-------------------------------------------------------------------->


         
          <div class=" col-md-5 search-bar">
              <form action="<?php echo createURL('index.php',"mod=search&do=searchlist")?>" method="post" role="search">
                  <div class="col-lg-10" style="float: right; margin-top: 8px;">
                      <div class="input-group">
                          <input type="text" name="search" id="inputSearch" value='<?php echo $_REQUEST['s']?$_REQUEST['s']:'';  ?>' class="search form-control " autocomplete="off" placeholder="Search for Locoyolo">
                          <span class="input-group-btn" >
                              <button class="btn btn-default" name="search" type="submit">Search!</button>
                            </span>
							<div id="divResult"></div>
                      </div><!-- /input-group -->
                  </div><!-- /.col-lg-6 -->
              </form>

          </div>
          <div id="icons" class=" col-md-5 icons_div">
              <div class="col nav">
              <div class="navbar-icon icon_1" title='Notifications'><button onclick='location.href="<?php print CreateURL('index.php','mod=notification&do=notifications');?>"' class="slimbutton" type="button" class="btn btn-default">N</button>
                  <?php  $status = "Pending";
				 
                   $sql = "Select * from notifications where user_id=$user_id and status = '$status'";
                   $res = $DB->RunSelectQuery($sql);

                  if(!is_array($res))
                  {
                      $res = array();
                  }
                  if (count($res) > 0){
                      ?>
                      <strong class="no-of-notification">
                          <?
                          echo count($res);
                          ?>
                      </strong>
<!--                      </strong> new notifications-->
                  <? } else { ?>
<!--                      Notifications-->
                  <? } ?>
              </div>

              <div class="navbar-icon icon_2" title='Ping a meetup'><button onclick="location.href='<?php print CreateURL('index.php','mod=ping&do=createPing');?>'" class="slimbuttonblue" type="button" class="btn btn-default">P</button></div>

              <div class="navbar-icon icon_3" title='Organise an event'><button onclick="location.href='<?php print CreateURL('index.php','mod=event&do=createEvent');?>'" class="slimbutton" type="button" class="btn btn-default">O</button></div>

              <div class="dropdown">
                  <div class="dropbtn">
                      <?php
                      $sql = "SELECT * from public_users where id=$user_id";
                     $before_result = $DB->RunSelectQuery($sql);
                      foreach($before_result as $result){
						 $result = (array) $result;
//						 print_r($result['profile_pic']);exit;
						if ($result['profile_pic'] == null ) {
                              ?>
                              <img width="25" height="25" style="border:#CCC 2px solid; border-radius:12.5px" src="<?php echo ROOTURL;?>/images/no_profile_pic.gif" />
                          <?php }else{
                              ?>
                              <img style="border:#CCC 2px solid; border-radius:12.5px" src="<? echo ROOTURL.'/'.$result["profile_pic"]; ?>" width="25" height="25" />
                          <?php }  } ?>
                  </div>
                
                      <div class="dropdown-content"><a href="<?php echo CreateURL('index.php',"mod=user&do=profile"); ?>"><font class="ArialVeryDarkGrey15">My Profile</font></a><a href="<?php echo CreateURL('index.php',"mod=user&do=logout"); ?>"><font class="ArialVeryDarkGrey15">Logout</font></a></div>

                 
              </div>
              </div>
          </div>
          </div>
      </div>



<!-------------------------------------------------------------------->
<?php

}
else
{ include(ROOTPATH."/lib/api/Facebook/autoload.php");
    $fb = new Facebook\Facebook([
        'app_id' => '850026601828810', // Replace {app-id} with your app id
        'app_secret' => '5c7e2e63652770b90221e6051a165a89',
        'default_graph_version' => 'v2.9',
        "persistent_data_handler"=>"session"
    ]);

    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['email']; // Optional permissions
    $returnurl =  createURL('index.php', 'mod=user&do=login&from=fb');
    $loginUrl = $helper->getLoginUrl($returnurl, $permissions);

    ?>
	  <div class="header-facebook-button">
                <button class="loginBtn loginBtn--facebook" id='FacebookBtn'  link="<?php echo $loginUrl; ?>">Login with Facebook</button></div>
            <div class="form_wrapper">
                <form  method="post" class="header-signin-form" name="signin-form" id="signin-form">
                    <div id="header_input" class="header_input">
                        <input name="email" type="email" id="email" size="15" placeholder="Email">
                        <input name="password" type="password" id="password" size="15" placeholder="Password">
                        <button type='submit' name='submit' value='submit' class="slimbutton"  class="btn btn-default">Login</button>
                    </div>
                </form>
                <a class="header_forgot_link" onclick='location.href="<?php print CreateURL('index.php','mod=user&do=forgotpass');?>"'>Forgotten account?</a>
            </div>
	<?php
	
}
?>
    
         
        </div> </div>
    </div>



<?php if($user_id!=''){?>

<script type="text/javascript">

    $(function(){
        $(".search").keyup(function()
        {
            $("#divResult").html('');
            var inputSearch = $(this).val();
            var dataString = 's='+ inputSearch;
            if(inputSearch!='')
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo CreateURL('index.php',"mod=ajax&do=mainsearch");?>",
                    data: dataString,
                    cache: false,
                    success: function(html)
                    {
                        $("#divResult").html(html).show();
                    }
                });
            }return false;
        });

      /*  jQuery("#divResult").live("click",function(e){
            var $clicked = $(e.target);
            var $name = $clicked.find('.name').html();
            var decoded = $("<div/>").html($name).text();
            $('#inputSearch').val(decoded);
        });
        jQuery(document).live("click", function(e) {
            var $clicked = $(e.target);
            if (! $clicked.hasClass("search")){
                jQuery("#divResult").fadeOut();
            }
        });*/
        $('#inputSearch').click(function(){
            jQuery("#divResult").fadeIn();
        });

    });
    $("#inputSearch").blur(function(){
        setTimeout(function(){
            $("#divResult").html('');
        },'200'); });
</script>
<?php }else {?>
<script>
    var signinWin;
    $('#FacebookBtn').click(function () {
        var link = $(this).attr('link');
        signinWin = window.open(link, "SignIn", "width=780,height=410,toolbar=0,scrollbars=0,status=0,resizable=0,location=0,menuBar=0");
        setTimeout(CheckLoginStatus, 2000);
        signinWin.focus();
        return false;
    });
</script>
<?php }?>
</html>


