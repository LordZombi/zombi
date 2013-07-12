<?
// Sluzi na kontrolu prihlasenych pouzivatelov a na prihlasenie. ===============

$_login_privilegia = Array (
                'user'=>'Používate¾',
                'manager'=>'Správca',
                'admin'=>'Administrátor',
              );
$_login_stav = Array (
                'ok'=>'Povolený',
                'block'=>'Blokovaný',
              );

$_LOGIN['logged']=false; // neprihlásený používate¾

// ak boli zadane prihlasovacie parametre, tak ich overime ---------------------
if ( isset($_POST['login_form_name']) and isset($_POST['login_form_password']) )
{
  if ( strlen($_POST['login_form_name'])>=3 and strlen($_POST['login_form_password'])>=3 )
  {
    // v DB sa overi ci existuje taky pouzivatel
    $mysqli = new mysqli($_PAGE['config_db_host'],$_PAGE['config_db_login'],$_PAGE['config_db_pass'],$_PAGE['config_db_name']);
    $mysqli->set_charset("cp1250");
    $result = $mysqli->query('SELECT * FROM '.$_PAGE['config_db_prefix'].'_login WHERE username = "'.$_POST['login_form_name'].'" AND password = md5("'.$_POST['login_form_password'].'");');
    if ($result->num_rows == 1)
    {
      // ak v db existuje takyto iba jeden pouzivatel pokracuje sa s overenim blokovania
      if ($result)
      {
        $row = $result->fetch_object();
        // ak pouzivatel nema konto blokovane tak sa postupuje dalej
        if ( $row->state == 'ok' )
        {
          // vygeneruje sa novy kluc prihlasenia        
          $_new_idsession = md5($_POST['login_form_name'].Date("U"));
          // kluc sa ulozi do db
          $result_in = $mysqli->query('UPDATE '.$_PAGE['config_db_prefix'].'_login SET idsession="'.$_new_idsession.'", datelastlogin="'.Date("Y-m-d H:i:s").'" WHERE username = "'.$_POST['login_form_name'].'" AND password = md5("'.$_POST['login_form_password'].'");');
          // kluc sa ulozi aj do session
          $_SESSION['logged_idsession'] = $_new_idsession;
          $_SESSION['logged_username'] = $row->username;
        }
        else $_LOGIN['error'][]='Konto "'.$row->fullname.'" je blokované.';
      }
      else $_LOGIN['error'][]='Nastala chyba pri overení prihlásenia.';
    } else $_LOGIN['error'][]='Prihlasovacie údaje nie sú správne.';
    $mysqli->close();
  }
  else $_LOGIN['error'][]='Prihlasovacie meno a heslo musí ma minimálne 3 znaky.';
}
// ak sa chceme odhlási -------------------------------------------------------
if ( $_GET['log']=='out' )
{
  unset($_SESSION['logged_idsession'],$_SESSION['logged_username']);
}
// ak sa v session nachádzaju prihlasovacie parametre, -------------------------
// overime v db ci su este platne
if ( isset($_SESSION['logged_idsession']) and isset($_SESSION['logged_username']) and strlen($_SESSION['logged_idsession'])>=3 and strlen($_SESSION['logged_username'])>=3 )
{
    $mysqli = new mysqli($_PAGE['config_db_host'],$_PAGE['config_db_login'],$_PAGE['config_db_pass'],$_PAGE['config_db_name']);
    $mysqli->set_charset("cp1250");
    $result2 = $mysqli->query('SELECT * FROM '.$_PAGE['config_db_prefix'].'_login WHERE username = "'.$_SESSION['logged_username'].'" AND idsession = "'.$_SESSION['logged_idsession'].'";');
    if ($result2->num_rows == 1)
    {
      // ak v db existuje takyto iba jeden pouzivatel pokracuje sa s overenim blokovania
      if ($result2)
      {
        $row2 = $result2->fetch_object();
        // ak pouzivatel nema konto blokovane tak sa postupuje dalej
        if ( $row2->state == 'ok' )
        {
          // ak mame aj požiadavku na zmenu mailu, tak ho zmeníme hneï tu aby sa to prejavilo aj ïalej
          if ( isset($_POST['kerberos_email']) and strlen($_POST['kerberos_email'])>3 )
          { // ak menime mailovu adresu, tak ju rovno posuvame dalej do infa o prihlaseni a ukladame aj do db
            $_LOGIN['email'] = $_POST['kerberos_email'];
            $result_mu = $mysqli->query('UPDATE '.$_PAGE['config_db_prefix'].'_login SET email="'.$_POST['kerberos_email'].'" WHERE username = "'.$_SESSION['logged_username'].'" AND idsession = "'.$_SESSION['logged_idsession'].'";');
            $_LOGIN_tmp['newemail']=true; // sprava o uspesnej zmene mailu.
          }
          else 
          { // ak nemenime mailovu adresu, tak nacitame tu co bola v db
            $_LOGIN['email'] = $row2->email;
          }
          $_LOGIN['logged']=true;
          $_LOGIN['fullname'] = $row2->fullname;
          $_LOGIN['privileges'] = $row2->privileges;
          $_LOGIN['id'] = $row2->id;
          $_LOGIN['mobil'] = $row2->mobil;
        }
      }
    }
    $mysqli->close();  
}
// =============================================================================
?>