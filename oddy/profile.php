<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Profile</title>
<link href="page_style.css" rel="stylesheet" type="text/css" />
<link href="members/form/form.css" rel="stylesheet" type="text/css" />
<script src="gen_validatorv4.js" type="text/javascript"></script>
</head>

<body>
	<script type="text/javascript">
		document.title="ΤΗΔΟ | Προφίλ χρήστη";
	</script>

<?php
$user="";
$message=""; 
//session_start();
if(isset($_SESSION['loggedin'])) //Εάν ο χρήστης είναι συνδεδεμένος
{
	$user="".htmlspecialchars($_SESSION['username']); //Παίρνουμε το username του
	$user1=$user; //Temp για σύγκριση όταν το προφίλ βλέπει ο admin για άλλον
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
	if(isset($_GET['p']))
		$user=$_GET['p'];
	$query="SELECT * FROM users WHERE username='".$user."'";
	$result=mysql_query($query);
	mysql_close();
	if((isset($_GET['submit']))&&($_GET['submit']=='details'))
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
		if($type=='1'||$type=='2')
		{
			$email=mysql_real_escape_string($_REQUEST['email']);
			$email_check = mysql_query("SELECT email FROM users WHERE email='$email'"); 
			$do_email_check = mysql_num_rows($email_check);
			$result1= mysql_query("SELECT * FROM users WHERE username='$user'");
			$current_email=mysql_result($result1,0,"email");
	
			//Εμφανίζουμε τα όποια σφάλματα  
			if(($do_email_check > 0)&&($current_email!=$email)) //Το e-mail υπάρχει ήδη
			{ 
				$message="Το e-mail υπάρχει ήδη!";
				header("location: default.php?page=messages.php&message=" . $message);
				die(); 
			}

			$update_details =mysql_query("UPDATE users SET email='$email' WHERE username='$user'");
			if(!$update_details) //Αν η ενημέρωση αποτύχει
			{ 
				die("ERROR: ".mysql_error()); //Σχετικό μήνυμα
			}
			mysql_close();
		}
		elseif($type=='0')
		{
			$email=mysql_real_escape_string($_REQUEST['email']);
			$address=mysql_real_escape_string($_REQUEST['address']);
			$phonehome=mysql_real_escape_string($_REQUEST['phonehome']);
			$phonemobile=mysql_real_escape_string($_REQUEST['phonemobile']);
			$email_check = mysql_query("SELECT email FROM users WHERE email='$email'"); 
			$do_email_check = mysql_num_rows($email_check);
			$result1= mysql_query("SELECT * FROM users WHERE username='$user'");
			$current_email=mysql_result($result1,0,"email");
	
			//Εμφανίζουμε τα όποια σφάλματα  
			if(($do_email_check > 0)&&($current_email!=$email)) //Το e-mail υπάρχει ήδη
			{ 
				$message="Το e-mail υπάρχει ήδη!";
				header("location: default.php?page=messages.php&message=" . $message);
				die(); 
			}
			$update_details =mysql_query("UPDATE users SET email='$email', address='$address', phonehome='$phonehome', phonemobile='$phonemobile' WHERE username='$user'");
			if(!$update_details) //Αν η ενημέρωση αποτύχει
			{ 
				die("ERROR: ".mysql_error()); //Σχετικό μήνυμα
			}
			mysql_close();
		}			

		header('Refresh: 0; URL=default.php?page=profile.php');
	}
	if((isset($_GET['submit']))&&($_GET['submit']=='password'))
	{
		$oldpassword =md5(mysql_real_escape_string($_REQUEST['oldpass']));
		$newpassword =md5(mysql_real_escape_string($_REQUEST['newpass']));
		$newpassword_conf =md5(mysql_real_escape_string($_REQUEST['newpass_conf']));
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
		$passcheck = mysql_query("SELECT * FROM users WHERE username='$user'");
		$current_pass = mysql_result($passcheck,0,"password");
		$success=0;
		if($oldpassword==$current_pass)
		{
			if($newpassword != $newpassword_conf) //Αν δεν ισούνται
			{ 		
				$success=1;
			}
			else
			{
				$success=2;
				$update_pass = mysql_query("UPDATE users SET password='$newpassword' WHERE username='$user'");
				if(!$update_pass) //Αν η ενημέρωση αποτύχει
				{ 
					die("ERROR: ".mysql_error()); //Σχετικό μήνυμα
				}
				mysql_close();
				//echo "<div id='text14'>Ο κωδικός πρόσβασης άλλαξε επιτυχώς.</div>";
				//header('Refresh: 2; URL=default.php?page=profile.php');
			}
		}
		else
		{
			$success=3;
		}
		if($success==1)
		{
			?>
			<script type="text/javascript">
				alert('Οι νέοι κωδικοί πρόσβασης δε ταιριάζουν.');
				window.location="default.php?page=profile.php&change=password";
			</script> 
			<?php
			exit();
		}
		elseif($success==2)
		{
			
			?>
			<script type="text/javascript">
				alert('Ο κωδικός πρόσβασης άλλαξε επιτυχώς.');
				window.location="default.php?page=profile.php";
			</script> 
			<?php
			exit();
		}
		elseif($success==3)
		{
			?>
			<script type="text/javascript">
				alert('Ο παλιός κωδικός πρόσβασης που εισάγατε είναι λάθος.');
				window.location="default.php?page=profile.php&change=password";
			</script> 
			<?php
			exit();
		}
	}
	//Κρατάμε τα ακόλουθα στοιχεία
	//$username=mysql_result($result,0,"username"); //id
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
	


	//Μορφοποίηση εμφάνισης των πιο πάνω στοιχείων
	if((isset($_GET['change']))&&($_GET['change']=='details'))
	{
	?>	
	<div id="form">
	<h1><a>Επεξεργασία στοιχείων χρήστη</a></h1>
		<form  id="form1" enctype="multipart/form-data" method="post" action="default.php?page=profile.php&submit=details">
		<table style="margin:inherit" border="0">
		<tr>
			<td>Όνομα χρήστη:</td><td><input type="text" size="20" disabled="disabled" title="Το όνομα χρήστη δε μπορεί να αλλάξει." value="<?php echo $username; ?>"/></td>
		</tr>
		<tr>
			<td>E-mail:</td><td><input name="email" type="text" size="30" required="required" value="<?php echo $email; ?>" /></td>
		</tr>
		<tr>
			<td>Επώνυμο:</td><td><input name="surname" type="text" size="20" disabled="disabled" title="Το επώνυμο δε μπορεί να αλλάξει." value="<?php echo $surname; ?>" /></td>
		</tr>
		<tr>
			<td>Όνομα:</td><td><input name="name" type="text" size="20" disabled="disabled" title="Το όνομα δε μπορεί να αλλάξει." value="<?php echo $name; ?>" /></td>
		</tr>
		<?php
		if($type=='1')
		{
		?>
		<tr>
			<td>Υπηρεσιακό ID:</td><td><input name="serviceid" type="text" size="20" disabled="disabled" title="Δε μπορείτε να αλλάξετε το υπηρεσιακό σας ID." value="<?php echo $serviceid; ?>" /></td>
		</tr>
		<?php }
		elseif($type=='0')
		{ 
		?>
		<tr>
			<td>Ημερομηνία γέννησης:</td><td><input name="dateofbirth" type="text" size="20" disabled="disabled" title="Η ημερομηνία γέννησης δε μπορεί να αλλάξει." value="<?php echo $dateofbirth; ?>" /></td>
		</tr>
		<tr>
			<td>Όνομα πατρός:</td><td><input name="fathersname" type="text" size="20" disabled="disabled" title="Το όνομα πατρός δε μπορεί να αλλάξει." value="<?php echo $fathersname; ?>" /></td>
		</tr>
		<tr>
			<td>Όνομα και επώνυμο μητέρας:</td><td><input name="mothersname" type="text" size="20" disabled="disabled" title="Το ονοματεπώνυμο μητέρας δε μπορεί να αλλάξει." value="<?php echo $mothersname; ?>" /></td>
		</tr>
		<tr>
			<td>Αριθμός Δελτίου Ταυτότητας:</td><td><input name="adt" type="text" size="20" disabled="disabled" title="Ο αριθμός δελτίου ταυτότητας δε μπορεί να αλλάξει." value="<?php echo $adt; ?>" /></td>
		</tr>
		<tr>
			<td>Αριθμός Φορολογικού Μητρώου:</td><td><input name="afm" type="text" size="20" disabled="disabled" title="Ο αριθμός φορολογικού μητρώου δε μπορεί να αλλάξει." value="<?php echo $afm; ?>" /></td>
		</tr>
		<tr>
			<td>Διεύθυνση:</td><td><input name="address" type="text" size="50" required="required" value="<?php echo $address; ?>" /></td>
		</tr>
		<tr>
			<td>Χώρα:</td><td><input name="country" type="text" size="30" disabled="disabled" title="Η χώρα δε μπορεί να αλλάξει." value="<?php echo $country; ?>" /></td>
		</tr>
		<tr>
			<td>Υπηκοότητα:</td><td><input name="citizenship" type="text" size="30" disabled="disabled" title="Η υπηκοότητα δε μπορεί να αλλάξει." value="<?php echo $citizenship; ?>" /></td>
		</tr>
		<tr>
			<td>Ιθαγένεια:</td><td><input name="nationality" type="text" size="30" disabled="disabled" title="Η ιθαγένεια δε μπορεί να αλλάξει." value="<?php echo $nationality; ?>" /></td>
		</tr>
		<tr>
			<td>Τηλέφωνο οικίας:</td><td><input name="phonehome" type="text" size="30" required="required" value="<?php echo $phonehome; ?>" /></td>
		</tr>
		<tr>
			<td>Κινητό τηλέφωνο:</td><td><input name="phonemobile" type="text" size="30" value="<?php echo $phonemobile; ?>" /></td>
		</tr>
		<?php
		} ?>
		</table>
		<br/>
		<?php
		if($type=='0')
		{ ?> 
		<div>Αλλάξτε όσα από τα στοιχεία επιθυμείτε. Τα απενεργοποιημένα στοιχεία, δε μπορούν να αλλάξουν από εσάς για λόγους ασφαλείας. 
		Για περισσότερες πληροφορίες <a href="default.php?page=main.php&contact=1">επικοινωνήστε με το ΤΗΔΟ</a>.</div>
		<br/>
		<div>Πατώντας "Αποθήκευση" δηλώνετε υπεύθυνα πως τα στοιχεία που παρέχετε στο σύστημα είναι πραγματικά και αντιστοιχούν στα δικά σας στοιχεία. 
		Για όποιες παρατυπίες, οι οποίες έγιναν ηθελημένα και δεν διορθώθηκαν από εσάς, θα αντιμετωπίσετε τις νόμιμες συνέπειες που ορίζει το 
		Ελληνικό Δίκαιο (N. 1599/1986). <a href="default.php?page=main.php&privacy=1">Δήλωση προστασίας απορρήτου.</a></div>
		<br/>
		<?php
		} 
		?>
		<input id="saveForm" class="button_text" type="submit" name="submit" value="Αποθήκευση" onclick="return confirm('Είστε σίγουροι πως έχετε ελέγξει τα στοιχεία που υποβάλετε;')" />
		<input id="saveForm" class="button_text" type="button" name="back" value="Άκυρο" onclick="parent.location='?page=profile.php'" />
		</form>
		<script type="text/javascript">
			var frmvalidator = new Validator("form1");
			frmvalidator.addValidation("email", "req", "Παρακαλώ εισάγετε το email.");
			frmvalidator.addValidation("email", "email", "Παρακαλώ εισάγετε μια έγκυρη διεύθυνση email.");
			document.write("<?php if($type=='0') { ?>");
				frmvalidator.addValidation("address", "req", "Παρακαλώ εισάγετε τη διεύθυνση κατοικίας.");
				frmvalidator.addValidation("phonehome", "req", "Παρακαλώ εισάγετε το τηλέφωνο οικίας.");
				frmvalidator.addValidation("phonehome", "num", "Παρακαλώ εισάγετε μόνο αριθμούς στο τηλέφωνο οικίας.");
				frmvalidator.addValidation("phonehome", "maxlen=10", "Παρακαλώ εισάγετε ένα έγκυρο τηλέφωνο οικίας (10 ψηφία).");
				frmvalidator.addValidation("phonehome", "minlen=10", "Παρακαλώ εισάγετε ένα έγκυρο τηλέφωνο οικίας (10 ψηφία).");
				frmvalidator.addValidation("phonemobile", "num", "Παρακαλώ εισάγετε μόνο αριθμούς στο κινητό τηλέφωνο.");
				frmvalidator.addValidation("phonemobile", "maxlen=10", "Παρακαλώ εισάγετε ένα έγκυρο κινητό τηλέφωνο (10 ψηφία).");
			document.write("<?php } ?>");
		</script>
	
		</div>
		<?php
		}
	
	elseif((isset($_GET['change']))&&($_GET['change']=='password'))
	{
	?>
		<div id="form">
		<h1><a>Αλλαγή κωδικού πρόσβασης</a></h1>
		<form id="form2" enctype="multipart/form-data" method="post" action="default.php?page=profile.php&submit=password">
		<table style="margin:inherit" border="0">
		<tr>
			<td>Τρέχων κωδικός πρόσβασης:</td><td><input name="oldpass" type="password" size="20" required="required"/></td>
		</tr>
		<tr>
			<td>Νέος κωδικός πρόσβασης:</td><td><input name="newpass" type="password" size="20" required="required" /></td>
		</tr>
		<tr>
			<td>Κωδικός πρόσβασης (ξανά):</td><td><input name="newpass_conf" type="password" size="20" required="required" /></td>
		</tr>
		</table>
			<br/> 
		    <input id="saveForm" class="button_text" type="submit" name="submit" value="Αποθήκευση" />
		    <input id="saveForm" class="button_text" type="button" name="back" value="Άκυρο" onclick="parent.location='?page=profile.php'" />
		</form>
		<script type="text/javascript">
			var frmvalidator = new Validator("form2");
			frmvalidator.addValidation("oldpass", "req", "Παρακαλώ εισάγετε τον παλιό κωδικό πρόσβασης.");
			frmvalidator.addValidation("newpass", "req", "Παρακαλώ εισάγετε το νέο κωδικό πρόσβασης.");
			frmvalidator.addValidation("newpass", "minlen=8", "Παρακαλώ εισάγετε τουλάχιστον 8 ψηφία στο νέο κωδικό πρόσβασης.");
			frmvalidator.addValidation("newpass_conf", "req", "Παρακαλώ εισάγετε ξανά το νέο κωδικό πρόσβασης.");
			frmvalidator.addValidation("newpass_conf", "eqelmnt=newpass", "Οι κωδικοί πρόσβασης που εισάγατε δε ταιριάζουν.");
		</script>	
		</div>
	<?php
	}

	else
	{
		echo "<table id='listitems' border='0'>";
		echo "<td><h1>Στοιχεία χρήστη</h1></td>";
		echo    "<tr>";
		echo    "<td><class id='text7'>Όνομα χρήστη:</class>&nbsp;&nbsp;&nbsp;&nbsp;$username</td>";
		echo    "</tr>";
		echo    "<tr>";
		echo    "<td><class id='text7'>E-mail:</class>&nbsp;&nbsp;&nbsp;&nbsp;$email</td>";
		echo    "</tr>";
		echo "</table>";
		
		echo "</br>";
		
		echo "<table id='listitems' border='0'>";
		echo "<tbody>";
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
		}
		if(($user1==$user)||$type_admin=='2') //Εάν ο χρήστης που είναι συνδεδεμένος, δεν είναι ίδιος με τον αρχικό $user, σημαίνει
						  //πως τη φόρμα βλέπει admin για άλλο χρήστη. Σε αντίθετη περίπτωση (δλδ το if είναι true)
						  //εμφανίζει επιλογές για αλλαγή στοιχείων και κωδικού
		{
			echo    "<tr>";
			echo    "<td>";
			echo	"<class id='text10'>";
			echo	"<a href='default.php?page=profile.php&change=details'>Αλλαγή στοιχείων</a>";
			echo	"&nbsp;-&nbsp;<a href='default.php?page=profile.php&change=password'>Αλλαγή κωδικού πρόσβασης</a>";
			echo	"</class>";
			echo	"</td>";
			echo    "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}
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