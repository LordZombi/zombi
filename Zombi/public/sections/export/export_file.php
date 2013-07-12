<?
// zobrazenie súboru -----------------------------------------------------------
// nastavenie hlavièiek
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
  { // ak máme záznam
    if ($result)
    { // ak nenastal problem pri selecte
      $row = $result->fetch_object();
      $filetype = 'image/jpg';  // nastavíme typ súboru
      if ( is_numeric($_GET['newsimage1']) )
      {
        $filename = 'news_'.$row->id.'_a.jpg'; // zostavíme názov
        $filesize = strlen($row->nimg1); // zistíme ve¾kos
        $filecontent = $row->nimg1;
      } 
      if ( is_numeric($_GET['newsimage2']) )
      {
        $filename = 'news_'.$row->id.'_b.jpg'; // zostavíme názov
        $filesize = strlen($row->nimg2); // zistíme ve¾kos
        $filecontent = $row->nimg2;
      } 
      if ( is_numeric($_GET['newsimage3']) )
      {
        $filename = 'news_'.$row->id.'_c.jpg'; // zostavíme názov
        $filesize = strlen($row->nimg3); // zistíme ve¾kos
        $filecontent = $row->nimg3;
      } 
      $showfile = true; // je to ok zobrazme obsah súboru      
    }
  }
}
// zobrazime obsah alebo vyhlásime chybu ---------------------------------------
if ( $showfile == true )
{ // nastavenie hlavièiek
  header("Content-type: ".$filetype);
  header("Content-Disposition: attachment; filename=".$filename.";");
  header("Content-Length: ".$filesize);
  // výpis obsahu
  echo $filecontent; 
}
else
{ // v prípade chyby, vypíšeme hlášku
  echo'<body><font face="arial">ERROR: No file...</font></body>';
}
$mysqli->close();
?>