<?php
    function SQL($statement) {
        $servername = "SERVER";

        // $username = "root";
        $username = "USERNAME";

        // $password = "";
        $password = "PASSWORD";

        // $dbname = "shs";
        $dbname = "DBNAME";

        // =======================================================================================

        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            echo die("Connection failed: " . $conn->connect_error);
        }

        $sql = $statement;

        $result = $conn->query($sql);

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
