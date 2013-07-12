<?
// ak sme na subdomene financnahitparada.sk poziadame o iny subtemplate
//if ( eregi("financnahitparada.sk", $_SERVER["HTTP_HOST"]) ) $subtemplate = 'financnahitparada';


if ( file_exists('./template/'.$_PAGE['template_id'].'/subtemplates/'.$subtemplate.'/template.php') )
  // spustime pozadovany subtemplate ak existuje  
  include './template/'.$_PAGE['template_id'].'/subtemplates/'.$subtemplate.'/template.php';
else
  // v inom pripade spusate hlavny template
  include 'template_default.php';
?>