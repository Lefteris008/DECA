<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Logout</title> <!--Βοηθητικός τίτλος-->
</head>

<body>
<?php
$_SESSION['loggedin']=FALSE; //Εάν ο χρήστης αποσυνδεθεί
session_destroy(); //Καταστρέφεται η σύνοδος
header('Refresh:0; URL=default.php?page=main.php'); //Γίνεται redirect στην αρχική σελίδα
?>
</body>

</html>
