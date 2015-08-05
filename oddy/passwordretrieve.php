<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Password Reset</title>
<link href="page_style.css" rel="stylesheet" type="text/css" />
<link href="members/form/form.css" rel="stylesheet" type="text/css" />
<script src="gen_validatorv4.js" type="text/javascript"></script>
</head>

<body>
<script type="text/javascript">
	document.title="ΤΗΔΟ | Επαναφορά κωδικού πρόσβασης";
</script>
<?php 
$message1="";
$mailfailure="";
if(isset($_GET['do']))
{
	$connect = mysql_connect("localhost", "aucadmin", "password"); //Συνδεόμαστε στη ΒΔ
	if(!$connect) //Αν δε συνδεθεί
	{ 
		die("ERROR: ".mysql_error()); //Εμφανίζουμε σφάλμα
	}
	//Επιλέγουμε τη ΒΔ
	$select_db = mysql_select_db("auction_site", $connect); 
	if(!$select_db) //Αν αποτύχει
	{ 
		die("ERROR: ".mysql_error()); //Επιστρέφουμε σφάλμα
	}
	$email=mysql_real_escape_string($_REQUEST['email']);
	$query="SELECT * FROM users WHERE email='$email'";
	$result=mysql_query($query);
	$num=mysql_num_rows($result);
	if($num==0)
		$message1="Δε βρέθηκε χρήστης με e-mail '".$email."'";
	else
	{
		$pass=md5(rand());
		$newpass=md5($pass);
		$message1=$pass;
		$query="UPDATE users SET password='$newpass' WHERE email='$email'";
		$result=mysql_query($query);
		if(!$result)
			die("ΣΦΑΛΜΑ: ".mysql_error());
		$to=$email;
		$from="thdo@eparaski.webpages.auth.gr";
		$subject="ΤΗΔΟ | Αίτηση Αλλαγής Κωδικού Πρόσβασης";
		$message="Κωδικός: ".$pass;
		$mailr=mail($to, $subject, $message, $from);
		if(!$mailr)
			$mailfailure="Το e-mail δε μπόρεσε να σταλεί.";
		else
			$mailfailure="Το e-mail στάλθηκε επιτυχώς.";
		mysql_close();
	}
}
?>
<form id="form" style="margin-top:auto;" action="default.php?page=passwordretrieve.php&do=change" method="post">
	<h1>Επαναφορά κωδικού πρόσβασης</h1>
	<div>
		Για να επαναφέρετε τον κωδικό πρόσβασής σας, συμπληρώστε το e-mail που δώσατε κατά
		την αρχική σας εγγραφή στο ΤΗΔΟ. Πρέπει να δώσετε έγκυρο e-mail.
	</div>
	<br/>
	<table id="table">
	<tr>
	<td>E-mail:</td>
	</tr>
	<tr>	
	<td><input name="email" type="email" size="40" required="required" title="Συμπληρώστε το e-mail σας"/></td>
	</tr>
	<tr>
	<td><?php echo $message1; ?></td>
	</tr>
	<tr>
	<td><?php echo $mailfailure; ?></td>
	</tr>
	</table>
	<br/>
	<input type="submit" value="Επαναφορά κωδικού"/>
	<script type="text/javascript">
		var frmvalidator = new Validator("form");
		frmvalidator.addValidation("email", "req", "Παρακαλώ εισάγετε το email.");
		frmvalidator.addValidation("email", "email", "Παρακαλώ εισάγετε μια έγκυρη διεύθυνση email.");
	</script>

</form>

</body>
</html>