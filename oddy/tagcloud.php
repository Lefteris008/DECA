<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="tag_style.css" media="all">
	<title>Tag Cloud</title>
	<script src="gen_validatorv4.js" type="text/javascript"></script>
</head>

<body>
<?php
$flag=FALSE;
//Sindesi me ti BD
$conn = mysql_connect('localhost', 'aucadmin', 'password');
if (!$conn or !mysql_select_db('auction_site', $conn))
	die("ERROR: ".mysql_error());
//Xeirismos anazitisewn
if((isset($_POST['submit'])) && ($_POST['submit'] == "Αναζήτηση"))
{
    //Pairnoume ton xrono
    $now = date("Y-m-d H:i:s");
    $flag=TRUE;
    //Kratame ton oro pou exei dothei ap ton xristi kai ton proetoimazoume gia erwtisi sti vasi
    $term = mysql_real_escape_string(strip_tags(trim($_POST['term'])));
    $search_res=$term;
    //Elegxos gia to an o oros exei dothei palaiotera
    if (mysql_result(mysql_query("SELECT COUNT(id) FROM search WHERE term = '$term'"), 0) > 0)
    {
        //O oros yparxei idi -enimerwsi tou counter kai tou teleutaiou time stamp
        mysql_query("UPDATE search SET counter = counter+1, last_search = '$now' WHERE term = '$term'");
    }
    else 
    {
        //O oros den yparxei -eisagwgi neas eggrafis
        mysql_query("INSERT INTO search (term, last_search) VALUES ('$term', '$now')");
    }	    
}
//Proetoimasia tou pinaka tou tag cloud gia emfanisi
$terms = array(); //Dimourgia kenou pinaka
$maximum = 0; //H metavliti $maximum einai o ipsiloteros counter gia ton oro anazitisis
$query = mysql_query("SELECT term, counter FROM search ORDER BY counter DESC LIMIT 30");
while ($row = mysql_fetch_array($query))
{
    $term = $row['term'];
    $counter = $row['counter'];
    //Enimerwsi tis metavlitis $maximum ean o en logw oros einai pio dimofilis ap' tous prohgoumenous orous
    if ($counter > $maximum)
    	$maximum = $counter; 
    $terms[] = array('term' => $term, 'counter' => $counter);
}
//Emfanisi twn orwn me tyxaia seira
shuffle($terms); 
?>
<div style="margin-right:20px; margin-top:20px">
<h2 style="font-family:Arial">Αναζήτηση</h2>
<form id="form6" style="margin-left:auto;" id="search" method="post" action="tagcloud.php">
	<input type="text" name="term" id="term" required="required" /> <br>
    <input type="submit" name="submit" id="submit" value="Αναζήτηση" />
</form>
<script type="text/javascript">
	var frmvalidator = new Validator("form6");
	frmvalidator.addValidation("term", "req", "Παρακαλώ εισάγετε έναν όρο αναζήτησης.");
</script>

<h3 style="font-family:Arial">Δημοφιλείς όροι</h3>
<div id="tagcloud">
<?php 
//Epanalipsi metaxy twn orwn
foreach ($terms as $term):
//Diapistwsi tou poso dimofilhs einai o oros ws posostoΞβ€™Ξ’Β
$percent = floor(($term['counter'] / $maximum) * 100);
//Katataksi tou orou se taxi, analogws tou posostou tou
//Oroi me megalitero pososto emfanizontai me megalytero megethos
//apo orous me mikrotero sto tag cloud
if ($percent < 20):
	$class = 'smallest'; //Poly mikroΞβ€™Ξ’Β
elseif ($percent >= 20 and $percent < 40):
    $class = 'small'; //Mikro
elseif ($percent >= 40 and $percent < 60):
    $class = 'medium'; //Messaio
elseif ($percent >= 60 and $percent < 80):
    $class = 'large'; //Megalo
else:
    $class = 'largest'; //Megisto
endif;
?>
<span class="<?php echo $class; ?>">
	<a href="default.php?page=listitems.php&term=<?php echo urlencode($term['term']); ?>"><?php echo $term['term']; ?></a>
</span>
<?php
endforeach;
if($flag==TRUE)
	header("Location: default.php?page=listitems.php&term=".$search_res);
?>
</div>
</div>
</body>
</html>