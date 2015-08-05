<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>ΤΗΔΟ - Ηλεκτρονικές Δημοπρασίες</title> <!--Ο τίτλος του site-->
<link rel="shortcut icon" href="favicn.ico" type="image/x-icon" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link href="page_style.css" rel="stylesheet" type="text/css" />
<link href="login_style.css" rel="stylesheet" type="text/css" />
<link href="tag_style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
</style>
<script src="gen_validatorv4.js" type="text/javascript"></script>
</head>

<body>
<div style="width:960px; margin:auto;">
<div id="masthead">
	<?php
	$user=""; 
	session_start();
	if(isset($_SESSION['loggedin'])) //Εάν ο χρήστης είναι συνδεδεμένος
	{
		$user="".htmlspecialchars($_SESSION['username']); //Παίρνουμε το username του
		//Επάνω δεξιά, δεν εμφανίζουμε το login form, αλλά ένα μήνυμα καλωσορίσματος του χρήστη, που είναι ήδη συνδεδεμένος
	 	echo "<span class='topright form_text'>Συνδεδεμένος ως: ".$user;
	 	echo "<br/>";
	 	echo "<a href='default.php?page=profile.php'>Προσωπικά στοιχεία</a> | <a href='default.php?page=logout.php'>Αποσύνδεση</a> </span><p>";
	 	
	}
	else
	{
		?> <!--Αν ο χρήστης δεν είναι συνδεδεμένος-->
		<!--Εμφανίζουμε επάνω τη φόρμα σύνδεσης, με τα πεδία "Username" και "Κωδικός"-->
		
		<form id="form5" class="topright" method="post" action="login.php"  style="width: 392px; height: auto">
			
        	<label><span class="form_text">Όνομα χρήστη:</span></label>
        	<input type="text" name="username" id="login" required="required"/>
        	<label><span class="form_text">Κωδικός:</span></label>
        	<input type="password" name="password" id="login" required="required"/>
        	<input type="submit" value="Σύνδεση" name="submitLogin" id="submit"/>
        	<br/>
        	<div id="text3"><a id="text11" href="default.php?page=passwordretrieve.php">Ξέχασα τον κωδικό πρόσβασης</a> | <a id="text11" href="default.php?page=register.html">Δημιουργία λογαριασμού</a></div>
        	<div id="text13"><noscript>
        		Η JavaScript είναι απενεργοποιημένη. Εάν δε την ενεργοποιήσετε, ορισμένα τμήματα του site δε θα λειτουργούν σωστά.
        	</noscript></div>
        	
        </form>
        <script type="text/javascript">
			var frmvalidator = new Validator("form5");
			frmvalidator.addValidation("username", "req", "Παρακαλώ εισάγετε το όνομα χρήστη.");
			frmvalidator.addValidation("password", "req", "Παρακαλώ εισάγετε τον κωδικό πρόσβασης.");
		</script>

                    
 	<?php } ?></div>

<!--Εμφανίζουμε το μενού απ' το page_style.css--> 	
<div id="menu" >
 <ul>
 <li><a href="default.php?page=index.php">Αρχική</a> <!--Η αρχική σελίδα-->
 </li>
 <li><a href="default.php?page=listitems.php&chcat=no">Προβολή δημοπρασιών</a> <!--Parent category, προβολής όλων των αντικειμένων-->
 <ul>
 <a href="default.php?page=listitems.php&chcat=active">Ενεργές</a>
 <a href="default.php?page=listitems.php&chcat=deactive">Ανενεργές</a>
 </ul>
 </li>
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
 $query = "SELECT type FROM users WHERE username='".$user."'";
 $result = mysql_query($query);
 $row = mysql_fetch_row($result);
 $type=$row[0];
 if(isset($_SESSION['loggedin']))
 {
 	if($type== 0)
 	{
 	?>
 		<li><a href="default.php?page=listitems.php&chcat=favorites">Αγαπημένες</a> <!--Τα αντικείμενα του χρήστη-->
 		</li>
 	<?php
 	}
 	elseif($type== 1)
 	{
 	?> <!--Σε περίπτωση που ο χρήστης είναι συνδεδεμένος ΚΑΙ είναι Admin (type==1) εμφανίζονται και τα εξής δύο:-->
 		<li><a href="default.php?page=listitems.php&chcat=user">Καταχωρημένες</a> <!--Τα αντικείμενα του χρήστη-->
 		</li>
 		<li><a href="default.php?page=members/form/form.php">Προσθήκη νέας</a> <!--Προσθήκη ενός νέου αντικειμένου-->
 		</li>
 	<?php
 	}
 	elseif($type== 2)
 	{
 	?> <!--Αν ο χρήστη είναι συνδεδεμένος ΚΑΙ είναι Super Admin-->
 		<li><a href="default.php?page=registeradmin.php">Εισαγωγή διαχειριστή</a> <!--Περιβάλλλον εισαγωγής Administrator-->
 		</li>
 		<li><a href="default.php?page=editusers.php">Επεξεργασία χρηστών</a></li>
 	<?php
 	}
 }
 ?>

 
 </ul>
 </div>




	<div id="page_content" style="width: 960px; margin-top:50px;">
	 
	 <div style="width:78%; margin-left:5px; float:left;  ">
	 
	<?php
	
	//Ουσιαστικά, η εμφάνιση του site γίνεται ως εξής: έχουμε μία base σελίδα, που εμφανίζει το header, το footer
	//το μενού, το login form και τη φόρμα αναζήτησης. Κεντρικά, υπάρχει μία άλλη σελίδα, η οποία αλλάζει
	//ανάλογα με τα περιεχόμενα που επιλέγονται να προβληθούν απ' τον χρήστη. Αν, δηλαδή, ο χρήστης επιλέξει το "Add new item"
	//η base page (η default.php) θα μείνει ίδια, αλλά κεντρικά θα φορτωθεί η σελίδα με τη φόρμα συμπλήρωσης του νέου αντικειμένου.
	//Αυτό έχει αντίκτυπο και στο url naming, με το site μας να έχει τη διεύθυνση 'localhost/auction_site/default.php?page=index.php'.
	//Εξαιρώντας τις πρώτες δύο παραμέτρους, το site ανοίγει απ' την default.php και ως page, βάζουμε την index.php. Παρακάτω, λοιπόν, εξετάζουμε
	//αν η εν λόγω σελίδα (η index.php εν προκειμένω) είναι η άδεια. Αν όχι, την εμφανίζουμε (κεντρικά, στη θέση που ορίσαμε στην default), ειδάλλως,
	//θα εμφανιστεί το μήνυμα του else-statement.
	$page = $_GET['page'];	//Παίρνουμε τη μεταβλητή $page
	if (!empty($page)) //Αν η σελίδα ΔΕΝ είναι κενή
	{ 
		include($page); //Εμφανίζεται η σελίδα
	}
	else
	{
		echo "ΣΦΑΛΜΑ: Η σελίδα που εισάγατε είναι κενή. Παρακαλώ, συμπληρώστε το URL με '?page=index.php'";
	} 
?>   </div>
<div style=" width:auto; float:right; margin-right:5px; text-align: center;"> <?php include 'tagcloud.php'; ?></div> <!--Εμφανίζουμε το tagcloud, με τις δημοφιλείς αναζητήσεις-->
	</div>
</div>

<div id="footer"> <!--Εμφανίζουμε το footer-->
<br/> <div id="text4"> <p><a href="default.php?page=main.php">Αρχική</a> | <a href="default.php?page=listitems.php&chcat=active">Ενεργές δημοπρασίες</a> | <a href="default.php?page=listitems.php&chcat=deactive">Ανενεργές δημοπρασίες</a> | <a href="default.php?page=main.php&contact=1">Επικοινωνία</a></p></div>
<div id="text3"> <p> &copy; <?php echo date ("Y"); ?> Υπουργείο Εσωτερικών. <a href="default.php?page=main.php&privacy=1">Προσωπικό Απόρρητο</a> | <a href="default.php?page=main.php&help=1">Βοήθεια &amp; Όροι Χρήσης</a> </p> </div>
</div>

</body>

</html>
