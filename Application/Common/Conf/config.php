<?php
return array(
	'MODULE_ALLOW_LIST' => array ( 'Home', 'M', 'Admin'),
	'DEFAULT_MODULE'	=> 'Home',
	'URL_MODEL' => '2',
	'SESSION_AUTO_START' => true,
	 
	'DB_TYPE'=>'mysql',
    'DB_HOST'=>'114.215.131.58',
    'DB_NAME'=>'gtp',
    'DB_USER'=>'root',
    'DB_PWD'=>'6fa1fa1952',
    'DB_PORT'=>'3306',
    'DB_PREFIX'=>'',
    
	'TOKEN_ON'  => false,
    'URL_CASE_INSENSITIVE' => true,
    'VAR_PAGE' => 'p',
    
	'SHOW_PAGE_TRACE' => false,
	'URL_PARAMS_BIND' => true,
	'URL_ROUTER_ON' => true,
	'URL_HTML_SUFFIX' => '',
	
	'URL_ROUTE_RULES' => array(
        
		//'topic/edit/:id' => 'topic/edit',
		//'topic/delete/:id' => 'topic/delete',
		//'topic/:opt/:id' => 'topic/:opt',
		//'topic/:id\d$' => 'topic/details',
		'search' => 'index/search',
		
		'user/settings' => 'user/settings',
		'user/face' => 'user/face',
		'user/crop' => 'user/crop',
		'user/login' => 'user/login',
		'user/register' => 'user/register',
		'user/logout' => 'user/logout',
		'user/get_city' => 'user/get_city',
		'user/edit/:id' => 'user/edit',
		'user/delete/:id' => 'user/delete',
		'user/:id\d$' => 'user/details',
		'user/:domain\s$' => 'user/details',
		
		'gtp/:id\d$' => 'gtp/details',
		'gtp/edit/:id' => 'gtp/edit',
		'gtp/delete/:id' => 'gtp/delete',
		'gtp/download/:id' => 'gtp/download',
		
		'vedio/:id\d$' => 'vedio/details',
		'vedio/edit/:id' => 'vedio/edit',
		'vedio/delete/:id' => 'vedio/delete',
		
		'blog/:id\d$' => 'blog/details',
		'blog/edit/:id' => 'blog/edit',
		'blog/delete/:id' => 'blog/delete',
    ),
    
	'TMPL_PARSE_STRING'  =>	array(
		'__SITE__' => 'http://localhost:9990/gtp',
		//'__SITE__' => 'http://www.ganhuole.com/ganhuo',
		'__TITLE__' => 'Guitar Pro',
	)
	
);