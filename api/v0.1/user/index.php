<?php
	include_once("../functions.inc.php");
	//===================================================================================
	class ApiException extends \Exception
    {
		const AUTHENTICATION_FAILED = 1;
        const MALFORMED_INPUT       = 2;
        const NOT_FOUND = 3;
        const ALLREADY_EXISTING = 4;
    }
	//===================================================================================

    $split = [];

	if (function_exists('getallheaders')) {
		$headers = getallheaders();

		if (isset($headers['Authorization'])) {
			$split = explode('=', $headers['Authorization']);
		}
    }
    

	try {
		if (isset($split[0])) {
            $key = trim($split[0], '"');
            $result = SQL("SELECT * FROM apikeys WHERE api_key LIKE '$key'");

            $count = $result->num_rows;
    
            if ($count === 1) {
                
            } else {
                throw new ApiException('access denied', ApiException::AUTHENTICATION_FAILED);
            }
		}
	} catch (ApiException $e) {
		if ($e->getCode() == ApiException::MALFORMED_INPUT) {
			header('HTTP/1.0 409 Bad Request');
		} elseif ($e->getCode() == ApiException::AUTHENTICATION_FAILED) {
			header('HTTP/1.0 401 Unauthorized');
		} elseif ($e->getCode() == ApiException::NOT_FOUND) {
			header('HTTP/1.0 404 Not found');
		} elseif ($e->getCode() == ApiException::ALLREADY_EXISTING) {
			header('HTTP/1.0 409 Conflict');
        }
	
		$result = ['message' => $e->getMessage()];

		header('Content-Type: application/json');
		echo json_encode($result);
	
		exit();
    }
    //===================================================================================
    
    indexAction();

	//===================================================================================
	function indexAction()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
        
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $result = get((string)$_GET['name'], (string)$_GET['password']);
            } elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
                $result = delete($input);
            } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $result = create($input);
            } elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
                $result = update($input);
            }
        
            header('HTTP/1.0 200 OK');
        } catch (ApiException $e) {
            if ($e->getCode() == ApiException::MALFORMED_INPUT) {
                header('HTTP/1.0 409 Bad Request');
            } elseif ($e->getCode() == ApiException::AUTHENTICATION_FAILED) {
                header('HTTP/1.0 401 Unauthorized');
            } elseif ($e->getCode() == ApiException::NOT_FOUND){
                header('HTTP/1.0 404 Not found');
            } elseif ($e->getCode() == ApiException::ALLREADY_EXISTING) {
                header('HTTP/1.0 409 Conflict');
            }
        
            $result = ['message' => $e->getMessage()];
        }
    
        header('Content-Type: application/json');
        echo json_encode($result);
	}
	//===================================================================================
	function get($name, $password)
    {
        $name = htmlspecialchars($name, ENT_QUOTES);
        $password = htmlspecialchars($password, ENT_QUOTES);
		
		$result = SQL("SELECT * FROM handschlag WHERE name LIKE '$name'");
		
        if ($result->num_rows  === 1) {
            if (password_verify($password, sqlReturn($result, 0, "password"))) {
                $result = SQL("SELECT * FROM handschlag WHERE name LIKE '$name'");
                return mysqli_fetch_array($result, MYSQLI_ASSOC);
            } else {
                throw new ApiException('access denied', ApiException::AUTHENTICATION_FAILED);
            }
        } else {
            throw new ApiException('Person not found', ApiException::NOT_FOUND);
        }
	}
	//===================================================================================
    function create(array $data)
    {
        $keys = array_keys($data);

        $required = ["name", "password", "typ", "partner"];

        // foreach ($required as $value) {
        //     if (in_array($value, $keys, true) === false) {
        //         throw new ApiException('malformed input', ApiException::MALFORMED_INPUT);
        //     }
        // }

        

        $keys = specialChars($keys);
        // $data = specialChars($data);

        $name = $data['name'];

        $result = SQL("SELECT * FROM handschlag WHERE name LIKE '$name'");

        $number = $result->num_rows;

		
        if ($number  > 0) {
            throw new ApiException('a user with this name allready exists', ApiException::ALLREADY_EXISTING);
        }


        // $request = "INSERT INTO handschlag (name, typ, password, mail, partner) VALUES ('$user', '$typ', '$pwd', '$mail','$partner')";
        $request = "INSERT INTO handschlag (";

        foreach ($keys as $key) {
            $request .= $key . ", ";
        }

        $request = substr($request, 0, -2) . ") VALUES (";

        for ($i=0; $i < count($keys); $i++) {
            if ($keys[$i] === "password") {
                $request .= "'" . password_hash($data[$keys[$i]], PASSWORD_DEFAULT) . "', ";
            } elseif ($keys[$i] === "partner") {
                $request .= "'" . $data[$keys[$i]] . ",', ";
            } else {
                $request .= "'" . $data[$keys[$i]] . "', ";
            }
        }

        $request = substr($request, 0, -2) . ")";

        SQL($request);

        return $data;
	}
	//===================================================================================
    function update(array $data)
    {
        $keys = array_keys($data);

        $required = ["name", "password"];

        foreach ($required as $value) {
            if (in_array($value, $keys, true) === false) {
                throw new ApiException('malformed input', ApiException::MALFORMED_INPUT);
            }
        }

        $keys = specialChars($keys);
        // $data = specialChars($data);

        $name = $data['name'];
        $result = SQL("SELECT * FROM handschlag WHERE name LIKE '$name'");
        $password = $data['password'];
		
        if ($result->num_rows  === 1) {
            if (password_verify($password, sqlReturn($result, 0, "password"))) {

            } else {
                throw new ApiException('access denied', ApiException::AUTHENTICATION_FAILED);
            }
        } else {
            throw new ApiException('Person not found', ApiException::NOT_FOUND);
        }



        // $request = "UPDATE handschlag SET terminlink='$sLinks[$sLink]" . ";" . strval($t) . "' WHERE name LIKE '$students[$sLink]'";
        $request = "UPDATE handschlag SET ";

        for ($i=0; $i < count($keys); $i++) {
            if ($keys[$i] === "password") {

            } elseif ($keys[$i] === "newPassword") {
                $request .= "password='" . password_hash($data[$keys[$i]], PASSWORD_DEFAULT) . "', ";
            } else {
                $request .= $keys[$i] . "='" . $data[$keys[$i]] . "', ";
            }
        }

        $request = substr($request, 0, -2) . " WHERE name LIKE '" . $data["name"] . "'";

        SQL($request);

        return $data;
    }
	//===================================================================================
    function delete($data) {
        $keys = array_keys($data);

        $required = ["name", "password"];

        foreach ($required as $value) {
            if (in_array($value, $keys, true) === false) {
                throw new ApiException('malformed input', ApiException::MALFORMED_INPUT);
            }
        }

        $keys = specialChars($keys);
        // $data = specialChars($data);

        $name = $data['name'];
        $password = $data['password'];

        //======================

        $result = SQL("SELECT * FROM handschlag WHERE name LIKE '$name'");
		
        if ($result->num_rows  === 1) {
            if (password_verify($password, sqlReturn($result, 0, "password"))) {
                $request = "DELETE FROM handschlag WHERE name LIKE '" . $name . "'";
                return SQL($request);
            } else {
                throw new ApiException('access denied', ApiException::AUTHENTICATION_FAILED);
            }
        } else {
            throw new ApiException('Person not found', ApiException::NOT_FOUND);
        }
    }

    function specialChars($array) {
        for ($i=0; $i < count($array); $i++) { 
            $array[$i] = htmlspecialchars($array[$i], ENT_QUOTES);
        }

        return $array;
    }
?>