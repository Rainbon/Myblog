<?php
// +----------------------------------------------------------------------
// | 夜色空凝 - 彩虹 [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://ch.yeskn.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
/**
 * 文章内页
 */
namespace Home\Controller;
use Common\Controller\HomebaseController;
class ArticleController extends HomebaseController {
    //文章内页
    public function index() {
		$id = intval($_GET['id']);
		$post = M('posts')->where(['id'=>$id])->find();
        $post['author_name'] = M('Users')->where(['id'=>$post['post_author']])->getField('user_nicename');
        $post['show_date']   = date('Y年m月d日',strtotime($post['post_date']));
        $this->assign('post',$post);
        $this->display('Home:post');
    }
}
