<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Edit User</title>
<link href="page_style.css" rel="stylesheet" type="text/css" />
<link href="members/form/form.css" rel="stylesheet" type="text/css" />
<script src="gen_validatorv4.js" type="text/javascript"></script>
</head>

<body>

<?php
if(isset($_SESSION['loggedin']))
{
	$user="".htmlspecialchars($_SESSION['username']);
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
	$query="SELECT * FROM users WHERE username='$user'"; //Επιλέγουμε όλα τα αντικείμενα με id, το "id"
	$result=mysql_query($query);
	mysql_close();
	$type=mysql_result($result,0,"type");
	if($type=='2')
	{
		$message="";
		if((isset($_GET['q']))&&($_GET['q']=="true"))
		{
			$connect = mysql_connect("localhost", "aucadmin", "password"); //Συνδεόμαστε στη ΒΔ
			if(!$connect) //Αν δε συνδεθεί
			{ 
				die("ERROR: ".mysql_error()); //Εμφανίζουμε σφάλμα
			}
			if(!isset($_GET['show']))
				$user_q = mysql_real_escape_string($_REQUEST['user_q']);
			else
				$user_q = $_GET['show'];
			//Επιλέγουμε τη ΒΔ
			$select_db = mysql_select_db("auction_site", $connect); 
			if(!$select_db) //Αν αποτύχει
			{ 
				die("ERROR: ".mysql_error()); //Επιστρέφουμε σφάλμα
			}
			$query="SELECT * FROM users WHERE username='$user_q'"; //Επιλέγουμε όλα τα αντικείμενα με id, το "id"
			$result=mysql_query($query);
			$num=mysql_numrows($result);
			mysql_close();
			if($num==0) //Αν δεν υπάρχουν τα εν λόγω αντικείμενα
			{
				$message="Δε βρέθηκε χρήστης με το όνομα '".$user_q."'"; //Εμφανίζουμε μήνυμ
			}
			else
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
				$result=mysql_query("SELECT * FROM users WHERE username='$user_q'");
				$username=mysql_result($result,0,"username");
				$email=mysql_result($result,0,"email"); //Κατηγορία
				$surname=mysql_result($result,0,"surname"); //Περιγραφή
				$name=mysql_result($result,0,"name"); //Χρήστης
				$dateofbirth=mysql_result($result,0,"dateofbirth"); //Τιμή
				$fathersname=mysql_result($result,0,"fathersname"); //Όνομα αρχείου
				$mothersname=mysql_result($result,0,"mothersname"); //id
				$adt=mysql_result($result,0,"adt"); //Τίτλος
				$afm=mysql_result($result,0,"afm"); //Κατηγορία
				$address=mysql_result($result,0,"address"); //Περιγραφή
				$citizenship=mysql_result($result,0,"citizenship"); //Χρήστης
				$nationality=mysql_result($result,0,"nationality"); //Τιμή
				$country=mysql_result($result,0,"country"); //Όνομα αρχείου
				$phonehome=mysql_result($result,0,"phonehome"); //id
				$phonemobile=mysql_result($result,0,"phonemobile"); //Τίτλος
				$type=mysql_result($result,0,"type");
				$serviceid=mysql_result($result,0,"serviceid");
				mysql_close();
				echo "<table id='listitems' border='0'>";
				echo "<td><h1>Στοιχεία χρήστη</h1></td>";
				echo    "<tr>";
				echo    "<td><class id='text7'>Όνομα χρήστη:</class>&nbsp;&nbsp;&nbsp;&nbsp;$username</td>";
				echo    "</tr>";
				echo    "<tr>";
				echo    "<td><class id='text7'>E-mail:</class>&nbsp;&nbsp;&nbsp;&nbsp;$email</td>";
				echo	"</tr>";
				echo "<td><h1>Προσωπικά στοιχεία</h1></td>";
				echo    "<tr>";
				echo    "<td><class id='text7'>Επώνυμο:</class>&nbsp;&nbsp;&nbsp;&nbsp;$surname</td>";
				echo    "</tr>";
				echo    "<tr>";
				echo    "<td><class id='text7'>Όνομα:</class>&nbsp;&nbsp;&nbsp;&nbsp;$name</td>";
				echo    "</tr>";
				if($type=='1')
				{
					echo	"<tr>";
					echo	"<td><class id='text7'>Υπηρεσιακό ID:</class>&nbsp;&nbsp;&nbsp;&nbsp;$serviceid</td>";
					echo	"</tr>";
					echo	"<tr>";
					echo	"<td><class id='text7'>Τύπος:</class>&nbsp;&nbsp;&nbsp;&nbsp;Διαχειριστής</td>";
					echo	"</tr>";
	
				}
				elseif($type=='0')
				{
					echo    "<tr>";
					echo    "<td><class id='text7'>Ημερομηνία γέννησης:</class>&nbsp;&nbsp;&nbsp;&nbsp;$dateofbirth</td>";
					echo    "</tr>";
					echo    "<tr>";
					echo    "<td><class id='text7'>Όνομα πατρός:</class>&nbsp;&nbsp;&nbsp;&nbsp;$fathersname</td>";
					echo    "</tr>";
					echo    "<tr>";
					echo    "<td><class id='text7'>Όνομα και επώνυμο μητρός:</class>&nbsp;&nbsp;&nbsp;&nbsp;$mothersname</td>";
					echo    "</tr>";
					echo    "<tr>";
					echo    "<td><class id='text7'>Αριθμός Δελτίου Ταυτότητας:</class>&nbsp;&nbsp;&nbsp;&nbsp;$adt</td>";
					echo    "</tr>";
					echo    "<tr>";
					echo    "<td><class id='text7'>Αριθμός Φορολογικού Μητρώου:</class>&nbsp;&nbsp;&nbsp;&nbsp;$afm</td>";
					echo    "</tr>";
					echo    "<tr>";
					echo    "<td><class id='text7'>Διεύθυνση:</class>&nbsp;&nbsp;&nbsp;&nbsp;$address</td>";
					echo    "</tr>";
					echo    "<tr>";
					echo    "<td><class id='text7'>Χώρα:</class>&nbsp;&nbsp;&nbsp;&nbsp;$country</td>";
					echo    "</tr>";
					echo    "<tr>";
					echo    "<td><class id='text7'>Υπηκοότητα:</class>&nbsp;&nbsp;&nbsp;&nbsp;$citizenship</td>";
					echo    "</tr>";
					echo    "<tr>";
					echo    "<td><class id='text7'>Ιθαγένεια:</class>&nbsp;&nbsp;&nbsp;&nbsp;$nationality</td>";
					echo    "</tr>";
					echo    "<tr>";
					echo    "<td><class id='text7'>Τηλέφωνο οικίας:</class>&nbsp;&nbsp;&nbsp;&nbsp;$phonehome</td>";
					echo    "</tr>";
					echo    "<tr>";
					echo    "<td><class id='text7'>Κινητό τηλέφωνο:</class>&nbsp;&nbsp;&nbsp;&nbsp;$phonemobile</td>";
					echo    "</tr>";
					echo	"<tr>";
					echo	"<td><class id='text7'>Τύπος:</class>&nbsp;&nbsp;&nbsp;&nbsp;Απλός χρήστης</td>";
					echo	"</tr>";
				}
				echo	"<tr>";
				echo	"<td></td>";
				echo	"</tr>";
				echo    "<tr>";
				echo    "<td>";
				echo	"<class id='text10'>";
				echo	"<a href='default.php?page=editusers.php&q=$user_q&edituser=true'>Αλλαγή στοιχείων</a>";
				?>
				&nbsp;-&nbsp;<a href="default.php?page=editusers.php&q=<?php echo $user_q; ?>&delete=true" onclick="return confirm('Είστε σίγουροι πως θέλετε να διαγράψετε τον χρήστη;')">Διαγραφή χρήστη</a>
				<?php
				echo	"</class>";
				echo	"</td>";
				echo    "</tr>";
				echo	"</tbody>";
				echo	"</table>";
				echo	"<br/>";
			}
		}
		elseif((isset($_GET['q']))&&($_GET['q']!="true")&&(isset($_GET['submit'])))
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
			$userforsubmit=$_GET['q'];
			$query="SELECT * FROM users WHERE username='".$userforsubmit."'";
			$result=mysql_query($query);
			$type=mysql_result($result,0,"type");
			if($type=='0')
			{
				$surname=mysql_real_escape_string($_REQUEST['surname']);
				$name=mysql_real_escape_string($_REQUEST['name']);
				$fathersname=mysql_real_escape_string($_REQUEST['fathersname']);
				$mothersname=mysql_real_escape_string($_REQUEST['mothersname']);
				$day=mysql_real_escape_string($_REQUEST['day']);
				$month=mysql_real_escape_string($_REQUEST['month']);
				$year=mysql_real_escape_string($_REQUEST['year']);
				$adt=mysql_real_escape_string($_REQUEST['adt']);
				$afm=mysql_real_escape_string($_REQUEST['afm']);
				$country=mysql_real_escape_string($_REQUEST['country']);
				$citizenship=mysql_real_escape_string($_REQUEST['citizenship']);
				$nationality=mysql_real_escape_string($_REQUEST['nationality']);
				$dateofbirth=$year."-".$month."-".$day;
				$update_details=mysql_query("UPDATE users SET surname='$surname', name='$name', dateofbirth='$dateofbirth', fathersname='$fathersname', mothersname='$mothersname', adt='$adt', afm='$afm', country='$country', citizenship='$citizenship', nationality='$nationality' WHERE username='$userforsubmit'");
				if(!$update_details)
					die("ΣΦΑΛΜΑ: ".mysql_error());
			}	
			elseif($type=='1')
			{
				$surname=mysql_real_escape_string($_REQUEST['surname']);
				$name=mysql_real_escape_string($_REQUEST['name']);
				$serviceid=mysql_real_escape_string($_REQUEST['serviceid']);
				$update_details=mysql_query("UPDATE users SET surname='$surname', name='$name', serviceid='$serviceid' WHERE username='$userforsubmit'");
				if(!$update_details)
					die("ΣΦΑΛΜΑ: ".mysql_error());
			}
			mysql_close();
			header("Location: default.php?page=editusers.php&q=true&show=".$userforsubmit);
		}
		elseif((isset($_GET['q']))&&($_GET['q']!="true")&&(isset($_GET['edituser'])))
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
			$userforedit=$_GET['q'];
			$result=mysql_query("SELECT * FROM users WHERE username='$userforedit'");
			$username=mysql_result($result,0,"username");
			$email=mysql_result($result,0,"email"); //Κατηγορία
			$surname=mysql_result($result,0,"surname"); //Περιγραφή
			$name=mysql_result($result,0,"name"); //Χρήστης
			$dateofbirth=mysql_result($result,0,"dateofbirth"); //Τιμή
			$fathersname=mysql_result($result,0,"fathersname"); //Όνομα αρχείου
			$mothersname=mysql_result($result,0,"mothersname"); //id
			$adt=mysql_result($result,0,"adt"); //Τίτλος
			$afm=mysql_result($result,0,"afm"); //Κατηγορία
			$address=mysql_result($result,0,"address"); //Περιγραφή
			$citizenship=mysql_result($result,0,"citizenship"); //Χρήστης
			$nationality=mysql_result($result,0,"nationality"); //Τιμή
			$country=mysql_result($result,0,"country"); //Όνομα αρχείου
			$phonehome=mysql_result($result,0,"phonehome"); //id
			$phonemobile=mysql_result($result,0,"phonemobile"); //Τίτλος
			$type=mysql_result($result,0,"type");
			$serviceid=mysql_result($result,0,"serviceid");
			mysql_close();
			
			?>
			<div id="form">
			<h1><a>Επεξεργασία στοιχείων χρήστη</a></h1>
			<form id="form1" enctype="multipart/form-data" method="post" action="default.php?page=editusers.php&q=<?php echo $userforedit; ?>&edituser=true&submit=true">
			<table style="margin:inherit" border="0">
			<tr>
				<td>Όνομα χρήστη:</td><td><input type="text" size="20" disabled="disabled" title="Το όνομα χρήστη δε μπορεί να αλλάξει." value="<?php echo $username; ?>"/></td>
			</tr>
			<tr>
				<td>E-mail:</td><td><input name="email" type="text" size="20" disabled="disabled" title="Το e-mail αλλάζει απ' τον χρήστη." value="<?php echo $email; ?>" /></td>
			</tr>
			<tr>
				<td>Επώνυμο:</td><td><input name="surname" type="text" size="20" required="required" value="<?php echo $surname; ?>" /></td>
			</tr>
			<tr>
				<td>Όνομα:</td><td><input name="name" type="text" size="20" required="required" value="<?php echo $name; ?>" /></td>
			</tr>
			<?php
			if($type=='1')
			{
			?>
			<tr>
				<td>Υπηρεσιακό ID:</td><td><input name="serviceid" type="text" size="20" required="required" value="<?php echo $serviceid; ?>" /></td>
			</tr>
			<?php }
			elseif($type=='0')
			{ 
			?>
			<tr>
				<td>Ημ. γέννησης (ΗΗ/ΜΜ/ΧΧΧΧ)*:</td>
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
					<select name="month">
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
					<input name="year" type="text" size="4" required="required" value="2012" title="Εδώ συμπληρώστε το έτος"/>
				</td> 
			</tr>
			<tr>
				<td>Όνομα πατρός:</td><td><input name="fathersname" type="text" size="20" required="required" value="<?php echo $fathersname; ?>" /></td>
			</tr>
			<tr>
				<td>Όνομα και επώνυμο μητέρας:</td><td><input name="mothersname" type="text" size="20" required="required" value="<?php echo $mothersname; ?>" /></td>
			</tr>
			<tr>
				<td>Αριθμός Δελτίου Ταυτότητας:</td><td><input name="adt" type="text" size="20" required="required" value="<?php echo $adt; ?>" /></td>
			</tr>
			<tr>
				<td>Αριθμός Φορολογικού Μητρώου:</td><td><input name="afm" type="text" size="20" required="required" value="<?php echo $afm; ?>" /></td>
			</tr>
			<tr>
				<td>Διεύθυνση:</td><td><input name="address" type="text" size="50" disabled="disabled" title="Η διεύθυνση αλλάζει απ' τον χρήστη." value="<?php echo $address; ?>" /></td>
			</tr>
			<tr>
				<td>Χώρα:</td><td><input name="country" type="text" size="30" required="required" value="<?php echo $country; ?>" /></td>
			</tr>
			<tr>
				<td>Υπηκοότητα:</td><td><input name="citizenship" type="text" size="30" required="required" value="<?php echo $citizenship; ?>" /></td>
			</tr>
			<tr>
				<td>Ιθαγένεια:</td><td><input name="nationality" type="text" size="30" required="required" value="<?php echo $nationality; ?>" /></td>
			</tr>
			<tr>
				<td>Τηλέφωνο οικίας:</td><td><input name="phonehome" type="text" size="30" disabled="disabled" title="Το τηλέφωνο οικίας αλλάζει απ' τον χρήστη" value="<?php echo $phonehome; ?>" /></td>
			</tr>
			<tr>
				<td>Κινητό τηλέφωνο:</td><td><input name="phonemobile" type="text" size="30" disabled="disabled" title="Το κινητό τηλέφωνο αλλάζει απ' τον χρήστη" value="<?php echo $phonemobile; ?>" /></td>
			</tr>
			<?php
			} ?>
			</table>
			<br/>
			<input id="saveForm" class="button_text" type="submit" name="submit" value="Αποθήκευση" onclick="return confirm('Είστε σίγουροι πως έχετε ελέγξει τα στοιχεία που υποβάλετε;')" />
			<input id="saveForm" class="button_text" type="button" name="back" value="Άκυρο" onclick="parent.location='?page=editusers.php'" />
			</form>
			<script type="text/javascript">
				var frmvalidator = new Validator("form1");
				frmvalidator.addValidation("surname", "req", "Παρακαλώ εισάγετε το επώνυμο.");
				frmvalidator.addValidation("name", "req", "Παρακαλώ εισάγετε το όνομα.");
				document.write("<?php if($type=='0') { ?>");
					frmvalidator.addValidation("year", "req", "Παρακαλώ εισάγετε το έτος γέννησης.");
					frmvalidator.addValidation("year", "minlen=4", "Παρακαλώ εισάγετε ένα έγκυρο έτος γέννησης.");
					frmvalidator.addValidation("year", "lt=1994", "Οι όροι χρήσης απαγορεύουν την πρόσβαση σε άτομα κάτω των 18 ετών.");
					frmvalidator.addValidation("fathersname", "req", "Παρακαλώ εισάγετε το πατρόνυμο.");
					frmvalidator.addValidation("mothersname", "req", "Παρακαλώ εισάγετε το ονοματεπώνυμο μητρός.");
					frmvalidator.addValidation("adt", "req", "Παρακαλώ εισάγετε τον Αριθμό Δελτίου Ταυτότητας (ΑΔΤ).");
					frmvalidator.addValidation("afm", "req", "Παρακαλώ εισάγετε τον Αριθμό Φορολογικού Μητρώου (ΑΦΜ).");
					frmvalidator.addValidation("afm", "num", "Παρακαλώ εισάγετε μόνο αριθμούς στο ΑΦΜ.");
					frmvalidator.addValidation("afm", "minlen=9", "Παρακαλώ εισάγετε ένα έγκυρο ΑΦΜ (9 ψηφία).");
					frmvalidator.addValidation("afm", "maxlen=9", "Παρακαλώ εισάγετε ένα έγκυρο ΑΦΜ (9 ψηφία).");
					frmvalidator.addValidation("country", "req", "Παρακαλώ εισάγετε τη χώρα διαμονής.");
					frmvalidator.addValidation("citizenship", "req", "Παρακαλώ εισάγετε την υπηκοότητα.");
					frmvalidator.addValidation("nationality", "req", "Παρακαλώ εισάγετε την ιθαγένεια.");
				document.write("<?php } elseif($type=='1') { ?>");
					frmvalidator.addValidation("serviceid", "req", "Παρακαλώ εισάγετε το Υπηρεσιακό ID.");
				document.write("<?php } ?>");
			</script>	
			</div>
			<br/>
			<?php
		}		
		elseif((isset($_GET['q']))&&($_GET['q']!="true")&&(isset($_GET['delete'])))
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
			$userfordelete=$_GET['q'];
			$delete=mysql_query("DELETE FROM users WHERE username='$userfordelete'");
			if(!$delete)
				die("ERROR: ".mysql_error()); //Επιστρέφουμε σφάλμα
		}
		?>
		<script type="text/javascript">
			document.title="ΤΗΔΟ | Αναζήτηση χρηστών";
		</script>

		<form id="form" style="margin-top:auto;" action="default.php?page=editusers.php&q=true" method="post">
		<h1>Αναζήτηση &amp; επεξεργασία χρηστών</h1>
		<table id="listitems" style="text-align:left width:auto; height:20px;" border="0">
		<tr>
		<td>Εισάγετε το όνομα χρήστη</td>
		</tr>
		<tr>
		<td><input type="text" name="user_q" size="50" required="required"></input></td>
		</tr>
		<tr>
		<?php if($message!="Found!") 
		{ ?>
		<td><?php echo $message; ?></td>
		<?php }  
		?>
		</tr>
		</table>
		<br/>
		<input type="submit" value="Αναζήτηση"/>
		</form>
		<script type="text/javascript">
			var frmvalidator = new Validator("form");
			frmvalidator.addValidation("user_q", "req", "Παρακαλώ εισάγετε το όνομα χρήστη.");
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
} 
else 
{ ?>
	<div id="text5"><p>ΣΦΑΛΜΑ: Απαγόρευση πρόσβασης.</p></div>
	<div id="text6"><p>Δεν έχετε επαρκή δικαιώματα για πρόσβαση σ' αυτή τη σελίδα.</p></div>
<?php 
} ?>
</body>
</html>