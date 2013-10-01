<?php
function smarty_function_cssload($params, &$smarty) {
	return Statical::load(View::$module, $params['file']);
}
