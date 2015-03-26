<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title><?php echo $this->pageTitle;?></title>
            <?php 
$path = Yii::app()->assetManager->publish(Yii::getPathOfAlias('admin.assets'));
    ?>
	
</head>
<body>
	<div id="content">
			 <?php echo $content; ?>
		</div>
</body>
</html>
