<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>New Item</title> <!--Η σελίδα είναι βοηθητική της "form.php"-->
</head>
<body>
<?php
session_start();
if(isset($_SESSION['username'])) //Αν ο χρήστης είναι συνδεδεμένος
{
	$connect = mysql_connect("localhost", "aucadmin", "password"); //Γίνεται σύνδεση
	if(!$connect) //Αν αποτύχει
	{ 
		die("ERROR: ".mysql_error()); //Εμφανίζεται σφάλμα
	} 
	//Επιλέγουμε τη ΒΔ 
	$select_db = mysql_select_db("auction_site", $connect); 
	if(!$select_db) //Αν αποτύχει
	{ 
		die("ERROR: ".mysql_error()); //Εμφανίζεται σφάλμα
	} 
	//Συλλογή των πληροφοριών
	$title =mysql_real_escape_string( $_REQUEST['title']); //Τίτλος
	$brand = mysql_real_escape_string($_REQUEST['brand']); //Περιγραφή
	$model =$_REQUEST['model']; //Τύπος
	$baseprice=mysql_real_escape_string( $_REQUEST['baseprice']); //Τιμή
	$tmp_name = $_FILES['file']['tmp_name'];
	$tags=mysql_real_escape_string($_REQUEST['tags']); //Tags
	$name = date("Ymd").$_FILES['file']['name']; //Όνομα εικόνας όπως αποθηκεύεται
	$target_path = "uploads/";
	$target_path = $target_path.date("Ymd") . basename( $_FILES['file']['name']); 
	$whitelist = array( ".jpg", ".jpeg", ".png", ".gif"); //Επιτρέπονται μόνο αυτοί οι τύποι αρχείων
	$black = true;
	$cc =mysql_real_escape_string( $_REQUEST['cc']); //Τίτλος
	$hp =mysql_real_escape_string( $_REQUEST['hp']); //Τίτλος
	$year =mysql_real_escape_string( $_REQUEST['year']); //Τίτλος
	$colour =mysql_real_escape_string( $_REQUEST['colour']); //Τίτλος
	$kms =mysql_real_escape_string( $_REQUEST['kms']); //Τίτλος
	$day=mysql_real_escape_string($_REQUEST['day']); //Τίτλος
	$month=mysql_real_escape_string($_REQUEST['month']);
	$year2=mysql_real_escape_string($_REQUEST['year2']);
	
	$creatorcomment =mysql_real_escape_string( $_REQUEST['creatorcomment']);
	foreach ($whitelist as $item) //Ελέγχεται αν το αρχείο είναι των επιτρεπόμενων τύπων
	{
		if (substr($name, strrpos($name, ".")) == $item) //Αν δεν ανήκει στη λίστα
		{
			$black = false; //Σηκώνουμε σημαία
			break;
		}
	}
	if(($black == true)&&(!empty($tmp_name))) //Αν έχει σηκωθεί σημαία και υπάρχει εικόνα
	{
		$message="Το site απαγορεύει τη μεταφόρτωση αυτού του αρχείου! Επιλέξτε μεταξύ .jpg, .jpeg, png, .gif"; //Σχετικό μήνυμα
    	header("location: ../default.php?page=messages.php&message=" . $message); //Redirect
    	die();
    }
	elseif(empty($tmp_name)) //Αν δεν υπάρχει εικόνα
	{
		$name="no_pic.jpg"; //Μπαίνει η default
	}
	if((!empty($tmp_name))&&(!move_uploaded_file($_FILES['file']['tmp_name'], $target_path))) //Αν υπάρχει εικόνα αλλά το αρχείο δε μεταφορτώθηκε
	{
  		$message="Υπήρξε σφάλμα στη μεταφόρτωση του αρχείου, προσπαθήστε ξανά!"; //Σχετικό μήνυμα
  		header("location: ../default.php?page=messages.php&message=" . $message); //Redirect
  		die();
   	}
   	//Για λόγους συμβατότητας με IE που δεν υποστηρίζει το required του HTML 5.0
   	//έχουμε τους πιο κάτω ελέγχους
	
	$dateofcompletion=$year2."-".$month."-".$day;
	$username=$_SESSION['username'];
	if($_GET['do']=="update") //Αν η φόρμα εμφανίστηκε έπειτα από επιλογή του "Modify Item"
	{
		$id=$_GET['id'];
		//Γίνεται ενημέρωση του αντικειμένου
		if($name=="no_pic.jpg"){//Αν δεν υπάρχει νέα εικόνα κρατάμε την παλιά
		$title=$brand." ".$model;
		$update = mysql_query("UPDATE item SET title='$title', model='$model', tags='$tags', baseprice='$baseprice', currentprice='$baseprice', brand='$brand', model='$model', cc='$cc', hp='$hp', year='$year', colour='$colour', kms='$kms', dateofcompletion='$dateofcompletion', creatorcomment='$creatorcomment' WHERE id='$id'");
        }
        else{
        $title=$brand." ".$model;
		$update = mysql_query("UPDATE item SET title='$title', model='$model', tags='$tags', filename='$name', baseprice='$baseprice', currentprice='$baseprice', brand='$brand', model='$model', cc='$cc', hp='$hp', year='$year', colour='$colour', kms='$kms', dateofcompletion='$dateofcompletion', creatorcomment='$creatorcomment' WHERE id='$id'");
		}
		echo $_GET['id'];
		if(!$update) //Αν η ενημέρωση αποτύχει
		{ 
			die("ERROR: ".mysql_error()); //Σχετικό μήνυμα
		}
	}
	else //Η φόρμα κλήθηκε έπειτα από επιλογή του "Add new item"
	{
		//Γίνεται εισαγωγή
		$title = $brand." ".$model;
		$insert = mysql_query("INSERT INTO item (user, title, filename, tags, baseprice, currentprice, brand, model, cc, hp, year, colour, kms, dateofcompletion, creatorcomment) VALUES ('$username', '$title', '$name', '$tags', '$baseprice', '$baseprice', '$brand', '$model', '$cc', '$hp', '$year', '$colour', '$kms', '$dateofcompletion', '$creatorcomment')"); 
		if(!$insert) //Αν η εισαγή αποτύχει
		{ 
			die("ERROR: ".mysql_error()); //Εμφανίζεται σχετικό μήνυμα
		}
	}
	$message="Η δημοπρασία προστέθηκε επιτυχώς!"; //Μήνυμα επιτυχίας
	header("location: ../default.php?page=messages.php&message=" . $message); //Redirect
}
else //Αν ο χρήστης δεν είναι συνδεδεμένος
{
	echo "Δεν είστε συνδεδεμένος! Ανακατεύθυνση στην αρχική."; //Σχετικό μήνυμα
	header('Refresh: 2; URL=../default.php?page=index.php'); //Redirect
}
?>
</body>
</html>
