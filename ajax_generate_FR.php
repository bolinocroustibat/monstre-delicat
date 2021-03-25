<?php

include("class.googlesheet.php");
include("class.person.php");
include("class.word.php");
include("class.sentence.php");

/* CREATION DE LA TABLE D'INDEX */
$gsheet = new GoogleSheet("https://docs.google.com/spreadsheets/d/1DHgjX83Tpa2JIjaVioyOpxaVsE1CKJWZZ6Jl4P-jMzg/edit#gid=0");
$gid_table = $gsheet->getGidTable();

/* CREATION DU PERSONNAGE */
$person = new Person();
$person_array = $person->getPersonArray();
$person_pic_filename = $person->getPersonPicture();

/* CREATION DU TITRE */
$sentence_obj = new Sentence($gid_table,"phrases",$person_array);
$sentence = $sentence_obj->getSentenceString();

$hash = hash('md5',$sentence); // Génère le hash

/* AFFCIHAGE SOUS FORME D'OBJET JSON POUR AJAX */
$data = [
	'hash' => $hash,
	'sentence' => $sentence,
	'picture' => $person_pic_filename
];
$jsonData = json_encode($data); // encode in a JSON object
echo $jsonData;

?>