<?php
header("Content-Type: application/json; charset=UTF-8"); // set response content type to JSON
$json = file_get_contents('php://input');
$data = json_decode($json);

$id = $data->todo_id;
$name = $data->name;
$completed = $data->completed;
$desc = $data->desc;
$alarmActivated = $data->alarmActivated;
$notifActivated = $data->notifActivated;
$limitDate = date('Y-m-d H:i:s',strtotime($data->limitDate));

$priority = $data->priority;
$earlyNotif = $data->earlyNotif;
$owner = $data->owner;

$conn = new mysqli("localhost", "id20615795_meedb", "%JYI3uMPasixas!e", "id20615795_mee");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare the SQL statement
$stmt = $conn->prepare("UPDATE `todos` SET `name`=?, `completed`=?, `desc`=?, `alarmActivated`=?, `notifActivated`=?, `limitDate`=?, `priority`=?, `earlyNotif`=? WHERE `todo_id`=? AND `owner`=?");
$stmt->bind_param("sisiisiiii", $name, $completed, $desc, $alarmActivated, $notifActivated, $limitDate, $priority, $earlyNotif,$id, $owner);

// execute the SQL statement
if ($stmt->execute()) {
    $todoId = $stmt->insert_id;
    $todo = array(
        "todo_id" => $stmt->insert_id,
        "name" => $name,
        "completed" => $completed,
        "desc" => $desc,
        "alarmActivated" => $alarmActivated,
        "notifActivated" => $notifActivated,
        "limitDate" => $limitDate,
        "priority" => $priority,
        "earlyNotif" => $earlyNotif,
        "owner" => $owner,
    );
    // return a success response
    http_response_code(200);
    echo json_encode($todo);
} else {
    // return an error response
    http_response_code(500);
    echo json_encode(array("message" => "Error creating todo: " . $stmt->error));
}

// close the database connection
$stmt->close();
$conn->close();
