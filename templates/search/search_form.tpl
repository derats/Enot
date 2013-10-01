{include file="../header.tpl" jsfiles="jquery-ui-1.10.3.custom.min.js" cssfiles="ui-lightness/jquery-ui-1.10.3.custom.min.css"}
    <div class="container">

      <div class="starter-template">
        <h1>Enot::power</h1>
        <p class="lead">
	        <form class="form-inline" role="form">
          <div class="form-group">
            <select id="lang" class="form-control"></select>
          </div>
	        <div class="form-group">
					  <select id="countries" class="form-control"></select>
				  </div>
  				<div class="form-group">
  				  <input id="search_city" type="text" class="form-control" placeholder="Text input">
  				</div>
			</form>
		</p>
      </div>

    </div><!-- /.container -->
    <div id="load" style="display: none;">
      <p><center>Loading ....</center></p>
    </div>
{jsload file="search.js"}
{include file="../footer.tpl"}
