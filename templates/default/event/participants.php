<?php
include_once(TEMPPATH . "/header.php");
$eventid = $_GET["eventid"];


$sql = "SELECT * from events where event_id= $eventid";
$eventData = $DB->RunSelectQuery($sql);
foreach($eventData as $result){
    $result = (array) $result;
    $userid = $result["user_id"];
    $event_name = $result["event_name"];
    $start_date = $result["start_date"];
    $event_price = $result["event_price"];
    $emailto = $userData->email;
    $organiser_name = $userData->firstname.' '.$userData->lastname;
}
$current_user_id = $user_id;
?>
<!-- JQuery -->
<script>
   //modal see all
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').focus()
    })
    //end modal
    $(document).ready(function() {

        // Get the modal
        var sendcodepopup = document.getElementById('sendcodepopup');
        // Get the button that opens the modal
        var sendcodebutton = document.getElementById("sendcodebutton");
        // Get the button that opens the modal
        var cancelbutton = document.getElementById("cancelbutton");
        var cancelpopup = document.getElementById('cancelpopup');
        var cancelyesbtn = document.getElementById("cancelyesbutton");
        var cancelnobtn = document.getElementById("cancelnobutton");
        cancelbutton.onclick = function() {
            sendcodepopup.style.display = "none";
        }
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == sendcodepopup) {
                sendcodepopup.style.display = "none";
            }
        }
// When the user clicks on <span> (x), close the modal
        cancelyesbtn.onclick = function() {
            cancelping(<?php echo $eventid;?>);
            cancelpopup.style.display = "none";
        }
        cancelnobtn.onclick = function() {
            cancelpopup.style.display = "none";
        }
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == cancelpopup) {
                cancelpopup.style.display = "none";
            }
//		if (event.target == bookpopup) {
//			bookpopup.style.display = "none";
//		}
        }

        sendcodebutton.addEventListener('click', function() {

            var emailfrom = "<?php echo  $userData->email ?>";
            var emailto = document.getElementById("participant_email").value;
            var event_name = "<?php echo $event_name ?>";
            var organiser_name = "<?php echo  $userData->firstname ?>";
            var participant_name = document.getElementById("participant_name").value;
            var event_id = "<?php echo $eventid ?>";
            var start_date = "<?php echo $start_date ?>";
            var event_price = "<?php echo $event_price ?>";
            var user_id = document.getElementById("participant_id").value;
            var section_id = document.getElementById("section_id").value;

            //POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
            $.ajax({
                type: "POST",
                url: "<?php echo CreateURL('index.php',"mod=ajax&do=booking_confirmation_message");?>",
                data: { emailfrom: emailfrom, emailto: emailto, organiser_name: organiser_name, participant_name: participant_name, event_id:event_id, event_name:event_name, start_date:start_date, event_price:event_price, user_id:user_id },
                //dataType: 'json',
                cache: false,
                success: function(data)
                {
                    if(data !== '') {
                        result = data;
                    } else {
                        result = data;
                    }
                    $('#participantstatus'+section_id).html(result);
                    sendcodepopup.style.display = "none";
                    window.location.href=window.location.href;
                }
            });

        });
    });
    function cancelping(id){
        //POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
        $.ajax({
            type: "POST",
            url: "<?php echo createURL('index.php', 'mod=ajax&do=cancel_event');?>",
            data: { event_id:id },
            //dataType: 'json',
            cache: false,
            success: function(data)
            {
                if(data == 'Y') {
                    result = data;
                    $('#canceleventbtn').html('Cancelled');
                    $('#canceleventbtn').attr('disabled','disabled');

                } else {
                    alert("There is some problem while cancelling ping.");
                }
                cancelpopup.style.display = 'none'
            }
        });
 }
    function send_confirmation_code_initial(id){
        document.getElementById("participant_email").value = document.getElementById("participant_email"+id).value;
        document.getElementById("participant_name").value = document.getElementById("participant_name"+id).value;
        document.getElementById("participant_image").value = document.getElementById("participant_image"+id).value;
        document.getElementById("participant_id").value = document.getElementById("participant_id"+id).value;
        document.getElementById("section_id").value = id;

        var participantname = document.getElementById("participant_name").value;
        var participantlastname = document.getElementById("participant_last_name"+id).value;
        var participantimage = document.getElementById("participant_image"+id).value;
        var participantemail = document.getElementById("participant_email").value;

        $('#send_invitation_text_modal').html('Please confirm that you want to send the code to:<br><br>&nbsp;&nbsp;&nbsp;<img src="'+participantimage+'" width="35" style="border-radius:17.5px; vertical-align:middle">&nbsp;&nbsp;&nbsp;<font style="ArialVeryDarkGrey15"><strong>'+participantname+' '+participantlastname+'</strong></font>');
        sendcodepopup.style.display = "block";
    }

    if(document.getElementById("canceleventbtn") && document.getElementById("canceleventbtn").value){
        var canceleventbtn = document.getElementById('canceleventbtn');
        canceleventbtn.onclick = function() {
            cancelpopup.style.display = "block";
        }
    }

</script>
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
</style>

<div style="height:10px"></div>
<!-- The Cancel Event Modal -->
<!-- The Cancel Event Modal -->
<div id="cancelpopup" class="modal" >


    <!-- Modal content -->
    <div class="modal-content" style="width:400px; padding:10px">
        <table width="420" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td height="10"></td>
            </tr>
            <tr>
                <td height="20" class="ArialOrange18">Cancel Event<br />
                    <br /></td>
            </tr>
            <tr>
                <td class="ArialVeryDarkGrey15"><table width="400" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>&nbsp;&nbsp;Are you sure you want to cancel this event?</td>
                            <td width="10">&nbsp;</td>
                            <td><form action="" method="post"><input class="standardbutton" style="cursor:pointer" type="button" id="cancelyesbutton" name="cancelyesbutton" value="Yes" />
                                    <input type="hidden" name="eventid" id="eventid" value="<?php echo  $eventid ?>" /></form></td>
                            <td width="10">&nbsp;</td>
                            <td><input class="standardgreybutton" style="cursor:pointer" type="submit" id="cancelnobutton" value="No" /></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
</div>

<div id="sendcodepopup" class="modal" >

    <!-- Modal content -->
    <div class="modal-content" style="width:300px; padding:10px">
        <table width="280" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td height="10"></td>
            </tr>
            <tr>
                <td height="20" class="ArialOrange18">Send confirmation code<br />
                    <br /></td>
            </tr>
            <tr>
                <td class="ArialVeryDarkGrey15"><table width="280" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td colspan="5"><div id="send_invitation_text_modal">&nbsp;&nbsp;&nbsp;Are you sure you want to send the invitation code to:</div></td>
                        </tr>
                        <tr>
                            <td width="320">&nbsp;</td>
                            <td width="10">&nbsp;</td>
                            <td><input class="standardbutton" style="cursor:pointer" type="submit" id="sendcodebutton" name="sendcodebutton" value="Yes" />
                                <input type="hidden" name="participant_email" id="participant_email" value="" />
                                <input type="hidden" name="participant_name" id="participant_name" value="" />
                                <input type="hidden" name="participant_image" id="participant_image" value="" />
                                <input type="hidden" name="participant_id" id="participant_id" value="" />
                                <input type="hidden" name="section_id" id="section_id" value="" />
                            </td>
                            <td width="10">&nbsp;</td>
                            <td width="50"><input class="standardgreybutton" style="cursor:pointer" type="submit" id="cancelbutton" value="No" /></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td height="10"></td>
            </tr>
        </table>
    </div>
</div>




<div id="participants-page-wrapper">
    <div class="container">
        <div class="has-event-message">
            <?php
            $sql = "SELECT * from public_users where id=$userid";
           $query = $DB->RunSelectQuery($sql);
            foreach($query as $resultuser){
                $resultuser = (array) $resultuser;

                if ($resultuser['profile_pic'] == "") {
                    ?>
                    <div class="event-message-image col-sm-1"><img class="image-has-radius" src="images/no_profile_pic.gif" alt="event-image"></div>
                <? }else{
                    ?>
                    <div class="event-message-image col-sm-1"><img class="image-has-radius" src="<? echo ROOTURL.'/' .$resultuser["profile_pic"]; ?>" alt="event-image"></div>
                <? }} ?>
            <div class="event-message-content col-sm-11"><strong>You</strong><p>are organizing an event.</p></div>
        </div>
        <div class="col-md-5 goes-on-left">
            <div class="row has-event-image">

                <?php
                $eventid = $_GET["eventid"];
                $sql = "Select * from events where event_id=$eventid";
                $events_organised = $DB->RunSelectQuery($sql);

                foreach($events_organised as $result_events_organised){
                $result_events_organised = (array)$result_events_organised;
                ?>
                <img class="image-doesnt-has-radius" src="<?php echo $result_events_organised["event_photo"] ?>"
                     alt="image">

            </div>
            <div class="row has-event-title">
                <h3><strong><?php echo $result_events_organised["event_name"] ?></strong></h3>
            </div>

            <div class="row has-date-time">
                <span> <?php echo date("j F Y", strtotime($result_events_organised["start_date"])) ?></span><span
                    class="make-space">|</span>
                <span><? echo date("g:ia", strtotime($result_events_organised["start_time"])) . " - " . date("g:ia", strtotime($result_events_organised["end_time"])); ?></span>
            </div>
            <div class="row has-edit-booking-details">
                <button class="btn btn-custom_cb btn_bold"
                        onClick="location.href='<?php echo createURL('index.php', "mod=event&do=editevent&eventid=".$result_events_organised["event_id"]); ?>'">
                    Edit event
                </button>
                <?php
                if ($result_events_organised['event_status'] == 'C')
                {
                    $status = 'Cancelled';
                    $disabled = 'disabled';
                }
                else
                {
                    $status = 'Cancel event';
                    $disabled = '';
                }
                ?>
                <span class="make-more-space"></span><button class="btn btn-custom_34 btn_bold" id="canceleventbtn" onclick="cancelpopup.style.display = 'block';" <?php echo $disabled;?> type="button"><?php echo $status;?></button>
            </div>
            <? }?>
            <?php $event_attended = "Y";
            $status = "Confirmed";
            $i=1;
            $a =1;
            $sql4 = "Select p.profile_pic,concat(p.firstname,' ',p.lastname) as name ,b.* from event_bookings b left join public_users as p on p.id= b.user_id where event_id=$eventid and booking_status like '$status'";
            $getallgoing = $DB->RunSelectQuery($sql4);
            if(is_array($getallgoing))
            {
                $getallgoing =$getallgoing;
            }
            else
            {
                $getallgoing = array();
            }
            //	echo"<pre>";
            //	print_r($getallgoing);exit();
            ?>
            <div class="has-people-interested">
                <? $event_attended = "Y";
                $status = "Pending";
                $i=1;
                $a =1;
                $sql4 = "Select p.profile_pic,concat(p.firstname,' ',p.lastname) as name ,b.* from event_bookings b left join public_users as p on p.id= b.user_id where event_id=$eventid and booking_status like '$status'";
                $getallins=  $DB->RunSelectQuery($sql4);
                if(is_array($getallins))
                {
                    $getallins=$getallins;
                }
                else
                {
                    $getallins= array();

                }
               ?>
                <div class="row has-title">
                    <h3>Free</h3>
                </div>
                <div class="row has-participants">
                    <p>
                        <span class="has-number"><?php echo count($getallgoing); ?></span><span class="interested going"> going</span><span>, </span><span class="has-number"><?php echo count($getallins); ?></span><span class="interested"> interested </span><span class="make-more-space"></span>
                        <button type="button" class="btn btn-custom_468 btn_bold" data-toggle="modal" data-target="#exampleModal"> See All  </button>


                    </p>
                </div>
                <div class="row" id="has-invite-friends">
                    <h4><strong>Invite your friends</strong></h4>
                    <br/>
                    <div class="has-invites">
                        <span><img class="image-has-radius" src="images/profile_img.jpg" alt="event-image"></span>
                        <span class="make-more-space"></span>
                        <span><strong>Jonathan</strong></span>
                        <a class="invite-button">invite</a>
                    </div>
                    <div class="has-invites">
                        <span><img class="image-has-radius" src="images/profile_img.jpg" alt="event-image"></span>
                        <span class="make-more-space"></span>
                        <span><strong>Jonathan</strong></span>
                        <a class="invite-button">invite</a>
                    </div>
                    <div class="has-invites">
                        <span><img class="image-has-radius" src="images/profile_img.jpg" alt="event-image"></span>
                        <span class="make-more-space"></span>
                        <span><strong>Jonathan</strong></span>
                        <a class="invite-button">invite</a>
                    </div>
                    <div class="has-invites">
                        <span><img class="image-has-radius" src="images/profile_img.jpg" alt="event-image"></span>
                        <span class="make-more-space"></span>
                        <span><strong>Jonathan</strong></span>
                        <a class="invite-button">invite</a>
                    </div>
                    <div class="has-invites">
                        <span><img class="image-has-radius" src="images/profile_img.jpg" alt="event-image"></span>
                        <span class="make-more-space"></span>
                        <span><strong>Jonathan</strong></span>
                        <a class="invite-button">invite</a>
                    </div>
                    <div class="has-see-all-friends-btn">
                        <button class="btn btn-primary">See all friends</button>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-7 goes-on-right">
            <div class="row has-participants-summary">
                <div class="has-title somewhat-gold">
                    <h3>Participants</h3>
                </div>
                <div class="has-participants-content">


                    <div class="has-people-going">

                        <p class="no-one-confirmed"><strong>Going (<span class="how-many"><?php  echo count($getallgoing) ?></span>)</strong></p>


                        <?
                        if (count($getallgoing) > 0){
                            ?>

                            <div class="has-going-people-list">
                                <?php
                                 foreach($getallgoing as $result_bookings){
                                    $result_bookings = (array) $result_bookings;
                                    $participant_id = $result_bookings["user_id"];
                                    $sql5 = "Select * from public_users where id=$participant_id";
                                    $result_user_data =  $DB->RunSelectQuery($sql5);
                                    foreach( $result_user_data as $result_user){
                                        $result_user = (array) $result_user;
                                        if ($result_user["profile_pic"] == ""){
                                            $profile_pic = ROOTURL."/images/no_profile_pic.gif";
                                        }else{
                                            $profile_pic = ROOTURL.'/'.$result_user["profile_pic"];
                                        }
                                        ?>
                                        <div class="going-people-list-item">
                                            <div class="has-list-image"><img src="<?php echo $profile_pic;?>"></div>
                                            <div class="make-space"></div>
                                            <div class="has-list-name-btn">
                                                <div class="has-list-item-name"><?php echo $result_user["firstname"]." ".$result_user["lastname"] ?></div>
                                                <?php if ($result_bookings["booking_status"] == "Confirmed") { ?>
                                                    <button class="slimbuttonblue btn btn-custom_cb btn_bold">Accepted</button> <?php }?>
                                            </div>
                                        </div>

                                        <?php $i++; $a++;
                                        if ($i%5 == 0){ ?>
                                            <?php
                                            $i = 1;
                                        }
                                    }
                                }?>

                                <div class="col-md-6"></div>
                            </div>
                            <?php
                        } else{
                            ?>
                            <p class="no-one-confirmed-message">Nobody has requested their attendance yet...</p>
                            <?
                        }
                        ?>

                    </div>

                    <p class="has-interested-people-number"><strong>Interested (<span class="how-many"><?php echo count($getallins) ?></span>)</strong></p>

                    <div class="has-interested-people-list">
                        <?php if(count($getallins)<=0){?>
                            <p class="no-one-confirmed-message">Nobody has confirmed their attendance yet...</p>		<?php }else{ ?>
                            <?php //echo '<pre>'; echo count($ins_users); echo '</pre>';
//                           print_r($getallins);
                            $counter =$a=1; foreach($getallins as $user){
                                $user = (array) $user;

                                //echo '<pre>';print_r($user);	echo '</pre>';

                                ?>
                                <input type="hidden" name="participant_email<?php echo $a ?>" id="participant_email<?php echo $a ?>" value="<?php echo $user["email"] ?>" />
                                <input type="hidden" name="participant_name<?php echo $a ?>" id="participant_name<?php echo $a ?>" value="<?php echo $user["firstname"] ?> " />
                                <input type="hidden" name="participant_last_name<?php echo $a ?>" id="participant_last_name<?php echo $a ?>" value="<?php echo $user["lastname"] ?> " />
                                <input type="hidden" name="participant_image<?php echo $a ?>" id="participant_image<?php echo $a ?>" value="<?php echo $profile_pic ?>" />
                                <input type="hidden" name="participant_id<?php echo $a ?>" id="participant_id<?php echo $a ?>" value="<?php echo $user["user_id"] ?>" />
                                <div class="interested-people-list-item">
                                    <div class="has-list-image"><img src="<?php echo ROOTURL.'/'.$user["profile_pic"]?>" alt="placeholder"></div>
                                    <div class="make-space"></div>
                                    <div class="has-list-name-btn">
                                        <div class="has-list-item-name"><?php echo $user['name']; $counter++;?> </div>
                                        <? if ($user["booking_status"] == "Pending") { ?>
                                            <div class="has-list-item-btn" id="participantstatus<?php echo $a ?>"><button onClick="send_confirmation_code_initial(<?php echo $a ?>)" class="slimbuttonblue btn btn-custom_cb btn_bold">Accept</button></div>

                                        <? }

                                        if ($user["booking_status"] == "Confirmed") { ?>
                                            <font class="ArialVeryDarkGreyBold15">Accepted</font>
                                        <? } if ($result_user["booking_status"] == "Pending Confirmation") { ?>
                                            <font class="ArialVeryDarkGrey15">Booking code sent</font>
                                        <? } ?>

                                    </div>
                                </div>
                            <?php } } ?>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class=""></div>
        <div class=""></div>
    </div>
</div>
</div>

<!-- Modal for see alll -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal">Search Going & Interested Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#going">Going</a></li>
                        <li><a href="#interested">Interested</a></li>

                    </ul>
                    <div class="tab-content">

                        <div id="going" class="tab-pane fade in active">


<!--                            <div id="container" class="search-name">-->
<!--                                <input type="text" id="searchname" placeholder="search name"/>-->
<!--                                <input type="button" id="button" value="Search" />-->
<!--                                <ul id="result"></ul>-->
<!--                            </div>-->

                            <div class="userlist">
                                <ul>
                                    <?php
                                    if(count($getallgoing)>=1)
                                    {
                                    foreach ($getallgoing as $goin_user )
                                    {
                                        $goin_user = (array) $goin_user; ?>
    <!--                                    <div><b>--><?php //echo $goin_user['name']?><!--</b></div>-->
                                      <li class="userdata">
                                          <img src="<?php echo ROOTURL.'/'.$goin_user['profile_pic']; ?>">
                                          <span class="username"><?php echo $goin_user['name']?></span>
                                      </li>
                                    <?php  }}else{?>
                                        <li class="userdata">No Users avalible.</li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                        <div id="interested" class="tab-pane fade">
                            <div class="search-name"><input type="text" class="form-control" id="recipient-name" placeholder="Search name"></div>
                            <div class="userlist">
                                <ul>
                                    <?php
                                    if(count($getallins)>0)
                                    {
                                    foreach ($getallins as $goin_user )
                                    {
                                        $goin_user = (array) $goin_user; ?>
                                        <!--                                    <div><b>--><?php //echo $goin_user['name']?><!--</b></div>-->
                                        <li class="userdata">
                                            <img src="<?php echo ROOTURL.'/'.$goin_user['profile_pic']; ?>">
                                            <span class="username"><?php echo $goin_user['name']?></span>
                                        </li>
                                    <?php  }}else
                                    { ?>
                                    <li class="userdata">No Users avalible.</li>
                                    <?php } ?>
                                </ul>
                            </div>
                            </div>

                        </div>
                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>



</div>
</body>
</html>

<script>
    $(document).ready(function(){
        $(".nav-tabs a").click(function(){
            $(this).tab('show');
        });
        $('.nav-tabs a').on('shown.bs.tab', function(event){
            var x = $(event.target).text();         // active tab
            var y = $(event.relatedTarget).text();  // previous tab
            $(".act span").text(x);
            $(".prev span").text(y);
        });
    });
</script>

<!--for search user name-->
<script >
    $(document).ready(function(){

        function search(){

            var title=$("#searchname").val();
            var eventId = <?php echo $eventid ?>;
            var range2 = "Confirmed";

            if(title!=""){
                $("#result").html("demo");
                $.ajax({
                    type:"post",
                    url:"search.php",
                    data:"title="+title,eventId:eventId,range2:range2,

                    success:function(data){
                        console.log(data);
                        $("#result").html(data);
                        $("#searchname").val("");


                    }
                });
            }



        }

        $("#button").click(function(){
            search();
        });

        $('#searchname').keyup(function(e) {
            if(e.keyCode == 13) {
                search();
            }
        });
    });
</script>