<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 2016/4/12
 * Time: 12:22
 */

namespace Home\Widget;


use Comment\Controller\WidgetController;

class FooterWidget extends WidgetController
{
    public function tagCloud()
    {
        $data = M('Tags')->limit(12)->select();
        $this->assign('data',$data);
        $this->display('Home:Widget:tagCloud');
    }
}