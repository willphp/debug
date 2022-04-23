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
	use Trace;	
	protected $openTrace = false; //是否开启trace
	protected $level; //trace等级
	protected $items; //trace集合
	protected $total; //trace统计
	/**
	 * 构造函数
	 */
	public function __construct() {
		$this->openTrace = Config::get('app.debug') && Config::get('app.trace');	
		$this->level = Config::get('debug.trace_level', []);
		if (!isset($this->level['base'])) {
			$this->level['base'] = '基本';
		}
	}
	/**
	 * 设置trace信息
	 * @param  string|array  $info  trace信息
	 * @param  string  $level  Trace级别
	 * @return void|array
	 */
	public function trace($info = '', $level = 'debug') {
		if (!$this->openTrace) {
			return;
		}
		if (empty($info)) {
			return $this->items;
		}
		$level = strtolower($level);
		if (!isset($this->items[$level])) {	
			$this->items[$level] = [];
		}	
		$info = $this->filter($info); //数据处理
		if (is_array($info)) {			
			$this->items[$level] = array_merge($this->items[$level], $info);
		} else {			
			$this->items[$level][] = $info;
		}
	}
	/**
	 * 数据处理
	 * @param  string|array $data 数据
	 * @param  mixed 		$default 默认值
	 * @return string|array
	 */
	protected function filter($data, $default = '') {
		if (empty($data)) {
			return $default;
		}
		if (is_array($data)) {
			array_walk_recursive($data, 'self::filterValue'); //输出前处理
		} else {
			self::filterValue($data, '');
		}
		return $data;
	}	
	protected static function filterValue(&$value, $key) {
		$value = ($value === null)? '' : htmlspecialchars($value, ENT_QUOTES);		
	}
	/**
	 * 追加trace信息到内容
	 * @param  string  $content 内容
	 * @return string
	 */
	public function appendTrace($content = '') {
		if ($this->openTrace && is_scalar($content) && !is_bool($content) && !preg_match('/^http(s?):\/\//', $content)) {
			$pos = strripos($content, '</body>');
			$trace = $this->getTrace();
			if (false !== $pos) {
				$content = substr($content, 0, $pos).$trace.substr($content, $pos);
			} else {
				$content = $content.$trace;
			}
		}
		return $content;
	}	
	/**
	 * 获取trace信息
	 */
	public function getTrace() {
		if (!$this->openTrace || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
			return '';
		}		
		$trace = $this->parseTrace();
		$errno = $this->getErrno();
		ob_start();		
		include __DIR__.'/../view/page_trace.php';
		return "\n".ob_get_clean()."\n";
	}
	/**
	 * 获取错误提示
	 */
	protected function getErrno() {
		$errno = '';
		if (isset($this->total['error']) && $this->total['error'] > 0) {
			$errno = ' <span style="color:red">'.$this->total['error'].'</span>';
		}
		return $errno;
	}
}