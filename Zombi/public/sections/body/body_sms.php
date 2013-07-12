<script type="text/javascript">
	function countChars(area, counter, max) {
	  var count = max - area.value.length;
	  document.getElementById(counter).innerHTML = "<span>" + count + "/160</span>";
	}
</script>
<div id="sms">
	<?php
		$limit = 1;
		$heslo = "zombiJePan";
		if (strlen($_POST['sms_message']) > 0 && $_POST['sms_pass'] == $heslo)// && dayLimit() < $limit)
		{
			$mysqli = new mysqli($_PAGE['config_db_host'],$_PAGE['config_db_login'],$_PAGE['config_db_pass'],$_PAGE['config_db_name']);
		    $result = $mysqli->query('SELECT * FROM '.$_PAGE['config_db_prefix'].'_sms WHERE date = "'.date('Y-m-d').'"');
		    if ($result)
		   		if ($result->num_rows >= $limit)
		    	{
		    		$sms = $result->fetch_object();
		    		echo "Dnes si u písal: " . $sms->time . "<br />";
		    		echo "Napíš mi mail: <a href='mailto:durmstrang.d@gmail.com'>zombi</a>";
		    	}
		    	else
		    	{
					$username = 'Zombi';
					$password = md5('Smiling07');
					$from = 'Zombi';
					$to = "421910404004";
					$message= urlencode($_POST['sms_message']);
					$status = file_get_contents("http://www.smartsms.sk/api/send.do?username=$username&password=$password&to=$to&message=$message&from=$from&details=1",FALSE,NULL,0,100);
					$result = $mysqli->query('INSERT INTO '.$_PAGE['config_db_prefix'].'_sms (date, text) VALUES (\''.date('Y-m-d').'\', \''.$message.'\')');
		    		if ($result) echo "Sms odoslaná: <br />" . $status;
		    		else echo "Sms odoslaná: <br />" . $status . ", ale nieèo je s DB napíš mi mail: <a href='mailto:durmstrang.d@gmail.com'>zombi</a>";
		    	}
		    else
		    {
		    	echo "Nieèo je s DB napíš mi mail: <a href='mailto:durmstrang.d@gmail.com'>zombi</a>";
		    }
		}
		else
		{
	?>
	<form name="sms" method="post" action="">
	<table>
	<tr>
		<td colspan="2"><div>Jolekov dennı limit: <?php echo $limit; ?> sms</div></td>
	</tr>
	<tr>
		<td colspan="2"><textarea name="sms_message" maxlength="160" onFocus="countChars(this,'char_count',160);" onKeyDown="countChars(this,'char_count',160);" onKeyUp="countChars(this,'char_count',160);"></textarea></td>
	</tr>
	<tr>
		<td align="left"><input name="sms_pass" type="password" value=""/><?php if ($_POST["send"] == "1123581321" && $_POST['sms_pass'] != $heslo) echo " <span style='color: #FF1E00'>&larr;&nbsp; heslo</span>"?></td>
		<td align="right"><div id="char_count">160/160</div></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="hidden" name="send" value="1123581321"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input name="mailMe" type="submit" value="Pošli" class="btn btn-primary" /></td>
	</tr>
	</table>
	</form>
	<br />
	<hr />
	<br />
	Stlaèením <strong>Pošli</strong> súhlasím s podmienkami a pravidlami pouívania.
	<ul>
		<li>Zaèa si koneène šetri na kredit.</li>
		<li>Nepísa SMS typu "povedz xxx nech mi zavola".</li>
		<li>Vyvarova sa vulgarizmom kede správu si èíta vıznamná osoba.</li>
		<li>Ïalšie pribudnú pod¾a správania.</li>
	</ul>
	<?php
		}
	?>
</div>