<?php

class GoogleSheet {

	private $sheet_url;
	private $sheet_id;
	private $gid_table;
	
	public function getSheetId() {
		return $this->sheet_id;
	}
	
	public function getGidTable() {
		return $this->gid_table;
	}

	public function __construct($sheet_url) {
		$this->sheet_url = $sheet_url;
		$this->SheetURLtoID($sheet_url);
		$csv_index_cachefile = dirname(__FILE__)."/cache/csv_cache.json";
		if (!file_exists($csv_index_cachefile)) { // if the index cache file doesn't exist...
			$this->BuildCacheFile();
		}
	}

	public function SheetURLtoID() {
		preg_match("'\/spreadsheets\/d\/([a-zA-Z0-9-_]+)'", $this->sheet_url, $sheet_id); // extract the ID from the URL
		$this->sheet_id = $sheet_id[1];
	}

	public function BuildCacheFile() {
		$csvfile = fopen('https://docs.google.com/spreadsheets/d/'.$this->sheet_id.'/export?format=csv', 'r');
		if (!$csvfile) {
			echo ("Erreur de lecture du Google Sheet !<br/> ");
		} else{
			$cache_dir = dirname(__FILE__)."/cache/";
			$cache_filename = "csv_cache.json";
			if (!is_dir($cache_dir) or !is_writable($cache_dir)) {	// Error if directory doesn't exist or isn't writable.
				echo ("Erreur ! Le répertoire de cache <i>".$cache_dir."</i> n'existe pas ou n'a pas les autorisations d'écriture nécéssaires.<br/>");
			} elseif (is_file($cache_filename) and !is_writable($cache_filename)) { // Error if the file exists and isn't writable.
				echo ("Erreur ! Le répertoire de cache est OK, mais le des fichiers de cache <i>".$cache_filename."</i> n'existe pas ou n'a pas les autorisations d'écriture nécéssaires.<br/>");
			} else {
				$temp_table = array();
				while($row = fgetcsv($csvfile)) {
					// $row = array_map( "utf8_encode", $row ); // à chacune des entrées la fonction utf8_encode est appliquée
					$temp_table[] = $row; // get the data from the CSV Google Sheet
				}
				fclose($csvfile);
				file_put_contents($cache_dir.$cache_filename, json_encode($temp_table) ); // put the data in the cachefile
				echo ("Fichier de cache <i>".$cache_filename."</i> mis à jour !<br/>");
			}
		}
	}
	
	public function CsvToArrayKeys() { // build 2-dimension array with keys
		static $temp_table;
		$cachefile = dirname(__FILE__)."/cache/csv_cache.json";
		$temp_table = json_decode(file_get_contents($cachefile) ); // ...on récupère les données à partir du fichier de cache
		$words_array = array();
		foreach( $temp_table as $line => $row) { // met dans le bon ordre
			if ($row[0] !='') { // enlève les cellules vides
				$words_array[$row[0]] = $row[1];
			}
		}
		array_splice($words_array,0,3); // enlève les 3 premières lignes du tableau
		return ($words_array);
	}
	
}
