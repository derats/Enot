<?php

require(dirname(__FILE__) . '/GTA.class.php');

class StaticDataRequests extends GTA {

	public $argv = array();

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

		foreach ($xpath->evaluate($this->{$method . 'Responce'}) as $item) {
			$_item = array();
			if($item->hasAttributes()) {
				foreach ($item->attributes as $attribute) {
					$_item[$attribute->name] = $attribute->value;
				}
			}
			$request[] = array_merge($_item, array('name' => $item->textContent));
		}
		return $request;
	}

	public $SearchCountryRequest = '<SearchCountryRequest><CountryName><![CDATA[##QUERY##]]></CountryName></SearchCountryRequest>';
	public $SearchCountryResponce = 'ResponseDetails/SearchCountryResponse/CountryDetails/Country';

	public $SearchCityRequest = '<SearchCityRequest CountryCode="##COUNTRY##"><CityName><![CDATA[##QUERY##]]></CityName></SearchCityRequest>';
	public $SearchCityResponce = 'ResponseDetails/SearchCityResponse/CityDetails/City';

}

// <ItemInformationDownloadRequest ItemType="hotel">
// <SearchAirportRequest>
// <SearchAOTNumberRequest>
// <SearchAreaRequest>
// <SearchBreakfastTypeRequest>
// <SearchCitiesInAreaRequest>
// <SearchCityRequest> +
// <SearchCountryRequest> +
// <SearchCurrencyRequest>
// <SearchFacilityRequest>
// <SearchHotelGroupRequest> (for clients on participation level zero only)
// <SearchItemRequest ItemType="hotel">
// <SearchItemRequest ItemType="sightseeing">
// <SearchItemRequest ItemType="transfer">
// <SearchItemInformationRequest>
// <SearchLinkRequest>
// <SearchLocationRequest>
// <SearchMealTypeRequest>
// <SearchRecommendedItemRequest>
// <SearchRemarkRequest>
// <SearchRoomTypeRequest>
// <SearchSightseeingCategoryRequest>
// <SearchSightseeingTypeRequest>
// <SearchSpecialEventRequest>
// <SearchStationRequest>
// <SearchTransferListRequest>
