<div id="main_wrapper">
	<div id="main">
		<div class="text_left">
			<h2>
				Hello<br /> 
			</h2>
			<p>
			<!-- 
				Moment�lne som �tudentom vysokej �koly Univerzity Komensk�ho
			    v Bratislave na fakulte matematiky, fyziky a informatiky. Odobor 
			    Aplikovan� Informatika. �tudujem a pracujem v Bratislave no som z
			    Popradu :).
			 -->
			 	Some stuff<br />
			 	Sed ac dolor quis est tincidunt luctus. Duis ligula nulla, vehicula ut facilisis a, pretium eu metus. Pellentesque sed justo felis, a lobortis velit. Integer mi dui, congue pellentesque ultrices ut, eleifend a dui. Nullam nec ligula eu dolor mollis vehicula. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin ultrices pellentesque libero id commodo. 
			</p>
			
		<!--
			<h2>
				�o viem a �o V�m m��em pon�knu� ?
			</h2>
			<p>- Kompletn� n�vrh designu webovej str�nky [Photoshop]<br />
			   - Vektorov� spracovanie obr�zkov a loga [Illustrator, Inkscape]<br />
	    	   - Zrealizovanie z�kladn�ch statick�ch str�nok [XHtml, CSS, Javascript]<br />
	    	   - Vyhotovenie dynamick�ch str�nok so spracov�van�m �dajov a pr�cou s datab�zou [PHP, MySql]<br />
	    	   - Naprogramovanie webov�ch aplik�ci�<br />
	           - Redesignovanie, prek�dovanie webstr�nok<br /><br />
				 Pracoval som, pracujem aj chem pracova� v programoch ako :
			</p>
		-->
			<h2>
				Skills
			</h2>
				<ul class="left">
					<li>Adobe Photoshop</li>
					<li>Adobe Illustrator</li>
					<li>(X)HTML</li>
					<li>XML</li>
					<li>CSS</li>
					<li>JavaScript</li>
					<li>AJAX</li>
					<li>WordPress</li>
				</ul>
				<ul class="left">
					<li>PHP</li>
					<li>Zend Framework</li>
					<li>MySQL</li>
					<li>Delphi/Lazarus</li>
					<li>C++</li>
					<li>C#</li>
					<li>Java/Android</li>
				</ul>
		</div>
		
		<!-- 
		<div class="text_right">
			<h2>
				Kontakt
			</h2>
			<table class="contact">
				<tr><td>Email: </td><td><a href="mailto:durmstrang.d@gmail.com">durmstrang.d@gmail.com</a></td></tr>
				<tr><td>Web: </td><td><a href="http://zombi.sk">www.zombi.sk</a></td></tr>
				<tr><td>Icq: </td><td>286 832 970</td></tr>	
				<tr><td>Facebook: </td><td><a href="http://www.facebook.com/zombi.sk">zombi.sk</a></td></tr>
				<tr><td>Telef�n: </td><td>0910 404 004</td></tr>
			</table>
		</div>
		-->
		
		<div class="text_right">
			<h2>
				If whatever Mail me ...
			</h2>
			<?php 
				$send = "";
				if (isset($_POST["mailMe"])) {
					if (trim($_POST["predmet"]) != "" && trim($_POST["email"]) != "" && trim($_POST["sprava"] != "")) {
						mailMe($_POST["predmet"], $_POST["email"], $_POST["sprava"]);
						$send = "�akujem za Va�u spr�vu. <br />Budem sa sna�i� odpoveda� �o najr�chlej�ie.";
					} else {
						$send = "Najprv pros�m vypl�te v�etky polia.";
					}
				}
				echo "<span class='error'>".$send."</span>";
			?>
			<form action="<?php echo $_SERVER["PHP_SELF"]."#form"; ?>" method="post" id="form">	
				<table>
					<tr>
						<td><label for="email">Your mail: </label></td>
						<td><input type="text" name="email" id="email" class="input" /></td>
					</tr>
					<tr>
						<td><label for="predmet">Subject: </label></td>
						<td><input type="text" name="predmet" id="predmet" class="input" /></td>
					</tr>
					<tr>
						<td><label for="sprava">Message: </label></td>
						<td><textarea name="sprava" class="input" id="sprava" rows="10" cols="38"></textarea></td>
					</tr>
					<tr>
						<td><input name="mailMe" type="submit" value="Send" class="button" /></td>
					</tr>
				</table>
			</form>
		</div>
		
		<div class="clr"></div>
	</div>
</div>