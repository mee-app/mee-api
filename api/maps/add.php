<?php
header("Content-Type: application/json; charset=UTF-8"); // set response content type to JSON
$json = file_get_contents('php://input');
$data = json_decode($json);

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
$stmt = $conn->prepare("INSERT INTO `maps`( `title`, `address`, `latitude`, `longitude`, `info`, `createdAt`, `owner`) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("sssssss", $title, $address, $latitude, $longitude, $info,$createdAt,$owner);

// execute the SQL statement
if ($stmt->execute()) {
    $mapId = $stmt->insert_id;
    $map = array(
        "map_id" => $stmt->insert_id,
        "title" => $title,
        "address" => $address,
        "latitude" => $latitude,
        "longitude" => $longitude,
        "info" => $info,
        "createdAt" => $createdAt,
        "owner" => $owner
    );
    // return a success response
    http_response_code(200);
    // echo json_encode(array("message" => "User created successfully"));
    echo json_encode($map);
} else {
    // return an error response
    http_response_code(500);
    echo json_encode(array("message" => "Error creating user: " . $stmt->error));
}

// close the database connection
$stmt->close();
$conn->close();