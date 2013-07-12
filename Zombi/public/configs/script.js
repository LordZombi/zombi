// JavaScript Document *********************************************************

// nastavi dalsi krok v kalkulacke a submitne formular =========================
function calc_go_to_step(step) {
  try
  { // ak na starne je button s id = "button_next_preloader" tak ho schov·me
    var o = document.getElementById('button_next_preloader');
    o.innerHTML='»akajte prosÌm...'
  }
  catch(err) {}
  document.getElementById('go_to_step').value=step;
  try
  { // pokusime sa submitnut formular podla mena
    document.calcform.submit();
  }
  catch(err) {}
  try
  { // pokusime sa submitnut formular podla id
    document.getElementById('calcform').submit();
  }
  catch(err) {}
}

// nastavi dalsi krok v kalkulacke a submitne formular =========================
function calc_go_to_step_and_select(step,select) {
  document.getElementById('go_to_step_select').value=select;
  calc_go_to_step(step);
}

// schova kontajner ============================================================
function hideit(what) {
  try
  {
  	var o = document.getElementById(what);
  	o.style.display = 'none';
  }
  catch(err) {}
}

// zobrazi kontajner ===========================================================
function showit(what) {
  try
  {
  	var o = document.getElementById(what);
  	o.style.display = '';
  }
  catch(err) {}
}

// AJAX funkcie ================================================================
// zachyti objekt
function getXmlHttpRequestObject() {
	var req = false;
    // branch for native XMLHttpRequest object
    if(window.XMLHttpRequest) {
    	try {
			req = new XMLHttpRequest();
        } catch(e) {
			req = false;
        }
    // branch for IE/Windows ActiveX version
    } else if(window.ActiveXObject) {
       	try {
        	req = new ActiveXObject("Msxml2.XMLHTTP");
      	} catch(e) {
        	try {
          		req = new ActiveXObject("Microsoft.XMLHTTP");
        	} catch(e) {
          		req = false;
        	}
		}
    }
    return req;
}
// tato funkcia sa vola vzdy ked chceme nieco=GetPage naËÌtaù niekde=SetPlace
// GetPage je v‰Ëöinou nejak· php alebo html str·nka bez hlaviËiek len s obsahom
// SetPlace je vacsinou DIV kde id parameter je hodnota = SetPlace
function getContent(GetPage,SetPlace) {
  var receiveReq = getXmlHttpRequestObject();
	if(receiveReq.readyState==4 || receiveReq.readyState==0) {
		
		if(window.XMLHttpRequest) {
			receiveReq.open("GET",GetPage, true);
			receiveReq.onreadystatechange = function() {
				var SetPlaceVariable = document.getElementById(SetPlace);
				if(receiveReq.readyState==4) {
					SetPlaceVariable.innerHTML = receiveReq.responseText;
				}
			};
			receiveReq.send(null);
		}
		else if (window.ActiveXObject) {		
			receiveReq.open("GET",GetPage, true);
			receiveReq.onreadystatechange = function() {
				var SetPlaceVariable = document.getElementById(SetPlace);
				if(receiveReq.readyState==4) {
					SetPlaceVariable.innerHTML = receiveReq.responseText;
				}
			};
			receiveReq.send();
		}
	}
}

// zavola vysledok formulara CALL ME NOW =======================================
function sendrequest_cmn(baseurl,page,cont,tel,when)
{
  hideit(cont+'-button');
  getContent( baseurl + 'modules/callmenow.php?c=' + cont + '&p=' + page + '&cmn_tnr=' + tel + '&cmn_when=' + when, cont);
}
// pomocna funkcia na zistenie pozicie prvku ===================================
function getElementPosition(elemID) {
    var offsetTrail = document.getElementById(elemID);
    var offsetLeft = 0;
    var offsetTop = 0;
    while (offsetTrail) {
        offsetLeft += offsetTrail.offsetLeft;
        offsetTop += offsetTrail.offsetTop;
        offsetTrail = offsetTrail.offsetParent;
    }
    if (navigator.userAgent.indexOf("Mac") != -1 && typeof document.body.leftMargin != "undefined") {
        offsetLeft += document.body.leftMargin;
        offsetTop += document.body.topMargin;
    }
    var pos = null;
    return pos = [offsetLeft,offsetTop]
}
// help box ====================================================================
function HelpBox(prv,baseurl,uri,ofsetleft,ofsettop)
{
  var pos = getElementPosition(prv.id); // zistime kde sa nachadza prvok na ktory sme klikli  
  var leftt = (pos[0]-200); // ak pozicia okna vlavo vych·dza mimo obrazovku nastavime natvrdo
  if (leftt <= 0) leftt=5;
  var topt = (pos[1]-140); // ak pozicia okna zhora vych·dza mimo obrazovku nastavime natvrdo
  if (topt <= 0) topt=5;
  document.getElementById('helpid').style.left=(leftt+ofsetleft)+'px'; // nastavime poziciu okna
  document.getElementById('helpid').style.top=(topt+ofsettop)+'px'; // nastavime poziciu okna
  document.getElementById('helpid_content').innerHTML='»akajte prosÌm ...'; // zobrazi sa v okne pokial ajax nenaËÌta obsah helpu
  showit('helpid'); // zobrazi help
  getContent(baseurl+'modules/help.php?help='+uri+'&left='+pos[0]+'&top='+pos[1],'helpid_content'); // nacita obsah do helpu
}
// refresh data ================================================================
// funkcia refreshuje php stranku aby sa udrzala session aj ked klient je neaktÌvny niekoæko min˙t.
function refreshdata(baseurl)
{
  var mTimer;
	clearTimeout(mTimer);
  getContent(baseurl+'modules/refreshdata.php','refreshdata');
	mTimer=setTimeout("refreshdata('"+baseurl+"')", 300000);
}
//