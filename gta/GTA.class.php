<?php

require(dirname(__FILE__) . '/XMLTransactionHander.class.php');
require(dirname(__FILE__) . '/properties.php');

class GTA {

	public $clientID = clientID;
	public $email = email;
	public $password = password;
	public $language = language;
	public $requestMode = requestMode; 
	public $responseCallbackURL = responseCallbackURL;
	public $requestURL = requestURL;


	public function xmlHeader() {
		$requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
		$requestData .= '<Request>';
		$requestData .= '<Source>';
		$requestData .= '<RequestorID Client="'.$this->clientID.'" EMailAddress="'.$this->email.'" Password="'.$this->password.'"/>';
		$requestData .= '<RequestorPreferences Language="'.$this->language.'">';
		$requestData .= '<RequestMode>'.$this->requestMode.'</RequestMode>';
		$requestData .= '</RequestorPreferences>';
		$requestData .= '</Source>';
		$requestData .= '<RequestDetails>';
		return $requestData;
	}

	public function xmlFooter() {
		$requestData = '</RequestDetails>';
		$requestData .= '</Request>';
		return $requestData;
	}

	public function request($request) {
		$requestXML = $this->xmlHeader() . $request . $this->xmlFooter();
		// todo: добавить валидацию xml
		$XMLTransactionHander = new XMLTransactionHander;
		$responseDoc = $XMLTransactionHander->executeRequest( $this->requestURL, $requestXML );
		$responseDoc->formatOutput = true; 
		if(!$responseDoc->schemaValidate(_ROOT . '/gta/xsd/cbsapi.xsd')) {
			throw new Exception('schema of responce NOT valid!');
		}
		if(View::$script)
			Enot::$logger->log($responseDoc->saveXML());
		return new DOMXPath($responseDoc);
	}

}