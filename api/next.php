<?php
//Connect to your database
$conn = new mysqli("localhost", "id20615795_meedb", "%JYI3uMPasixas!e", "id20615795_mee");

if (isset($_GET['table']) && isset($_GET['name'])){
    $result = $conn->query("SELECT MAX(".$_GET['name'].") as newId FROM ".$_GET['table']);
}


//Check if user exists
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    $json = json_encode($data);

    header("Content-Type: application/json");
    echo $json;
} else {
    header("HTTP/1.1 404 Not Found");
    echo "Note not found";
}
?>
