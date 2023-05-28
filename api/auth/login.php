<?php
header("Content-Type: application/json; charset=UTF-8"); // set response content type to JSON

$json = file_get_contents('php://input');
$data = json_decode($json);

$email = $data->email;
$password = $data->password;

$conn = new mysqli("localhost", "id20615795_meedb", "%JYI3uMPasixas!e", "id20615795_mee");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare the SQL statement
$stmt = $conn->prepare("SELECT * FROM `user` WHERE `email` = ?");
$stmt->bind_param("s", $email);

// execute the SQL statement
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        http_response_code(200);
        $user = array(
            "user_id" => $row['user_id'],
            "username" => $row['username'],
            "email" => $row['email'],
            // "token" => $row['token'],
        );
        echo json_encode($user);
    } else {
        echo false;
    }
} else {
    // return an error response
    http_response_code(500);
    echo json_encode(array("message" => "Error creating user: " . $stmt->error));
}

// close the database connection
$stmt->close();
$conn->close();
