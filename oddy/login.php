<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" type="text/css" href="mystyle.css"/>
<title>Login</title> <!--Βοηθητικός τίτλος-->
<!--Κώδικας CSS-->
<style type="text/css">
.auto-style1
{
	color: #00FF00;
}
.auto-style2
{
	text-align: right;
}
</style>
</head>

<body>
<?php
session_start();
mysql_connect("localhost", "aucadmin", "password"); //Συνδεόμαστε με τη ΒΔ
mysql_select_db("auction_site"); //Επιλέγουμε τη ΒΔ
if(isset($_POST['submitLogin'])) //Αν ο χρήστης έχει πατήσει το "Login"
{ 
	$username = mysql_real_escape_string($_POST['username']); //Κρατάμε το username
 	$password = md5(mysql_real_escape_string($_POST['password'])); //Κρατάμε τον κωδικό (με κρυπτογράφηση για ασφάλεια κατά των SQL Injections)
 	$select_user = mysql_query("SELECT COUNT(id) AS amount FROM users WHERE username = '$username' AND password = '$password' "); //Αναζητάται στη ΒΔ ο εν λόγω χρήστης
 	$user = mysql_fetch_assoc($select_user); //Επιλέγεται ο εν λόγω χρήστης
 	$amount_found = (int)$user['amount']; //Πλήθος χρηστών που βρέθηκαν στη ΒΔ με τα στοιχεία που δόθηκαν
 	if($amount_found > 0) //Εάν το πλήθος είναι πάνω από 0
 	{
 		$_SESSION['loggedin'] = TRUE; //Μαρκάρεται ως επιτυχής η σύνδεση
 		$_SESSION['username'] = $username; //Γίνεται η ανάθεση του username
 		$message="Επιτυχής σύνδεση! Γίνεται ανακατεύθυνση."; //Εμφανίζεται σχετικό μήνυμα
 		header("location: default.php?page=messages.php&message=" . $message); //Γίνεται redirect στην αρχική σελίδα
 	}
 	else //Εάν δε βρεθεί χρήστης
 	{ 
 		$message="Λάθος κωδικός πρόσβασης ή όνομα χρήστη! Γίνεται ανακατεύθυνση."; //Εμφανίζεται σχετικό μήνυμα
 		header("location: default.php?page=messages.php&message=" . $message); //Γίνεται redirect στην αρχική σελίδα
 	}
 	if(isset($_POST['registration'])) //Αν ο χρήστης πατήσεις το "Sign Up"
 	{
   		header( 'location:default.php?page=register.php' ) ; //Οδηγείται στη σελίδα για εγγραφή
 	}
}
else
{
	header('Refresh: 0; URL=default.php?page=index.php'); //Redirect στην αρχική σελίδα
}
?>
</body>
</html>
