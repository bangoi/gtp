<?php 

namespace Admin\Model;
use Think\Model\ViewModel;

class GtpViewModel extends ViewModel {
	 
    protected $viewFields = array(
    
        'Gtp' => array(
        	'id', 'user_id', 'artist_name', 'song_title', 'file_name', 'author',
        	'source', 'download_num', 'digg_num', 'comment_num', 'tags', 'add_time', 'state'
		),  
        'User' => array('nick', '_on'=>'Gtp.user_id = User.id'),
        
    );
	 
} 
?>
