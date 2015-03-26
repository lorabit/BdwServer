<!-- <h4 style="padding:10px 0px 0px 10px;">订单信息</h4>
<div class="ios-list">

	<div class="ios-item">
		<div class="title"><?php echo $policy->created_at; ?></div>
		<div class="detail">创建时间</div>
	</div>
<?php
	$photos = Photo::model()->findAll('policy_id='.$policy->id);
	foreach ($photos as $photo) {
		echo '<div class="ios-item"><div class="single text-center"><img src="'.$photo->getUrl().'" class="img-responsive img-rounded" style="width:100%;"/></div></div>';
	}
?>
	<div class="ios-item">
		<div class="single"><div class="col-xs-6"><input type="text" class="form-control" placeholder="价格，单位：元。例如100元，输入：“100”" /></div><div class="col-xs-6"><button class="btn btn-success">接单</button> <button class="btn btn-danger">拒绝</button></div></div>
	</div>
</div> -->

<div class="photo-list">
	<?php
	$photos = Photo::model()->findAll('policy_id='.$policy->id);
	foreach ($photos as $photo) {
		echo '<div class="photo"><img src="'.$photo->getUrl().'" class="img-responsive" style="width:100%;"/></div>';
	}
?>
</div>

<div class="comment">
<?php 
	echo $policy->comment;
?>
</div>

<div class="input-group">
	<p><input type="text" placeholder="金额" id="price" /></p>
	<hr/>
	<p><input type="text" placeholder="维修天数" id="time" /></p>
	<hr/>
	<p><label>是否派车接</label><span class="switch"><?php
$this->widget(
    'booster.widgets.TbSwitch',
    array(
        'name' => 'testToggleButtonB',
        'options' => array(
            'size' => 'normal', //null, 'mini', 'small', 'normal', 'large
            'onColor' => 'success', // 'primary', 'info', 'success', 'warning', 'danger', 'default'
            'offColor' => 'danger',  // 'primary', 'info', 'success', 'warning', 'danger', 'default'
        ),
    )
);
	?></span></p>
</div>

<?php 
if($push->policy->status==Policy::STATUS_OPEN){
?>
<button class="input-group" id="submit">
立刻抢单
</button>
<?php
} 

if($push->status==PolicyPush::STATUS_QUOTED){
?>
<button class="input-group" id="submit">
修改订单
</button>
<?php
} 

if($push->status==PolicyPush::STATUS_PAID){
?>
<button class="input-group" id="service-end">
完成服务
</button>
<?php
} 

if($push->status==PolicyPush::STATUS_DONE){
?>
<button class="input-group disabled">
等待用户评价
</button>
<?php
} 

if($push->status==PolicyPush::STATUS_COMMENTED||$push->policy->status==Policy::STATUS_CLOSED){
?>
<button class="input-group disabled">
流程结束
</button>
<?php
} 
?>


<div id="finished-container">
	<div class="panel" id="success-panel">
		<p class="text-center ok-icon"><span class="glyphicon glyphicon-ok"></span></p>
		<p style=""><h4 class="text-center" style="color:#777;margin-bottom:20px;">提交成功！。</h4></p>
		<p class="text-center"><a class="btn btn-default" href="/wxh5/policy/index">返回订单列表</a> </p>
	</div>
	<div class="panel" id="fail-panel">
		<p class="text-center fail-icon"><span class="glyphicon glyphicon-remove"></span></p>
		<p style=""><h4 class="text-center msg" style="color:#777;margin-bottom:20px;"></h4></p>
		<p class="text-center"><button class="btn btn-primary" onclick="closePanel()">好的</button></p>
	</div>
	<div class="panel" id="ban-panel">
		<p class="text-center ban-icon"><span class="glyphicon glyphicon-ban-circle"></span></p>
		<p style=""><h4 class="text-center" style="color:#777;margin-bottom:20px;">该任务暂时没有待标注的数据了，请尝试其他任务。</h4></p>
		<p class="text-center"><a class="btn btn-default" href="/crowd/mobile/index">返回任务列表</a> <a class="btn btn-default" href="/crowd/mobile/gettask"><span class="glyphicon glyphicon-flash"></span> 快速开始</a></p>
	</div>
</div>


<style type="text/css">
body{background: #E8E8E8;}
	.comment{margin-top:15px;background: #FFF;float:left;padding:10px 10px;width:100%;}
	.photo-list{margin-top:15px;background: #FFF;float:left;padding:10px 0px;width:100%;}
	.photo{width:calc(50% - 20px);margin:5px;float:left;max-height:200px;overflow: hidden;border-radius: 10px;}
	.input-group {border:1px solid #CCC;width:90%;margin: auto;margin-top:20px;margin-left:5%;float:left;background: #FFF;border-radius: 10px;padding:0px 10px;}
	.input-group input{border:none;width:100%;font-size:16px;line-height:30px;height:30px;margin-top:7px;margin-bottom:7px;padding-left:10px;}
	.input-group p{margin:0px;padding:0px;height:44px;vertical-align: middle;line-height:44px;}
	.input-group hr{margin:0px;}
	.input-group label{font-size:16px;color:#666;padding-left:10px;font-weight: normal;}
	.input-group .switch{
	    /*margin-top: 1px;*/
	    float: right;
	}
	button.input-group{
		background: #F40;
		color:#FFF;
		border:1px #F40 solid;
		height:44px;
		line-height:44px;
		font-size:16px;
	}
	.input-group.disabled{
		background: #ffB060;
		border:1px solid #ffB060;;
	}

#finished-container{
		width:100%;
		height:100%;
		position: absolute;;
		top:0px;
		left:0px;
		z-index:100000;
		background: rgba(100,100,0,0.1);
		display: none;
	}
	#finished-container .panel{
		width:80%;
		padding:10px;
		background: #FFF;
		min-height: 200px;
		margin:auto;
		margin-top:50px;
		border-radius: 5px;
		display: none;
	}
	.ok-icon{font-size:60px;color:#5cb85c;}
	.fail-icon{font-size:60px;color:#d9534f;}
	.ban-icon{font-size:60px;color:#f0ad4e;}
	#main-container.blur{
    
    -webkit-filter: blur(5px); /* Chrome, Opera */
       -moz-filter: blur(5px);
        -ms-filter: blur(5px);    
            filter: blur(5px);
    
    filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius=5, MakeShadow=false); /* IE6~IE9 */
	}

</style>
<script type="text/javascript">
var push_id = <?php echo $push->id;?>;
$('#submit').on('click',function(){
	'use strict';
	var price = $('#price').val();
	var time = $('#time').val();
	var pickup = $('.bootstrap-switch-on').length;
	if(price==''){
		showError('金额不能为空！');
		return;
	}
	if(time==''){
		showError('维修天数不能为空！');
		return;
	}
	if(parseInt(time)!=time){
		showError('维修天数必须为整数！');
		return;
	}

	if(parseInt(price)!=price){
		showError('金额必须为整数！');
		return;
	}

	$.ajax({
		url:'/wxh5/policy/submit',
		type:'POST',
		data:{
			id: push_id,
			price: price,
			time: time,
			pickup: pickup
		},
		success:function(json){
			showSuccess();
		}
	});
});

$('#service-end').on('click',function(){
	window.location = 'done?id='+push_id;
});

function showError(msg){
    $('#main-container').addClass('blur');
    $('#fail-panel .msg').text(msg);
    $('#finished-container').css({background:'rgba(100,0,0,0.1)'}).fadeIn();
    $('#fail-panel').slideDown();
}
function showSuccess(){
    $('#main-container').addClass('blur');
    $('#finished-container').css({background:'rgba(0,100,0,0.1)'}).fadeIn();
    $('#success-panel').slideDown();
}
function showBan(){
    $('#main-container').addClass('blur');
    $('#finished-container').css({background:'rgba(100,100,0,0.1)'}).fadeIn();
    $('#ban-panel').slideDown();
}

function closePanel(){
    $('#main-container').removeClass('blur');
    $('#finished-container').fadeOut();
    $('#fail-panel').slideUp();
    $('#success-panel').slideUp();
    $('#ban-panel').slideUp();
}
</script>