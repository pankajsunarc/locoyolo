<?php
//require_once('image_manipulator.php');
//
//include "header.php";
//include "panel/ly_db.php";
//?>
<?php include_once(TEMPPATH . "/header.php"); ?>

<?php
$sql     = "SELECT entry_type from events where event_id=$event_id";
$query = $DB->RunSelectQuery($sql);
foreach ($query as $queryResult)
{
    $result =(array)$queryResult;
}
//$result = '';
if($result)
{

    if(isset($result['entry_type'])&&($result['entry_type']!='Ping')){

        echo "<script>window.location.href='/locomvc/index.php'</script>";
    }
}
else
{
    //header("location:/lokoyolo/index.php");
    echo "<script>window.location.href='/locomvc/index.php'</script>";
}

if (isset($_POST['cancelyesbutton'])) {
    $dataToUpdate =[
        'event_status'=> "C"
    ];
    $query= $DB->UpdateRecord('events',$dataToUpdate,'event_id="'.$event_id.'"');

}


$email = $_SESSION['user_email'];
$query = "SELECT * from public_users where email='$email'";
//print_r($query);exit;
$resultdata = $DB->RunSelectQuery($query);
//print_r($resultdata);exit;
foreach ($resultdata as $data1) {

    $result = (array)$data1;
//    print_r($result);exit;
    $participant_name = $result["firstname"];
    $current_user_id = $result["id"];
    $current_profile_pic = $result["profile_pic"];
//    print_r($current_user_id);exit;
}


echo $sql     = "SELECT * from ping_locations where event_id=$event_id";
$locationData = $DB->RunSelectQuery($sql);

foreach ($locationData as $location) {
    $data = (array)$location;
    $eventLat = $data['event_lat'];
    $eventLong = $data['event_long'];

}



$sql = "SELECT * from events where event_id=$event_id";
//print_r($sql);exit;
$eventData = $DB->RunSelectQuery($sql);
foreach ($eventData as $data) {
    $result = (array)$data;
    $userid = $result["user_id"];
    $start_date = $result["start_date"];

}
?>

<script>
    $(document).ready(function() {
        var sendcommentbtn = document.getElementById("sendcommentbtn");
        sendcommentbtn.addEventListener('click', function() {

            var comment_message = document.getElementById("comment_message").value;
            var user_id = "<?= $current_user_id ?>";
            var event_id = "<?= $event_id ?>";

            if (document.getElementById("comments_number").value == "0"){
                $('#commentsdisplay').html('');
            }

            //POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
            $.ajax({
                type: "POST",
                url: "<?php echo CreateURL('index.php',"mod=ajax&do=send_comment");?>",
                data: { comment_message: comment_message, user_id:user_id, event_id:event_id },
                //dataType: 'json',
                cache: false,
                success: function(data)
                {
                    if(data == 'OK') {
                        result = data;
                    } else {
                        result = data;
                    }
                    $('#comment_message').val('');

                    $('#commentsdisplay').prepend(result);
                    document.getElementById("comments_number").value = parseInt(document.getElementById("comments_number").value) + 1;
                }
            });

        });

//////////////////////////////////MOBILE MESSAGE B0X/////////////////////////////////

        $('body').delegate('#bookbtn','click',function(){

            var event_id = "<?= $event_id ?>";
            var user_id = "<?= $current_user_id ?>";
            var start_date = "<?= $start_date ?>";
            var book_status = document.getElementById("book_status").value;
            //POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
            $.ajax({
                type: "POST",
                url: "<?php echo CreateURL('index.php',"mod=ajax&do=join_ping");?>",
                data: { event_id:event_id, user_id:user_id, book_status:book_status, start_date:start_date },
                //dataType: 'json',
                cache: false,
                success: function(data)
                {
                    if(data == 'OK') {
                        result = data;
                    } else {
                        result = data;
                    }
                    $('#join_meetup_content').html(result);
                    var bookbtn = document.getElementById("bookbtn");
                }
            });

        });


    });

    function delete_comment(id, name){

        $.ajax({
            type: "POST",
            url: "<?php echo CreateURL('index.php',"mod=ajax&do=delete_comment");?>",
            data: { comment_id:id },
            //dataType: 'json',
            cache: false,
            success: function(data)
            {

                if(data == 'Y') {
                   $('#comment_content'+id).parent().parent().remove();
                } else {

                   alert('The comment was not deleted.');
                }
//                $('#comment_content'+id).html('<font class="ArialVeryDarkGreyBold15">'+name+'</font>&nbsp;<font class="ArialVeryDarkGrey15" style="color:#F63; font-style: italic;">Comment has been deleted.</font>');
            }
        });
    }
    // For send invitaion
    function sendInvitation(buddyid,senderId,eventId){
//POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
        $.ajax({
            type: "POST",
            url: "invite<?php echo CreateURL('index.php',"mod=ajax&do=invite");?>",
            data: { buddyid:buddyid,senderId:senderId,eventId:eventId },
            //dataType: 'json',
            cache: false,
            success: function(data)
            {
                if(data == 'OK') {
                    $('#buddy-'+buddyid).html('<a class="invite-button" >invited</a>');
                }

            }
        });
    }

</script>
<script type="text/javascript">
    function initMap() {
        // Create the map.
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: {lat: <?= $eventLat ?>, lng: <?= $eventLong ?>},
            disableDefaultUI: true,
            scrollwheel: false,
        });

        // Add the circle for this city to the map.
        var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: {lat: <?= $eventLat ?>, lng: <?= $eventLong ?>},
            radius: 100
        });

        // Create the map.
        var map_mobile = new google.maps.Map(document.getElementById('map_mobile'), {
            zoom: 16,
            center: {lat: <?= $eventLat ?>, lng: <?= $eventLong ?>},
            disableDefaultUI: true,
            scrollwheel: false,
        });

        // Add the circle for this city to the map.
        var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map_mobile,
            center: {lat: <?= $eventLat ?>, lng: <?= $eventLong ?>},
            radius: 100
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHXsI2hOfs6x7NJLR8LnN5wG-2N-ha0S8&callback=initMap">
</script>



<?php
$sql = "SELECT * from events where event_id=$event_id";
//print_r($sql);exit;
$eventData = $DB->RunSelectQuery($sql);
foreach ($eventData as $data) {
    $result = (array)$data;
    $userid = $result["user_id"];
    $event_name = $result["event_name"];
    $start_date = $result["start_date"];
    $event_price = $result["event_price"];
}
//Check if event is a PING
if ($result["entry_type"] == "") {
    header('Location:' . $site_url);
}
//$userid is the id of the organiser

$sql2 = "SELECT * from public_users where id=$userid";
//print_r($sql2);exit;
$userData = $DB->RunSelectQuery($sql2);
foreach ($userData as $data) {
    $resultuser = (array)$data;
    $emailto = $resultuser["email"];
    $organiser_name = $resultuser["firstname"];
}



//Check if current user and event_organiser are buddies
$sql  = "SELECT * from buddies where user_id=$current_user_id and buddy_id=$userid";
$stmt = $DB->RunSelectQuery($query);
if (Count($stmt) < 1 && $userid !== $current_user_id) {

    header('Location: ' . $site_url);
}

$userMailID = $_SESSION['user_email'];

$sql5   = "SELECT * from public_users where email='$userMailID'";
$stmt = $DB->RunSelectQuery($sql5);
foreach ($stmt as $data) {
    $resultuser = (array)$data;
    $loggedInUserId = $resultuser['id'];}
//   print_r($loggedInUserId);exit;
?>


<!-- The Cancel Event Modal -->
<div id="cancelpopup" class="modal" >

    <!-- Modal content -->
    <div class="modal-content" style="width:400px; padding:10px">
        <table width="420" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td height="10"></td>
            </tr>
            <tr>
                <td height="20" class="ArialOrange18">&nbsp;&nbsp;Cancel Event<br />
                    <br /></td>
            </tr>
            <tr>
                <td class="ArialVeryDarkGrey15"><table width="400" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>&nbsp;&nbsp;Are you sure you want to cancel this event?</td>
                            <td width="10">&nbsp;</td>
                            <td><form action="" method="post"><input class="standardbutton" style="cursor:pointer" type="submit" id="cancelyesbutton" name="cancelyesbutton" value="Yes" />
                                    <input type="hidden" name="eventid" id="eventid" value="<?= $event_id ?>" /></form></td>
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

<body>

<div id="ping-detail-page-wrapper">
    <div class="container">
        <div class="col-md-7 goes-on-left">
            <?
            $sql = "SELECT * from events where event_id=$event_id";
            $eventData = $DB->RunSelectQuery($sql);

            foreach ($eventData as $event) {
                $result = (array)$event;

                $userid = $result["user_id"];
            }?>
                <div class="row has-event-message">
                    <?php
                    $sql2 = "SELECT * from public_users where id= $userid";
                    $userData = $DB->RunSelectQuery($sql2);

                    foreach ($userData as $data) {
                    $public_user = (array)$data;
                    $profilepic = $public_user['profile_pic'];
                    ?><?php
                    if ($profilepic == "") {
                        ?>
                        <div class="event-message-image col-sm-1"><img class="image-has-radius" src="images/no_profile_pic.gif"
                                                                       alt="event-image"></div>
                        <?
                    } else {
                        ?>
                        <div class="event-message-image col-sm-1"><img class="image-has-radius" src="<?
                            echo ROOTURL . '/' . $profilepic;
                            ?>" alt="event-image"></div>
                        <?
                    }
                    ?>
                    <div class="event-message-content col-sm-11"><strong><?= $resultuser["firstname"] ?></strong>
                        <p>has pinged a meetup.</p></div>

                    </div>
                    <div class="row has-heading-for-event">
                        <h3><strong><?= $result["event_name"] ?></strong></h3>
                    </div>
                    <div class="row has-date-time">
                        <span><?= date("j F Y", strtotime($result["start_date"])) ?></span><span class="make-space">|</span><span><?
                            echo date("g:ia", strtotime($result["start_time"]));
                            ?></span>
                    </div>

                    <div class="row has-description">
                        <p>There is a promotion at <span class="has-event-name"><?= $result["event_name"] ?></span> ...let's go!</p>
                    </div>
                    <?php
//                    print_r($userid);exit;
                    if($userid!=$_SESSION['user_id']){

//            echo "<pre>";
//            print_r($stmt3->rowCount());
                        ?>
                        <div class="row " id="join_meetup_content">
                            <?
                            //            $userMailID = $_SESSION['login_user_email'];
                            //
                            //            $sql5   = "SELECT * from public_users where email=:userMailID";
                            //            $stmt5  = $pdo->prepare($sql5);
                            //            $stmt5->bindParam(':userMailID', $userMailID, PDO::PARAM_INT);
                            //            $stmt5->execute();
                            //
                            //            while ($resultuser = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                            //            $loggedInUserId = $resultuser['id'];

                            $sql3  = "SELECT * from event_bookings where user_id= $loggedInUserId and event_id=$event_id";
                            $stmt3 = $DB->RunSelectQuery($sql3);


                            if ($stmt3 < 1 ) {


                                ?>
                                <button class="btn btn-custom_535 btn_bold" type="submit" name="bookbtn" id="bookbtn"
                                        value="Join meetup">Join meetup
                                </button>
                                <input type="hidden" name="book_status" id="book_status" value="N"/>
                                <?
                            } else {
                                ?>
                                <span> You have joined this meetup.</span>
                                <button class="btn btn-custom_535 btn_bold" type="submit" name="bookbtn" id="bookbtn"
                                        value="Leave meetup">Leave meetup
                                </button>
                                <input type="hidden" name="book_status" id="book_status" value="Y"/>
                                <?
                            }
                            ?><?php

                            ?>        </div>


                    <?php }
                    $status = "Confirmed";
                    $sql4 = "Select p.profile_pic,concat(p.firstname,' ',p.lastname) as name ,b.* from event_bookings b left join public_users as p on p.id= b.user_id where event_id=$event_id and booking_status like '$status'";

                    $getallgoing = $DB->RunSelectQuery($sql4);
                    if(!is_array($getallgoing))
                    {
                        $getallgoing=array();
                    }
//                    echo"<pre>";
//        print_r($getallgoing);exit();

                    ?>

                    <div class="row how-many-joined">
                        <span><span class="has-number"><?php echo Count($getallgoing);?></span> people joined</span><span class="make-more-space"></span><button type="button" class="btn btn-custom_468 btn_bold" data-toggle="modal" data-target="#exampleModalPing"> See All  </button>
                    </div>


                    <div class="row has-map">
                        <div id="map" style="height:200px;"></div>
                    </div>

                    <div class="row has-comments">
                        <div class="has-title"><h4>Comments</h4></div>
                        <div class="has-comment-area"><?php
                            if ($profilepic == "") {
                                ?>
                                <div class="Comments-message-image"><img class="image-has-radius" src="images/no_profile_pic.gif" alt="event-image"></div>
                                <?
                            } else {
                                ?>
                                <div class="Comments-message-image"><img class="image-has-radius" src="<?
                                    echo ROOTURL . '/' . $profilepic;
                                    ?>" alt="event-image"></div>
                                <?
                            }
                            ?>
                            <input type="textarea" class="comment-area textboxbasicborder"  name="sendcommentbtn" id="comment_message"  placeholder="Send a Comment...">
                            <input class="standardgreybutton" style="cursor:pointer" type="submit" name="sendcommentbtn" id="sendcommentbtn" value="Send" />
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?
                $sql  = "Select * from comments where event_id=$event_id order by id desc";
                $stmtComment = $DB->RunSelectQuery($sql);
                if(!is_array($stmtComment))
                {
                    $stmtComment=array();
                }
                ?>
                <input type="hidden" value="<?= Count($stmtComment) ?>" id="comments_number" />

                <div class="row comments-to-display" id="commentsdisplay">
                    <?
                    if (Count($stmtComment) > 0) {
                      foreach ($stmtComment as $data){
                          $result =(array)$data;
                            ?>
            <div class="commentli">
                <div style="display:inline-block; vertical-align:top; width:35px">

                    <?
                    $userId = $result["user_id"];
                    $sql2 = "SELECT * from public_users where id=$userId";
                    $query = $DB->RunSelectQuery($sql2);
                    foreach ($query as $data){
                        $resultuser = (array)$data;
                        $profilepic = $resultuser['profile_pic'];
                        $user_name = $resultuser['firstname']." ".$resultuser['lastname'];
                        if ($current_profile_pic == "") {
                            ?>

                            <img width="30" height="30" valign="middle" style="border-radius:100px" src="images/no_profile_pic.gif" />
                        <? }else{ ?>
                            <img width="30" height="30" valign="middle" style="border-radius:100px" src="<? echo ROOTURL . '/' .$current_profile_pic; ?>" />
                        <? }
                    }?>
                </div>
                <div style="display:inline-block; width:10px; vertical-align:top;"><div style="height:5px"></div><img src="images/speech_triangle.gif" width="10"></div>
                <div style="display:inline-block;">
                    <div style="height:5px"></div>
                    <div style="border-radius:0px 3px 3px 3px; padding:5px" id="comment_content<?=$result["id"] ?>">
                        <font class="ArialVeryDarkGreyBold15"><? echo $user_name; ?></font>
                        <font class="ArialVeryDarkGrey15">  <? echo $result["comment"] ?></font>
                        <br>
                        <div style="display:inline-block;">
                            <font class="ArialVeryDarkGrey15" style="color:#999; font-size:13px"><?=date("j M", strtotime($result["entry_date"])) ?>, <?=date("h:i a", strtotime($result["entry_date"])) ?></font>
                        </div>
                        &nbsp;&nbsp;
                        <div style="display:inline-block; cursor:pointer" onclick="delete_comment(<?=$result["id"] ?>, '<?=$user_name ?>')"><font class="ArialVeryDarkGrey15" style="color:#F63; font-size:13px">Delete</font>
                        </div>
                    </div>
                </div>




                            </div>
                            <?
                        } }else{ ?>
                        <div style="height:25px; width:100% margin: 0 auto; text-align:center"><div style="height:12px"></div><font class="ArialVeryDarkGrey15">No comments yet...</font></div>
                        <?
                    }
                    ?>
                </div>


<!--            --><?// }?>
        </div>
        <?php
//        $event_id = $_REQUEST['eventid'];
//        function check_invited_user($id)
//        {
//            global $DB,$event_id;
//
////            $event_id = $_REQUEST['eventid'];
//            $qryTogetinvited =" SELECT count(*) as total from event_bookings where user_id = $id AND event_id = $event_id";
//            $UserBuddyList = $DB->RunSelectQuery($qryTogetinvited);
//            foreach ($UserBuddyList as $data)
//            {
//                $invitedBuddyList =(array)$data;
//            }
//            return $invitedBuddyList[0]['total'];
//        }
//        function check_isinvited_user($id)
//        {
//            global $DB,$event_id;
//            $qryTogetinvited =" SELECT count(*) as total from notifications where user_id = $id AND event_id = $event_id";
//
//            $invitedBuddyList =  $qryTogetinvited->fetchAll();
//            $UserBuddyList = $DB->RunSelectQuery($invitedBuddyList);
//            foreach ($UserBuddyList as $data)
//            {
//                $invitedBuddyList =(array)$data;
//            }
//            return $invitedBuddyList[0]['total'];
//        }

        $status = "Confirmed";
        $qryToFetchBuddy =" SELECT buddies.buddy_id, public_users.profile_pic, CONCAT(public_users.firstname, ' ', public_users.lastname ) As FullName
        FROM buddies INNER JOIN public_users ON buddies.buddy_id=public_users.id WHERE user_id = $loggedInUserId AND status = '$status'";
        $UserBuddyList =$DB->RunSelectQuery($qryToFetchBuddy);
        if(!is_array($UserBuddyList))
        {
            $UserBuddyList =array();
        }

//          $friend = $list[0];
        ?>
        <div class="col-md-4">
        <?php if(count($UserBuddyList) < 1){?>
            <div class="row" id="has-invite-friends">
                <h4><strong>Invite your friends</strong></h4>
                <br/>
                <span>No Friend Available</span>
            </div>
            <?php }else{?>
                <div class="row" id="has-invite-friends">
                    <h4><strong>Invite your friends</strong></h4>
                    <br/>


                    <?php  foreach ($UserBuddyList as $buddyData) {
                        $buddy = (array)$buddyData;

                        if (isset($buddy['profile_pic']) && $buddy['profile_pic'] != '') {
                            $img =  $buddy['profile_pic'];
                        } else {
                            $img = 'images/profile_img.jpg';

                        }
                        ?>
                        <div class="has-invites">
                        <span class="buddy-img"><img class="image-has-radius" src="<?php echo $img ?>"
                                                     alt="event-image"></span>
                            <span class="make-more-space"></span>
                            <span><strong><?php echo $buddy['FullName'] ?></strong></span>
                            <a class="invite-button">invite</a>
                        </div>
                    <?php } ?>


                    <div class="has-see-all-friends-btn">
                        <button class="btn btn-primary">See all friends</button>
                    </div>
                </div>
                <?php }?>


        </div>
        <?php
        ?>
    </div>
</div>
<!-- Modal for see alll -->
<div class="modal fade" id="exampleModalPing" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal">People Joined</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
    <div class="modal-body">
        <div class="container">
        <div class="tab-content">
        <div id="going" class="tab-pane fade in active">
<!--                            <div id="container" class="search-name">-->
<!--                                <input type="text" id="searchname" placeholder="Search Tutorials Here... Ex: Java, Php, Jquery..."/>-->
<!--                                <input type="button" id="button" value="Search" />-->
<!--                                <ul id="result"></ul>-->
<!--                            </div>-->
<!--                         --><?//php?>
        <div>
            <?php foreach ($getallgoing as $data )
            {
                $goin_user =(array)$data;
            if(isset($goin_user['profile_pic'])&&$goin_user['profile_pic']!='')
                {
                $img = $site_url.$goin_user['profile_pic'];
                }
                 else
                {
                $img =  $site_url.'images/profile_img.jpg';
                }
            ?>
        <div class="has-invites">
            <span class="pop-up-img">
                <img class="image-has-radius"src="<?php echo $img; ?>" alt="event-image">
            </span>
            <span class="make-more-space"></span>
            <span><strong><?php echo $goin_user['name']?></strong></span>

        </div>
            <?php  }?>
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
<script>
    $(document).ready(function(){

        function search(){

            var title=$("#searchname").val();
            var eventId = <?php echo $event_id ?>;
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