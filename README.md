# 调试组件
Debug组件(DebugBar)用于展示trace页面，这是一个调试/分析工具条

#开始使用

####安装组件

使用 composer 命令进行安装或下载源代码使用(依赖willphp/config组件)。

    composer require willphp/debug

> WillPHP 框架已经内置此组件，无需再安装。

####使用示例

    \willphp\debug\Debug::trace('error info', 'error'); //设置错误信息


####开启Trace

`config/app.php`配置文件可开启trace显示DebugBar：
	
	'debug' => true, //开启debug后trace才生效
	'trace' => true, //开启显示trace页面

`config/debug.php`配置文件可设置相关显示信息：

	//设置显示trace的级别
	'trace_level' => [
			'base'  => '基本',				
			//'file'  => '文件', //不显示文件加载栏目
			'sql'   => 'SQL',
			'debug' => '调试',
			'post'  => 'POST',
			'get'   => 'GET',
			//'cookie'=> 'COOKIE',
			//'session'=> 'SESSION',
			'error' => '错误',
	],
	//设置获取错误的方法
	'get_error' => '\willphp\error\Error::all', 
	//设置获取路由信息的方法
	'get_route' => '\willphp\route\Route::getRoute', 
	//设置获取请求变量的方法
	'get_request' => '\willphp\request\Request::all', 
	'request_type' => ['get', 'post', 'cookie', 'session'], //请求变量类型
	
####设置trace

可在数据库查询和错误处理中把相关信息记录到trace
	
	Debug::trace('SELECT * FROM `test`', 'sql'); //记录sql到trace
	Debug::trace('错误信息', 'error'); //记录error到trace
	Debug::trace(['id'=>1]); //在调试打印数组

####显示trace

在显示内容后，可获取trace内容并在底部显示

    $trace = Debug::getTrace(); //获取trace
    echo $trace;  

####助手函数

	trace('info', 'error'); //设置trace,第二个参数默认debug 

