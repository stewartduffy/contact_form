<?php
$recipient = 'name@email.com';//email address you want it to go to
$emailSubject = "An enquiry via our website!";

$name = isset($_POST['theName']) ? strip_tags($_POST['theName']) : "";
$email = isset($_POST['email']) ? strip_tags($_POST['email']) : "";
$message = isset($_POST['message']) ? strip_tags($_POST['message']) : "";
$feedback = array();

if(isset($_POST['submit'])){
	
	$spam = strip_tags($_POST['other']);
	if($spam != "") die("SPAM");
	if(!validName($name) || $name == "Name") $feedback["invalidName"] = true;
	if(!validEmail($email)) $feedback["invalidEmail"] = true;
	if($message == "" || $message == "Message") $feedback["invalidMessage"] = true;
	
	if(count($feedback) == 0) {
		$sent = sendEmail($recipient, $name, $email, $message);
		if($sent) $feedback["sent"] = true;
		else $feedback["sendFailed"] = true;
	}
	
}

function sendEmail($to, $fromName, $fromEmail, $message) {

	$headers = "Reply-To: $fromName <$fromEmail>\r\n";
	$headers .= "From: $fromName <$fromEmail>\r\n";
	$headers .= "Content-Type: text/plain\r\n";
	$subject = $emailSubject;
	$body = "Name:\t $fromName \n";
	$body .= "Email:\t $fromEmail \n\n";
	$body .= $message;
	$sentmail = mail($to, $subject, $body, $headers);

	if($sentmail) return true;
	else return false;
}

function validName($name) {
	if(strlen($name) > 2)
	return eregi('^[A-Za-z\. \-]*$', $name); 
}

function validEmail($email){
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}

?>

<link rel="stylesheet" href="contactForm/contactForm.css" />

<form method="post" id="form" action="#form" >
	<ul class="clearfix blocklist">
		<li><label for="theName">Name</label><input id="theName" name="theName" type="text" class="text" value="<?php if($name != "") echo $name; ?>" maxlength="50" /></li>
		<li><label for="email">Email</label><input id="email" name="email" type="text" class="text" value="<?php if($email != "") echo $email; ?>" maxlength="50" /></li>
		<li><label for="message">Message</label><textarea id="message" name="message" rows="4" cols="30"><?php if($message != "") echo $message; ?></textarea></li>
		<li class="formBtns">
			<button id="formSubmit" name="submit" type="submit">submit</button>
		</li>
		<li id="feedback">
			<?php if(isset($feedback['invalidName'])) echo "<p>Please provide a valid name</p>"; ?>
			<?php if(isset($feedback['invalidEmail'])) echo "<p>Please provide a valid email address</p>"; ?>
			<?php if(isset($feedback['invalidMessage'])) echo "<p>Please provide a message</p>"; ?>
			<?php if(isset($feedback['sent'])) echo "<p>You're message was sent.<br /> We will get back to you soon!</p>";?>
			<?php if(isset($feedback['sendFailed'])) echo "<p>Sorry, for some reason your message was not sent.</p>";?>
		</li>
	</ul>
	<input id="sneaky" name="other" type="text" size="20" />
</form>

<script src="contactForm/contactForm.js"></script>
