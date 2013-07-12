<div id="boxes">

<?php	
$narodenie = new DateTime("1994-08-03");
$dnes = new DateTime();
$interval = $narodenie->diff($dnes);
echo  $interval->y . "r " . $interval->m."m ".$interval->d."d";
echo "<br />".$interval->format('%a days');


$narodenie = strtotime("1994-08-03");
$dnes = strtotime(date("Y-m-d"));
echo $vek = floor((date("Ymd",$dnes) - date("Ymd",$narodenie)) / 10000);

$_vek_osoby_drzitel = floor((date("Ymd",$_datum_pociatku_poistenia) - date("Ymd",$_datum_narodenia)) / 10000);
?>

</div>