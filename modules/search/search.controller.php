<?php

class Search_Controller extends Enot {

	public function default_action() {
		//Enot::$memcache->flush();
		//print_r($this->model->get('SearchCity', 'RU'));
		$this->view->display('search_form');
		//Enot::$logger->log(print_r(Enot::$memcache->get('countries'), true));
		//print_r($this->model->get('SearchCountry'));
	}

	public function fetchCities() {
		if($this->model->searchRecursive($_POST['COUNTRY'], $this->model->get('SearchCountry'))) {
			echo json_encode($this->model->cityComplete());
		}
	}

	public function fetchCountries() {
		$this->view->jquery('#countries')->text('');
		foreach ($this->model->get('SearchCountry') as $country) {
			$this->view->jquery('#countries')->append('<option value="'.$country['Code'].'">'.$country['name'].'</option>');	
		}
	}

	public function fetchLanguages() {
		$this->view->jquery('#lang')->text('');
		foreach ($this->model->Languages() as $key => $lang) {
			$this->view->jquery('#lang')->append('<option value="'.$key.'"'.($key == $_SESSION['lang'] ? 'selected' : NULL).'>'.$lang.'</option>');
		}
	}

	public function changeLang() {
		$_SESSION['lang'] = $_POST['language'];
	}


	

}