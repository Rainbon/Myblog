<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 2016/4/10
 * Time: 15:09
 */

namespace Home\Widget;


use Home\Model\PostsModel;
use Think\Controller;

class SidebarWidget extends Controller
{
    public function recommend()
    {
        $posts = M('Posts')->where(['post_status'=>1,'recommended'=>1])->field('post_title,id')->limit(5)->select();
        $this->assign('posts',$posts);
        $this->display('Home:Widget:recommend');
    }

    public function archives()
    {
        $postModel = new PostsModel();
        $date = array();
        $list = $postModel->field('id,post_date')
            ->where(['post_status'=>1])
            ->order('post_date desc')
            ->select();
        
        function format_date($date)
        {
            return date('Y年m月',strtotime($date));
        }

        foreach ($list as $key => $value){
            $date[] = format_date($value['post_date']);
        }
        $data = array_count_values($date);
        foreach ($data as $key => $value){
            $_data[] = array(
                'name'  => $key,
                'count' => $value,
                'year'  => mb_substr($key,0,4),
                'month' => mb_substr($key,5,2),

            );
        }

        $this->assign('data',$_data);
        $this->display('Home:Widget:archives');
    }

    public function hotTags()
    {
        $data = M('Tags')->order('count desc')->limit(10)->select();
        $this->assign('data',$data);
        $this->display('Home:Widget:hotTags');
    }
}