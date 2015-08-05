<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Comments</title> <!--Τίτλος συμβατότητας-->
</head>

<body>
	<?php
     session_start();
     //Ελέγχουμε εάν ο χρήστης είναι συνδεδεμένος
	 if(isset($_GET['do'])&&($_SESSION['loggedin']==TRUE)) //Εάν είναι
	 {
	 	$itemid=$_GET['id'];
 	 	$user=$_SESSION['username'];
 	 	$comment=mysql_real_escape_string($_REQUEST['message']);
 	 	//Αν και έχουμε συμπεριλάβει την εντολή required στην φόρμα αν ο browser δεν υποστηρίζει 
 	 	// HTML 5.0 κάνουμε αυτον τον έλεγχο.
   	 	if(empty($comment))
  	 	{
  	 	    $message="Please enter the comment!";
     	    header("location: default.php?page=messages.php&message=".$message); //Ανακατεύθυνση στη σελίδα μηνυμάτων
		    die();
		}
	 	else //Εάν υπάρχει μήνυμα
	 	{
			$connect = mysql_connect("localhost", "aucadmin", "password"); //Γίνεται σύνδεση στη βάση
			if(!$connect) //Εάν δε συνδεθεί
			{ 
	 			die("ERROR: ".mysql_error()); //Εμφανίζεται σφάλμα
	 	    } 
			//Γίνεται επιλογή της ΒΔ 
	 		$select_db = mysql_select_db("auction_site", $connect); 
	 		if(!$select_db) //Εάν δε μπορέσει να την επιλέξει
	 		{ 
				die("ERROR: ".mysql_error()); //Εμφανίζεται σφάλμα
	 	    }
	 	   	//Σε άλλη περίπτωση εισάγεται το σχόλιο στη ΒΔ, στον πίνακα 'comments'
   	 	   	$insert = mysql_query("INSERT INTO comments (itemid, comment, user) VALUES ('$itemid','$comment','$user')");
   	 	   	if(!$insert) //Εάν δε μπορέσει να το εισάγει
   	 	   	{
   	 	   		die("ERROR: ".mysql_error()); //Εμφανίζεται πρόβλημα
		   	} 
		   	header("Location: default.php?page=viewitem.php&itemid=$itemid&bid_c=no"); //Ανακατεύθυνση στη σελίδα προβολής αντικειμένου  
		}	
	 }
	 else //Αν ο χρήστης δεν είναι συνδεδεμένος
	 {
	     $message="You are not logged in!"; 
         header("location: default.php?page=messages.php&message=" . $message); //Ανακτεύθυνση στη σελίδα μηνυμάτων
	     die();
	 }
	

?>
</body>

</html>
