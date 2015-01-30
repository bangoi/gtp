<?php 

namespace Admin\Model;
use Think\Model\ViewModel;

class BlogViewModel extends ViewModel {
	 
    protected $viewFields = array(
    
        'Blog' => array(
        	'id', 'user_id', 'title', 'description', 'content', 'tags',
        	'cover_path', 'tags', 'add_time', 'state'
		),  
        'User' => array('nick', '_on'=>'Blog.user_id = User.id'),
        
    );
	 
} 
?>
