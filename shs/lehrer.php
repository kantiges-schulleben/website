<?php
    //get
    //titel -> session name

    //need
    /*
    * name -> session name
    * host.externalId -> Id of the user in your system.
    * duration
    */

    include_once("/include/functions.inc.php");

    session_start();

    $output = "0";

    if (isset($_SESSION['user']) === false || isset($_SESSION['typ']) === false) {
        $output .= "login";
        echo $output;
        exit();
    }

    $teacher = $_SESSION['user'];
    $tid = sqlReturn(SQL("SELECT id FROM handschlag WHERE name LIKE ?", [$teacher]), 0, "id");

    //$duration = $_POST['duration'];
    $duration = 3600 + 600; // 1h + 10 min Puffer
    $title = $_POST['data'];

    $rawStudents = sqlReturn(SQL("SELECT * FROM handschlag WHERE name LIKE ?", [$teacher]), 0, "partner");

    $students = [];
    $ids = [];

    $tmp = "";

    for ($i = 0; $i < strlen($rawStudents); $i++){
        if ($rawStudents[$i] != ",") {
            $tmp .= $rawStudents[$i];
        } else {
            array_push($students, $tmp);

            array_push($ids, sqlReturn(SQL("SELECT id FROM handschlag WHERE name LIKE ?", [$tmp]), 0, "id"));

            $tmp = "";
        }
    }

    if ($tmp !== "") {
        array_push($students, $tmp);

        array_push($ids, sqlReturn(SQL("SELECT id FROM handschlag WHERE name LIKE ?", [$tmp]), 0, "id"));

        $tmp = "";
    }

    // check===============================================================================
    $boolActive = [];

    foreach ($students as $value) {
        $result = sqlReturn(SQL("SELECT terminlink FROM handschlag WHERE name LIKE ?", [$value]), 0, "terminlink");
        $boolStudentActive = false;

        if ($result !== "") {
            $link = "";
            $time = "";
            $endOfLink = false;

            for ($i = 0; $i < strlen($result); $i++){
                if ($endOfLink == true) {
                    $time .= $result[$i];
                } else {
                    if ($result[$i] != ";") {
                        $link .= $result[$i];
                    } else {
                        $endOfLink = true;
                    }
                }
            }

            $currentTime = time();
            $time = intval($time);

            if ($currentTime - $time < $duration){//4200) {
                $boolStudentActive = true;
            }
        }

        array_push($boolActive, $boolStudentActive);
    }

    $notReady = false;
    $names = "";

    for ($i = 0; $i < count($boolActive); $i++) {
        if ($boolActive[$i] == true) {
            $names .= $students[$i] . ", ";
            $notReady = true;
        }
    }

    if (strlen($names) > 0) {
        $names = substr($names, 0, -2);

        $output = '1' . $names . " hat/haben gerade eine andere Unterrichtseinheit.";

        echo $output;
        exit();
    }


    //API-Call=============================================================================

    //create Session==========================================
    $key = "API-KEY";

    $data =  array(
        'name' => $title,
        'host' => array(
            "externalId" => 10000 + intval($tid),
            "name" => "Lehrer"
        ),
        'duration' => $duration,
        'shared' => 'true'
    );

    $result = APIpost('https://app.liveboard.online/api/v3ext/session', $data, $key);

    $result = json_decode($result, true);

    if (in_array('id', $result['payload']) === true) {
    } else {
        echo "1Es ist ein Fehler aufgetreten. Bitte setzte dich mit uns in Verbindung, sollte dies mehrmals passieren.";
        exit();
    }

    $payload = $result['payload'];
    
    $sessionID = $payload['id'];

    //create Link for teacher===============================================================
    $data = [
        'externalId' => strval(10000 + intval($tid)),
        'nativeSupport' => 'true',
        'name' => "Lehrer"
    ];

    $result = APIpost('https://app.liveboard.online/api/v3ext/session/' . $sessionID . '/link', $data, $key);


    $result = json_decode($result, true);

    $payload = $result['payload'];
    
    $tlink = $payload['sessionLink'];

    //create Link for student/s=============================================================
    $sLinks = [];

    for ($stud = 0; $stud < count($students); $stud++) {
        $data = [
            'externalId' => strval(10000 + intval($ids[$stud])),
            'nativeSupport' => 'true',
            'name' => "schueler"
        ];
    
        $result = APIpost('https://app.liveboard.online/api/v3ext/session/' . $sessionID . '/link', $data, $key);
    
    
        $result = json_decode($result, true);
    
        $payload = $result['payload'];
        
        array_push($sLinks, $payload['sessionLink']);
    }
    
    

    //=====================================================================================

    //save link to db========================================

    $t = time();
    //teacher
    SQL("UPDATE handschlag SET terminlink=? WHERE name LIKE ?", [$tlink . ";" . strval($t), $teacher]);

    //student/s

    for ($sLink = 0; $sLink < count($students); $sLink++) {
        SQL("UPDATE handschlag SET terminlink=? WHERE name LIKE ?", [$sLinks[$sLink] . ";" . strval($t), $students[$sLink]]);
    }
    

    //=============================================================================
    echo "0" . $tlink;
?>
