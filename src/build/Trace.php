<?php
/*--------------------------------------------------------------------------
 | Software: [WillPHP framework]
 | Site: www.113344.com
 |--------------------------------------------------------------------------
 | Author: no-mind <24203741@qq.com>
 | WeChat: www113344
 | Copyright (c) 2020-2022, www.113344.com. All Rights Reserved.
 |-------------------------------------------------------------------------*/
namespace willphp\debug\build;
use willphp\config\Config;
/**
 * Trace处理
 * trait Trace
 * @package willphp\debug\build
 */
trait Trace {
	/**
	 * 处理trace
	 */
	protected function parseTrace() {
		defined('START_TIME') or define('START_TIME', microtime(true));
		$this->getRequrieFile();
		$this->getBaseInfo();			
		$this->getErrorInfo();
		$request_type = Config::get('debug.request_type', []);
		$trace = [];		
		foreach ($this->level as $k => $v) {
			$k = strtolower($k);
			if (in_array($k, $request_type)) {
				$ok = $this->traceRequest($k);
				if (!$ok) {
					unset($this->level[$k]);
					continue;
				}
			} 		
			$this->total[$k] = isset($this->items[$k])? count($this->items[$k]) : 0;			
			$title = ($k != 'base')? $v.'('.$this->total[$k].')' : $v;
			$trace[$title] = isset($this->items[$k])? $this->items[$k] : [];
			if ($k != 'base' && $this->total[$k] > 0) {
				$trace['基本']['调试统计'] .=  ' | '.$v.'：'.$this->total[$k];
			}
		}
		return $trace;		
	}
	/**
	 * 获取错误信息
	 */
	protected function getErrorInfo() {
		$get_error = Config::get('debug.get_error', '');
		$errors = is_callable($get_error)? call_user_func($get_error) : [];
		if (!empty($errors)) {
			$this->trace($errors, 'error');
		}
	}	
	/**
	 * 获取请求信息
	 */
	protected function traceRequest($type = '') {
		$get_request = Config::get('debug.get_request', '');
		$request = is_callable($get_request)? call_user_func($get_request) : [];
		$key = strtoupper($type);
		if (isset($request[$key])) {
			$this->items[$type] = $request[$key];
		}
		return empty($this->items[$type])? false : true;
	}
	/**
	 * 获取文件加载信息
	 */
	protected function getRequrieFile() {
		$files = get_included_files();
		$total = 0;		
		$k = 0;
		foreach ($files as $k => $file) {
			$k = $k + 1;
			$filesize = filesize($file);
			if (isset($this->level['file'])) {
				$this->items['file'][] = $k.'.'.$file.' ( '.number_format($filesize / 1024, 2).' KB )';
			}			
			$total += $filesize;
		}
		$this->total['file'] = $k;
		$this->total['file_size'] = number_format($total / 1024, 2).' KB';
	}
	/**
	 * 获取trace基本信息
	 */
	protected function getBaseInfo() {
		$this->items['base']['主机信息'] = $_SERVER['SERVER_SOFTWARE'];
		$url = trim('http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']), '/\\');
		$this->items['base']['请求信息'] = $_SERVER['SERVER_PROTOCOL'].' '.$_SERVER['REQUEST_METHOD'].': <a href="'.$url.'" style="color:#000;">'.$url.'</a>';
		$get_route = Config::get('debug.get_route', '');
		if (is_callable($get_route)) {
			$route = call_user_func($get_route);
			$update_page = Config::get('view.view_cache')? ' <a href="?_cache=0" style="color:#000;">更新页面</a>' : '';
			$this->items['base']['路由参数'] = $route.$update_page;
		}
		$memory = defined('START_MEMORY')? memory_get_usage() - START_MEMORY : memory_get_usage();
		$this->items['base']['内存开销'] = number_format($memory/1024,2).' KB';
		$this->items['base']['调试统计'] = '文件：'.$this->total['file'].'('.$this->total['file_size'].')';
		$this->items['base']['运行时间'] = round((microtime(true) - START_TIME) , 4).'s at '.date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']).$this->getVersion();
	}
	/**
	 * 获取框架版本信息
	 */
	protected function getVersion() {
		defined('WILLPHP_VERSION') or define('WILLPHP_VERSION', '4.0.1');
		return ' <a href="http://www.113344.com" style="color:green;" target="_blank">WillPHPv'.WILLPHP_VERSION.'</a>';
	}	
}