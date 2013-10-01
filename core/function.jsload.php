<?php
function smarty_function_jsload($params, &$smarty) {
	return Statical::load(View::$module, $params['file']);
}
