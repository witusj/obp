<?php $pathinfo = pathinfo($_SERVER['SCRIPT_NAME']); ?>
<?php include('settings.php'); ?>
<!DOCTYPE html>
<head>
   <title><?php 
      if ($pathinfo['dirname'] == "/OBP") { echo "Optimization of Business Processes";} 
      elseif ($pathinfo['dirname'] == "/CCO") {echo "Call Center Optimization";} 
      elseif ($pathinfo['dirname'] == "/CCWFM") {echo "A Deep Dive Into Call Center WFM";} 
      elseif ($pathinfo['dirname'] == "/occ") {echo "Otimiza&ccedil;&atilde;o para Contact Center";} 
      elseif ($pathinfo['dirname'] == "/IBA") {echo "Introduction to Business Analytics";} 
      elseif (getenv('DOMAIN') == "mm-zorglogistiek") {echo "Methoden en Modellen voor Zorglogistiek";}
      else {echo "Ger Koole";}
   ?></title>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">		
   <meta name="description" content="Ger Koole">
   <meta name="viewport" content="width=1100">		
   <link rel="stylesheet" type="text/css" href="/style.css" />
   <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico">
   <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
</head>
<body>
   <div id="head" <?php 
      if     ($pathinfo['dirname'] == "/OBP") {echo "class=\"OBP\"";} 
      elseif ($pathinfo['dirname'] == "/CCO") {echo "class=\"CCO\"";} 
      elseif ($pathinfo['dirname'] == "/CCWFM") {echo "class=\"CCWFM\"";}
      elseif ($pathinfo['dirname'] == "/occ") {echo "class=\"CCO\"";} 
      elseif ($pathinfo['dirname'] == "/IBA") {echo "class=\"IBA\"";} 
      elseif (getenv('DOMAIN') == "mm-zorglogistiek") {echo "class=\"mmzl\"";}?>>
      <div id="title-container">
         <div id="title">
		<?php 
                if ($pathinfo['dirname'] == "/OBP") 
                  {echo "Optimization of Business Processes";} 
                elseif ($pathinfo['dirname'] == "/CCO") 
                  {echo "<a href=\"/\">Ger Koole</a>: Call Center Optimization";} 
                elseif ($pathinfo['dirname'] == "/CCWFM") 
                  {echo "<a href=\"/\">Ger Koole</a>: A Deep Dive Into Call Center WFM";} 
                elseif ($pathinfo['dirname'] == "/occ") 
                  {echo "<a href=\"/\">Ger Koole</a>: Otimiza&ccedil;&atilde;o para Contact Center";} 
                elseif ($pathinfo['dirname'] == "/IBA") 
                  {echo "<a href=\"/\">Ger Koole</a>: Introduction to Business Analytics";} 
                elseif (getenv('DOMAIN') == "mm-zorglogistiek") 
                  {echo "Methoden en Modellen voor Zorglogistiek";} 
                else 
                  {echo "<a href=\"/\">Ger Koole</a>";}
			?>
			</div>
		</div>
	</div>
	<div id="content">
		<div id="menu"><?php include("menu.php"); ?></div>
		<div id="text">