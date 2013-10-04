{include file="../header.tpl" jsfiles="jquery-ui-1.10.3.custom.min.js" cssfiles="ui-lightness/jquery-ui-1.10.3.custom.min.css"}
    <div class="container">

      <div class="starter-template">
        <h1>Enot::power</h1>
        <p class="lead">
	        <form id="search" class="form-inline" role="form">
          <div class="form-group">
            <label for="lang">Язык:</label>
            <select id="lang" name="lang" class="form-control"></select>
          </div>
	        <div class="form-group">
            <label for="country">Страна:</label>
					  <select id="country" name="country" class="form-control"></select>
				  </div>
  				<div class="form-group">
            <label for="searchCity">Город:</label>
  				  <input id="searchCity" name="searchCity" type="text" class="form-control" placeholder="Несколько букв в названии города">
  				</div>
          <p>
          <div class="form-group">
            <label for="dateIn">Дата заезда:</label>
            <input id="dateIn" name="dateIn" type="text" class="form-control" placeholder="01/01/2021">
          </div>
          <div class="form-group">
            <label for="roomCode">Тип номера:</label>
            <select id="roomCode" name="roomCode" class="form-control"></select>
          </div>
          <div class="form-group">
            <label for="roomNumber">Комнат:</label>
            <select id="roomNumber" name="roomNumber" class="form-control"></select>
          </div>
          <div class="form-group">
            <label for="duration">Продолжительность:</label>
            <select id="duration" name="duration" class="form-control"></select>
          </div>
          </p>
          <p>
            <button type="button" id="goSearch" class="btn btn-primary btn-lg">Large button</button>
          </p>
			</form>
		</p>
      </div>

    </div><!-- /.container -->
    <div id="load" style="display: none;">
      <p><center>Loading ....</center></p>
    </div>
{jsload file="search.js"}
{include file="../footer.tpl"}
