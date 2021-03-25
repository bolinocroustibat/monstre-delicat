<?php

	// include("connex.php");

	$hash = $_GET['hash'];

//	$bdd = database_connect();
//	$req = $bdd->query("SELECT sentence,pic_filename FROM fakenews WHERE hash='".$hash."'");
//	$rep = $req->fetchAll();
//	if ($rep) {
//		$sentence= $rep[0]['sentence'];
//		$picture= $rep[0]['pic_filename'];
//	}

	/* DISPLAYING AS A AJSON OBJECT FOR AJAX CALLS */
	$data = [
		'sentence' => "ihoih",
		'picture' => "ohoh"
	];
	$jsonData = json_encode($_GET); // encode in a JSON object
	echo "$jsonData";

?>