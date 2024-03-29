<?php
header("Content-Type: application/json; charset=UTF-8"); // set response content type to JSON

$json = file_get_contents('php://input');
$data = json_decode($json);

$noteId = $data->note_id;
$title = $data->title;
$content = $data->content;
$date = $data->date;
$color = $data->color;
$owner = $data->owner;

$conn = new mysqli("localhost", "id20615795_meedb", "%JYI3uMPasixas!e", "id20615795_mee");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// prepare the SQL statement
$stmt = $conn->prepare("UPDATE `notes` SET `title`=?, `content`=?, `date`=?, `color`=?, `owner`=? WHERE `note_id`=?");
$stmt->bind_param("sssssi", $title, $content, $date, $color, $owner, $noteId);

// execute the SQL statement
if ($stmt->execute()) {
    $note = array(
        "id" => $noteId,
        "title" => $title,
        "content" => $content,
        "date" => $date,
        "color" => $color,
        "owner" => $owner
    );
    // return a success response
    http_response_code(200);
    echo json_encode($note);
} else {
    // return an error response
    http_response_code(500);
    echo json_encode(array("message" => "Error updating note: " . $stmt->error));
}

// close the database connection
$stmt->close();
$conn->close();
