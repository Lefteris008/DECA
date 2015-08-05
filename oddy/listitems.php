<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>List Auctions</title> <!--Ο τίτλος της σελίδας-->
<!--Σύνδεση του απαραίτητου αρχείου css-->
<link href="page_style.css" rel="stylesheet" type="text/css" />
<!--Style του κειμένου με CSS-->
<style type="text/css">
#text
{
	font-size:16px;
	font-weight:bold;
	font-family:"Arial";
}
</style>
</head>

<body>
<?php
$flag=false;
$flag1=false;
//Γίνεται έλεγχος για να δούμε από ποια κατηγορία θα εμφανίσουμε προϊόν
//Αρχικά ελέγχεται το URL. Το URL είναι η σελίδα που έκανε κλικ ο χρήστης
//απ' τις child pages του "View all items". Συγκεκριμένα, μας ενδιαφέρει η τελευταία
//παράμετρος, chcat=XX, όπου XX οι περιπτώσεις που εξετάζουμε
if((isset($_GET['chcat']))&&($_GET['chcat']=="active")) //Εάν το URL περιλαμβάνει "sale"
{
	?>
	<script type="text/javascript">
		document.title="ΤΗΔΟ | Ενεργές δημοπρασίες";
	</script>
	<?php
	$query="SELECT * FROM item where active='1'"; //Επιστρέφουμε τα αποτελέσματα προς πώληση
}
elseif((isset($_GET['chcat']))&&($_GET['chcat']=="deactive")) //Ομοίως, αν το URL περιλαμβάνει "excange"
{
	?>
	<script type="text/javascript">
		document.title="ΤΗΔΟ | Ανενεργές δημοπρασίες";
	</script>
	<?php

	$query="SELECT * FROM item where active='0'"; //Επιστρέφουμε τα αποτελέσματα προς ανταλλαγή
}
elseif((isset($_GET['chcat']))&&($_GET['chcat']=="user")&&(isset($_SESSION['loggedin']))) //Αν το URL έχει τη λέξει "user" και υπάρχει συνδεδεμένος χρήστης
{
	?>
	<script type="text/javascript">
		document.title="ΤΗΔΟ | Δημοπρασίες που καταχωρήσατε";
	</script>
	<?php
	$user=$_SESSION['username']; //Παίρνουμε το username
	if(!isset($_GET['do']))
	{
		$query="SELECT * FROM item where user='$user'"; //Επιστρέφουμε όλα τα αποτελέσματα του χρήστη "user"
	}
	elseif($_GET['do']=="delete") //Εάν ο χρήστης επιλέξει να διαγράψει το αντικείμενό του
	{
		//echo "Είστε σίγουροι πως θέλετε να διαγράψετε τη δημοπρασία; Η δημοπρασία δεν μπορεί να επαναφερθεί μετά απ' αυτό.";
				
		$i=$_GET['id']; //Παίρνουμε το id
		$query="DELETE FROM item where user='$user' and id='$i'"; //Το διαγράφουμε
		$flag=true; //Κάνουμε ένα άτυπο "signal", σηκώνοντας τη σημαία
	}
	elseif($_GET['do']=="deactivate")
	{
		$i=$_GET['id'];
		$query1="UPDATE item SET active='0' WHERE id='$i'";
		$update1=mysql_query($query1);
		$flag1=true;
	}
	elseif($_GET['do']=="activate")
	{
		$i=$_GET['id'];
		$query2="UPDATE item SET active='1', flag='false' WHERE id='$i'";
		$update2=mysql_query($query2);
		$flag1=true;
	}
}
elseif(isset($_GET['chcat'])&&($_GET['chcat']=="favorites")) //Εάν το URL περιλαμβάνει "ask"
{
	?>
	<script type="text/javascript">
		document.title="ΤΗΔΟ | Αγαπημένες δημοπρασίες";
	</script>
	<?php
	$currentuser="";
	if(isset($_SESSION['loggedin']))
		$currentuser="".htmlspecialchars($_SESSION['username']);
	$query="SELECT * FROM item, favorites WHERE favorites.auction_id=item.id AND favorites.username='$currentuser'"; //Επιστρέφουμε όλα τα αντικείμενα που έχουν ζητηθεί προς αγορά
}
elseif(isset($_GET['term'])) //Εάν τώρα έχει γίνει αναζήτηση αποτελεσμάτων
{
	$term=$_GET['term'];
	?>
	<script type="text/javascript">
		document.title="ΤΗΔΟ | Αναζήτηση για '<?php echo $term; ?>'";
	</script>
	<?php

	$search= mysql_real_escape_string($_GET['term']); //Στη μεταβλητή search, μπαίνει ο όρος "term"
	$query="SELECT * FROM item where title LIKE '%$search%' || tags LIKE '%$search%'"; //Γίνεται επιλογή των αντικειμένων που ταιριάζουν στο search
}
else //Η περίπτωση της κατηγορίας "no", όπου απλά γίνεται κλικ στο parent category "View all items"
{
	?>
	<script type="text/javascript">
		document.title="ΤΗΔΟ | Δημοπρασίες";
	</script>
	<?php
	$query="SELECT * FROM item"; //Επιλέγονται όλα τα αντικείμενα
}
	$connect = mysql_connect("localhost", "aucadmin", "password"); //Γίνεται σύνδεση στη ΒΔ 
if(!$connect) //Εάν υπάρξει πρόβλημα στη σύνδεση
{ 
	die("ERROR: ".mysql_error()); //Εμφανίζεται σχετικό μήνυμα
} 
	$select_db = mysql_select_db("auction_site", $connect); //Γίνεται επιλογή της ΒΔ
if(!$select_db) //Αν υπάρξει πρόβλημα
{ 
	die("ERROR: ".mysql_error()); //Εμφανίζεται σχετικό μήνυμα
}
$result=mysql_query($query);
if($flag==true) //Αν έχει σηκωθεί σημαία, δηλαδή έχει διαγραφεί αντικείμενο
{
	echo "Item has succesfully been deleted!"; //Εμφανίζεται σχετικό μήνυμα
	header("Location: default.php?page=listitems.php&chcat=user"); //Γίνεται redirect στη σελίδα με τα αντικείμενα του χρήστη
}
if($flag1==true)
{
	header("Location: default.php?page=listitems.php&chcat=user");
}
$num=mysql_numrows($result); //Παίρνουμε τον αριθμό των αποτελεσμάτων
mysql_close(); //Ολοκληρώνουμε το session τη mySQL
if($num==0) //Εάν δεν υπάρχουν αντικείμενα
{
	echo "Δε βρέθηκαν αντικείμενα!"; //Εμφανίζεται σχετικό μήνυμα
}
else //Εάν υπάρχουν
{
	$i=0;
	?> <!--Κλείνε το πάνω κομμάτι php κώδικα-->
	
	<table id="listitems" border="0"
	cellpadding="1" cellspacing="1" >
	
	<tbody>
	
	<!--Το layout της γραμμής με το αντικείμενο-->
	<tr>
		
		<td id="text">Τίτλος</td> <!--Τίτλος-->
	    <td id="text">Κατάσταση</td> <!--Κατηγορία-->
	    <td id="text">Τρέχουσα τιμή</td> <!--Τιμή-->
	    <td id="text">Φωτογραφία</td> <!--Φωτογραφία (αν υπάρχει, αν όχι μπαίνει η "no_pic")-->
	</tr>
	<?php
	$c = 0;
 	while ($i < $num) //Όσο υπάρχουν στοιχεία
	{
		//Περνάμε στις μεταβλητές τα ανάλογα στοιχεία
		$id=mysql_result($result,$i,"id");
	 	$title=mysql_result($result,$i,"title");
		$category=mysql_result($result,$i,"active");
	 	$user=mysql_result($result,$i,"user");
	 	$currentprice=mysql_result($result,$i,"currentprice");
	 	$filename=mysql_result($result,$i,"filename");
	 	$i++; //Αυξάνουμε το i, ώστε κάποια στιγμή να ξεπεράσει τον αριθμό των αντικειμένων
	 		  //και να σπάσει η επανάληψη
	  	echo "<tr>";
	  	echo "<td id='text10'><a href=default.php?page=viewitem.php&itemid=$id&bid_c=no>$title</a>&nbsp;"; //Το link του αντικειμένου
	  	if(isset($_SESSION['loggedin'])&&($_SESSION['username']==$user)) //Εάν ο χρήστης είναι συνδεδεμένος
	  	{
	  		echo "<br/>";
	  		echo "&nbsp;<a href=default.php?page=members/form/form.php&id=$id>Επεξεργασία</a>"; //Εμφανίζουμε την επιλογή για επεξεργασία
	  		?>
	  		&nbsp;-&nbsp;<a href="default.php?page=listitems.php&chcat=user&do=delete&id=<?php echo $id; ?>" onclick="return confirm('Είστε σίγουροι πως θέλετε να διαγράψετε τη δημοπρασία; Δε μπορείτε να αναιρέσετε αυτή την ενέργεια.')">Διαγραφή</a>
	  		<?php
	  		if($category==1)
	  		{
	  			?>
	  			&nbsp;-&nbsp;<a href="default.php?page=listitems.php&chcat=user&do=deactivate&id=<?php echo $id; ?>" onclick="return confirm('Είστε σίγουροι πως θέλετε να απενεργοποιήσετε αυτή τη δημοπρασία; Κανένας νέος αγοραστής δε θα μπορεί να υποβάλλει νέα προσφορά.')">Απενεργοποίηση</a>
	  			<?php
	  		}
	  		else
	  		{
	  			?>
	  			&nbsp;-&nbsp;<a href="default.php?page=listitems.php&chcat=user&do=activate&id=<?php echo $id; ?>" onclick="return confirm('Είστε σίγουροι πως θέλετε να ενεργοποιήσετε αυτή τη δημοπρασία; Εάν η ημερομηνία ολοκλήρωσης έχει περάσει, η δημοπρασία θα απενεργοποιηθεί ξανά αυτόματα.')">Ενεργοποίηση</a>
	  			<?php

	  		}
	  	}
	  	echo "</td>";
	  	//Γίνεται εμφάνιση των επιμέρους στοιχείων του αντικειμένου
	  	if($category==1)
	  	{
	  		echo "<td id='text10'>Ενεργή</td>";
	  	}
	  	else
	  	{
	  		echo "<td id='text10'>Ανενεργή</td>";
	  	}
	  	echo "<td id='text10'>€ $currentprice</td>";
	  	echo "<td id='text10'>";
	  	echo '<img id="iconstyle" alt="ΣΦΑΛΜΑ: Δε βρέθηκε εικόνα." src="members/uploads/'.$filename.'" width=100px height=100px>'."&nbsp;&nbsp;" ;
	  	
	  	echo "</td>";
	  	echo "  </tr>";
	  	//και κατ' επέκταση του ίδιου του αντικειμένου, συνολικά
	}
}
?>
</tbody>
</table>

</body>

</html>
