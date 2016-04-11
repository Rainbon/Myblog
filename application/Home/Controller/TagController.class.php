<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 2016/4/12
 * Time: 1:03
 */

namespace Home\Controller;


use Common\Controller\HomebaseController;
use Think\Page;

class TagController extends HomebaseController
{

    public function index()
    {
        $tag_id = M('Tags')->where(['name'=>I('name')])->getField('id');
        $post_ids = M('Tag_relationships')->where(array('tag_id'=>$tag_id))
            ->field('object_id')->select();
        $_post_ids = [];
        foreach ($post_ids as $value){
            $_post_ids[] = $value['object_id'];
        }
        $count = M('Posts')->where(['post_status'=>1,'id'=>array('in',$_post_ids)])->count();
        $Page = new Page($count,5);
        $pages = $Page->show();
        $posts = M('Posts')->where(['post_status'=>1,'id'=>array('in',$_post_ids)])
            ->order("post_date desc")
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();

        if($posts){
            foreach ($posts as $key => $value){
                $posts[$key]['author_name'] = M('Users')->where(['id'=>$value['post_author']])->getField('user_nicename');
                $posts[$key]['show_date']   = date('Y年m月d日',strtotime($posts[$key]['post_date']));
            }
        }


        $this->assign('pages',$pages);
        $this->assign('pn',$Page->getPn());
        $this->assign('tag',I('name'));
        $this->assign('posts',$posts);
        $this->display("Home:tag");
    }
}