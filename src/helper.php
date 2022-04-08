<?php
if (!function_exists('trace')) {
	/**
	 * 记录trace信息
	 * @param  string|array  $info  变量
	 * @param  string  $level  Trace级别(debug,sql,error)
	 * @return void|array
	 */
	function trace($info = '', $level = 'debug') {
		return \willphp\debug\Debug::trace($info, $level);
	}
}