<?php
$filename = 'sendme.txt';
$file_path = '../../' . $filename;
$to = 'ruizalfa6@gmail.com';
$subject = 'Mee Register';
$message = '<html><head> <style> body { font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 0; margin: 0; } .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #fff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 5px; } h1 { font-size: 24px; margin-top: 0; } p { font-size: 16px; line-height: 1.5; } a { color: #2196f3; text-decoration: none; } a:hover { text-decoration: underline; } .split-left { width: 60%; float: left; } .split-right { width: 40%; float: right; } @media only screen and (max-width: 400px) { .split-left, .split-right { width: 100%; display: grid; place-items: center; padding-bottom: 20px; } } </style> </head> <body> <div class="container"> <h1>Verify Your Account</h1> <div class="split-left"> <p>Thank you for creating an account with Mee. To activate your account, please click on the following link:</p> <p><a href="https://meedb.000webhostapp.com/1234567890">Verify Account</a></p> </div> <div class="split-right"> <img src="https://meedb.000webhostapp.com/media/mee.png" width="150px" height="150px" /> </div> <br /> <div> <p>If you did not create an account on our website, please ignore this email.</p> </div> </div> </body></html>';


// Read the file content and encode it in base64 format
$file_content = file_get_contents($file_path);
$encoded_content = chunk_split(base64_encode($file_content));

// Generate a random boundary string
$boundary = md5(time());

// Set the email headers
$headers = "From: Conector <meedatabase@gmail.com>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

// Create the email body
$email_body = "--$boundary\r\n";
$email_body .= "Content-Type: text/html; charset=UTF-8\r\n";
$email_body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$email_body .= "$message\r\n";
$email_body .= "--$boundary\r\n";
$email_body .= "Content-Type: application/octet-stream; name=\"$filename\"\r\n";
$email_body .= "Content-Transfer-Encoding: base64\r\n";
$email_body .= "Content-Disposition: attachment; filename=\"$filename\"\r\n\r\n";
$email_body .= "$encoded_content\r\n";
$email_body .= "--$boundary--\r\n";

// Send the email
if (mail($to, $subject, $email_body, $headers)) {
    echo 'Email sent successfully.';
} else {
    echo 'Email sending failed.';
}
