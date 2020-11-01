<?php
    function SQL($prepareStatement, $parameter) {
        $servername = "localhost";
        $username = "USERNAME";
        $password = "PASSWORD";
        $dbname = "DBNAME";

        // =======================================================================================

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            echo die("Hoppla! Es hat etwas nicht funktioniert.");
        }

        $sql = $conn->prepare($prepareStatement);

        // $sql->bind_param(str_repeat("s", count($parameter)), ...$parameter);

        $strings = str_repeat("s", count($parameter));
        array_unshift($parameter, $strings);

        call_user_func_array(array($sql, "bind_param"), $parameter);

        $sql->execute();

        $result = $sql->get_result();

        $sql->close();
        $conn->close();

        return $result;
    }


    function toString($arg) {
        $tmp = "";
        foreach ($arg as $value) {
            $tmp = $tmp . $value;
        }
        return $tmp;
    }

    function sqlReturn($search, $row, $field){
        $i=0;
        while($results=mysqli_fetch_array($search)){
            if ($i==$row){
                $result=$results[$field];
            }
            $i++;
        }
        return $result;
    }

    function APIpost($url, $data, $key) {
        // Initializes a new cURL session
        $curl = curl_init($url);

        // Set the CURLOPT_RETURNTRANSFER option to true
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Set the CURLOPT_POST option to true for POST request
        curl_setopt($curl, CURLOPT_POST, true);

        // Set the request data as JSON using json_encode function
        curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));

        // Set custom headers for RapidAPI Auth and Content-Type header
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'X-Liveboard-Api-Key: ' . $key,
            'Content-Type: application/json'
        ]);

        // Execute cURL request with all previous settings
        $response = curl_exec($curl);

        // Close cURL session
        curl_close($curl);
        return $response;
    }
?>
