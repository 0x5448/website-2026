<?php
require_once "Mail.php";

if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "An error occured. This page should not be accessed directly; please go back and submit the form.";
	exit();
}

$name = $_POST['name'];
$visitor_email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

//Validate first
if(empty($name)||empty($visitor_email)||empty($message)) 
{
    echo "Invalid input. Please go back and make sure you have entered your name, email, and a message.";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Something's not right with the way you entered your email. Please go back and try again.";
    exit;
}

$email_body = "You have received a new message from $name.\n\n Subject:\n $subject \n Email:\n $visitor_email \n\nMessage:\n$message \n";
$from = "Admin <admin@tedhadges.com>";
$to = "Ted Hadges <tedhadges@gmail.com>";
$subject = "New Form Submission";
$body = "$email_body";
$host = "ssl://cpanel.freehosting.com";
$port = "465";
$username = "admin@tedhadges.com";
$password = ",Q.o3Py!#rIu";
$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'port' => $port,
    'auth' => true,
    'username' => $username,
    'password' => $password));
$mail = $smtp->send($to, $headers, $body);
if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
 } else {
  echo("<p>Message successfully sent!</p>");
 }
 //done. redirect to thank-you page.
header('Location: thanks.html');

// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}

   
?> 