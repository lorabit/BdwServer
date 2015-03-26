<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php

    // $path = Yii::app()->assetManager->publish(Yii::getPathOfAlias('wxh5.assets'));
    // Yii::app()->clientScript->registerCssFile($path . '/css/mobile.css');
    ?>

        <title><?php echo $this->pageTitle?$this->pageTitle:'车安安'; ?></title>
        <style type="text/css">


body{background: #f1f1f1;overflow: auto;height:auto;}
</style>
    </head>
    <body>
           
            <?php
            echo $content;
            ?>

    </body>
</html>