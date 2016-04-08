<?php
// +----------------------------------------------------------------------
// | 夜色空凝 - 彩虹 [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://ch.yeskn.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Portal\Controller;
use Common\Controller\HomebaseController; 
/**
 * 首页
 */
class IndexController extends HomebaseController {
	
    //首页
	public function index() {
		$posts = M('Posts')->order('post_date desc')->limit(10)->select();
        if($posts){
            foreach ($posts as $key => $value){
                $posts[$key]['author_name'] = M('Users')->where(['id'=>$value['post_author']])->getField('user_nicename');
            }
        }
        $this->assign('posts',$posts);
    	$this->display(":index");
    }

}


