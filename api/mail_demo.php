<?php 
 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json'); 

// Import PHPMailer classes into the global namespace 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
 
require '../PHPMailer/src/Exception.php'; 
require '../PHPMailer/src/PHPMailer.php'; 
require '../PHPMailer/src/SMTP.php'; 

$data = json_decode(file_get_contents('php://input'), true);
$tableData = $data['data'];

$mail = new PHPMailer; 
 
$mail->isSMTP();                      // Set mailer to use SMTP 
$mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers 
$mail->SMTPAuth = true;               // Enable SMTP authentication 
$mail->Username = '';   // SMTP username 
$mail->Password = '';   // SMTP password 
$mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
$mail->Port = 587;                    // TCP port to connect to 
 
// Sender info 
$mail->setFrom('', 'Warehouse Management System'); 

// Add a recipient 
$mail->addAddress(($data['address'] ? $data['address'] : '')); 
 
// Set email format to HTML 
$mail->isHTML(true);

// Mail subject 
$mail->Subject = $data['subject'] ? $data['subject'] : ''; 
 
// Mail body content 
// start table
$html = '<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>WMS</title>

<style>
  body,
  table,
  td,
  a {
    -webkit-text-size-adjust: 100%;
    -ms-text-size-adjust: 100%;
  }

  table,
  td {
    mso-table-lspace: 0pt;
    mso-table-rspace: 0pt;
  }

  img {
    -ms-interpolation-mode: bicubic;
  }
  
  .page-header{
    width: 50%;
    height: 55px;
    font-size: 25px;
    line-height: 27px;
    color: #acb6c2;
    font-weight: bold;
  }
  .details-table {
    width: 80%;
    table-layout: fixed;
    border-collapse: collapse;
  }

  .details-table tbody {
    display: block;
    height: auto;
    width: 100%;
    overflow: auto;
    border-right: 0.5px solid #C8C8C8;
    border-left: 0.5px solid #C8C8C8;
  }

  .details-table thead tr {
    display: block;
  }

  .details-table th {
    width: 333px;
    height: 45px;
    border-top: 6px solid #8FACBB;
    padding: 10px 20px;
    color: #FFFFFF;
    background-color: #3A454E;
    border-collapse: collapse;
    border-right: 0.5px solid #C8C8C8;
    border-left: 0.5px solid #C8C8C8;
  }

  .details-table td {
    width: 333px;
    height: 40px;
    text-align: center;
    padding: 10px 20px;
    border-right: 0.5px solid #C8C8C8;
    border-left: 0px;
    color: #3A454E;
    border-bottom: 0.5px solid #C8C8C8;
  }

</style>
</head>

<body style="margin:0;padding:0;min-width:100%;background-color:#ffffff; font-family:Arial, Helvetica, sans-serif;"
bgcolor="#ffffff">
<span class="page-header">' . ($data['subject'] ? $data['subject'] : '') . '</span>
<br>
<br>
<table id="table-details" class="details-table">
  <thead>
    <tr>';
foreach($tableData[0] as $key=>$value){
    $html .= '<th>' . htmlspecialchars($key) . '</th>';
}

 $html.='</tr>
  </thead>
  <tbody>';
  foreach( $tableData as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td>' . htmlspecialchars($value2) . '</td>';
        }
        $html .= '</tr>';
    }
    
$html .= '</tbody>
</table>

</body>

</html>';

$mail->Body    = $html; 
 
// Send email 
if(!$mail->send()) { 
    echo json_encode(
        array('status'=> 400,
        'message' => 'Email could not be sent. Mailer Error: '.$mail->ErrorInfo)
    );  
} else {
    echo json_encode(
        array('message' => 'Email has been sent.')
    );  
} 
 
?>