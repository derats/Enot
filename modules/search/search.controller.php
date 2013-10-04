<?php

class Search_Controller extends Enot {

	public function default_action() {
		//Enot::$memcache->flush();
		//print_r($this->model->get('SearchCountry'));
		//print_r($this->model->get('SearchCity', 'RU'));
		$this->view->display('search_form');
		//Enot::$logger->log(print_r(Enot::$memcache->get('countries'), true));
		//print_r($this->model->get('SearchCountry'));

	}

	public function fetchRoomCode() {
		$this->view->jquery('#roomCode')->text('');
		foreach ($this->model->get('SearchRoomType') as $item) {
			$this->view->jquery('#roomCode')->append(sprintf('<option value="%s">%s</option>',
			$item['attributes']['code'],
			$item['text']));
		}
	}

	public function fetchRoomNumber() {
		$this->view->jquery('#roomNumber')->text('');
		foreach ($this->model->rooms() as $key => $value) {
			$this->view->jquery('#roomNumber')->append(sprintf('<option value="%s">%s</option>',
				$key,
				$value));
		}
	}

	public function fetchDuration() {
		$this->view->jquery('#duration')->text('');
		foreach ($this->model->duration() as $key => $value) {
			$this->view->jquery('#duration')->append(sprintf('<option value="%s">%s</option>',
				$key,
				$value));
		}
	}

	public function fetchCities() {
		if($this->model->searchRecursive($_POST['COUNTRY'], $this->model->get('SearchCountry'))) {
			$_SESSION['COUNTRY'] = $_POST['COUNTRY'];
			echo json_encode($this->model->cityComplete());
		}
	}

	public function fetchCountries() {
		$this->view->jquery('#country')->text('');
		foreach ($this->model->get('SearchCountry') as $item) {
			$this->view->jquery('#country')->append(sprintf('<option value="%s"%s>%s</option>',
				$item['attributes']['code'],
				$item['attributes']['code'] == $_SESSION['COUNTRY'] ? 'selected' : '',
				$item['text']));
		}
	}

	public function fetchLanguages() {
		$this->view->jquery('#lang')->text('');
		foreach ($this->model->Languages() as $key => $lang) {
			$this->view->jquery('#lang')->append(sprintf('<option value="%s"%s>%s</option>', 
				$key,
				$key == $_SESSION['lang'] ? 'selected' : '',
				$lang));
		}
	}

	public function changeLang() {
		$_SESSION['lang'] = $_POST['language'];
	}

}