<?php
header("Content-Type: application/json; charset=UTF-8"); // set response content type to JSON

$json = file_get_contents('php://input');
$data = json_decode($json);

$mapId = $data->map_id;
$title = $data->title;
$address = $data->address;
$latitude = $data->latitude;
$longitude = $data->longitude;
$info = $data->info;
$createdAt = $data->createdAt;
$owner = $data->owner;

$conn = new mysqli("localhost", "id20615795_meedb", "%JYI3uMPasixas!e", "id20615795_mee");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// prepare the SQL statement
$stmt = $conn->prepare("UPDATE `maps` SET `title`=? WHERE `map_id`=?");
$stmt->bind_param("si", $title, $mapId);

// execute the SQL statement
if ($stmt->execute()) {
    // return a success response
    http_response_code(200);
} else {
    // return an error response
    http_response_code(500);
    echo json_encode(array("message" => "Error updating note: " . $stmt->error));
}

// close the database connection
$stmt->close();
$conn->close();
