<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>View item</title>
<link href="page_style.css" rel="stylesheet" type="text/css" />
<script src="gen_validatorv4.js" type="text/javascript"></script>
</head>

<body>

<?php 
function comments($id,$user)
{
	$connect = mysql_connect("localhost", "aucadmin", "password"); //Σύνδεση με τη ΒΔ
	if(!$connect) //Αν αποτύχει
	{ 
		die("ERROR: ".mysql_error()); //Επιστρέφεται σφάλμα
	} 
	$query_com="SELECT * FROM comments where itemid='$id'"; //Επιλέγονται τα σχόλια για το εν λόγω αντικείμενο
	//Γίνεται επιλογή της ΒΔ 
	$select_db = mysql_select_db("auction_site", $connect); 
	if(!$select_db) //Αν αποτύχει
	{ 
		die("ERROR: ".mysql_error()); //Επιστρέφεται σφάλμα
	}
	$result_com=mysql_query($query_com);
	$num_com=mysql_numrows($result_com);
	if($num_com==0) //Αν επιστραφούν 0 αποτελέσματα
	{
		echo "Δεν υπάρχουν σχόλια"; //Τότε δεν υπάρχουν σχόλια
	}
	else //Υπάρχουν σχόλια
	{
		?>
		<!--Μορφοποιούμε το σημείο που εμφανίζονται-->
		<table style="text-align: left;  width: auto; height: auto;" border="0"
    	cellpadding="2" cellspacing="2">
    	
    	<tr>
    	<td id="text"  required="required" style="border-bottom: thin gray;">Σχόλια</td>
    	</tr>
    	<?php 
    	$i=0;
		while ($i < $num_com) //Όσο υπάρχουν σχόλια
		{
			//Εμφανίζουμε τα ακόλουθα
    		$comment=mysql_result($result_com,$i,"comment"); //Σχόλιο
    		$displaycomment=wordwrap($comment, 72, "\n", true);
    		$date=mysql_result($result_com,$i,"date"); //Ημερομηνία
    		$usercom=mysql_result($result_com,$i,"user"); //Χρήστης
    		$i++; //Αυξάνουμε το i, ώστε κάποια στιγμή να ξεπεράσει τον αριθμό των σχολίων
    		echo    "<tr>";
    		echo    "<td id='comments'><strong>Από το χρήστη:</strong>&nbsp;&nbsp;<em>$usercom</em>&nbsp;&nbsp<strong>Στις:</strong>&nbsp;&nbsp<em>$date</em></td>";
    		echo    "</tr>";
    		echo    "<tr>";
    		echo    "<td id='comments''>$displaycomment</td>";
    		echo    "</tr>";
    		
		}
	}
	
    if(isset($_SESSION['loggedin'])) //Αν ο χρήστης είναι συνδεδεμένος
    {
    	echo	"<tr><td></td></tr>";
    	echo	"<tr><td></td></tr>";
    	echo	"<tr><td></td></tr>";
    	echo    "<tr>";
    	echo    "<td>";
    	//Τότε εμφανίζουμε το πλαίσιο κειμένου ώστε να εισάγει σχόλιο
    	?>
    	
    	<form id="form1" method="post" action="comments.php?do=save&id=<?php echo $id; ?>">
    	Αφήστε το σχόλιό σας:<br /><textarea style="resize: none;" name="message" required="required" rows="5" cols="77" ></textarea><br />
    	<input type="submit" value="Δημοσίευση" /> 
    	</form>
    	<script type="text/javascript">
    		var frmvalidator = new Validator("form1");
			frmvalidator.addValidation("message", "req", "Παρακαλώ εισάγετε το σχόλιό σας.");
    	</script>
     	<?php
     	echo    "</td>";
    	echo    "</tr>";
    } 
    
	?>
	
	</table>
	<?php 
}
$id=$_GET['itemid']; //Παίρνουμε το id του αντικειμλενου
if(isset($_GET['bid_c']))
	$bid_c=$_GET['bid_c'];
$currentuser="";
if(isset($_SESSION['loggedin']))
	$currentuser="".htmlspecialchars($_SESSION['username']);
$connect = mysql_connect("localhost", "aucadmin", "password"); //Συνδεόμαστε στη ΒΔ
if(!$connect) //Αν δε συνδεθεί
{ 
	die("ERROR: ".mysql_error()); //Εμφανίζουμε σφάλμα
} 
$query="SELECT * FROM item where id='$id'"; //Επιλέγουμε όλα τα αντικείμενα με id, το "id"
//Επιλέγουμε τη ΒΔ
$select_db = mysql_select_db("auction_site", $connect); 
if(!$select_db) //Αν αποτύχει
{ 
	die("ERROR: ".mysql_error()); //Επιστρέφουμε σφάλμα
}
$result=mysql_query($query);
$num=mysql_numrows($result);
mysql_close();
if($num==0) //Αν δεν υπάρχουν τα εν λόγω αντικείμενα
{
	echo "Το αντικείμενο δε βρέθηκε"; //Εμφανίζουμε μήνυμα
}
else //Αν υπάρχουν
{
	//Κρατάμε τα ακόλουθα στοιχεία
	$id=mysql_result($result,0,"id"); //id
	$title=mysql_result($result,0,"title"); //Τίτλος
	$category=mysql_result($result,0,"active"); //Κατηγορία
	$user=mysql_result($result,0,"user"); //Χρήστης
	$baseprice=mysql_result($result,0,"baseprice"); //Τιμή
	$filename=mysql_result($result,0,"filename"); //Όνομα αρχείου
	$brand=mysql_result($result,0,"brand");
	$model=mysql_result($result,0,"model");
	//$baseprice=mysql_result($result,0,"baseprice");
	$cc=mysql_result($result,0,"cc");
	$hp=mysql_result($result,0,"hp");
	$year=mysql_result($result,0,"year");
	$colour=mysql_result($result,0,"colour");
	$kms=mysql_result($result,0,"kms");
	$dateofcompletion=mysql_result($result,0,"dateofcompletion");
	$mostrecentbider=mysql_result($result,0,"mostrecentbider");
	$creatorcomment=mysql_result($result,0,"creatorcomment");
	$currentprice=mysql_result($result,0,"currentprice");
	$currentdate=date("Y-m-d");
	$currentdate_c = strtotime($currentdate);
	$dateofcompletion_c = strtotime($dateofcompletion);
	$flag=mysql_result($result,0,"flag");
	if(($dateofcompletion_c < $currentdate_c)&&$flag=='false')
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
		$update=mysql_query("UPDATE item SET active='0', flag='true' WHERE id='$id'");
		if(!$update)
			die("ERROR: ".mysql_error()); //Επιστρέφουμε σφάλμα
		
		header('Refresh:0; URL=default.php?page=viewitem.php&itemid='.$id.'&bid_c=no');


	}
	
	?>
	<script type="text/javascript">
		document.title="ΤΗΔΟ | <?php echo $title; ?>";
	</script>
	<?php
	if((isset($_GET['fav']))&&($_GET['fav']=="add"))
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
		$fav=mysql_query("INSERT INTO favorites (username, auction_id) VALUES ('$currentuser', '$id')");
		if(!$fav)
			die("ERROR: ".mysql_error()); //Επιστρέφουμε σφάλμα
		mysql_close();
		header("Location: default.php?page=viewitem.php&itemid=$id&bid_c=no");
	}
	elseif((isset($_GET['fav']))&&($_GET['fav']=="delete"))
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
		$fav=mysql_query("DELETE FROM favorites WHERE username='$currentuser' AND auction_id='$id'");
		if(!$fav)
			die("ERROR: ".mysql_error()); //Επιστρέφουμε σφάλμα 
		mysql_close();
		header("Location: default.php?page=viewitem.php&itemid=$id&bid_c=no");

	}
	if($bid_c=="yes")
	{
		$connect = mysql_connect("localhost", "aucadmin", "password"); //Συνδεόμαστε στη ΒΔ
		if(!$connect) //Αν δε συνδεθεί
		{ 
			die("ERROR: ".mysql_error()); //Εμφανίζουμε σφάλμα
		} 
		$query="SELECT * FROM item where id='$id'"; //Επιλέγουμε όλα τα αντικείμενα με id, το "id"
		//Επιλέγουμε τη ΒΔ
		$select_db = mysql_select_db("auction_site", $connect); 
		if(!$select_db) //Αν αποτύχει
		{ 
			die("ERROR: ".mysql_error()); //Επιστρέφουμε σφάλμα
		}
		if($_REQUEST['bid_price']==0)
		{
			//echo "<div>Η τιμή προφοράς δε μπορεί να είναι μηδενική.</div>";
			//header('Refresh: 2; URL=default.php?page=viewitem.php&itemid='.$id.'&bid_c=no');
			//die();
			?>
			<script type="text/javascript">
				alert('Η τιμή προσφοράς δε μπορεί να είναι μηδενική.');
				window.location="default.php?page=viewitem.php&itemid=<?php echo $id; ?>&bid_c=no";
			</script> 
			<?php
			die();
		}
		if($_REQUEST['bid_price']>5000)
		{
			//echo "<div>Η τιμή προφοράς δε μπορεί να υπερβαίνει τα €5.000.</div>";
			//header('Refresh: 2; URL=default.php?page=viewitem.php&itemid='.$id.'&bid_c=no');
			?>
			<script type="text/javascript">
				alert('Η τιμή προσφοράς δε μπορεί να υπερβαίνει τα €5.000.');
				window.location="default.php?page=viewitem.php&itemid=<?php echo $id; ?>&bid_c=no";
			</script> 
			<?php
			die();

		}
		$newprice=$currentprice + $_REQUEST['bid_price'];
		$mostrecentbider = $currentuser;
		$query_new="UPDATE item SET currentprice='$newprice', mostrecentbider='$mostrecentbider' WHERE id='$id'";
		$update=mysql_query($query_new);
			
		
		if(!$update) //Αν η ενημέρωση αποτύχει
		{ 
			die("ERROR: ".mysql_error()); //Σχετικό μήνυμα
		}
		mysql_close();
		header('Refresh:0; URL=default.php?page=viewitem.php&itemid='.$id.'&bid_c=no' ) ;
	}
	
	$connect = mysql_connect("localhost", "aucadmin", "password"); //Συνδεόμαστε στη ΒΔ
	if(!$connect) //Αν δε συνδεθεί
	{ 
		die("ERROR: ".mysql_error()); //Εμφανίζουμε σφάλμα
	} 
	$select_db = mysql_select_db("auction_site", $connect); 
	if(!$select_db) //Αν αποτύχει
	{ 
		die("ERROR: ".mysql_error()); //Επιστρέφουμε σφάλμα
	}


	$query_user="SELECT type FROM users WHERE username='$currentuser'";
	$query_f="SELECT * FROM favorites WHERE auction_id='$id' AND username='$currentuser'";
	$result_f=mysql_query($query_f);
	$num=mysql_numrows($result_f);
	$result_user=mysql_query($query_user);
	$row = mysql_fetch_row($result_user);
	$typeuser=$row[0];
	mysql_close();
	//Μορφοποίηση εμφάνισης των πιο πάνω στοιχείων
	echo "<table id='listitems' style='text-align:left  width: auto; height: 20px;  ' border='0'>";
	echo "<tbody>";
	echo    "<tr>";
	echo    "<td id='text5'>$title</td>";
	echo    "</tr>";
	echo	"<tr>";
	echo	"<td>";
	echo	"</td>";
	if((isset($_SESSION['loggedin']))&&($typeuser==0))
	{
	echo	"<td>";
	if($num==0)
	{
	?> 
		<input id="favbutton-plus" style="float:right" type="button" title="Προσθήκη στα αγαπημένα" onclick="parent.location='?page=viewitem.php&itemid=<?php echo $id; ?>&bid_c=no&fav=add'" value=""></input>
	<?php
	}
	else
	{
	?> 
		<input id="favbutton-delete" style="float:right" type="button" title="Αφαίρεση από τα αγαπημένα" onclick="parent.location='?page=viewitem.php&itemid=<?php echo $id; ?>&bid_c=no&fav=delete'" value=""></input>
	<?php
	}
	echo	"</td>";
	}
	echo	"</tr>";
	echo    "<tr>";
	echo    "<td id='text7'>Μάρκα:</td>";	
	echo    "<td id='text2'>$brand</td>";
	echo	"</tr>";
	echo    "<tr>";
	echo    "<td id='text7'>Μοντέλο:</td>";	
	echo    "<td id='text2'>$model</td>";
	echo	"</tr>";
	if($creatorcomment!='')
	{
		echo    "<tr>";
		echo    "<td id='text7'>Σχόλιο συντάκτη:</td>";	
		echo    "<td id='text2'>$creatorcomment</td>";
		echo	"</tr>";
	}
	echo    "<tr>";
	echo    "<td id='text7'>Κυβικά:</td>";	
	echo    "<td id='text2'>$cc</td>";
	echo	"</tr>";
	echo    "<tr>";
	echo    "<td id='text7'>Ίπποι:</td>";	
	echo    "<td id='text2'>$hp</td>";
	echo	"</tr>";
	echo    "<tr>";
	echo    "<td id='text7'>Χρονολογία κατασκευής:</td>";	
	echo    "<td id='text2'>$year</td>";
	echo	"</tr>";
	echo    "<tr>";
	echo    "<td id='text7'>Χρώμα:</td>";	
	echo    "<td id='text2'>$colour</td>";
	echo	"</tr>";
	echo    "<tr>";
	echo    "<td id='text7'>Χιλιόμετρα:</td>";	
	echo    "<td id='text2'>$kms</td>";
	echo	"</tr>";
	echo    "<tr>";
	echo    "<td id='text7'>Τιμή εκκίνησης:</td>";	
	echo    "<td id='text2'>€ $baseprice</td>";
	echo	"</tr>";
	echo    "<tr>";
	echo    "<td id='text7'>Τρέχουσα τιμή:</td>";	
	echo    "<td id='text2'>€ $currentprice</td>";
	echo	"</tr>";
	echo    "<tr>";
	echo    "<td id='text7'>Ημερομηνία ολοκλήρωσης:</td>";
		if($category==1)	
	echo    "<td id='text2'>$dateofcompletion</td>";
		else
	echo    "<td id='text12'>ΕΚΛΕΙΣΕ</td>";
	echo	"</tr>";
	echo    "<tr>";
	echo    "<td id='text7'>Φωτογραφία</td>";	
	echo    "<td>";
	echo    '<img id="iconstyle" alt="ΣΦΑΛΜΑ: Δε βρέθηκε εικόνα." src="members/uploads/'.$filename.'" width=300px height=300px>';
	echo    "</td>";
	echo	"</tr>";
	echo    "<tr>";
	echo    "<td id='text7'>Κατάσταση:</td>";
	if($category==1)
		echo    "<td id='text2'>Ενεργή</td>";
	else
		echo	"<td id='text2'>Ανενεργή</td>";
	echo    "</tr>";
	
	if($category==0)
	{
		echo	"<tr>";
		echo	"<td id='text7'>Κατοχυρώθηκε στον χρήστη: </td>";
		if((isset($_SESSION['loggedin']))&&($typeuser==1))
		{
			echo  "<td><a href='default.php?page=profile.php&p=$mostrecentbider'>$mostrecentbider</a></td>";
		}
		else
		{
			echo  "<td>$mostrecentbider</td>";
		}
		echo	"</tr>";
	}
	
	echo    "<tr>";
	echo    "<td>";
	if((isset($_SESSION['loggedin']))&&($category==1)&&($typeuser==0))
	{
		
		//echo "<a href='default.php?page=viewitem.php&itemid=".$id."&bid_c=yes'><img id=bidbutton src='bid-button.png'/></a>";
		if($mostrecentbider!=$currentuser)
		{
		?>
		
			
			
			<form id="form8" style="margin-top:auto;" action="default.php?page=viewitem.php&itemid=<?php echo $id; ?>&bid_c=yes" method="post">
			<div>
			<input id="bidbutton" type="submit" value="Προσφορά (bid)" onclick="return confirm('Είστε σίγουρος πως θέλετε να υποβάλετε νέα προσφορά; Δε μπορείτε να αναιρέσετε αυτή την ενέργεια.')"></input>
			<td>€&nbsp;<input name="bid_price" type="text" size="5" required="required" title="Παρακαλώ, συμπληρώστε την τιμή που επιθυμείτε να υποβάλλετε ως προσφορά"></input></td></div>
			</form>
			<script type="text/javascript">
    			var frmvalidator = new Validator("form8");
				frmvalidator.addValidation("bid_price", "req", "Παρακαλώ εισάγετε το ποσό προσφοράς σας (bid).");
    		</script>
			</td>
			</tr>
			<tr>
			<td>
			<div id="text11">Παρακαλώ διαβάστε τους <a href="default.php?page=main.php&help=1">όρους χρήσης</a> <br/>(εδάφιο 1.1.1.) για τις προσφορές (bids).</div>		
		
		<?php
		}
		else
		{
		?>
		
		<input id="bidbutton" type="button" disabled="disabled" value="Προσφορά (bid)"></input>
		
		
		<?php
		
			echo	"</td>";
			echo	"</tr>";
			echo	"<tr>";
			echo	"<td>";
			echo	"<div id='text11'>Έχετε ήδη καταθέσει προσφορά γι' αυτή</br>τη δημοπρασία. Έως ότου κάποιος άλλος</br>χρήστης καταθέσει εκ νέου δικιά του</br>προσφορά, δε μπορείτε να κάνετε ξανά bid.</div>";
			

		}
		
	}
	elseif(!(isset($_SESSION['loggedin']))&&($category==1))
	{
		echo	"Συνδεθείτε για να συμμετάσχετε στη δημοπρασία.";
		echo	"<br/>";
		echo	"Δεν έχετε λογαριασμό; <a href='default.php?page=register.html'>Εγγραφείτε δωρεάν!</a>";
	}	
	echo	"</td>";
	echo	"</tr>";
	echo "</tbody>";
	echo "</table>";
	echo "<br/>";
	
	echo	"<table id='listitems' style='text-align:left  width: auto; height: 20px;  ' border='0'>";
	echo	"<tbody>";
	echo    "<tr>";
	echo    "<td id='text2'>";
			comments($id,$user);
	echo	"</td>";
	echo	"</tr>";
	echo	"</tbody>";
	echo	"</table>";
	echo	"</br>";
	
	if((isset($_SESSION['loggedin']))&&$typeuser==0)
	{
		echo "<table id='listitems1' style='text-align:left  width: auto; height: 20px;  ' border='0'>";
		echo "<tbody>";
		echo    "<tr>";
		echo    "<td id='text7'>Επικοινωνήστε με τον αρμόδιο διαχειριστή</td>";
		echo    "</tr>";
		echo    "<tr>";
		echo    "<td>";
		echo	"<br/>";
		if((isset($_SESSION['loggedin']))&&(!isset($_GET['do']))) //Αν ο χρήστης είναι συνδεδεμένος
		{
			//Του εμφανίζουμε τη φόρμα συμπλήρωσης e-mail
			?>
			<form id='form2' method='post' action='default.php?page=mail.php&do=send&id=$id'>
  			Το e-mail σας*: <br/> <input name="email" type="email" required="required" size="30"/> <br/>
  			Το μήνυμα σας*:<br/> <textarea style="resize: none;" name="message" rows="5" cols="35"  required="required"></textarea> <br/>
  			<input type="submit" value="Αποστολή μηνύματος"/>
  			</form>
  			<script type="text/javascript">
    			var frmvalidator = new Validator("form2");
    			frmvalidator.addValidation("email", "req", "Παρακαλώ εισάγετε το email σας.");
    			frmvalidator.addValidation("email", "email", "Παρακαλώ εισάγετε ένα έγκυρο email.");
				frmvalidator.addValidation("message", "req", "Παρακαλώ εισάγετε το μήνυμά σας.");
    		</script>

   			<?php
  		} 
		echo    "</td>";
		echo	"</tr>";
		//echo	"<tr><td></td></tr>"; 
		echo "</tbody>";
		echo "</table>";
	}
	
}
?> 
</body>
</html>