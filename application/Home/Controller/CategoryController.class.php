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
 * 文章列表
*/
class CategoryController extends HomebaseController {

	//文章内页
	public function index() {
		$term=sp_get_term($_GET['id']);
		
		if(empty($term)){
		    header('HTTP/1.1 404 Not Found');
		    header('Status:404 Not Found');
		    if(sp_template_file_exists(MODULE_NAME."/404")){
		        $this->display(":404");
		    }
		    	
		    return ;
		}
		
		$tplname=$term["list_tpl"];
    	$tplname=sp_get_apphome_tpl($tplname, "list");
    	$this->assign('term',$term);
    	$this->assign('cat_id', intval($_GET['id']));
        //$child_term = M('Nav')->where(['parentid'=>$term['term_id']])->getField('id');
        $postIdArray = M('Term_relationships')->where(array('term_id'=>$term['term_id']))->field('object_id')->select();
        $post_ids = array();
        foreach ($postIdArray as $key => $value){
            $post_ids[] = $value['object_id'];
        }
        if(!$post_ids)
        {
            $post_ids = ['0'];
        }
        
        $count = M('Posts')->where(['post_status'=>1,'id'=>array('in',$post_ids)])->count();
        $Page = new Page($count,5);
        $pages = $Page->show();
        $posts = M('Posts')->where(['post_status'=>1,'id'=>array('in',$post_ids)])->order("post_date desc")
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
    	$this->display("Home:$tplname");
	}
	
	public function nav_index(){
		$navcatname="文章分类";
		$datas=sp_get_terms("field:term_id,name");
		$navrule=array(
				"action"=>"List/index",
				"param"=>array(
						"id"=>"term_id"
				),
				"label"=>"name");
		exit(sp_get_nav4admin($navcatname,$datas,$navrule));
		
	}
	
}
