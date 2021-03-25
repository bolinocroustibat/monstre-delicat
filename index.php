<!DOCTYPE html>
<html lang="fr">

<?php

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// RECUPERATION DES DONNEES EN CAS DE CHARGEMENT DE LA PAGE AVEC HASH
if(isset($_GET['hash']) && $_GET['hash']!='') { // Si on recoit un hash
	$hash = $_GET['hash'];
	include("connex.php");	
	$bdd = database_connect();
	$req = $bdd->query("SELECT sentence,pic_filename FROM fakenews WHERE hash='".$hash."'");
	$rep = $req->fetchAll();
	if ($rep) {
		$sentence= $rep[0]['sentence'];
		$picture= $rep[0]['pic_filename'];
	}
}
?>

<head>

	<?php include("header.php"); ?>

	<script>

		window.onpopstate = function() { // if a back or forward browser button is clicked
			hash = document.location.href.split("/").pop().replace(/\.[^/.]+$/, "") ;
			$.ajax({
				type: "GET",
				url: 'ajax_get_data_FR.php',
				data: 'hash=' + hash,
				contentType: "application/json",
				dataType: 'json',
				success: function (data) {
					console.log(data);
//					var dataObj = jQuery.parseJSON(data);
//					sentence = dataObj.sentence;
//					picture = dataObj.picture;
//					$('.project-wrapper').css('visibility', 'visible');
//					$('.share-wrapper').css('visibility', 'visible');
//					$('.image').attr('src','./photos/'+picture);
//					$('.project').html(sentence);
// TEST 
				}
			})
		};

		function generate_data() { // si le bouton de génération a été cliqué
			$(".project, .site").hide("fade");
			$(".image").hide("fade", function() { // when the image is also hidden, launch the ajax call
				$.ajax({
					type: "POST",		
					url: 'ajax_generate_FR.php',
					success: function (data) {
						var dataObj = jQuery.parseJSON(data);
						hash = dataObj.hash;
						sentence = dataObj.sentence;
						picture = dataObj.picture;
						if ((typeof sentence !== 'undefined') && (typeof hash !== 'undefined')) { // si les variables existent
							$(".image").attr("src","./photos/"+picture);
							$(".project").html(sentence);
							history.replaceState(sentence, sentence, hash+'.html'); // change l'URL dynamiquement
						}
					}
				})
				$(".project-wrapper").css("visibility", "visible");
			});
			$(".image, .project, .site").show("fade");
		}
		function read_data(sentence, picture) { // si on a reçu les données grâce au hash dans l'URL, utilisée en argument du body onload
			$('.project-wrapper').css('visibility', 'visible');
			$('.image').attr('src','./photos/'+picture);
			$('.project').html(sentence);
		}
	</script>

</head>

<body<?php if(isset($sentence) && $sentence!='' && isset($picture) && $picture!=''){echo ' onload="read_data(\''.$sentence.'\',\''.addslashes($picture).'\')"';} ?>>

	<div id="main-wrapper">

		<h1>Monstre délicat</h1>

		WIP
	
	</div>
	

</body>

</html>