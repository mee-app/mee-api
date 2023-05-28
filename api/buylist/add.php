<?php
header("Content-Type: application/json; charset=UTF-8"); // set response content type to JSON

$json = file_get_contents('php://input');
$data = json_decode($json);
$name = $data->name;
$elements = $data->elements;
$count = $data->count;
$owner = $data->owner;

$conn = new mysqli("localhost", "id20615795_meedb", "%JYI3uMPasixas!e", "id20615795_mee");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO `buylist`(`name`, `elements`, `count`, `owner`) VALUES (?,?,?,?)");
$stmt->bind_param("ssss", $name, $elements, $count, $owner);

// execute the SQL statement
if ($stmt->execute()) {
    $noteId = $stmt->insert_id;
    $note = array(
        "buylist_id" => $stmt->insert_id,
        "name" => $name,
        "elements" => $elements,
        "count" => $count,
        "owner" => $owner
    );
    // return a success response
    http_response_code(200);
    // echo json_encode(array("message" => "User created successfully"));
    echo json_encode($note);
} else {
    // return an error response
    http_response_code(500);
    echo json_encode(array("message" => "Error creating user: " . $stmt->error));
}

// close the database connection
$stmt->close();
$conn->close();
