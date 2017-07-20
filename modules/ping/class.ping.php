<?php

/**
 * @author :  Akshay Yadav
 */
class Ping
{


    function createPing($userData)
    {

        global $DB, $frmdata, $userData;
        $characters = 'ab0cd1ef2gh3ij4kl5mn6op7qr8st9uvwxyz';
        $string = '';
        $requestcode = '';
        $max = strlen($characters) - 1;
        $event_code = '';
        for ($i = 0; $i < 15; $i++) {
            $event_code .= $characters[mt_rand(0, $max)];
        }
        $frmdata['event_code'] = $event_code;
        $frmdata['user_id'] = $userData->id;
        $frmdata['start_date'] = date("Y-m-d");
        $frmdata['entry_type'] = "Ping";
        $frmdata['event_status'] = "L";
        $frmdata['event_entry_date'] = date("Y-m-d H:i:s");
        $event_start_time = $frmdata['start_time'];
        $errormessage = array();

        if (isset($frmdata['event_name']) && ($frmdata['event_name'] != '')) {
            $email = trim($frmdata['event_name']);
        } else {
            $errormessage['error']['event_name'] = "Please enter event name.<br>";
        }

        if (isset($frmdata['event_location']) && ($frmdata['event_location'] != '')) {
            $email = trim($frmdata['event_location']);
        } else {

            $errormessage['error']['event_location'] = "Please enter event location.<br>";
        }

        if (count($errormessage) == 0) {
//
            $id = $DB->InsertRecord('events', $frmdata);

            $selectUser = $DB->SelectRecord('events', "user_id='" . $userData->id . "' AND event_code='" . $frmdata['event_code'] . "'");


            $pingLocationData['event_lat'] = $frmdata['event_lat'];
            $pingLocationData['event_location'] = $frmdata['event_location'];
            $pingLocationData['event_long'] = $frmdata['event_long'];
            $pingLocationData['event_id'] = $selectUser->event_id;
//
            $insertDataIntoPingLocationTable = $DB->InsertRecord('ping_locations', $pingLocationData);



                $stmt = "Select * from events where event_code=$event_code order by event_id desc limit 1";

              foreach ($stmt as $data) {
                  $result = (array)$data;
                    $eventid = $result["event_id"];
                  $event_name = $result["event_name"];
                }

                $startdate = date("j F Y", strtotime($event_entry_date));
                $starttime = date("g:ia", strtotime($event_start_time));
                $endtime = date("g:ia", strtotime($event_end_time));

                $message = "<p>You have just pinged a meetup!</p>
		<table width=\"340\" style=\"border:#FFCC66 1px solid;padding:5px;border-radius:3px;\"><tr><td width=\"120\"><img width=\"120\" src=\"http://www.locoyolo.com/" . $photofilename . "\" /></td><td width=\"10\"></td><td>" . $frmdata['event_name'] . "<div style=\"height:5px\"></div><strong>" . $startdate . "</strong> | " . $starttime . "</td></tr></table>";
                $emailmessage = '<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			</head>
			<body>
			<div>
					<p>Hello ' . $_SESSION["user_email"] . '!</p>
					<p>' . $message . '</p>
					<p><strong>LocoYolo Team</strong></p>

			</div>
			</body>
			</html>';
                $to = $_SESSION["login_user_email"];
                $subject = 'New Event: ' . $event_name;
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: mail@locoyolo.com\r\n';
//                mail($to, $subject, $emailmessage, $headers);
                header(ROOTURL."/pingdetails.php?eventid=" . $selectUser->event_id);
            $messagegood = "The event has been added";
        } else {

            return $errormessage;
        }

    }

    function showPingDetail($userEvent_id)
    {
        global $DB,  $userData;
        return $userEvent_id;

    }
    function bookingStatus($event_id)
    {
        global $DB, $userData;
        $result = $DB->SelectRecord('event_bookings', "event_id='" . $event_id . "' AND  user_id='"         . $userData->id . "'");
        return $result;
    }
    function peopleJoined($event_id)
    {
        global $DB, $userData;
        $user_id = $userData->id;
        $status = "Confirmed";
        $query = "Select p.profile_pic,concat(p.firstname,' ',p.lastname) as name ,b.* from event_bookings b left join public_users as p on p.id= b.user_id where event_id =$event_id and booking_status like '$status'";

        $res_data = $DB->RunSelectQuery($query);
        $total = count((array)$res_data);

        return $total;

    }
}

?>