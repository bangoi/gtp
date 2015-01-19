<?php
return array(
	'MODULE_ALLOW_LIST' => array ( 'Home', 'M'),
	'DEFAULT_MODULE'	=> 'Home',
	'URL_MODEL' => '2',
	'SESSION_AUTO_START' => true,
	
	'DB_TYPE'=>'mysql',
    'DB_HOST'=>'localhost',
    'DB_NAME'=>'gtp',
    'DB_USER'=>'root',
    'DB_PWD'=>'qeephp',
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
		
		'item/:id\d$' => 'item/details',
		'item/edit/:id' => 'item/edit',
		'item/delete/:id' => 'item/delete',
		'item/reopen/:id' => 'item/reopen',
		'item/apply/:id' => 'item/apply',
		'item/withdraw/:id' => 'item/withdraw',
		
		'people/:id\d$' => 'people/details',
		'people/edit/:id' => 'people/edit',
		'people/delete/:id' => 'people/delete',
		'people/repwd/:id' => 'people/repwd',
		
		'order/:id\d$' => 'order/details',
		'order/edit/:id' => 'order/edit',
		'order/delete/:id' => 'order/delete',
		
		'gtp/:id\d$' => 'gtp/details',
		'gtp/edit/:id' => 'gtp/edit',
		'gtp/delete/:id' => 'gtp/delete',
		'gtp/download/:id' => 'gtp/download',
		
		'vedio/:id\d$' => 'vedio/details',
		'vedio/edit/:id' => 'vedio/edit',
		'vedio/delete/:id' => 'vedio/delete',
    ),
    
	'TMPL_PARSE_STRING'  =>	array(
		'__SITE__' => 'http://localhost:9990/gtp',
		//'__SITE__' => 'http://www.ganhuole.com/ganhuo',
		'__TITLE__' => 'Guitar Pro',
	)
	
);