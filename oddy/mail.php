<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Message</title> <!--Βοηθητικός τίτλος-->
</head>

<body>
<?php 
if(($_GET['do']=='send')&&(isset($_SESSION['loggedin'] ))) //Αν έχει γίνει αίτηση αποστολής και ο χρήστης είναι συνδεδεμένος
{
	//Στους λοιπούς browsers πλην του IE και τις παλαιότερες εκδόσεις FF,
	//το $_REQUEST αρκεί για να ελεγχθεί το αν έχουν συμπληρωθεί μήνυμα και e-mail.
	//ΠΡΟΣΟΧΗ: Για άγνωστο λόγο, κάθε φορά που φορτώνεται η σελίδα, το πλαίσιο του μηνύματος
	//έχει 3 κενά, οπότε αν σταλεί το μήνυμα χωρίς να έχει συμπληρωθεί κείμενο, δίνεται η εντύπωση πως
	//η σελίδα επιτρέπει την αποστολή κενών μηνυμάτων (η σελίδα αντιλαμβάνεται το μήνυμα ως μη κενό, λόγω
	//των τριών κενών). Γι' αυτό το λόγο, εάν δε σβηστούν τα κενά,
	//ακόμα και στους browsers που το υποστηρίζουν, δεν ενεργοποιείται το S_REQUEST και αν' αυτού
	//ενεργοποιείται το elseif statement, με το fallback μήνυμα.
	$email = $_REQUEST['email'] ; //Ζητείται το e-mail
  	$message = mysql_real_escape_string($_REQUEST['message']) ; //Αποθηκεύεται το μήνυμα
  	$id=$_GET['id']; //Παίρνουμε το id του
  	//Σε περίπτωση ασυμβατότητας του browser να αντιληφθεί το $_REQUEST (Internet Explorer)
  	//έχουμε το ακόλουθο if-else statement
  	if(empty($email)) //Αν δεν έχει δωθεί e-mail
  	{
  		$message="Please enter your email!"; //Εμφανίζουμε σχετικό μήνυμα
  		header("location: default.php?page=messages.php&message=" . $message); //Κάνουμε redirect στην αρχική
  		die();
  	}
  	elseif(empty($message)||$message=="  ") //Αν το e-mail δεν είναι κενό, αλλά το μήνυμα είναι άδειο (ή έχει τα 3 κενά)
  	{
  		$message="Please enter the message!"; //Εμφανίζουμε σχετικό μήνυμα
  		header("location: default.php?page=messages.php&message=" . $message); //Κάνουμε redirect στην αρχική
  		die();
  	}
  	else //Αν και τα δύο στοιχεία δόθηκαν
  	{
  		$from="thdo@eparaski.webpages.auth.gr";
  		$to="thdo@eparaski.webpages.auth.gr";
  		$subject="ΤΗΔΟ | Νέο προσωπικό μήνυμα από μέλος";
  		$message=$message." Από το μέλος με e-mail: ".$email;
  		$mailr=mail($to, $subject, $message, $from); //Στέλνουμε e-mail
  		if(!mailr)
  		{
  			?>
  			<script type="text/javascript">
  				alert('Το μήνυμα δε μπόρεσε να σταλεί επιτυχώς.');
  				window.location="default.php?page=viewitem.php&itemid=$id&bid_c=no";
  			</script>
  			<?php 
  		}
  		header( "Location: default.php?page=viewitem.php&itemid=$id&bid_c=no"); //Κάνουμε redirect πίσω στο αντικείμενο
  	}
}
else //Αν ο χρήστης δεν έχει συνδεθεί
{
	$message="You are not logged in!"; //Εμφανίζουμε σχετικό μήνυμα
	header("location: default.php?page=messages.php&message=" . $message); //Κάνουμε redirect στην αρχική σελίδα
}
?>
</body>

</html>
