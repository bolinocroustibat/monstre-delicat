<?php

include("class.googlesheet.php");
include("class.person.php");
include("class.word.php");
include("class.sentence.php");

/* CREATION DE LA TABLE D'INDEX */
$gsheet = new GoogleSheet("https://docs.google.com/spreadsheets/d/1DHgjX83Tpa2JIjaVioyOpxaVsE1CKJWZZ6Jl4P-jMzg/edit#gid=0");

/* CREATION DU TITRE */
$sentence_obj = new Sentence();
$sentence = $sentence_obj->getSentenceString();

$hash = hash('md5',$sentence); // Génère le hash

/* AFFCIHAGE SOUS FORME D'OBJET JSON POUR AJAX */
$data = [
	'hash' => $hash,
	'sentence' => $sentence,
];
$jsonData = json_encode($data); // encode in a JSON object
echo $jsonData;

?>