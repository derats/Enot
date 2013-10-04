<?php

class Search_Model extends StaticDataRequests {

	public function __construct() {
		if(empty($_SESSION['lang']))
			$_SESSION['lang'] = 'RU';
		$this->language = $_GET['lang'] ? $_GET['lang'] : $_SESSION['lang'];
	}

	public function cityComplete() {
		$tmp = array();
		foreach($this->get('SearchCity', $_POST['COUNTRY']) as $item) {
			$tmp[] = array('label' => $_POST['COUNTRY'].': '.$item['text'], 'value' => $item['text'], 'code' => $item['attributes']['code']);
		}
		return $tmp;
	}

	public function searchRecursive($needle, $array) {
		foreach ($array as $key => $value) {
			if($needle === $value || (is_array($value) && $this->searchRecursive($needle, $value))) {
				return true;
			}
		}
		return false;
	}

	// public function SearchCountry($arg) {
	// 	$array = parent::SearchCountry($arg);
	// 	//asort($array);
	// 	return $array;
	// }

	// public function SearchCity($country, $query) {
	// 	if(preg_match( '/[\p{Cyrillic}]/u', $query)) {
	// 		$this->language = 'RU';
	// 	}
	// 	return parent::SearchCity($country, $query);
	// }

	public function duration() {
		return array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
			'6' => '6',
			'7' => '7',
			'8' => '8',
			'9' => '9');
	}

	public function rooms() {
		return array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5');
	}

	public function Languages() {
		return array(
			'AR' => 'ARABIC',
			'ZH' => 'CHINESE SIMPLIFIED',
			'ZZ' => 'CHINESE TRADITIONAL',
			'EN' => 'ENGLISH',
			'FR' => 'FRENCH',
			'DE' => 'GERMAN',
			'IW' => 'HEBREW',
			'IT' => 'ITALIAN',
			'JA' => 'JAPANESE',
			'KO' => 'KOREAN',
			'RU' => 'RUSSIAN',
			'ES' => 'SPANISH',
			'TH' => 'THAI');
	}
}