<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 2016/4/13
 * Time: 12:26
 */

namespace Home\Controller;


use Common\Controller\HomebaseController;
use Think\Page;

class AuthorController extends HomebaseController
{
    public function index()
    {
        if(preg_match('/^\d+$/',I('name'))){
            $where = array('post_author'=>I('name'));
        }
        else
        {
            $author_id = M('Users')->where(array('user_nicename'=>I('name')))->getField('id');
            $where = array('post_author'=>$author_id);
        }

        $where = array_merge($where,array('post_status'=>1));
        $count = M('Posts')->where($where)->count();
        $Page = new Page($count,5);
        $pages = $Page->show();
        $posts = M('Posts')->where($where)->order("post_date desc")
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
        $this->assign('author',I('name'));
        $this->assign('posts',$posts);
        $this->display("Home:author");

    }
}