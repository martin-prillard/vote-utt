<?
session_start();
if(!isset($_SESSION['auth_admin']))
{
	header("location:index.php");
}

include("conf.site");
include("fonctions.php");

//intialiser la connexion à la base de données
//
$bdd = new PDO('mysql:host='.$BDD_hote.';dbname='.$BDD_nmDB, $BDD_user, $BDD_pass);
?>

<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Administration</title>
	<!-- link to the CSS files for this menu type -->
	<link rel="stylesheet" media="screen" href="css/superfish.css">
	<link rel="stylesheet" media="screen" href="css/datePicker.css.css">
	
	<link href="css/global.css" rel="stylesheet" type="text/css" />
	<!-- link to the JavaScript files (hoverIntent is optional) -->
	<!-- if you use hoverIntent, use the updated r7 version (see FAQ) -->
	<script src="js/hoverIntent.js"></script>
	<script src="js/superfish.js"></script>
	<!-- initialise Superfish -->
	<script>

	jQuery(document).ready(function(){
		jQuery('ul.sf-menu').superfish();
	});

	</script>
	
	<!-- Add jQuery library -->
	<script type="text/javascript" src="lib/jquery-1.10.1.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="source/jquery.fancybox.css?v=2.1.5" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
	
	<script>
			$('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});
	</script>
	
</head>
<body>

<div id="header">
	<div id="header_top">
		<span>Bienvenue sur le panneau d'administration </span><a class="link_jaune" href="logout.php">se déconnecter</a>
	</div>
	<div id="header_mid">
		<center><h1>Administration des données appli Vote-utt</h1></center>
	</div>
	
</div>

<div id="content">
	<div id="header_menu">
		<ul class="sf-menu">
			<li>
				<a href="admin.php">HOME</a>
			</li>
			<li>
				<a href="">GESTION</a>
				<ul>
					<li><a href="admin_elections.php">Gestion des éléctions</a></li>
					<li><a href="admin_users.php">Gestion des utilisateurs</a></li>
					<li><a href="admin_candidats.php">Gestion des candidats</a></li>
					<li><a href="admin_votes.php">Gestion des votes</a></li>
				</ul>
			</li>
		</ul>
		
	</div>
	
	<div id="content_top">
		
	</div>
	
	<div id="content_produits">
		<div id="content_produits_center">