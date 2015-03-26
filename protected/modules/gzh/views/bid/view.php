<?php 
	$map = new Amap();
	$map->params = array(
		'location' => $store->longitude.','.$store->latitude,
		'zoom' => 13,
		'markers' => 'mid,0x8bbc3a,A:'.$store->longitude.','.$store->latitude,
		'size' => '480*250'
	);	
?>

<div class="map">
<?php echo '<img src="'.$map->getRestUrl().'" />'; ?>
<div class="content">
	<div class="store-name"><?php echo htmlentities($store->name);?></div>
	<div class="service-list"><span><?php echo $bid->time;?>天</span><?php if($bid->pickup==1){?><span>接车</span><?php } ?></div>
</div>
</div>
<div class="tab-title">
	<button class="active" id="btn-tab-description">介绍<span class="triangle"><span></span></span></button>
	<!-- <button>图集</button> -->
	<button id="btn-tab-comment">评价<span class="triangle"><span></span></span></button>
</div>
<div id="tab-description" class="tab-body">
	<div class="basic-info">
		<div class="store-name"><?php echo htmlentities($store->name);?></div>
		<div class="quote"><span class="price">&#65509;<?php echo htmlentities($bid->price);?></span><span class="tag">报价</span></div>
	</div>
	<div class="details">
		<p>
			<label>商家电话</label>
			<span><?php echo htmlentities($store->phone);?></span>
		</p>
		<p>
			<label>商家地址</label>
			<span><?php echo htmlentities($store->address);?></span>
		</p>
		<p>
			<label>好评率</label>
			<span><?php echo $store->goodRate;?></span>
		</p>
		<p>
			<label>修车用时</label>
			<span>平均<?php echo htmlentities($store->fix_time);?>天</span>
		</p>
		<p>
			<label>其他服务</label>
			<span><?php echo htmlentities($store->service);?></span>
		</p>
	</div>
</div>

<div id="tab-comment" class="tab-body">
	<?php 
		$sql = "select id from PolicyPush where store_id=".$store->id." and rate is not null and status=".PolicyPush::STATUS_COMMENTED." order by updated_at desc limit 0,20";
		$res = Yii::app()->db->createCommand($sql)->queryAll();
		$ids = array();
		foreach ($res as $row) {
			$ids[] =  $row['id'];
		}
		$comments = array();
		if(count($ids)>0)
			$comments = PolicyPush::model()->findAll('id in ('.implode(',', $ids).')');
		foreach ($comments as $comment) {
			echo '<div class="comment">
			<div class="avatar"><img src="'.$comment->policy->user->getAvatar().'"/></div>
			<div class="content">'.htmlentities($comment->comment).'</div>
			<div class="stars" data-rate="'.$comment->rate.'"><div class="datetime">'.$comment->updated_at.'</div></div>
			
			</div>';
		}
	?>
</div>

<div class="bottom-bar">
	<div class="store-price">
		<label>商家报价</label>
		<span>&#65509;<?php echo htmlentities($bid->price);?></span>
	</div>
	<?php 

		if($bid->status == PolicyPush::STATUS_SENT)
			echo '<button class="btn-processing">评估中</button>';
		if($bid->status == PolicyPush::STATUS_QUOTED)
			echo '<button class="btn-pay">立即付款</button>';
		
		if($bid->status == PolicyPush::STATUS_PAID)
			echo '<button class="btn-processing">请到店处理</button>';
		
		if($bid->status == PolicyPush::STATUS_DONE)
			echo '<button class="btn-comment">点击评价</button>';
		if($bid->status == PolicyPush::STATUS_COMMENTED)
			echo '<button class="btn-processing">已评价</button>';

	?>
</div>

<div class="comment-cover">
	<form class="comment-form" method="post" action="comment?id=<?php echo $bid->id; ?>">
		<p><label>服务星级</label><input type="hidden" id="rate" name="rate" value="1" /><span class="star-control stars"><?php 
		for($i=1;$i<=5;$i++)
			if($i==1)
				echo '<span data-order="'.$i.'" class="glyphicon glyphicon-star"></span>';
			else
				echo '<span data-order="'.$i.'" class="glyphicon glyphicon-star-empty"></span>';
		?></span></p>
		<p class="textarea"><textarea placeholder="评价内容" name="comment"></textarea></p>
		<div class="btns"><button type="button" class="cancel-comment">取消评价</button><button type="submit" class="submit-comment">提交评价</button></div>
	</form>
</div>
<script type="text/javascript">
	var bid_id = <?php echo $bid->id; ?>;

	$(function(){
		var hash = location.hash;
		if(hash=="#!description"||hash=='')
			loadDescription();
		if(hash=='#!comment')
			loadComment();
		$('.btn-pay').on('click',function(){
			window.location = '/gzh/bid/pay?id='+bid_id;
		});
		$('.btn-comment').on('click',function(){
			$('.comment-cover').show();
		});
		$('.cancel-comment').on('click',function(){
			$('.comment-cover').hide();
		});
		$('.star-control>span').on('click',function(){
			var order = $(this).attr('data-order');
			$('#rate').val(order);
			$('.star-control>span').each(function(i,e){
				if($(e).attr('data-order')<=order)
					$(e).removeClass('glyphicon-star-empty').addClass('glyphicon-star');
				else
					$(e).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
			});
		});
		$('.comment .stars').each(function(i,e){
			var rate = $(e).attr('data-rate');
			for(var i=0;i<rate;i++){
				$(e).append('<span class="glyphicon glyphicon-star"></span>');
			}
		});
		$('#btn-tab-comment').on('click',function(){
			loadComment();
		});

		$('#btn-tab-description').on('click',function(){
			loadDescription();
		});
	});

	function loadComment(){
		$('.tab-title button').removeClass('active');
		$('#btn-tab-comment').addClass('active');
		$('.tab-body').hide();
		$('#tab-comment').show();
		location.hash = '#!comment';
	}
	

	function loadDescription(){
		$('.tab-title button').removeClass('active');
		$('#btn-tab-description').addClass('active');
		$('.tab-body').hide();
		$('#tab-description').show();
		location.hash = '#!description';
	}
	
</script>
<style type="text/css">
body{padding-bottom:45px;}

/*map*/
	.map{width:100%;position: relative;;}
	.map .content{

	 /* Safari 4-5, Chrome 1-9 */
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(rgba(0,0,0,0)), to(rgba(0,0,0,0.7)));

  /* Safari 5.1, Chrome 10+ */
  background: -webkit-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,0.7));

  /* Firefox 3.6+ */
  background: -moz-linear-gradient(top,rgba(0,0,0,0), rgba(0,0,0,0.7));

  /* IE 10 */
  background: -ms-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,0.7));

  /* Opera 11.10+ */
  background: -o-linear-gradient(top,rgba(0,0,0,0), rgba(0,0,0,0.7));
  width:100%;
  height:60px;
  position: absolute;
  bottom:0px;
  left:0px;
  z-index:999;
  padding:13px 0px 0px 10px;
	}
	.map .content .store-name{color:#FFF;}
	.map .service-list>span{
		color:#FFF;
		background: #F40;
		padding:1px 8px;
		font-size:11px;
		border-radius: 5px;display: inline-block;margin-right:5px;
	}
	.map img{width:100%;}
/*tab*/
.tab-title{width:100%;height:auto;overflow: auto;background: #8bbc3a;}
.tab-title>*{position:relative;font-weight:100;height:45px;line-height:45px;font-size:15px;width:50%;display: block;float:left;color:#DEDEDE;text-align: center;background: #8bbc3a;border:none;border-right:1px solid #a2c961;}
.tab-title .active{color:#FFF;}
.tab-title .triangle{
	height:14px;width:14px;position: absolute;bottom:-8px;left:50%;
	display: none;
}
.tab-title .active .triangle{display: block;}
.tab-title .triangle>*{filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=1);
	-moz-transform: rotate(45deg);
	-o-transform: rotate(45deg);
	-webkit-transform: rotate(45deg);
	transform: rotate(45deg);
background: White;height:14px;width:14px;display: block;
margin-left:-8px;
}

/*description*/
.basic-info{background: #FFF;width:100%;overflow: auto;height:auto;border-bottom:1px solid #f7f7f7;padding:12px;}
.basic-info .store-name{font-size:22px;color:#333;line-height:40px;}
.basic-info .quote{line-height:32px;}
.basic-info .quote .price{font-size:22px;color:#ee4e2f;float:left;}
.basic-info .quote .tag{float:left;line-height:18px;margin-top:6px;background: #ee4e2f;color:#FFF;padding:1px 6px;margin-left:5px;border-radius: 5px; font-size:12px;}

.details{padding:0px 12px;background: #f7f8f7;}
.details p{line-height:45px;border-bottom:1px solid #ececec;font-size:15px;clear:both;margin:0px;overflow: visible;padding:0px;height:45px;}
.details p label{font-weight: normal;color:#9a9a9b;float:left;}
.details p span{float:right;}

/*bottombar*/

.bottom-bar{
	height:45px;
	width:100%;
	position: fixed;
	bottom:0px;
	left:0px;
	background: rgba(255,255,255,0.9);
	line-height:45px;
	/*border-top:1px solid #e7e7e7;*/
	-moz-box-shadow:0px -3px 5px #CCC;              
    -webkit-box-shadow:0px -3px 5px #CCC;           
    box-shadow:0px -3px 5px #CCC; 
}
.bottom-bar .store-price{width:50%;float:left;padding:0px 12px;}
.bottom-bar .store-price label{font-weight: normal;color:#9a9a9b;float: left;font-size:14px;}
.bottom-bar .store-price span{font-size:22px;color:#ee4e2f;float:right;}
.bottom-bar .btn-pay, .btn-comment{background: #f75000;border:none;width:50%;color:#FFF;font-size:20px;padding:0px;
	line-height:45px;}

.btn-processing{background: #ffB060;border:none;width:50%;color:#FFF;font-size:20px;padding:0px;
	line-height:45px;}

/*comment form*/
.comment-cover{
display: none;
	position: fixed;top:0px;left:0px;height:100%;width:100%;background: rgba(255,255,255,0.8);z-index: 9998;}
.comment-form{
	width:100%;
	background: rgba(255,255,255,0.9);
	position: fixed;
	top:0px;
	z-index:9999;
	/*bottom:45px;*/
	min-height:100px;
	-moz-box-shadow:0px 3px 5px #CCC;              
    -webkit-box-shadow:0px 3px 5px #CCC;           
    box-shadow:0px 3px 5px #CCC; 
}
.comment-form>p{
	line-height:45px;border-bottom:1px solid #ececec;font-size:15px;clear:both;margin:0px;overflow: visible;padding:0px 10px;height:auto;float:left;width:100%;
}
.comment-form>p label{float:left;font-size:14px;color:#999;font-weight: normal;}
.comment-form>p .stars{float:right;}
.comment-form>p .stars>span{font-size: 22px;margin-left:3px;top:4px;color:#CCC;}
.comment-form>p .stars>span.glyphicon-star{color:#f40;}
.comment-form>p textarea{width:100%;margin-top:10px;margin-bottom:10px;height:80px;line-height:20px;font-size:16px;border:none;background: none;}
.comment-form .btns{width:100%;}
.comment-form .btns>button{width:50%;border:none;height:45px;font-size:16px;}
.submit-comment{background: #8bbc3a;color:#FFF;}
.cancel-comment{background: #FFF;color:#999;}

/*comment list*/
.comment{width:100%;padding:10px;border-bottom:1px solid #CCC;background: #FFF;overflow: auto;}
.comment .avatar{float:left;width:100px;padding:10px;}
.comment .avatar img{width:100%;border-radius: 50px;}
.comment .content{margin-top:10px;font-size:18px;color:#666;height:55px;overflow: hidden;width:100%;margin-left:-100px;padding-left:100px;float:left;}
.comment .datetime{float:right;text-align:right;font-size:15px;color:#999;/*width:100%;margin-left:-100px;*/}
.comment .stars{line-height: 22px;}
.comment .stars span{margin-right:2px;font-size:20px;color:#8bbc3a;float:left;}
</style>




