<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

<title>Messages</title>
</head>
<body>
<?php
$message=$_GET['message']; //Παίρνουμε το μήνυμα
//Κατόπιν μπαίνουμε σε ένα if-else statement, για να ελέγξουμε για ποιο μήνυμα πρόκειται
//Αναλόγως του μηνύματος, το εμφανίζουμε και κάνουμε redirect στην κατάλληλη σελίδα
//ή εμφανίζουμε ένα πλήκτρο προς επιστροφή
if($message=="Η εγγραφή ολοκληρώθηκε επιτυχώς")
{
	echo "$message. Γίνεται ανακατεύθυνση στην αρχική σελίδα. Παρακαλώ συνδεθείτε.";
	header( "refresh:2 ;url=default.php?page=index.php" );
} 
elseif($message=="Το όνομα χρήστη υπάρχει ήδη!")
{
	echo "$message";
	?>
	<!--Εμφανίζουμε σχετικό πλήκτρο επιστροφής στην προηγούμενη σελίδα, την οποία-->
	<!--παίρνουμε μέσω της JavaScript Engine του εκάστωτε browser-->
	<form>
		<input type="button" value="Επιστροφή στην προηγούμενη σελίδα" onclick="javascript:history.go(-1)" />
	</form>
	<?php
} 
elseif($message=="Το e-mail υπάρχει ήδη!")
{
	echo "$message";
	?>
	<form>
		<input type="button" value="Επιστροφή στην προηγούμενη σελίδα" onclick="javascript:history.go(-1)" />
	</form>
	<?php
}
elseif($message=="Παρακαλώ εισάγετε ένα όνομα χρήστη!")
{
	echo "$message Παρακαλώ επιστρέψτε πίσω.";
	?>
	<form>
		<input type="button" value="Επιστροφή στην προηγούμενη σελίδα" onclick="javascript:history.go(-1)" />
	</form><?php
}
elseif($message=="Please enter a e-mail!")
{
	echo "$message Παρακαλώ επιστρέψτε πίσω.";
	?>
	<form>
		<input type="button" value="Επιστροφή στην προηγούμενη σελίδα" onclick="javascript:history.go(-1)" />
	</form><?php
} 
elseif($message=="Please enter a password!")
{
	echo "$message Παρακαλώ επιστρέψτε πίσω.";
	?>
	<form>
		<input type="button" value="Επιστροφή στην προηγούμενη σελίδα" onclick="javascript:history.go(-1)" />
	</form><?php
}
elseif($message=="Passwords don't match!")
{
	echo "$message Παρακαλώ επιστρέψτε πίσω.";
	?>
	<form>
		<input type="button" value="Επιστροφή στην προηγούμενη σελίδα" onclick="javascript:history.go(-1)" />
	</form><?php
} 
elseif($message=="Enter Price if you sell or ask to buy!")
{
	echo "$message Παρακαλώ επιστρέψτε πίσω.";
	?>
	<form>
		<input type="button" value="Επιστροφή στην προηγούμενη σελίδα" onclick="javascript:history.go(-1)" />
	</form><?php
}
elseif($message=="Enter Price ONLY if you sell or ask to buy!")
{
	echo "$message Παρακαλώ επιστρέψτε πίσω.";
	?>
	<form>
		<input type="button" value="Επιστροφή στην προηγούμενη σελίδα" onclick="javascript:history.go(-1)" />
	</form>
	<?php
}
elseif($message=="Το site απαγορεύει τη μεταφόρτωση αυτού του αρχείου! Επιλέξτε μεταξύ .jpg, .jpeg, png, .gif")
{
	echo "$message. Παρακαλώ επιστρέψτε πίσω.";
	?>
	<form>
		<input type="button" value="Επιστροφή στην προηγούμενη σελίδα" onclick="javascript:history.go(-1)" />
	</form>
	<?php
}
elseif($message=="Υπήρξε σφάλμα στη μεταφόρτωση του αρχείου, προσπαθήστε ξανά!")
{
	echo "$message Παρακαλώ επιστρέψτε πίσω.";
	?>
	<form>
		<input type="button" value="Επιστροφή στην προηγούμενη σελίδα" onclick="javascript:history.go(-1)" />
	</form>
	<?php
}
elseif($message=="You have successfully logged out! Redirecting in home.")
{
	echo $message;
	header('Refresh: 2; URL=default.php?page=index.php');
}
elseif($message=="Επιτυχής σύνδεση! Γίνεται ανακατεύθυνση.")
{
	echo $message;
	header('Refresh: 2; URL=default.php?page=index.php');
}
elseif($message=="Λάθος κωδικός πρόσβασης ή όνομα χρήστη! Γίνεται ανακατεύθυνση.")
{
	echo $message;
	header('Refresh: 2; URL=default.php?page=index.php');
}
elseif($message=="Η δημοπρασία προστέθηκε επιτυχώς!")
{
	echo "$message Ανακατεύθυνση στις δημοπρασίες σας.";
	header('Refresh: 2; URL=default.php?page=listitems.php&chcat=user');
}
elseif($message=="Please enter the comment!")
{
	echo "$message Παρακαλώ επιστρέψτε πίσω.";
	?>
	<form>
		<input type="button" value="Επιστροφή στην προηγούμενη σελίδα" onclick="javascript:history.go(-1)" />
	</form>
	<?php
}
elseif($message=="Δεν είστε συνδεδεμένος!")
{
	echo "$message Ανακατεύθυνση στην αρχική.";
	header('Refresh: 2; URL=default.php?page=index.php');
}
elseif($message=="Please enter your email! Auto Redirecting!")
{
	echo "$message Παρακαλώ επιστρέψτε πίσω.";
	?>
	<form>
		<input type="button" value="Επιστροφή στην προηγούμενη σελίδα" onclick="javascript:history.go(-1)" />
	</form><?php
}
elseif($message=="Please enter your email!")
{
	echo "$message Παρακαλώ επιστρέψτε πίσω.";
	?>
	<form>
		<input type="button" value="Επιστροφή στην προηγούμενη σελίδα" onclick="javascript:history.go(-1)" />
	</form><?php
}
elseif($message=="Please enter the message!")
{
	echo "$message Παρακαλώ επιστρέψτε πίσω.";
	?>
	<form>
		<input type="button" value="Επιστροφή στην προηγούμενη σελίδα" onclick="javascript:history.go(-1)" />
	</form>
	<?php
}
?>
</body>
</html>
