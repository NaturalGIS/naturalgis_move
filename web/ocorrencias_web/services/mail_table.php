<?php
/* Email Detials */
  $mail_to = "amira@uevora.pt";
  $from_mail = $_SESSION['login_user'];
  $from_name = $_SESSION['name_user'];
  $reply_to = $_SESSION['login_user'];
  $subject = "Novas ocorrências";
  //$message = "test";
  $message = "Utilizador: " . $_SESSION['login_user'] . "\n" .
             "Tabela: " . $newfilename  . "\n";
 
/* Attachment File */
  // Attachment location
  $file_name = $newfilename;
  $path = "/home/mapserver/www/vertebrados_uploads/";
   
  // Read the file content
  $file = $path.$file_name;
  $file_size = filesize($file);
  $handle = fopen($file, "r");
  $content = fread($handle, $file_size);
  fclose($handle);
  $content = chunk_split(base64_encode($content));
   
/* Set the email header */
  // Generate a boundary
  $boundary = md5(uniqid(time()));
   
  // Email header
  $header = "From: ".$from_name." <".$from_mail.">".PHP_EOL;
  $header .= "Reply-To: ".$reply_to.PHP_EOL;
  $header .= "MIME-Version: 1.0".PHP_EOL;
   
  // Multipart wraps the Email Content and Attachment
  $header .= "Content-Type: multipart/mixed; boundary=\"".$boundary."\"".PHP_EOL;
  $header .= "This is a multi-part message in MIME format.".PHP_EOL;
  $header .= "--".$boundary.PHP_EOL;
   
  // Email content
  // Content-type can be text/plain or text/html
  $header .= "Content-type:text/plain; charset=iso-8859-1".PHP_EOL;
  $header .= "Content-Transfer-Encoding: 7bit".PHP_EOL.PHP_EOL;
  $header .= "$message".PHP_EOL;
  $header .= "--".$boundary.PHP_EOL;
   
  // Attachment
  // Edit content type for different file extensions
  $header .= "Content-Type: application/xml; name=\"".$file_name."\"".PHP_EOL;
  $header .= "Content-Transfer-Encoding: base64".PHP_EOL;
  $header .= "Content-Disposition: attachment; filename=\"".$file_name."\"".PHP_EOL.PHP_EOL;
  $header .= $content.PHP_EOL;
  $header .= "--".$boundary."--";
   
  // Send email
  if (mail($mail_to, $subject, "", $header)) {
    echo "Sent";
  } else {
    echo "Error";
  }
?>
