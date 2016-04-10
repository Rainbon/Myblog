<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 2016/4/10
 * Time: 15:09
 */

namespace Home\Widget;


use Think\Controller;

class SidebarWidget extends Controller
{
    public function recommend()
    {
        $posts = M('Posts')->where(['post_status'=>1,'recommended'=>1])->field('post_title,id')->limit(5)->select();
        $this->assign('posts',$posts);
        $this->display('Home:Widget:recommend');
    }
}