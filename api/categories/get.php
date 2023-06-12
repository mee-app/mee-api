<?php
//Connect to your database
$conn = new mysqli("localhost", "id20615795_meedb", "%JYI3uMPasixas!e", "id20615795_mee");

$result = $conn->query("SELECT * FROM categories");


//Check if user exists
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $json = json_encode($data);

    header("Content-Type: application/json");
    echo $json;
} else {
    header("Content-Type: application/json");
    echo json_encode(false);
}
