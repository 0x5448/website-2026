<?php
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
//$subject = $_POST['subject'];
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

$email_from = $visitor_email;//<== update the email address
$email_subject = "New Form Submission";
$email_body = "You have received a new message from the user $name.\n\n Here is the message:\n $message \n";
    
$to = "tedhadges@gmail.com";//<== update the email address
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
//mail($to,$email_subject,$email_body,$headers);
mail($to,$email_subject,$email_body);
echo "sent";
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