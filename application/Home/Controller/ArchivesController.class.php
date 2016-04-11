<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 2016/4/12
 * Time: 1:30
 */

namespace Home\Controller;


use Common\Controller\HomebaseController;
use Think\Page;

class ArchivesController extends HomebaseController
{

    public function index()
    {
        $date = strtotime(I('year').'-'.I('month'));
        $endDate = strtotime('+1 month',$date);
        $_date = date('Y-m-d H:i:s',$date);
        $_endDate = date('Y-m-d H:i:s',$endDate);
        $count = M('Posts')
            ->where(['post_status'=>1,'post_date'=>['between',[$_date,$_endDate]]])
            ->count();
        //var_dump(M('Posts')->getlastSql());
        $Page = new Page($count,5);
        $pages = $Page->show();
        $posts = M('Posts')
            ->where(['post_status'=>1,'post_date'=>['between',[$_date,$_endDate]]])
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
        $this->assign('date',I('year').'年'.I('month'));
        $this->assign('posts',$posts);
        $this->display("Home:archives");
    }
}