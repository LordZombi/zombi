<?
// zobrazenie s�boru -----------------------------------------------------------
// nastavenie hlavi�iek
header("Expires: " . gmdate( "D, d M Y H:i:s" ) . " GMT");
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
// pripojenie do DB
$mysqli = new mysqli($_PAGE['config_db_host'],$_PAGE['config_db_login'],$_PAGE['config_db_pass'],$_PAGE['config_db_name']);
$mysqli->set_charset("cp1250");
// spracujeme vstupne hodnoty --------------------------------------------------
// ak sa jedna o subor aktuality
if ( 
      ( isset($_GET['newsimage1']) and is_numeric($_GET['newsimage1']) ) or
      ( isset($_GET['newsimage2']) and is_numeric($_GET['newsimage2']) ) or
      ( isset($_GET['newsimage3']) and is_numeric($_GET['newsimage3']) )
   )
{ // vypis z DB aktuality
  if ( is_numeric($_GET['newsimage1']) ) $result = $mysqli->query("SELECT * FROM ".$_PAGE['config_db_prefix']."_news WHERE id = '".$_GET['newsimage1']."';");
  if ( is_numeric($_GET['newsimage2']) ) $result = $mysqli->query("SELECT * FROM ".$_PAGE['config_db_prefix']."_news WHERE id = '".$_GET['newsimage2']."';");
  if ( is_numeric($_GET['newsimage3']) ) $result = $mysqli->query("SELECT * FROM ".$_PAGE['config_db_prefix']."_news WHERE id = '".$_GET['newsimage3']."';");
  if ($result->num_rows > 0)
  { // ak m�me z�znam
    if ($result)
    { // ak nenastal problem pri selecte
      $row = $result->fetch_object();
      $filetype = 'image/jpg';  // nastav�me typ s�boru
      if ( is_numeric($_GET['newsimage1']) )
      {
        $filename = 'news_'.$row->id.'_a.jpg'; // zostav�me n�zov
        $filesize = strlen($row->nimg1); // zist�me ve�kos�
        $filecontent = $row->nimg1;
      } 
      if ( is_numeric($_GET['newsimage2']) )
      {
        $filename = 'news_'.$row->id.'_b.jpg'; // zostav�me n�zov
        $filesize = strlen($row->nimg2); // zist�me ve�kos�
        $filecontent = $row->nimg2;
      } 
      if ( is_numeric($_GET['newsimage3']) )
      {
        $filename = 'news_'.$row->id.'_c.jpg'; // zostav�me n�zov
        $filesize = strlen($row->nimg3); // zist�me ve�kos�
        $filecontent = $row->nimg3;
      } 
      $showfile = true; // je to ok zobrazme obsah s�boru      
    }
  }
}
// zobrazime obsah alebo vyhl�sime chybu ---------------------------------------
if ( $showfile == true )
{ // nastavenie hlavi�iek
  header("Content-type: ".$filetype);
  header("Content-Disposition: attachment; filename=".$filename.";");
  header("Content-Length: ".$filesize);
  // v�pis obsahu
  echo $filecontent; 
}
else
{ // v pr�pade chyby, vyp�eme hl�ku
  echo'<body><font face="arial">ERROR: No file...</font></body>';
}
$mysqli->close();
?>