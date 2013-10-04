<?php

require(dirname(__FILE__) . '/GTA.class.php');

class StaticDataRequests extends GTA {

	public $SearchCountryRequest = '<SearchCountryRequest><CountryName><![CDATA[##QUERY##]]></CountryName></SearchCountryRequest>';
	public $SearchCountryResponce = 'ResponseDetails/SearchCountryResponse/CountryDetails';

	public $SearchCityRequest = '<SearchCityRequest CountryCode="##COUNTRY##"><CityName><![CDATA[##QUERY##]]></CityName></SearchCityRequest>';
	public $SearchCityResponce = 'ResponseDetails/SearchCityResponse/CityDetails';

	public $SearchRoomTypeRequest = '<SearchRoomTypeRequest />';
	public $SearchRoomTypeResponce = 'ResponseDetails/SearchRoomTypeResponse/RoomTypeDetails';

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
// <SearchRoomTypeRequest> +
// <SearchSightseeingCategoryRequest>
// <SearchSightseeingTypeRequest>
// <SearchSpecialEventRequest>
// <SearchStationRequest>
// <SearchTransferListRequest>


