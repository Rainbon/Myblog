<?php
// +----------------------------------------------------------------------
// | 夜色空凝 - 彩虹 [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://ch.yeskn.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Home\Controller;
use Common\Controller\HomebaseController;
use Think\Page;

/**
 * 首页
 */
class IndexController extends HomebaseController {
	
    //首页
	public function index() {


		$count = M('Posts')->where(['post_status'=>1])->count();
		$Page = new Page($count,5);
		$pages = $Page->show();
		$posts = M('Posts')->where(['post_status'=>1])->order("post_date desc")
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

        $this->assign('posts',$posts);
    	$this->display("Home:index");
    }

	public function about(){
		$this->display("Home:about");
	}

	public function avatar()
	{
		$id = I('id');
        $image = file_get_contents("http://static.yeskn.com/avatar/".$id.".jpg");  //假设当前文件夹已有图片001.jpg
        header('Content-type: image/jpg');
        echo $image;
        die();
	}

    public function test(){
        $this->display('Home:test');
    }

}


