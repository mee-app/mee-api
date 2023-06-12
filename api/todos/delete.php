<?php
header("Content-Type: application/json; charset=UTF-8"); // set response content type to JSON
$json = file_get_contents('php://input');
$data = json_decode($json);

$id = $data;


$conn = new mysqli("localhost", "id20615795_meedb", "%JYI3uMPasixas!e", "id20615795_mee");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare the SQL statement
$stmt = $conn->prepare("DELETE FROM `todos` WHERE `todo_id`=?");
$stmt->bind_param("i", $id);

// execute the SQL statement
if ($stmt->execute()) {
    // return a success response
    http_response_code(200);
    echo json_encode('Todo deleted succesfully');
} else {
    // return an error response
    http_response_code(500);
    echo json_encode(array("message" => "Error creating todo: " . $stmt->error));
}

// close the database connection
$stmt->close();
$conn->close();
