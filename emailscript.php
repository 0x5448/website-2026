<?php
// the message
$message = "First line of text\nSecond line of text";

if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// use wordwrap() if lines are longer than 70 characters
$message = wordwrap($msg,70);

// send email
mail("tedhadges@gmail.com","My subject",$message);
?>