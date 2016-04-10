<?php
$configs = array(
    'URL_MODEL'             => 2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    'TAGLIB_BUILD_IN' => THINKCMF_CORE_TAGLIBS . ',Home\Lib\Taglib\Home',
    'TMPL_TEMPLATE_SUFFIX' => '.html', // 默认模板文件后缀
    'TMPL_FILE_DEPR' => '/', // 模板文件MODULE_NAME与ACTION_NAME之间的分割符
    'HTML_CACHE_RULES' => array(
        // 定义静态缓存规则
        // 定义格式1 数组方式
        'article:index' => array('Home/article/{id}',600),
        'index:index' => array('Home/index',600),
        'list:index' => array('Home/list/{id}_{p}',60)
    ),
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES'=>array(
        'page/:id'     => 'Home/Index/index?page=:1',
        'article/:id'  => 'Home/Article/index?id=:1',
        'category/:id' => 'Home/Category/index?id=:1',

    )
);

return array_merge($configs);
