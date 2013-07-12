<?
// ************************************************************************** //
// konfiguracny subor                                                         //
// ************************************************************************** //

// z�kladn� url, kde be�� web (koli rewrite a jednoduchosti prelinkovania) =====

$_PAGE['base_url'] = '/';
// $_PAGE['base_url']='http://www.zombi.sk/';

// nastavenie databazy =========================================================

/*
$_PAGE['config_db_host']='localhost';
$_PAGE['config_db_login']='zombi_sk';
$_PAGE['config_db_pass']='zombiDB';
$_PAGE['config_db_name']='zombi_sk_zombi';
$_PAGE['config_db_prefix']='zm';
*/

$_PAGE['config_db_host']='localhost';
$_PAGE['config_db_login']='root';
$_PAGE['config_db_pass']='';
$_PAGE['config_db_name']='';
$_PAGE['config_db_prefix']='';

// nastavenie zasielania mailov ================================================

$_PAGE['mail_from_name']='zombi.sk'; // odosielatel mailu pre klientov - jeho nazov
$_PAGE['mail_from_mail']='info@zombi.sk'; // odosielatel mailu pre klientov - jeho email

// defaultny template pre web ==================================================

$_PAGE['template_id']='default';

// defaultny jazyk =============================================================

$_PAGE['default_ln']='en';

// defaultne meta tagy =========================================================

$_PAGE['title']='Zombi';
$_PAGE['keywords']='programmer, web designer, web developer, andorid, java, tomas zamba';
$_PAGE['description']='Tomáš Zamba - Freeance Web Designer and Programmer. Personal Portfolio';

// meta tagy pre jednotlive sekcie .............................................

$_PAGES['styles']['title']='Styles | Zombi';
$_PAGES['styles']['keywords']='Styles | Keywords';
$_PAGES['styles']['description']='Styles | Description';

// =============================================================================
?>