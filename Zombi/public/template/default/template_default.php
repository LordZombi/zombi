<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="sk">
<head>
	<title><?=$_PAGE['title']?></title>
	<meta name="title" content="<?=$_PAGE['title']?>" />
	<!-- <meta name="keywords" content="<?=$_PAGE['keywords']?>" /> ignored for years -->
	<meta name="description" content="<?=$_PAGE['description']?>" />
	<meta name="author" content="Tomáš Zamba [www.zombi.sk]; e-mail: durmstrang.d@gmail.com" />
	<meta name="robots" content="all,follow" />
	<meta name="googlebot" content="index,follow,snippet,archive" />
	<meta http-equiv="content-type"	content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="sk" />
	<link rel="shortcut icon" href="<?echo$_PAGE['base_url'];?>favicon.ico" />
	<link rel="stylesheet" href="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/css/bootstrap.css'?>" media="screen" />
	<link rel="stylesheet" href="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/css/bootstrap.min.css'?>" media="screen" />
	<link rel="stylesheet" href="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/css/style.css'?>" media="screen,print" />
	<link rel="stylesheet" href="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/css/styleParallel.css'?>" media="screen" />
	<link rel="stylesheet" href="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/css/jquery.fancybox-1.3.4.css'?>" media="screen" />
	<script src="<?echo$_PAGE['base_url'];?>configs/js/script.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script src="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/js/jquery.parallax-1.1.3.js';?>"></script>
	<script src="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/js/jquery.localscroll-1.2.7-min.js';?>"></script>
	<script src="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/js/jquery.scrollTo-1.4.2-min.js';?>"></script>
	<script src="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/js/jquery.easing-1.3.pack.js';?>"></script>
	<script src="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/js/jquery.fancybox-1.3.4.pack.js';?>"></script>
	<script src="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/js/jquery.mousewheel-3.0.4.pack.js';?>"></script>
	<script src="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/js/smoothscroll.js';?>"></script>
	<script src="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/js/bootstrap.js';?>"></script>
	<script src="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/js/bootstrap.min.js';?>"></script>
	<script src="<?echo$_PAGE['base_url'].'template/'.$_PAGE['template_id'].'/js/textarea-maxlength.js';?>"></script>
	<script>
	$(document).ready(function() {
		$('#intro').parallax("50%", 0.1);
		$('#second').parallax("50%", 0.1);
		$('#third').parallax("50%", 0.3);
		$('.bg').parallax("50%", 0.4);

		$("a#single_image").fancybox();

		$("a#single_image").fancybox({
			'hideOnContentClick': true,
			'transitionOut'	:	'elastic',
			'autoScale' : false
		});

		 $("a.grouped_images").fancybox();

		$("a.grouped_images").fancybox({
			'hideOnContentClick': true,
			'transitionOut'	:	'elastic',
			'autoScale' : false
		});
	});
	</script>
</head>
<body data-spy="scroll">
	<div id="wrapper">
		<?
		if (file_exists('./modules/head_'.$_GET['list'].'.php') ) require'./modules/head_'.$_GET['list'].'.php';
		else if (file_exists('./modules/header.php') ) require'./modules/header.php';
		?>
		<div class="content">
			<? if (file_exists('./modules/leftmenu.php') ) require'./modules/leftmenu.php'; ?>

			<?
			if (file_exists('./sections/body/'.$_GET['list'].'/body_'.$_GET['act1'].'.php') ) require'./sections/body/'.$_GET['list'].'/body_'.$_GET['act1'].'.php';
			elseif (file_exists('./sections/body/body_'.$_GET['list'].'.php') ) require'./sections/body/body_'.$_GET['list'].'.php';
			?>

			<?
			if (file_exists('./modules/mod_'.$_GET['list'].'.php') ) require'./modules/mod_'.$_GET['list'].'.php';
			else if (file_exists('./modules/info.php') ) require'./modules/info.php';
			?>
		</div>
		<? if (file_exists('./modules/footer.php') ) require'./modules/footer.php'; ?>
	</div>
</body>
</html>
