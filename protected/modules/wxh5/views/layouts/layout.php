<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon" /> -->
        <?php

    $path = Yii::app()->assetManager->publish(Yii::getPathOfAlias('wxh5.assets'));
    Yii::app()->clientScript->registerCssFile($path . '/css/mobile.css');
    ?>

        <title><?php echo $this->pageTitle?$this->pageTitle:'车安安'; ?></title>
    </head>
    <body>
            <div class="tabbar">
                <!-- <a class="tab<?php if($this->action->id=="home") echo " active";?>" href="/crowd/mobile/home"><span class="glyphicon glyphicon-home"></span>MBOX</a> -->
                <a class="tab<?php if($this->id=="policy"&&$this->action!='bid') echo " active";?>" href="/wxh5/policy/index"><span class="glyphicon glyphicon-th-list"></span>保单</a>
                <a class="tab<?php if($this->id=="policy"&&$this->action->id=='bid') echo " active";?>" href="/wxh5/policy/bid"><span class="glyphicon glyphicon-flash"></span>出价</a>
                <a class="tab<?php if($this->id=="store") echo " active";?>" href="/wxh5/store/index"><span class="glyphicon glyphicon-stats"></span>商铺</a>
                <!-- <a class="tab"><span class="glyphicon glyphicon-th"></span>返回内外</a> -->
           </div>
           <div style="margin-bottom:60px;width:100%;float:left;">
            <?php
            echo $content;
            ?>
        	</div>

    </body>
</html>