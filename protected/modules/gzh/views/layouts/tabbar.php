<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name=”viewport” content=”width=device-width, initial-scale=1, maximum-scale=1″>
        <?php

    // $path = Yii::app()->assetManager->publish(Yii::getPathOfAlias('wxh5.assets'));
    // Yii::app()->clientScript->registerCssFile($path . '/css/mobile.css');
    ?>

        <title><?php echo $this->pageTitle?$this->pageTitle:'车安安'; ?></title>
    
        <style>
body{background: #f1f1f1;padding-bottom:120px;overflow: auto;height:auto;}
/*Tabbar Begin*/
    .tabbar{
        height:48px;
        width:100%;
        background: #2b3035;
        color:#FFF;
        position: fixed;
        bottom:0px;
        z-index:999999999999;
    }
    .tabbar-item {width:33.333%;float:left;text-align: center;font-size:10px;color:#FFF;}
    .tabbar-item:focus,.tabbar-item:hover,.tabbar-item:visited,.tabbar-item.active{color:#8bbc3a;text-decoration: none;}
    .tabbar-item .glyphicon {display: block;font-size:25px;margin-top:6px;margin-bottom:2px;}
    .tabbar-item .center{margin-top: -24px;
background: #2b3035;
display: inline-block;
padding: 27px 13px;
border-radius: 43px;}
    .tabbar-item .center .glyphicon{font-size: 19px;
border-radius: 39px;
background: #8bbc3a;
color: #FFF;
padding: 22px;
margin-top: -23px;}
/*Tabbar End*/

/*pagination*/

    .pagination-container{width:auto;margin:0px 5px 5px 5px;height:auto;margin-top:20px;float:right;}
    .pagination{
        display: block;
        float:left;
        height:30px;
        width:60px;
        line-height:30px;
        background: #FFF;
        border-radius: 3px;
        margin:0px;
        margin-right:5px;
        text-align: center;
        color:#F40;
        border:1px solid #CCC;
    }
    .pagination:hover{
        color:#FFF;
        background: #F40;
    }

    .pagination.disabled{color:#CCC;}
    .pagination.disabled:hover{color:#CCC;
        background: #FFF;cursor:default;}

        /*global*/

.list-view{padding:0px;}
*{font-family: Helvetica, Tahoma, Arial, STXihei, "华文细黑", "Microsoft YaHei", "微软雅黑", SimSun, "宋体", Heiti, "黑体", sans-serif;}
</style>
    </head>
    <body>
           
            <?php
            echo $content;
            ?>


<!-- Tabbar Begin -->
<div class="tabbar">
    <a class="tabbar-item" href="/gzh/policy/index"><span class="glyphicon glyphicon-time"></span>历史订单</a>
    <a class="tabbar-item" href="/gzh/policy/create"><span class="center"><span class="glyphicon glyphicon-plus"></span></a>
    <a class="tabbar-item" href="/gzh/shop/index"><span class="glyphicon glyphicon-gift"></span>商城</a>
</div>
<!-- Tabbar End -->

    </body>
</html>