
<?php 
	 $this->registerSDK(array('getLocation','chooseImage','uploadImage'));
?>

<script type="text/javascript">


var photoid = 0;
var photolist = {};
var medialist = {};
var latitude;
var longitude;
wx.ready(function(){
	wx.getLocation({
	    success: function (res) {
	        latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
	        longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
	        var speed = res.speed; // 速度，以米/每秒计
	        var accuracy = res.accuracy; // 位置精度
	    }
	});
});

$(function(){
	function uploadPhoto(imgid){
		var pid = photoid;
		photolist[pid] = imgid;
		$('.photo-list .new-photo').before(
        	$('<img>').attr('src',imgid).attr('order',pid).addClass('uploading')
        );
        wx.uploadImage({
		    localId: imgid, // 需要上传的图片的本地ID，由chooseImage接口获得
		    success: function (res) {
		    	$('.photo-list>img[order='+pid+']').removeClass('uploading');
		        var serverId = res.serverId; // 返回图片的服务器端ID
		        medialist[pid] = res.serverId;
		    }
		});
        photoid++;
	}
	$('.new-photo').on('click',function(){
		wx.chooseImage({
		    success: function (res) {
		        var imgids = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
		        if(typeof imgids=='object'){
		        	for(var i in imgids){
		        		uploadPhoto(imgids[i]);
		        		break;
		        	}
		        }else
		        	uploadPhoto(imgids);
		    }
		});
	});

	$('.new-photo>img').on('click',function(){
		$(this).remove();
	});

	$('#submit').on('click',function(){
		$.ajax({
			url:'/gzh/policy/create',
			type:'POST',
			data:{
				mediaid:medialist,
				model:$('#model').val(),
				quote:$('#quote').val(),
				description:$('#description').val(),
				latitude:latitude,
				longitude:longitude
			},
			success:function(json){
				if(json.code==0){
					window.location = 'index';
				}else
					if(json.code==1)
						alert(json.msg);
						else 
							alert(JSON.stringify(json));
			},
			error:function(json){

				alert('error');
				alert(JSON.stringify(json));
			}
		});
	});
});

</script>

<!-- Form Begin -->
<div class="input-group">
	<h4>请添加事故图片，建议添加定损单照片</h4>
	<div class="photo-list">
		<button class="new-photo">+</button>
	</div>
</div>

<div class="input-group">
	<p>
		<label>车型</label>
		<input type="text" id="model" />
	</p>
	<hr/>
	<p>
		<label>定损金额</label>
		<input type="text" id="quote" />
	</p>
	<hr/>
	<p>
		<label>事故描述</label>
		<textarea id="description"></textarea>
	</p>
</div>

<button class="mbtn" id="submit">提交询价</button>
<!-- Form End -->



<style>

/*Form Begin*/
.input-group{
	margin-top:15px;
	padding-left:10px;
	background: #FFF;
	width: 100%;
	border-top:1px solid #e6e6e6;
	border-bottom:1px solid #e6e6e6;
	overflow: auto;
}
.input-group h4{font-size: 14px;
font-weight: 100;
color:#a6a6a6;
}
.photo-list{overflow: auto;}
.photo-list>*{
	float:left;
	width: 66px;
	height:66px;
	background: #FFF;
	border:1px solid #e5e5e5;
	margin-right:10px;
	margin-bottom:10px;
}
.photo-list>img.uploading{
	opacity: 0.2;
}
.photo-list .new-photo{
	color:#e5e5e5;
	text-align: center;
	font-size:28px;
}
.input-group p{line-height:40px;margin:0px; vertical-align: top;clear:both;overflow: auto;}
.input-group hr{margin:0px;float:left;width:100%;display: block;}
.input-group input[type=text]{
	border:none;
	font-size:16px;
	line-height:16px;
}
.input-group textarea{font-size:16px;border:none;line-height: 20px;padding-top:10px;width:calc(100% - 80px);height:80px;}
.input-group label{font-size:15px;float:left;color:#808080;font-weight: 400;display: inline-block;width:70px;}
.mbtn{
	width:80%;
	margin-left:10%;
	margin-right:10%;
	height:40px;
	border:none;
	color:#FFF;
	font-size:16px;
	background: #8bbc3a;
	margin-top:20px;
}
/*Form End*/
</style>



