<h4 class="title">车安安 － 账户关联</h4>
<form method="post">
<div class="input-group">
	<p><input id="phone" name="phone" type="text" class="text-box" placeholder="手机号" value="<?php echo htmlentities($_POST['phone']);?>"/></p>
	<p class="divider"></p>
	<p><input id="password" name="password" type="password" class="text-box" placeholder="密码"/></p>
</div>

<button class="mbtn" type="submit">注册账号</button>
<button class="mbtn" type="submit">关联账号</button>
<h4 class="title"><?php echo $msg; ?></h4>
</form>
<style>
body{
	background: #E8E8E8;
	padding:10px;
}
.title {
	margin-left:5%;
}
.input-group{
	border-radius: 10px;
	border:1px solid #CCC;
	width:90%;
	margin-left:5%;
	margin-right:5%;
	background: #FFF;
	padding:5px 10px;
}
.input-group p{margin:0px;}
.input-group .divider{border-bottom: 1px solid #CCC;width:100%;}
.input-group .text-box{
	background: none;
	border:none;
	width: 100%;
	font-size:16px;
	line-height:35px;
	padding-left:10px;
}
.mbtn{
	background: #F40;
	color:#FFF;
	border:1px;
	border-radius: 10px;
	padding:10px;
	margin-top:10px;
	margin-left:5%;
	width:90%;
	margin-right:5%;
}
</style>