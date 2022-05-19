# 调试组件

Debug组件(DebugBar)用于展示trace页面，这是一个调试和分析工具条

#开始使用

####安装组件

使用 composer 命令进行安装或下载源代码使用，依赖(willphp/config)。

    composer require willphp/debug

> WillPHP框架已经内置此组件，无需再安装。

####使用示例

    \willphp\debug\Debug::trace('error info', 'error'); //设置错误信息

####调试设置

必须常量：
	
	define('APP_TRACE', true); //是否开启调试栏
	define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	define('RUN_MEMORY', memory_get_usage()); //开始内存
	define('RUN_TIME', microtime(true)); //开始时间

`config/debug.php`配置文件可设置相关显示信息：

	//设置显示的trace
	'level' => [
			'base' => '基本',
			'file' => '文件', //文件加载
			'sql' => 'SQL',
			'debug' => '调试',
			'post' => 'POST',
			'get' => 'GET',
			'cookie' => 'COOKIE',
			'session' => 'SESSION',
			'error' => '错误',
	],
	//获取路由信息(可选)
	'get_route' => '', 

	
####设置trace

可在数据库查询和错误处理中把相关信息记录到trace
	
	Debug::trace('SELECT * FROM `test`', 'sql'); //记录sql到trace
	Debug::trace('错误信息', 'error'); //记录error到trace
	Debug::trace(['id'=>1]); //在调试栏目中显示数组

####显示trace

在显示内容后，可获取trace内容并在底部显示

    $trace = Debug::getTrace(); //获取trace
    echo $trace;  
    
添加trace信息到内容后面：

    $content = Debug::appendTrace($content); 
    echo $content;      

####助手函数

已去除内置，请自行设置此函数。

	/**
	 * 记录trace信息
	 * @param  string|array  $info  变量
	 * @param  string  $level  Trace级别(debug,sql,error)
	 * @return void|array
	 */
	function trace($info = '', $level = 'debug') {
		return \willphp\debug\Debug::trace($info, $level);
	}
	