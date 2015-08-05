<!DOCTYPE html>
<html>


<head>
<link href="/oddy/members/form/form.css" rel="stylesheet" type="text/css" />
<style type="text/css">
</style>

<title>Register Admin</title>
<script src="gen_validatorv4.js" type="text/javascript"></script>
</head>
<body>
<?php 
$connect = mysql_connect("localhost", "aucadmin", "password");
if(!$connect) //Αν δε συνδεθεί 
{ 
	die("ERROR: ".mysql_error()); //Εμφανίζουμε σφάλμα
}
//Επιλέγουμε τη ΒΔ
$select_db = mysql_select_db("auction_site", $connect); 
if(!$select_db) //Αν δεν επιλεγεί
{ 
	die("ERROR: ".mysql_error()); //Εμφανίζουμε σφάλμα
}
$currentuser="";
$type=3;
if(isset($_SESSION['loggedin']))
{
	$currentuser="".htmlspecialchars($_SESSION['username']);
	$result=mysql_query("SELECT * FROM users WHERE username='$currentuser'");
	$type=mysql_result($result,0,"type");
}

if((isset($_SESSION['loggedin']))&&($type!='0'))
{
?>

	<script type="text/javascript">
		document.title="ΤΗΔΟ | Εισαγωγή διαχειριστή";
	</script>

	<form id="form" style="margin-top:auto;" action="registrationadmin.php" method="post">
		<div >
	<h1>Φόρμα εισαγωγής διαχειριστή</h1>
	<div> Στην παρακάτω φόρμα, εισάγετε τα στοιχεία του υπαλλήλου που θέλετε να ορίσετε ως διαχειριστή. Μετά την εισαγωγή, 
	ο διαχειριστής θα έχει το δικαίωμα έναρξης δημοπρασιών, επεξεργασίας και διαγραφής τους, καθώς επίσης και θα μπορεί 
	να επικοινωνεί με χρήστες που θα κερδίσουν δημοπρασίες.</div>
	<br/>
	<table style="margin:inherit" border="0">
	<tr>
	<td>Όνομα χρήστη (username):</td><td><input name="username" type="text" size="20" required="required"/></td>
	</tr>
	<tr>
	<td>Email:</td><td><input name="email" type="text" size="20" required="required"/></td> 
	</tr>
	<tr>
	<td>Κωδικός πρόσβασης:</td><td><input name="password" type="password" size="20" required="required"/></td> 
	</tr>
	<tr>
	<td>Επανεισαγωγή κωδικού πρόσβασης:</td><td><input name="password_conf" type="password" size="20" required="required"/></td> 
	</tr>
	<tr>
	<td>Επώνυμο:</td><td><input name="surname" type="text" size="30" required="required"/></td> 
	</tr>
	<tr>
	<td>Όνομα:</td><td><input name="name" type="text" size="30" required="required"/></td> 
	</tr>
	<tr>
	<td>Υπηρεσιακό ID:</td><td><input name="serviceid" type="text" size="10" required="required"/></td>
	</tr>
	</table>
	<br/> <div>Όλα τα πεδία είναι υποχρεωτικά.</div>
	<br/> <div>Πρόκειται να καταχωρήσετε έναν νέο διαχειριστή. Παρακαλώ ελέγξτε τα στοιχεία πριν την τελική υποβολή. 
	Σημειώστε ότι αν τα στοιχεία καταχωρηθούν μπορούν να αλλάξουν μεμονωμένα για κάθε διαχειριστή απ' το μενού 
	"Προσωπικά στοιχεία".</div>
	<br/> <input type="submit" value="Εισαγωγή" onclick="return confirm('Είστε σίγουροι πως όλα τα στοιχεία που δώσατε είναι σωστά;')"/>
	</div>
	</form>
	
	<script type="text/javascript">
		var frmvalidator = new Validator("form");
		frmvalidator.addValidation("username", "req", "Παρακαλώ εισάγετε το όνομα χρήστη.");
		frmvalidator.addValidation("email", "req", "Παρακαλώ εισάγετε το email.");
		frmvalidator.addValidation("email", "email", "Παρακαλώ εισάγετε μια έγκυρη διεύθυνση email.");
		frmvalidator.addValidation("password", "req", "Παρακαλώ εισάγετε τον κωδικό πρόσβασης.");
		frmvalidator.addValidation("password", "minlen=8", "Παρακαλώ εισάγετε τουλάχιστον 8 ψηφία στον κωδικό πρόσβασης.");
		frmvalidator.addValidation("password_conf", "req", "Παρακαλώ εισάγετε ξανά τον κωδικό πρόσβασης.");
		frmvalidator.addValidation("password_conf", "eqelmnt=password", "Οι κωδικοί πρόσβασης που εισάγατε δε ταιριάζουν.");
		frmvalidator.addValidation("surname", "req", "Παρακαλώ εισάγετε το επώνυμό σας.");
		frmvalidator.addValidation("name", "req", "Παρακαλώ εισάγετε το όνομά σας.");
		frmvalidator.addValidation("serviceid", "req", "Παρακαλώ συμπληρώστε το Υπηρεσιακό ID.");
	</script>

<?php 
}
else
{
?>
	<div id="text5"><p>ΣΦΑΛΜΑ: Απαγόρευση πρόσβασης.</p></div>
	<div id="text6"><p>Δεν έχετε επαρκή δικαιώματα για πρόσβαση σ' αυτή τη σελίδα.</p></div>
<?php	
}
?>
</body>
</html> 