<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
		<?php 
$path = Yii::app()->assetManager->publish(Yii::getPathOfAlias('admin.assets'));
	?>
	<meta charset="utf-8" />
	<title><?php echo $this->pageTitle; ?></title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<style>
  body{
    background: #EEE;
  }
  .banner{
    float:left;
    margin-bottom:30px;
    width:100%;
    margin-top:-20px;
    color:#FFF;
    padding:30px 0px 30px 100px;
    background: linear-gradient(45deg, #143457 0%, #4E657E 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
    box-shadow: 0 3px 7px rgba(0, 0, 0, 0.2) inset, 0 -3px 7px rgba(0, 0, 0, 0.2) inset;
  }
  .banner p{font-size:1.5em;}
  .banner h1{}
  .banner h1 .img-rounded{
    position: relative;
    top:-3px;
    height:40px;
    margin-right:15px;
  }
  .panel{
    background: #FFF;
    border-radius: 10px;
    padding:20px;
    border:1px solid #EEE;
    overflow: auto;
    height:auto;
  }
  .navbar-brand .logo{height:20px;
    position: relative;
    top:-2px;
    margin-right:5px;
  }
</style>
</head>
<body>
	
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img class="logo" src="<?php echo $this->module->assetsUrl; ?>/images/logo.jpg"/>车安安 | 后台</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if($this->id=='dashboard'){?>class="active"<?php } ?>><a href="#"><span class="glyphicon glyphicon-dashboard"></span> 仪表盘</a></li>
        <li class="dropdown<?php if($this->id=='account'){?> active<?php } ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> 账号 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="/admin/account/create">创建</a></li>
            <li><a href="/admin/account/index">查询</a></li>
            <!-- <li class="divider"></li> -->
          </ul>
        </li> 
        <li class="dropdown<?php if($this->id=='policy'||$this->id=='bid'){?> active<?php } ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-file"></span> 档案 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="/admin/test/index">查询</a></li>
            <li><a href="/admin/testee/index">受试人</a></li>
          </ul>
        </li>
        <li class="dropdown<?php if($this->id=='sys'){?> active<?php } ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span> 系统 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="/admin/sys/wxqylog">微信回调日志</a></li>
          </ul>
        </li>

      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo Yii::app()->user->getState('email');?> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">编辑个人资料</a></li>
            <li class="divider"></li>
            <li><a href="/site/logout">登出</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

		<!-- begin #content -->
		<div id="content">
			 <?php echo $content; ?>
		</div>
		<!-- end #content -->
		
</body>
</html>
