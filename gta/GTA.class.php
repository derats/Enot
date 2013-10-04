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

	public $argv = array();

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

	public function get($request, $country = null, $query = null) {
		$this->argv = array(
			'hash'	  => md5(implode(array_merge(func_get_args(), array($this->language)))),
			'request' => $request,
			'country' => $country,
			'query'   => $query);
		return $this->cached();
	}

	public function cached() {
		if($cache = Enot::$memcache->get($this->argv['hash'])) {
			return $cache;
		} else {
			$response = $this->{$this->argv['request']}();
			Enot::$memcache->set($this->argv['hash'], $response);
			return $response;
		}
	}

	public function __call($method, $arg) {
		$patterns = array(
			'/##COUNTRY##/',
			'/##QUERY##/');
		$replacements = array(
			$this->argv['country'],
			$this->argv['query']);

		if(!isset($this->{$method . 'Request'}) && !isset($this->{$method . 'Responce'})) {
			throw new Exception('XML pattern for ' . $method . ' das not existen!');
		}

		$xml = preg_replace($patterns, $replacements, $this->{$method . 'Request'});
		$xpath = $this->request($xml);
		$request = array();


		$nodeList = $xpath->evaluate($this->{$method . 'Responce'});
		$simpleXML = simplexml_load_string($nodeList->item(0)->ownerDocument->saveXML($nodeList->item(0)));
		$request = xmlObjToArr($simpleXML);
		
		// foreach ($xpath->evaluate($this->{$method . 'Responce'}) as $item) {

		// 	$x = $item->ownerDocument->saveXML($item);
		// 	//var_dump($x);
		// 	$x = simplexml_load_string($x);
		// 	$xml_array = xmlObjToArr($x);
		// 	print_r($xml_array['children']); exit;

		// }		

		// foreach ($xpath->evaluate($this->{$method . 'Responce'}) as $item) {
		// 	$_item = array();
		// 	if($item->hasAttributes()) {
		// 		foreach ($item->attributes as $attribute) {
		// 			$_item[$attribute->name] = $attribute->value;
		// 		}
		// 	}
		// 	$request[] = array_merge($_item, array('name' => $item->textContent));
		// }
		
		return array_shift($request['children']);
	}

}

function xmlObjToArr($obj) { 
    $namespace = $obj->getDocNamespaces(true); 
    $namespace[NULL] = NULL; 
    
    $children = array(); 
    $attributes = array(); 
    $name = strtolower((string)$obj->getName()); 
    
    $text = trim((string)$obj); 
    if( strlen($text) <= 0 ) { 
        $text = NULL; 
    } 
    
    // get info for all namespaces 
    if(is_object($obj)) { 
        foreach( $namespace as $ns=>$nsUrl ) { 
            // atributes 
            $objAttributes = $obj->attributes($ns, true); 
            foreach( $objAttributes as $attributeName => $attributeValue ) { 
                $attribName = strtolower(trim((string)$attributeName)); 
                $attribVal = trim((string)$attributeValue); 
                if (!empty($ns)) { 
                    $attribName = $ns . ':' . $attribName; 
                } 
                $attributes[$attribName] = $attribVal; 
            } 
            
            // children 
            $objChildren = $obj->children($ns, true); 
            foreach( $objChildren as $childName=>$child ) { 
                $childName = strtolower((string)$childName); 
                if( !empty($ns) ) { 
                    $childName = $ns.':'.$childName; 
                } 
                $children[$childName][] = xmlObjToArr($child); 
            } 
        } 
    } 
    
    return array( 
        'name'=>$name, 
        'text'=>$text, 
        'attributes'=>$attributes, 
        'children'=>$children 
    ); 
}