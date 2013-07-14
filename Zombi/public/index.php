<?
// spustenie session
session_start();

// nacitanie konfiguracneho suboru pre web
if (file_exists('./configs/global.php') ) require'./configs/global.php';
else echo'ERROR: CONFIG FILE MISSING...';

// ak nie je zvolena ziadna pozadovana stranka alebo je zvolena taka ktora neexistuje tak sa zobrazi homepage
if ( !isset($_GET['list']) ) $_GET['list']='homepage';

// nacitanie suboru funkcii pre web
if (file_exists('./configs/functions.php') ) require'./configs/functions.php'; // modul pre funkcie
if (file_exists('./configs/functions_'.$_GET['list'].'.php') ) require'./configs/functions_'.$_GET['list'].'.php'; // modul pre funkcie pre danu sekciu
if (file_exists('./configs/login.php') ) require'./configs/login.php'; // modul pre prihlasovanie

// ak je zvolena stranka/podstranka taka ktora neexistuje tak prejdeme o uroven vyssie z WEB/LIST/ACT1 na WEB/LIST/ a podobne...
if ( file_exists('./sections/export/export_'.$_GET['list'].'.php') )
{
  // vola sa url, krora bude pre aplikaciu: pdf, xls a podobne, cize sa nena��ta template...
}
elseif ( $_GET['list']=='terminy' and isset($_GET['act1']) )
{
  // ak sa jedna o termin pre rezervaciu, tak nepresmerujeme nikam
  List($termin,$termin_id)=explode('-',$_GET["act1"]);
  if ( !( $termin=='termin' and is_numeric($termin_id) ) ) Header( "Location: ".$_PAGE['base_url'].$_GET['list'] );
}
elseif ( isset($_GET['list']) and isset($_GET['act1']) and !file_exists('./sections/body/'.$_GET['list'].'/body_'.$_GET['act1'].'.php') ) Header( "Location: ".$_PAGE['base_url'].$_GET['list'] );
elseif ( isset($_GET['list']) and !isset($_GET['act1']) and !file_exists('./sections/body/body_'.$_GET['list'].'.php') ) Header( "Location: ".$_PAGE['base_url'] );

// nacitanie meta tagov pre jednotlive sekcie WEB/LIST/ACT1/
    if (isset($_PAGES[$_GET['list']][$_GET['act1']]['title'])) $_PAGE['title'] = $_PAGES[$_GET['list']][$_GET['act1']]['title'];
elseif (isset($_PAGES[$_GET['list']]['title'])) $_PAGE['title'] = $_PAGES[$_GET['list']]['title'];
    if (isset($_PAGES[$_GET['list']][$_GET['act1']]['keywords'])) $_PAGE['keywords'] = $_PAGES[$_GET['list']][$_GET['act1']]['keywords'];
elseif (isset($_PAGES[$_GET['list']]['title'])) $_PAGE['keywords'] = $_PAGES[$_GET['list']]['keywords'];
    if (isset($_PAGES[$_GET['list']][$_GET['act1']]['description'])) $_PAGE['description'] = $_PAGES[$_GET['list']][$_GET['act1']]['description'];
elseif (isset($_PAGES[$_GET['list']]['title'])) $_PAGE['description'] = $_PAGES[$_GET['list']]['description'];

// nacitanie dat pre danu sekciu
if (file_exists('./sections/data/'.$_GET['list'].'/data_'.$_GET['act1'].'.php') ) require'./sections/data/'.$_GET['list'].'/data_'.$_GET['act1'].'.php';
elseif (file_exists('./sections/data/data_'.$_GET['list'].'.php') ) require'./sections/data/data_'.$_GET['list'].'.php';

// nacitanie template pre web
if (file_exists('./sections/export/export_'.$_GET['list'].'.php') ) require'./sections/export/export_'.$_GET['list'].'.php'; // template pre aplikacie: generovanie pdf, xls a podobne...
elseif (file_exists('./template/'.$_PAGE['template_id'].'/template.php') ) require'./template/'.$_PAGE['template_id'].'/template.php'; // temlate: v�sup HTML
else echo'ERROR: TEMPLATE FILE MISSING...';

?>
