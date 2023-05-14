<?php

session_start(); // Start a new or resume an existing session

function prevent_xpath_injection(string $input){
    if (!preg_match('/[^a-zA-Z0-9]+\'/',$input)){
        http_response_code(403);
        header('Content-Type: application/json'); 
        $message = array("message" => "Request couldn't process for some reasons");
        echo json_encode($message);
        die();
    }
    else {
        return $input;
    }
}

if (isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    // $username = prevent_xpath_injection($username);
    // $password = prevent_xpath_injection($password);


    $xml = simplexml_load_file('./sensitive-data.xml');
    $result = $xml->xpath("//users/user[username = '$username' and password = '$password']");
    if (!empty($result)){
        $_SESSION['username'] = $username; // Set the session variable
        header("Location: admin.php"); // Redirect to the dashboard page
    }
    else
    {
        http_response_code(401);
        header('Content-Type: application/json'); 
        $message = array("message" => "username or password is not correct");
        echo json_encode($message);
    }
}
else{
    header("Location: login.php");
}
?>