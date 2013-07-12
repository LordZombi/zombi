<?
// Sluzi na vytvorenie SELECT tagu vo FORMe z pola. ============================
// $rows - pole d·t pre select
// $selected - ktory ma bys oznaceny ako selected
function select_from_array($rows,$selected) {
  foreach($rows as $key => $value){
    if(strlen($value)>0){
      if ($key==$selected) echo'<option value="'.$key.'" selected="selected">'.$value."</option>\n";
      else echo'<option value="'.$key.'">'.$value."</option>\n";
    }
  }
}

// Funkcia ktora vrati velkost suboru v ludsky privetivej hodnote KB / MB ======
function filesize2human ($filename) {
  $filesize_tmp1=(FileSize("$filename"))/1024;
  if ($filesize_tmp1<1024): $filesize=Round($filesize_tmp1,2).' KB';
  else: $filesize=Round(($filesize_tmp1/1024),2).' MB';
  endif;
  return str_replace(".",",",$filesize);
}

// funkcia na zistenie spravnosti formatu adresy ===============================
function checkemail($email) {
  if (preg_match("/^[a-zA-Z0-9_\+-]+(\.[a-zA-z0-9_\+-]+)*@[a-zA-Z0-9-]+ (\.[a-zA-Z0-9-]+)*\.[a-zA-Z]{2,4}$/x",$email)) return true;
  else return false;
}
// funkcia najde hodnotu v poli podla zadanych intervalov ======================
// ak najde hodnotu vrati hodnotu v inom pripade vrati false
function najdi_hodnotu($pole,$separator,$hodnota)
{
  $_bolanajdenacena = false;
  $_najdena_cena = 0;
  // prehladame pole
  foreach ($pole as $key=>$value) 
  {
    // ak sme v poli nasli nejake hodnoty tak hladame interval
    unset($od,$do);
  	List($od,$do)=explode($separator,$key);
  	if ( isset($od) and isset($do) and $od<=$hodnota and $hodnota<=$do ) // ak sa jedna o interval, napr: 5-13
    {
      // ak nasa hladana hodnota je v intervale, tak sme ju nasli
      $_bolanajdenacena = true;
      $_najdena_cena = $value;
    }
    elseif ( isset($od) and !isset($do) and $od==$hodnota ) // ak sa jedna iba o jednu hodnotu, napr: 1984
    {
      // ak nasa hladana hodnota je v intervale, tak sme ju nasli
      $_bolanajdenacena = true;
      $_najdena_cena = $value;
    }
  }
  if ( $_bolanajdenacena == true ) return $_najdena_cena;
  else return false;
}
// funkcia skontroluje ci zadana hodnota patri do intervalu ====================
// ak zadana hodnota je z daneho intervalu tak vrati true v inom pripade false
function skontroluj_hodnotu($interval,$separator,$hodnota)
{
  	List($od,$do)=explode($separator,$interval);
    if ( isset($od) and isset($do) and isset($hodnota) )
    {
      if ( $od<=$hodnota and $hodnota<=$do ) return true;
      else return false;
    }
    else return false;
}
// kontrola rodnÈho ËÌsla ======================================================
// vstup: rodnÈ ËÌslo
// v˝stup FALSE alebo RODN… »ÕSLO vo form·te ABCDEF/GHIJ alebo ABCDEF/GHI
function rc_kontrola($rodnecislo)
{
  $rodnecislo = preg_replace("#[^0-9]#i","", $rodnecislo); 
  if ( strlen($rodnecislo)==10 )
  {
    $rok = substr($rodnecislo, 0, 2);
    $mesiac = substr($rodnecislo, 2, 2);
    $den = substr($rodnecislo, 4, 2);
    $zbytok = substr($rodnecislo, 6, strlen($rodnecislo)-6 );
    $suma = $rok + $mesiac + $den + $zbytok;
    $zvysok = $suma % 11;
    $rodnecislo = substr($rodnecislo, 0, 6).'/'.substr($rodnecislo, 6, strlen($rodnecislo)-6 );
    if ( $zvysok==0 ) return $rodnecislo;
    else return false;
  }
  elseif ( strlen($rodnecislo)==9 )
  {
    $rodnecislo = substr($rodnecislo, 0, 6).'/'.substr($rodnecislo, 6, strlen($rodnecislo)-6 );
    return $rodnecislo;
  }
  else
    return false;
}
// v˝poËet d·tumu narodenia z rodnÈho ËÌsla ====================================
// vstup: rodnÈ ËÌslo
// v˝stup FALSE alebo POLE den, mesiac, rok, pohlavie
function rc_datum($rodnecislo)
{
  if ( rc_kontrola($rodnecislo) )
  { // ak je rË spr·vne poËÌtame d·tum narodenia
    $rok = ( substr($rodnecislo,0,2) < date("Y")-1999 ? '20':'19' ).substr($rodnecislo,0,2); // rok dodame cely
    $mesiac = substr($rodnecislo,2,2);
    if ( $mesiac > 13 )
    { // zrejme sa jedn· o ûenu
      $pohlavie = 'w'; // prÌznak ûeny
      $mesiac -= 50; // prepoËÌtame mesiac
    }
    else $pohlavie = 'm'; // v inom prÌpade muû
    $den = substr($rodnecislo,4,2);
    $tmp = mktime(12, 0, 0, $mesiac, $den, $rok);
    return Array( 'd'=>Date("d",$tmp),'m'=>Date("m",$tmp),'y'=>Date("Y",$tmp),'s'=>$pohlavie, );
  }
  else
    return false;
}
// poËet mesiacov medzi dvoma datumami =========================================
// od 2.6.2010 do 1.7.2010 = 1 mesiac
// od 2.6.2010 do 2.7.2010 = 2 mesiace
// vstup: od_den, od_mesiac, od_rok, do_den, do_mesiac, do_rok
// v˝stup pocet mesiacov
function pocet_mesiacov($od_d,$od_m,$od_y,$do_d,$do_m,$do_y)
{
  $pocet_mesiacov = 0;
  // porovname datumy
  $_datum_od_unix = mktime(12,0,0,$od_m,$od_d,$od_y);
  $_datum_do_unix = mktime(12,0,0,$do_m,$do_d,$do_y);
  if ( $_datum_od_unix > $_datum_do_unix)
  {
    // v pripade potreby vymenime, aby od bol mensi ako do
    $tmp = $_datum_od_unix;
    $_datum_od_unix = $_datum_do_unix;
    $_datum_do_unix = $tmp;

	list($_datum_od_unix,$_datum_do_unix) = array($_datum_do_unix,$_datum_od_unix);
  }
  $od_d = Date("d", $_datum_od_unix);
  $od_m = Date("m", $_datum_od_unix);
  $od_y = Date("Y", $_datum_od_unix);
  $do_d = Date("d", $_datum_do_unix);
  $do_m = Date("m", $_datum_do_unix);
  $do_y = Date("Y", $_datum_do_unix);
  if ( $od_y == $do_y )
  { // v pripade toho ze datumy su v tom istom roku
    if ( $od_d > $do_d )
    { // ak sa dni neprekr˝vaj˙, tak pocet je roziel mesiacov
      $pocet_mesiacov = $do_m - $od_m; 
    }
    else
    { // ak sa dni prekr˝vaj˙, tak pocet je roziel mesiacov plus 1 ako obdobie ich prekrytia
      $pocet_mesiacov = $do_m - $od_m + 1; 
    }
  }
  else
  { // v pripade ze datumy su z rozneho roku
    $pocet_mesiacov = 12 - $od_m + $do_m; // spocitame pocet mesiacov v danom roku
    if ( $od_d <= $do_d ) $pocet_mesiacov += 1; // ak sa dni prekr˝vaj˙, tak pocet zv˝öime o 1 ako obdobie ich prekrytia
    $pocet_mesiacov += ( $do_y - $od_y - 1 ) * 12; // ak rozdiel rokov je viec ako 1, tak za kazdy rok pripocitame 12 mesiacov
  }
  return $pocet_mesiacov;
}

function pocet_dni($od_d,$od_m,$od_y,$do_d,$do_m,$do_y)
{
  // pocet dni
  $_datum_od_unix = mktime(12,0,0,$od_m,$od_d,$od_y);
  $_datum_do_unix = mktime(12,0,0,$do_m,$do_d,$do_y);

  if ( $_datum_od_unix > $_datum_do_unix)
  {
    // v pripade potreby vymenime, aby od bol mensi ako do
    $tmp = $_datum_od_unix;
    $_datum_od_unix = $_datum_do_unix;
    $_datum_do_unix = $tmp;
  }

  $_pocet_dni = 1 + (($_datum_do_unix-$_datum_od_unix)/86400);
  $_pocet_dni = round($_pocet_dni);  // zaokruhlenie, koli posuvaniu casu o hodinu

  return $_pocet_dni;
}

// vek od datumu narodenia po zvoleny datum ====================================
// narodeny 18.11.1992 po 19.11.2010 je 18 rokov
// narodeny 19.11.1992 po 19.11.2010 je 18 rokov
// narodeny 20.11.1992 po 19.11.2010 je 17 rokov
// narodeny 20.12.1992 po 19.11.2010 je 17 rokov
// vstup: nar_den, nar_mesiac, nar_rok, do_den, do_mesiac, do_rok
// v˝stup: pocet rokov
function vek($nar_d,$nar_m,$nar_y,$do_d,$do_m,$do_y)
{
  return floor(abs(date("Ymd",mktime(0,0,0,$do_m,$do_d,$do_y)) - date("Ymd",mktime(0,0,0,$nar_m,$nar_d,$nar_y))) / 10000);
}

// funkcia na zostavenie jedneho dlheho stingu z pola stringov ================= 
//vstup: je pole $input
// $input = array 
//  (
//    array     
//    (
//      'nazov_polozky' => 'PrÌznak zmluvy',
//      'od' => 1,
//      'do' => 1,
//      'znak_pre_doplnenie' => ' ',
//      'zarovnanie' => 'L',
//      'hodnota' => 'z', // z / n  
//    ),
//  );
// 'od', 'do' - pozicia znakov od do
// 'znak_pre_doplnenie' - urcuje akym znakom maju byt doplnene medzery   
// 'zarovnanie' - zarovanie stringu v poli L - vlavo, R alebo P - v pravo
// 'hodnota' - samotny string    
////////////////////////////////////////////////////////////////////////////////
// vystup: 
// 'dv' - datova veta,
// 'stav' - stav v akom je vyskladana datova veta, ok - vsetko prebehlo v poriadku, err - nastala chyba
// 'poznamka' - poznamka, kde a aka chyba nastala
function vyskladaj_string_z_pozicii($input, $medzera = ' ')
{
  $stav_prepisania = false; // ked sa prepisu data, tak sa nastavi na TRUE
  //$medzera = '-'; // medzera, ktorou sa doplnia
  $stav = 'ok';
  
  foreach ($input as $key => $value)
  {
    $input_do[] = $value['do'];  // vytvorenie pola DO, kvali zisteniu maximanej hodnoty DO
    
    $value['hodnota'] = strval($value['hodnota']); // pretypovanie na string
    
    if (strlen($value['hodnota']) > ($value['do'] - $value['od']+1))
    {
      $stav = 'err';
      $poznamka .= '| "'.$value['nazov_polozky'].'" je priliz dlhy string: "'.$value['hodnota'].'" |';
    } 
    if ($value['zarovnanie'] == 'L')
    {
      $i_string = 0;
      for ($i = $value['od']; $i <= $value['do']; $i++)
      {
        if (isset($value['hodnota'][$i_string]))
        { 
          if (isset($input_string[$i])) 
          {
            $stav = 'err';
            $stav_prepisania = true;
          } 
          $input_string[$i] = $value['hodnota'][$i_string];
        }
        else
        {
          if (isset($input_string[$i])) 
          {
            $stav = 'err';
            $stav_prepisania = true;
          }
          $input_string[$i] = $value['znak_pre_doplnenie'];      
        }
        $i_string++;
      }
    }
    elseif ($value['zarovnanie'] == 'P' || $value['zarovnanie'] == 'R')
    {
      $i_string = strlen($value['hodnota'])-1;
      //echo 'dlzka stringu: '.strlen($value['hodnota']).'<br>'; 
      for ($i = $value['do']; $i >= $value['od']; $i--)
      {
        //echo 'string: '.$value['hodnota'][$i_string].'<br>';
        if (isset($value['hodnota'][$i_string]))
        { 
          if (isset($input_string[$i]))
          {
            $stav = 'err';
            $stav_prepisania = true;
          }
          $input_string[$i] = $value['hodnota'][$i_string];
        }
        else
        {
          if (isset($input_string[$i])) 
          {
            $stav = 'err';
            $stav_prepisania = true;
          }
          $input_string[$i] = $value['znak_pre_doplnenie'];      
        }
        $i_string--;
      }
    }    
    else
    {
      $stav = 'err';
      $poznamka .= '| "'.$value['nazov_polozky'].'" je nezn·me zarovnanie: "'.$value['zarovnanie'].'" |';
    }
  }
  
  if ($stav_prepisania) $poznamka .= '| Hodnoty sa nam prepisuju! |';  
  
  //ksort($input_string);
  $max_do = max($input_do);
  $datova_veta = ''; 
  for ($i = 1; $i <= $max_do; $i++)
  {
    if ( strlen($input_string[$i]) == 0 )    $input_string[$i] = $medzera;
    $datova_veta .= $input_string[$i];
  } 
  
  return Array( 'dv'=>$datova_veta,'stav'=>$stav,'poznamka'=>$poznamka );
}

// funkcia na zostavenie jedneho stringu s oddelovacim znakom z pola ===========
// Vstupy:
// $input - pole stringov,
// $oddelovaci_znak - oddelovaci znak, ktory sa ma vlozit medzi jednotlive stringy
// $oddelovaci_znak_nahradny - nahradny oddelovaci znak, ak by sa povodny oddelovaci znak zhodoval so znakom v niektorom stringu
// $od - zaciatocna pozicia pola
// $do - dlzka pola, koncova pozicia pola
////////////////////////////////////////////////////////////////////////////////
// vystup: 
// 'dv' - datova veta,
// 'stav' - stav v akom je vyskladana datova veta, ok - vsetko prebehlo v poriadku, err - nastala chyba
// 'poznamka' - poznamka, kde a aka chyba nastala 
function vyskladaj_string_z_pola($input, $oddelovaci_znak, $oddelovaci_znak_nahradny, $od, $do)
{
  $stav = 'ok';
  $oddelovac = $oddelovaci_znak;
  if ($oddelovaci_znak == $oddelovaci_znak_nahradny) 
  {
    $poznamka .= '| Oddelovaci znak "'.$oddelovaci_znak.'" je zhodny s nahradnym znakom! |';
    $stav = 'err';
    return Array( 'dv'=>' ','stav'=>$stav,'poznamka'=>$poznamka );
  }
  // osetrenie, ak je od vecsie ako do, aby isiel od najmensieho po najvecsi
  if ($od > $do)
  {
    $temp = $od;
    $od = $do;
    $do = $temp;
  }
  
  for ($i = $od; $i <= $do; $i++)
  {
    if (isset($input[$i])) 
    {
      $input_pole[$i] = $input[$i];
    } 
    else
    {
      $input_pole[$i] = ' ';
    } 
    $input_pole[$i] = str_replace($oddelovaci_znak, $oddelovaci_znak_nahradny, $input_pole[$i]);  
  }
  
  $datova_veta = implode($oddelovac, $input_pole);
    
  return Array( 'dv'=>$datova_veta,'stav'=>$stav,'poznamka'=>$poznamka );
}
// Sluzi na odoslanie inform·cie o chyb·ch. ====================================
function zachytenie_chyby($popischyby,$dberror,$dalsieinfo)
{
  // v˝pis zobrazen˝ na obrazovke
  $vypis .= 'Nastala chyba s popisom:<br />';
  $vypis .= '<strong>'.$popischyby.'</strong><br />';
  $vypis .= 'Naöi pracovnÌci boli o chybe informovanÌ a bud˙ ju neodkladne rieöiù.';
  // ak nebudu ziadne errory, tak odoslanie formulara
  $subject='Hl·senie ch˝b.';
  $from_name='Netfinancie.sk';
  $from_mail='postmaster@netfinancie.sk';
  $to_mail='it@netfinancie.sk';
  $headers="From: $from_name <$from_mail>\n";
  $headers.="Content-Type: text/html; charset=windows-1250\n";
  $headers.="X-Priority: 1\n";
  // ======================== mail BODY BEG
  $message=''; // zmazanie predchadzajuceho textu...
  $message.='<font face="verdana" size="3" color="#000000"><b>Netfinancie.sk / NASTALA CHYBA!</b></font><br />'."\n";
  $message.='<hr size="1" color="#000000">'."\n";
  $message.='<font face="verdana" size="3" color="#000088">Inform·cia o chybe zobrazen· pouûÌvateæovi</font><br />'."\n";
  $message.='<font face="verdana" size="2" color="#000000">'."\n";
  $message.=$vypis;
  $message.='</font><br /><br />'."\n";
  $message.='<font face="verdana" size="3" color="#000088">œalöie inform·cie o chybe</font><br />'."\n";
  $message.='<font face="verdana" size="2" color="#000000">'."\n";
  $message.='DoplÚuj˙ce info v kÛde: '.$dalsieinfo.'<br />';
  $message.='Host: '.getenv("HTTP_HOST").'<br />';
  $message.='Skript: '.$_SERVER['REQUEST_URI'].'<br />';
  $message.='IP: '.$_SERVER['REMOTE_ADDR'].'<br />';
  $message.='DBerror: '.$dberror.'<br />';
  $message.='</font><br />'."\n";
  $message.='<font face="verdana" size="3" color="#000088">V˝pis session</font><br />'."\n";
  $message.='<font face="verdana" size="2" color="#000000">'."\n";
  foreach ( $_SESSION as $key=>$value)
  {
    if ( is_array($value) )
    {
      $message.='---------- BEGIN ARRAY: '.$key.' ----------<br />';
      $message.='session['.$key.']='.NL2BR(htmlspecialchars(var_export($value,true))).'<br />';
      $message.='---------- END ARRAY: '.$key.' ----------<br />';
    }
    else
      $message.='session['.$key.']='.$value.'<br />';
  }
  $message.='</font>'."\n";
  $message.='<hr size="1" color="#000000">'."\n";
  $message.='<font face="verdana" size="1" color="#000000">'."\n";
  $message.='Mail odoslan˝: '.Date("d.m.Y H:i:s").'<br>'."\n";
  $message.='</font>'."\n";
  // ======================== mail BODY END
  @$mailing=Mail($to_mail, $subject, $message, $headers);
  return $vypis;
}
// Text rozdeli na riadky s maximalnym poctom znakov podla slov ================
// vstup: text (iba text nie html tagy a znacky typu &euro;)
// vstup: max pocet znakov maximalne v jednom riadku
// vystup: pole a kyzdy jeho prvok je jeden riadok textu kde max pocet znakov je $MAX
function rozdelnariadky($text,$max)
{
  $slova = explode(' ', $text);
  if ( count($slova)>0 )
  {
    $cislovety = 1;
    foreach ( $slova as $slovo)
    {
      if ( strlen( $veta[$cislovety] ) + strlen( $slovo ) >= $max ) $cislovety++;
    	$veta[$cislovety] .= $slovo.' ';
    }
    foreach ( $veta as $value)
    {
    	$output[] = trim($value);
    }
    if ( count($output)>0 ) return $output;
    else return false;
  }
  else return false;
}
// sklonovanie slov podla poctu ================================================
// vstup1: cislo - mnoûstvo
// vstup2: slovo pre poËet 1 (1 deÚ)
// vstup3: slovo pre poËet 2-4 (2 dni)
// vstup4: slovo pre poËet 5 a viac (5 dnÌ)
// vystup: slovo podla ËÌsla
function sklonovanie($int,$slovo1,$slovo24,$slovo5) {
  $int=floor($int);
      if($int==1) return $slovo1;
  elseif($int>=2 && $int<=4) return $slovo24;
  elseif($int>=5 || $int==0) return $slovo5;
}
// Ëasov˝ popis ================================================================
// vstup: Ëas v sekund·ch
// vystup: Ëas v human forme
function cas_rozdiel($cas_rozdielu_s) {
     if ($cas_rozdielu_s<0): $vystup_text='!!!';
 elseif ($cas_rozdielu_s==0): $vystup_text='0';
 elseif ($cas_rozdielu_s<60): $vystup_text=$cas_rozdielu_s.' '.sklonovanie($cas_rozdielu_s,'sekunda','sekundy','sek˙nd');
 elseif ($cas_rozdielu_s<3600): $vystup_text=floor($cas_rozdielu_s/60).' '.sklonovanie(floor($cas_rozdielu_s/60),'min˙ta','min˙ty','min˙t').' a '.($cas_rozdielu_s%60).' '.sklonovanie($cas_rozdielu_s%60,'sekunda','sekundy','sek˙nd');
 elseif ($cas_rozdielu_s<86400): $vystup_text=floor($cas_rozdielu_s/(60*60)).' '.sklonovanie(floor($cas_rozdielu_s/(60*60)),'hodina','hodiny','hodÌn').' a '.($cas_rozdielu_s/60%60).' '.sklonovanie($cas_rozdielu_s/60%60,'min˙ta','min˙ty','min˙t');
 elseif ($cas_rozdielu_s<3153600): $vystup_text=floor($cas_rozdielu_s/60/60/24).' '.sklonovanie(floor($cas_rozdielu_s/60/60/24),'deÚ','dni','dnÌ').' a '.(($cas_rozdielu_s/60/60)%24).' '.sklonovanie(($cas_rozdielu_s/60/60)%24,'hodina','hodiny','hodÌn');
 else: $vystup_text=floor($cas_rozdielu_s/60/60/24).' '.sklonovanie(floor($cas_rozdielu_s/60/60/24),'deÚ','dni','dnÌ');
 endif;
return $vystup_text;
};
// ulozenie suboru =============================================================
// aky/kde subor sa ma ulozit
// obsah ulozeneho suboru
function save_to_file($fileaddress,$filecontent)
{
  $file=fopen($fileaddress,"a");
  fputs($file,$filecontent);
  fclose($file);
}
// generovanie hash stringu ====================================================
// vstupom je cislo - dÂûka vygenerovanÈho stringu
// vystupom je string pozostavajuci z nahodnych znakov abecedy funkcie
function vygeneruj_hash($dlzka)
{
  if ( !is_int($dlzka) or $dlzka<1 ) $dlzka=5; // ak sme zadali zlu dlzku tak dlzka bude 5 defaultne
  $znaky=Array('1','2','3','4','5','6','7','8','9','A','B','C','E','F','H','J','K','L','M','N','P','R','S','T','X'); // abeceda prijemnych znakov
  $znak=''; // pre istotu vynulujeme znak
  for ($i=0; $i<$dlzka; $i++)
  {
    $znak .= $znaky[rand(0,count($znaky)-1)]; // henerujeme znak po znaku
  }
  return $znak; // returnujeme string
}
// uprava telefonneho cisla ====================================================
// vstupom je string
// vystupom je tel cislo vo formate <stat><operator><cislo> a podobne...
function telnr($tel)
{
  // nechame si len ËÌsla (plus a medzera prec)
  $tel = preg_replace("#[^0-9]#i","", $tel);
  // odrezeme nuly na zaciatku este pred predvolbou statu
  if ( substr($tel,0,3)=='011' ) $tel=substr($tel,3,strlen($tel)); // odrezeme na zaciatku 011
  if ( substr($tel,0,2)=='00' ) $tel=substr($tel,2,strlen($tel)); // odrezeme na zaciatku 00
  if ( substr($tel,0,1)=='0' ) $tel=substr($tel,1,strlen($tel)); // odrezeme na zaciatku 00
  // kontrola dlzky cisla
  if ( strlen($tel)<=8 )
  { 
    // ak je menej znakov ako 8 tak zrejme nebola zadana predvolba
    // nebudeme nic robit
  }
  elseif ( strlen($tel)<=10 )
  { // ak bolo zadanych menej ako 10 znakov
    if ( substr($tel,0,1)=='0' ) $tel=substr($tel,1,strlen($tel)); // odrezeme na zaciatku 0 pred predvolbou
    $tel = '421'.$tel; // budeme predpokladat, ze ked nezadal predvolbu, ûe ide o slovenske ËÌslo
  }
  // ak dal niekto nulu za predvolbu statu a pred predvolbu operatora, tak ju odrezeme
  if ( substr($tel,3,1)=='0' ) $tel=substr($tel,0,3).substr($tel,4,strlen($tel));
  // vr·time cislo
  return $tel;
}

// sformatovanie telefonneho cisla =============================================
// vstupom je tel cislo vo formate <stat><operator><cislo> (v˝stup z funkcie "telnr()")
// vystupom je tel cislo sformatovane tak aby sa dalo lepsie citat
function telnr_format($tel)
{
  $tel = preg_replace("/[^0-9]/", "", $tel);
  $tel = telnr($tel); // pre istotu este raz pouzijeme   
  if(strlen($tel) == 12 and ( substr($tel,3,1)=='9' or substr($tel,3,2)=='69' ) ) return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{3})/", "$1 $2 $3 $4", $tel);
  elseif(strlen($tel) == 12 ) return preg_replace("/([0-9]{3})([0-9]{2})([0-9]{3})([0-9]{4})/", "$1 $2 $3 $4", $tel);
  else return $tel;
}

// zistenie ci tel cislo je mobil ==============================================
// vstupom je tel cislo vo formate <stat><operator><cislo> (v˝stup z funkcie "telnr()")
// vystupom je true ak sa jedna o mobilny telefon a v inom pripade false
function telnr_mobil($tel)
{
  $tel = telnr($tel); // pre istotu este raz pouzijeme
  $_sk_operator = array('901','902','903','904','905','907','908','910','911','913','915','918','919','940','944','948','949','959','917');
  if(strlen($tel) == 12 and in_array(substr($tel,3,3),$_sk_operator) ) return true;   
  return false;
}

// uprava E»V ==================================================================
// vstupom je string
// vystupom je E»V vo formate <dve pismena> + < 5 cisel alebo pismen >
// ak je ecv v nespravnom form·te, tak vysledkom je FALSE 
function ecv_kontrola($ecv)
{
  // nechame si len pÌsmen· a ËÌsla (ostatne prec)
  $ecv = preg_replace("#[^a-zA-Z0-9]#i","", $ecv);
  $ecv = strtoupper($ecv);
  if ( preg_match("/^[A-Z]{2}[A-Z0-9]{5}$/",$ecv) ) return $ecv;
  else return false;
}
// doplnenie nul do pozadovanej dlzky cisla cisla ==============================
// vstupom je $value - kladn· ËÌseln· hodnota, $num - kladn· ËÌseln· hodnota, ktor· reprezentuje poËet cifier vo v˝stupe
// vystupom je ËÌslo $value, kde do dÂûky $num s˙ doplnenÈ nuly
function num_format($value,$num)
{
  if ( strlen($value) < $num and is_numeric($value) and $value > 0 and is_numeric($num) and $num > 0 )
  {
    $dopln = $num - strlen($value);
    for ($i=1; $i<=$dopln; $i++)
    {
    	$t_value .= '0'; 
    }
    return $t_value.$value;
  }
  else return $value;
}
// vypis hlasok ERROR alebo OK =================================================
// vstupom je $pole - pole stringov a $typ err/ok ktore znaci ci ide o chybu alebo ok
// vystupom je vygenerovana sprava
function vypis_hlasok($pole,$typ)
{
  if (count($pole)>0)
  {
    // vypÌse errorove hlasenia
    echo'<div class="'.$typ.'_top">'."\n";
    echo'  <div class="'.$typ.'_bottom">'."\n";
    echo'    <div class="'.$typ.'_middle">'."\n";
    foreach ($pole as $key=>$value)
    {
      echo '<p>'.$value.'</p>';	
    }
    echo'     </div>'."\n";
    echo'  </div>'."\n";
    echo'</div>'."\n";
  }
}
// prevod nadpisu (string) do peknej url adresy ================================
// vstupom je string
// vystupom je url adresa zhotovena podla stringu
function friendly_url($string)
{
  // prehodime vsetko na malÈ pÌsmen·
  $string = strtolower($string);
  // zmenime pismena s diakritikou na pismena bez diakritiky
  $string = str_replace(array('æ','Â','ö','Ë','ù','û','˝','·','Ì','È','Ú','˙','‰','Ù','Û'),array('l','l','s','c','t','z','y','a','i','e','n','u','a','o','o'),$string);
  // nechame si len ËÌsla (plus a medzera prec)
  $string = preg_replace("/[^a-z0-9]+/i","-", $string);
  // odstranime pomlcky zo zaciatku a z konca
  $string = trim($string, "-");
  return $string;
}
// =============================================================================
?>