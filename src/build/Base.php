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
class Base {
	protected $items = ['base'=>[], 'file'=>[], 'sql'=>[], 'debug'=>[], 'error'=>[]];
	protected $total = ['file'=>0, 'sql'=>0, 'debug'=>0, 'error'=>0, 'filesize'=>'1 KB']; //统计
	/**
	 * 设置trace信息
	 * @param  string|array  $info  变量
	 * @param  string  $level  Trace级别
	 * @return void|array
	 */
	public function trace($info = '', $level = 'debug') {
		if (!Config::get('app.debug') || !Config::get('app.trace')) {
			return;
		}
		if (empty($info)) {
			return $this->items;
		}
		if (isset($this->items[$level])) {			
			$this->items[$level][] = is_array($info)? '<pre style="line-height:15px;">'.var_export($info, true).'</pre>' : htmlspecialchars($info, ENT_SUBSTITUTE);
		}
	}
	/**
	 * 获取trace信息
	 */
	public function getTrace() {
		if (!Config::get('app.debug') || !Config::get('app.trace') || $this->isAjax()) {
			return '';
		}
		defined('START_TIME') or define('START_TIME', microtime(true));
		defined('WILLPHP_VERSION') or define('WILLPHP_VERSION', '3.1.0');
		$this->getRequrieFile();
		$this->totalTrace();
		$this->getBaseInfo();		
		$trace_level = Config::get('debug.trace_level', []);
		if (!isset($trace_level['base'])) {
			$trace_level['base'] = '基本';
		}		
		foreach ($trace_level as $k => $v) {
			if (isset($this->items[$k])) {
				$v = isset($this->total[$k])? $v.'('.$this->total[$k].')' : $v;								
				$trace[$v] = $this->items[$k];
			}			
		}
		$errno = ($this->total['error'] > 0)? ' <span style="color:red">'.$this->total['error'].'</span>' : '';	
		ob_start();		
		include __DIR__.'/../view/page_trace.php';
		return "\n".ob_get_clean()."\n";
	}
	/**
	 * 是否为异步(Ajax)提交
	 * @return bool
	 */
	protected function isAjax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH'])	&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	/**
	 * 获取文件加载信息
	 */
	protected function getRequrieFile() {
		$files = get_included_files();
		$total = 0;
		foreach ($files as $k => $file) {
			$k = $k + 1;
			$filesize = filesize($file);
			$this->items['file'][] = $k.'.'.$file.' ( '.number_format($filesize / 1024, 2).' KB )';
			$total += $filesize;
		}
		$this->total['filesize'] = number_format($total / 1024, 2).' KB';
	}
	/**
	 * 统计trace信息
	 */
	protected function totalTrace() {
		$this->total['file'] = count($this->items['file']);
		$this->total['sql'] = count($this->items['sql']);
		$this->total['error'] = count($this->items['error']);
		$this->total['debug'] = count($this->items['debug']);
	}	
	/**
	 * 获取trace基本信息
	 */	
	protected function getBaseInfo() {
		$base = [];
		$base[] = ' 主机信息： '.$_SERVER['SERVER_SOFTWARE'];
		$base[] = ' 请求信息： '.$_SERVER['SERVER_PROTOCOL'].' '.$_SERVER['REQUEST_METHOD'].': '.trim('http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']), '/\\');	
		$get_route = Config::get('debug.get_route', '');
		if (!empty($get_route) && is_callable($get_route)) {
			$base[] = ' 路由参数： '.call_user_func_array($get_route, []);
		}
		$memory = defined('START_MEMORY')? memory_get_usage() - START_MEMORY : memory_get_usage();		
		$base[] = ' 内存开销： '.number_format($memory/1024,2).' KB';
		$base[] = ' 文件加载： '.$this->total['file'].' ('.$this->total['filesize'].') | SQL：'.$this->total['sql'].' | 调试：'.$this->total['debug'].' | 错误：'.$this->total['error'];		
		$version = ' <a href="http://www.113344.com" style="color:green;" target="_blank">WillPHPv'.WILLPHP_VERSION.'</a>';
		$base[] = ' 运行时间： '.round((microtime(true) - START_TIME) , 4).'s at '.date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']).$version;	
		$this->items['base'] = $base;
	}	

	
}