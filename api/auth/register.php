<?php
header("Content-Type: application/json; charset=UTF-8"); // set response content type to JSON

$json = file_get_contents('php://input');
$data = json_decode($json);

$username = $data->username;
$email = $data->email;
$password = $data->password;
$hashed = password_hash($password, PASSWORD_DEFAULT);
$token = uniqid($username, true);

$conn = new mysqli("localhost", "id20615795_meedb", "%JYI3uMPasixas!e", "id20615795_mee");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO `user`(`username`, `email`, `password`) VALUES (?,?,?)");
$stmt->bind_param("sss", $username, $email, $hashed);

// execute the SQL statement
if ($stmt->execute()) {
    // return a success response
    http_response_code(200);
    echo "Sending mail";
    $to = $email;
    $subject = 'Subject of your email';
    $message = '<html><head> <title>Verify Your Account</title> <style> body { font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 0; margin: 0; } .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #fff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 5px; } h1 { font-size: 24px; margin-top: 0; } p { font-size: 16px; line-height: 1.5; } a { color: #2196f3; text-decoration: none; } a:hover { text-decoration: underline; } </style></head><body> <div class="container"> <h1>Verify Your Account</h1> <p>Thank you for creating an account with Mee. To activate your account, please click on the following link:</p> <p><a href="https://meedb.000webhostapp.com/' . $token . '">Verify Account</a></p> <p>If you did not create an account on our website, please ignore this email.</p> </div></body></html>';
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: meedatabase@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    if(mail($to, $subject, $message, $headers)){
        echo "Mail sent!";
    }else{
        echo "Error mail";
    }
    
} else {
    // return an error response
    http_response_code(500);
    echo json_encode(array("message" => "Error creating user: " . $stmt->error));
}

// close the database connection
$stmt->close();
$conn->close();
