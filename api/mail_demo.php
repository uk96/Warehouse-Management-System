<?php 
 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json'); 

// Import PHPMailer classes into the global namespace 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
 
require 'C:/xampp/htdocs/PHPMailer-master/src/Exception.php'; 
require 'C:/xampp/htdocs/PHPMailer-master/src/PHPMailer.php'; 
require 'C:/xampp/htdocs/PHPMailer-master/src/SMTP.php'; 

$data = json_decode(file_get_contents('php://input'), true);
$tableData = $data['data'];
 
$mail = new PHPMailer; 
 
$mail->isSMTP();                      // Set mailer to use SMTP 
$mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers 
$mail->SMTPAuth = true;               // Enable SMTP authentication 
$mail->Username = 'user@gmail.com';   // SMTP username 
$mail->Password = 'gmail_password';   // SMTP password 
$mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
$mail->Port = 587;                    // TCP port to connect to 
 
// Sender info 
$mail->setFrom('sender@codexworld.com', 'CodexWorld'); 
$mail->addReplyTo('reply@codexworld.com', 'CodexWorld'); 
 
// Add a recipient 
$mail->addAddress('recipient@example.com'); 
 
//$mail->addCC('cc@example.com'); 
//$mail->addBCC('bcc@example.com'); 
 
// Set email format to HTML 
$mail->isHTML(true); 
 
// Mail subject 
$mail->Subject = 'Email from Localhost by CodexWorld'; 
 
// Mail body content 
// start table
$html = '<table>';
// header row
$html .= '<tr>';
foreach($tableData[0] as $key=>$value){
        $html .= '<th>' . htmlspecialchars($key) . '</th>';
    }
$html .= '</tr>';

// data rows
foreach( $tableData as $key=>$value){
    $html .= '<tr>';
    foreach($value as $key2=>$value2){
        $html .= '<td>' . htmlspecialchars($value2) . '</td>';
    }
    $html .= '</tr>';
}

// finish table and return it

$html .= '</table>';
$mail->Body    = $html; 
 
// Send email 
if(!$mail->send()) { 
    echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo; 
} else { 
    echo 'Message has been sent.'; 
} 
 
?>