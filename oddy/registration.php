<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Sign Up Form</title>
</head>
<body>

<?php 
//Γίνεται σύνδεση στη ΒΔ 
$connect = mysql_connect("localhost", "aucadmin", "password"); 
if(!$connect) //Εάν αποτύχει η σύνδεση
{ 
	die("ERROR :".mysql_error()); //Εμφανίζουμε σχετικό μήνυμα
} 

//Επιλέγουμε τη ΒΔ
$select_db = mysql_select_db("auction_site", $connect); 
if(!$select_db) //Εάν δε μπορέσει να επιλέξει τη ΒΔ
{ 
	die("ERROR :".mysql_error()); //Εμφανίζουμε σχετικό μήνυμα
} 

//Μαζεύουμε τις πληροφορίες
//Συγκεντρώνουμε τα στοιχεία username, e-mail και κωδικός πρόσβασης
$username =mysql_real_escape_string( $_REQUEST['username']); 
$email = $_REQUEST['email']; 
$password =md5( mysql_real_escape_string($_REQUEST['password'])); //Με το md5, παίρνουμε κρυπτογραφημένο κωδικό και αποφεύγουμε το SQL Injection
$pass_conf =md5( mysql_real_escape_string($_REQUEST['password_conf']));
$surname =mysql_real_escape_string( $_REQUEST['surname']);
$name =mysql_real_escape_string( $_REQUEST['name']);
//$dateofbirth =mysql_real_escape_string( $_REQUEST['dateofbirth']);
$day=mysql_real_escape_string($_REQUEST['day']);
$month=mysql_real_escape_string($_REQUEST['month']);
$year=mysql_real_escape_string($_REQUEST['year']);
$fathersname =mysql_real_escape_string( $_REQUEST['fathersname']);
$mothersname =mysql_real_escape_string( $_REQUEST['mothersname']);
$adt =mysql_real_escape_string( $_REQUEST['adt']);
$afm =mysql_real_escape_string( $_REQUEST['afm']);
$address =mysql_real_escape_string( $_REQUEST['address']);
$phonehome =mysql_real_escape_string( $_REQUEST['phonehome']);
$phonemobile =mysql_real_escape_string( $_REQUEST['phonemobile']);
$citizenship =mysql_real_escape_string($_REQUEST['citizenship']);
$nationality =mysql_real_escape_string($_REQUEST['nationality']);
$country =mysql_real_escape_string($_REQUEST['country']);
//Επειδή ο IE έχει κάποιες ασυμβατότητες με το required του HTML 5.0
//υπήρχε περίπτωση να γίνει Sign Up με κενά στοιχεία απ' τον εν λόγω
//browser και η διαδικασία να ολοκληρωθεί επιτυχώς, με συνέπεια να μπορεί
//να γίνει σύνδεση και με κενά στοιχεία. Γι' αυτό, το ακόλουθο if-else statement
//παίζει το ρόλο του fallback.
if(empty($username)) //Αν το username είναι κενό
{
	$message="Παρακαλώ εισάγετε ένα όνομα χρήστη!"; //Εμφανίζουμε μήνυμα
	header("location: default.php?page=messages.php&message=" . $message); //Κάνουμε redirect
	die();
}
elseif(empty($email)) //Αν το e-mail είναι κενό
{
	$message="Please enter a e-mail!"; //Εμφανίζουμε μήνυμα
	header("location: default.php?page=messages.php&message=" . $message); //Κάνουμε redirect
	die();
}
elseif(!isset($_REQUEST['password'])) //Αν δεν δόθηκε κωδικός (δεν επιτρέπονται κενοί κωδικοί)
{
	$message="Please enter a password!"; //Εμφανίζουμε μήνυμα
	header("location: default.php?page=messages.php&message=" . $message); //Κάνουμε redirect
	die();
}
//Δεν υπάρχει νόημα να ελέγξουμε την περίπτωση που δίνεται κενός κωδικός στο "Retype password",
//μιας και θα ελεγχθεί παρακάτω, όταν οι κωδικοί δε θα ταιριάζουν
else //Αν δόθηκαν όλα τα στοιχεία, ξεκινάμε τον έλεγχο
{
	//Ελέγχουμε εάν το username είναι σε χρήση 
	$user_check = mysql_query("SELECT username FROM users WHERE username='$username'"); 
	$do_user_check = mysql_num_rows($user_check); 
	
	//Τώρα ελέγχουμε ένα το e-mail είναι σε χρήση 
	$email_check = mysql_query("SELECT email FROM users WHERE email='$email'"); 
	$do_email_check = mysql_num_rows($email_check); 
	
	//Εμφανίζουμε τα όποια σφάλματα 
	if($do_user_check > 0) //Ο χρήστης υπάρχει ήδη
	{ 
		$message="Το όνομα χρήστη υπάρχει ήδη!";
		header("location: default.php?page=messages.php&message=" . $message); 
		die(); 
	} 
	if($do_email_check > 0) //Το e-mail υπάρχει ήδη
	{ 
		$message="Το e-mail υπάρχει ήδη!";
		header("location: default.php?page=messages.php&message=" . $message);
		die(); 
	} 
	
	//Έλεγχος των δύο κωδικών
	if($password != $pass_conf) //Αν δεν ισούνται (εδώ πιάνουμε την περίπτωση κενού $pass_conf)
	{ 
		$message="Passwords don't match!";
		header("location: default.php?page=messages.php&message=" . $message);
		die(); 
	} 
	
	//Αν όλα είναι σωστά, τότε εισάγουμε το χρήστη στη ΒΔ
	$dateofbirth=$year."-".$month."-".$day; 
	$insert = mysql_query("INSERT INTO users (username, password, email, surname, name, dateofbirth, fathersname, mothersname, adt, afm, address, phonehome, phonemobile, citizenship, nationality, country) VALUES ('$username', '$password', '$email', '$surname', '$name', '$dateofbirth', '$fathersname', '$mothersname', '$adt', '$afm', '$address', '$phonehome', '$phonemobile', '$citizenship', '$nationality', '$country')"); 
	if(!$insert) //Αν αποτύχει η εισαγωγή
	{ 
		die("ERROR: ".mysql_error()); //Εμφανίζουμε σχετικό σφάλμα
	} 
	$message="Η εγγραφή ολοκληρώθηκε επιτυχώς"; //Μήνυμα επιτυχίας
	header("location: default.php?page=messages.php&message=" . $message); //Redirect
}
?>
</body>

</html>
