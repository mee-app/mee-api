<?php
//Connect to your database
$conn = new mysqli("localhost", "id20615795_meedb", "%JYI3uMPasixas!e", "id20615795_mee");

if (isset($_GET['user_id'])){
    $result = $conn->query("SELECT * FROM notes WHERE owner = ".$_GET['user_id']);
}else{
    $result = $conn->query("SELECT * FROM notes");
}


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
?>
