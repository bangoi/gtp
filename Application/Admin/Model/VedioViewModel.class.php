<?php

namespace Home\Model;
use Think\Model\ViewModel;

class VedioViewModel extends ViewModel {
	 
    protected $viewFields = array(
        
        'Vedio' => array(
        	'id', 'user_id', 'title', 'code', 'thumb', 'digg_num', 'view_num', 'comment_num',
        	'artist_name', 'song_title', 'tags', 'add_time', 'state'),
        	  
        'User'=>array('nick', '_on' => 'Vedio.user_id = User.id'),
        
    );
	 
} 
?>