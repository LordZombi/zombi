<?php
foreach ($_SESSION as $key => $value) {
	unset($_SESSION[$key]);
}
?>