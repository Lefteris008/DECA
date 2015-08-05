<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link href="members/form/form.css" rel="stylesheet" type="text/css" />
<link href="page_style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
</style>
<title>Add Item</title>
<script src="gen_validatorv4.js" type="text/javascript"></script>
</head>
<?php
$connect = mysql_connect("localhost", "aucadmin", "password"); //Γίνεται σύνδεση με τη ΒΔ
if(!$connect) //Αν αποτύχει
{ 
	die("ERROR: ".mysql_error()); //Εμφανίζεται σφάλμα
}
//Επιλέγουμε τη ΒΔ
$select_db = mysql_select_db("auction_site", $connect); 
if(!$select_db) //Αν αποτύχει
{ 
	die("ERROR: ".mysql_error()); //Εμφανίζουμε σχετικό μήνυμα
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
	if((isset($_SESSION['loggedin']))&&(isset($_GET['id']))) //Αν ο χρήστης είναι συνδεδεμένος τοτε σημαίνει οτι εχει επιλέξει, να τροποποιήσει 
	//ενα αντικείμενο. Ετσι ανοιγουμε το αντικείμενο απο την βάση δεδομένων κρατάμε τις μεταβλητές του έτσι ώστε να τις εμφανίσουμε στην φόρμα
	{
		$connect = mysql_connect("localhost", "aucadmin", "password"); //Γίνεται σύνδεση με τη ΒΔ
		if(!$connect) //Αν αποτύχει
		{ 
			die("ERROR: ".mysql_error()); //Εμφανίζεται σφάλμα
		} 
		$id= mysql_real_escape_string($_GET['id']); //Παίρνουμε το id
		//Επιλέγουμε τη ΒΔ
		$select_db = mysql_select_db("auction_site", $connect); 
		if(!$select_db) //Αν αποτύχει
		{ 
			die("ERROR: ".mysql_error()); //Εμφανίζουμε σχετικό μήνυμα
		}
		$result=mysql_query("SELECT * FROM item where id='$id'"); //Ψάχνουμε στη ΒΔ για αντικείμενα με id, "id"
		$num=mysql_numrows($result);
		mysql_close();
	 	if($num==0) //Αν είναι 0
	 	{
	 		echo "No items found!"; //Τότε δεν υπάρχουν αντικείμενα
	 	}
	 	else //Αν υπάρχουν αντικείμενα
	 	{
	 		$id=mysql_result($result,0,"id"); //Κρατάμε το id
	 		$user=mysql_result($result,0,"user"); //Κρατάμε το χρήστη
	 		if(($_SESSION['loggedin'])&&(isset($_GET['id']))&&$_SESSION['username']==$user) //Αν είναι συνδεδεμένος
	 		{
	 			//Κρατάμε τα πιο κάτω στοιχεία
	 			$title=mysql_result($result,0,"title");
	 			$brand=mysql_result($result,0,"brand");
	 			$model=mysql_result($result,0,"model");
	 			$creatorcomment=mysql_result($result,0,"creatorcomment");
	 			$tags=mysql_result($result,0,"tags");
	 			$do="update";
	 			$baseprice=mysql_result($result,0,"baseprice");
	 			$cc=mysql_result($result,0,"cc");
	 			$hp=mysql_result($result,0,"hp");
	 			$year=mysql_result($result,0,"year");
	 			$colour=mysql_result($result,0,"colour");
	 			$kms=mysql_result($result,0,"kms");
	 			$dateofcompletion=mysql_result($result,0,"dateofcompletion");
	 			
	 		}
	 		else //Αν δεν είναι συνδεδεμένος
	 		{
	 			header("Location: default.php?page=listitems.php&chcat=no"); //Γίνεται redirect
	 		}
	 	}
	}
	else //Αλλιώς αυτό που θέλει ειναι να εισάγει ενα νέο στοιχείο άρα αρχικοποιούμε τις μεταβλητές για να μην εμφανίζονται μυνήματα λάθους.
	{ 
		//Θέτουμε NULL όλα τα στοιχεία
		$id=NULL;
	 	//$title=NULL;
	 	$brand=NULL;
	 	$model=NULL;
	 	$file=NULL;
	 	$creatorcomment=NULL;
	 	$user=NULL;
	 	$baseprice=NULL;
	 	$tags=NULL;
	 	$do=NULL;
	 	$cc=NULL;
	 	$hp=NULL;
	 	$year=NULL;
	 	$colour=NULL;
	 	$kms=NULL;
	 	$dateofcompletion=NULL;
	}
	?>
	<!--Μορφοποίηση εμφάνισης σελίδας-->
	<body>	
	<div id="form">
	<?php
	if($do=="update")
	{
		?>
		<script type="text/javascript">
			document.title="ΤΗΔΟ | Επεξεργασία δημοπρασίας";
		</script> 
		<?php
		echo "<h1><a>Επεξεργασία δημοπρασίας '$title'</a></h1>";
	}
	else
	{
		?>
		<script type="text/javascript">
			document.title="ΤΗΔΟ | Εισαγωγή δημοπρασίας";
		</script> 
		<?php
		echo "<h1><a>Φόρμα καταχώρησης νέας δημοπρασίας</a></h1>";
	}
	?>
	<form id="form1"enctype="multipart/form-data" method="post" action="members/new_item.php?do=<?php echo $do; ?>&id=<?php echo $id; ?>">
		<table style="margin:inherit" border="0">
			<tr>
				<td>Μάρκα*:</td><td><input name="brand" type="text" maxlength="30" required="required" value="<?php echo $brand; ?>" /></td>
			</tr>
			<tr>
				<td>Μοντέλο*:</td><td><input name="model" type="text" maxlength="30" required="required" value="<?php echo $model; ?>" /></td>
			</tr>
			<tr>
				<td>Μεταφόρτωση εικόνας:</td><td><input name="file" class="element file" type="file"/></td>
			</tr>
			<tr>
				<td>Tags (για την αναζήτηση)*:</td><td><input id="element_4" name="tags" class="element text medium" type="text" maxlength="255" required="required" value="<?php echo $tags; ?>"/></td>
			</tr>
			<tr>
				<td>Σχόλιο συντάκτη:</td><td><textarea name="creatorcomment" style="resize:none" rows="3" cols="30"></textarea></td>
			</tr>
			<tr>
				<td>Τιμή εκκίνησης* (€):</td><td><input  name="baseprice" size="10" value="<?php echo $baseprice; ?>" type="text" required="required" /></td>
			</tr>
			<tr>
				<td>Κυβικά*:</td><td><input name="cc" type="text" size="4" required="required" value="<?php echo $cc; ?>" /></td>
			</tr>
			<tr>
				<td>Ίπποι*:</td><td><input name="hp" type="text" size="3" required="required" value="<?php echo $hp; ?>" /></td>
			</tr>
			<tr>
				<td>Χρονολογία*:</td><td><input name="year" type="text" size="4" required="required" value="<?php echo $year; ?>" /></td>
			</tr>
			<tr>
				<td>Χρώμα*:</td><td><input name="colour" type="text" size="30" required="required" value="<?php echo $colour; ?>" /></td>
			</tr>
			<tr>
				<td>Χιλιόμετρα*:</td><td><input name="kms" type="text" size="7" required="required" value="<?php echo $kms; ?>" /></td>
			</tr>
			<tr>
				<?php
				if(isset($_REQUEST['id']))
				{ ?>
					<td id="text12">Ημερομηνία ολοκλήρωσης*:</td>
				<?php }
				else
				{ ?>
					<td>Ημερομηνία ολοκλήρωσης*:</td>
				<?php } ?>
				<td>
			<select name="day">
				<option value="01">01</option>
				<option value="02">02</option>
				<option value="03">03</option>
				<option value="04">04</option>
				<option value="05">05</option>
				<option value="06">06</option>
				<option value="07">07</option>
				<option value="08">08</option>
				<option value="09">09</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
			</select>
			<select name="month" >
				<option value="01">Ιανουάριος</option>
				<option value="02">Φεβρουάριος</option>
				<option value="03">Μάρτιος</option>
				<option value="04">Απρίλιος</option>
				<option value="05">Μάιος</option>
				<option value="06">Ιούνιος</option>
				<option value="07">Ιούλιος</option>
				<option value="08">Αύγουστος</option>
				<option value="09">Σεπτέμβριος</option>
				<option value="10">Οκτώβριος</option>
				<option value="11">Νοέμβριος</option>
				<option value="12">Δεκέμβριος</option>
			</select>
			<input name="year2" type="text" size="4" required="required" value="2012" title="Εδώ συμπληρώστε το έτος"/>
			</td>
			</tr>
		</table>
		<br/> 
		<div>* Υποχρεωτικά πεδία</div>
		<br/>
		<div>Προσοχή: Ελέγξτε τα στοιχεία πριν την τελική υποβολή. Μπορείτε πάντα να επεξεργαστείτε μια δημοπρασία σε μεταγενέστερο χρόνο, 
		απ' την επιλογή "Επεξεργασία" στις δημοπρασίες που εμφανίζονται στη σελίδα "Καταχωρημένες" και αντιστοιχούν στις δημοπρασίες που 
		έχετε εισάγει εσείς ως διαχειριστής στο παρελθόν.</div>
		<br/>
		<input id="saveForm" class="button_text" type="submit" name="submit" value="Υποβολή" onclick="return confirm('Είστε σίγουροι πως έχετε ελέγξει όλα τα πεδία;')"/>
		<input id="resetForm" class="button_text" type="button" name="back" value="Άκυρο" onclick="parent.location='?page=listitems.php&chcat=active'" />
	</form>
	<script type="text/javascript">
		var frmvalidator = new Validator("form1");
		frmvalidator.addValidation("brand", "req", "Παρακαλώ εισάγετε τη μάρκα του αυτοκινήτου.");
		frmvalidator.addValidation("model", "req", "Παρακαλώ εισάγετε το μοντέλο του αυτοκινήτου.");
		frmvalidator.addValidation("tags", "req", "Παρακαλώ εισάγετε τα tags.");
		frmvalidator.addValidation("baseprice", "req", "Παρακαλώ εισάγετε την τιμή εκκίνησης.");
		frmvalidator.addValidation("baseprice", "num", "Παρακαλώ εισάγετε μόνο αριθμούς στην τιμή εκκίνησης.");
		frmvalidator.addValidation("cc", "req", "Παρακαλώ εισάγετε τα κυβικά.");
		frmvalidator.addValidation("cc", "num", "Παρακαλώ εισάγετε μόνο αριθμούς στα κυβικά.");
		frmvalidator.addValidation("cc", "maxlen=4", "Παρακαλώ εισάγετε μια έγκυρη τιμή για τα κυβικά (4 ψηφία).");
		frmvalidator.addValidation("hp", "req", "Παρακαλώ εισάγετε τους ίππους.");
		frmvalidator.addValidation("hp", "num", "Παρακαλώ εισάγετε μόνο αριθμούς στους ίππους.");
		frmvalidator.addValidation("hp", "maxlen=3", "Παρακαλώ εισάγετε μια έγκυρη τιμή για τους ίππους (3 ψηφία).");
		frmvalidator.addValidation("year", "req", "Παρακαλώ εισάγετε τη χρονολογία.");
		frmvalidator.addValidation("year", "minlen=4", "Παρακαλώ εισάγετε μια έγκυρη χρονολογία.");
		frmvalidator.addValidation("year", "lt=2013", "Η χρονολογία δε μπορεί να είναι μεταγενέστερη του 2012.");
		frmvalidator.addValidation("color", "req", "Παρακαλώ εισάγετε το χρώμα.");
		frmvalidator.addValidation("kms", "req", "Παρακαλώ εισάγετε τον αριθμό χιλιομέτρων.");
		frmvalidator.addValidation("kms", "num", "Παρακαλώ εισάγετε μόνο αριθμούς στον αριθμό χιλιομέτρων.");
		frmvalidator.addValidation("kms", "lt=9999999", "Παρακαλώ εισάγετε μια έγκυρη τιμή στον αριθμό χιλιομέτρων (< 9.999.999 km).");
		frmvalidator.addValidation("year2", "req", "Παρακαλώ εισάγετε το έτος ολοκλήρωσης δημοπρασίας.");
		frmvalidator.addValidation("year2", "minlen=4", "Παρακαλώ εισάγετε ένα έγκυρο έτος ολοκλήρωσης δημοπρασίας.");
		frmvalidator.addValidation("year2", "lt=2013", "Το έτος ολοκλήρωσης δημοπρασίας δε μπορεί να μεταγενέστερο του 2012.");
	</script>
	
	</div>
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