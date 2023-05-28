<?php
header("Content-Type: application/json; charset=UTF-8"); // set response content type to JSON

$conn = new mysqli("localhost", "id20615795_meedb", "%JYI3uMPasixas!e", "id20615795_mee");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// prepare the SQL statement
if (isset($_REQUEST['id'])) {
    $stmt = $conn->prepare("DELETE FROM `notes` WHERE `note_id`=?");
    $stmt->bind_param("i", $_REQUEST['id']);

    // execute the SQL statement
    if ($stmt->execute()) {
        // return a success response
        http_response_code(200);
        echo json_encode(array("message" => "Note deleted successfully"));
    } else {
        // return an error response
        http_response_code(500);
        echo json_encode(array("message" => "Error deleting note: " . $stmt->error));
    }
} else {
    // return an error response
    http_response_code(500);
    echo json_encode(array("message" => "No ID was provided"));
}


// close the database connection
$stmt->close();
$conn->close();
