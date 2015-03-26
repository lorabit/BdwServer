<script type="text/javascript" src="/themes/classic/assets/js/distance.js">
</script>

<?php 
	 $this->registerSDK(array('getLocation','chooseImage','uploadImage'));
?>

<script type="text/javascript">

var latitude;
var longitude;
wx.ready(function(){
	wx.getLocation({
	    success: function (res) {
	        latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
	        longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
	        var speed = res.speed; // 速度，以米/每秒计
	        var accuracy = res.accuracy; // 位置精度
	        render_distance(longitude,latitude);
	    }
	});
});

</script>
<div class="topbar">
	<a class="leftSide" href="index?id=<?php echo $policy->id;?>&order=time">
	 	时间由近到远<?php if($order=='time') echo '<div class="triangle"></div>';?>
	</a>
	<a class="rightSide" href="index?id=<?php echo $policy->id;?>&order=price">
	     价格由低到高<?php if($order=='price') echo '<div class="triangle"></div>';?>
	</a>
</div>

<?php

    $blockView = $this->createWidget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        //'ajaxUpdate' => 'build-list-container',
        //'updateSelector' => '#build-list-container .pagination',
        //'htmlOptions' => array('class' => 'widget-view', 'style' => 'overflow:auto'),
        //'itemsCssClass' => 'build-items',
        'template' => '{items}',
        'itemView' => '_item',
    ));
    $pagination = $dataProvider->getPagination();
    $currentPage = $pagination->getCurrentPage() + 1;
    $pageCount = $pagination->getPageCount();
    $itemCount = $pagination->getItemCount();
    $pageSize = $pagination->getPageSize();

    $start = ($currentPage - 1) * $pageSize + 1;
    $count = min($pageSize, ($itemCount - $start + 1));
    $end = $start + $count - 1;
?>

<?php 
    // echo '<div class="pagination-container">';
    // echo '<a class="pagination previous' . ($currentPage==1?' disabled':'') . '" href="/crowd/mobile/index/Task_page/' . ($currentPage==1?1:$currentPage-1) . '"><span class="glyphicon glyphicon-chevron-left"></span></a>';
    // echo '<a class="pagination next' . ($currentPage==$pageCount?' disabled':'') . '" href="/crowd/mobile/index/Task_page/' . ($currentPage==$pageCount?$currentPage:$currentPage+1) . '"><span class="glyphicon glyphicon-chevron-right"></span></a>';

    // echo '</div>';
   ?>
<?php 
    $blockView->run(); 
?>
<?php 
    echo '<div class="pagination-container">';
    echo '<a class="pagination previous' . ($currentPage==1?' disabled':'') . '" href="index?id='.$policy->id.'&PolicyPush_page=' . ($currentPage==1?1:$currentPage-1) . '"><span class="glyphicon glyphicon-chevron-left"></span></a>';
    echo '<a class="pagination next' . ($currentPage==$pageCount?' disabled':'') . '" href="index?id='.$policy->id.'&PolicyPush_page=' . ($currentPage==$pageCount?$currentPage:$currentPage+1) . '"><span class="glyphicon glyphicon-chevron-right"></span></a>';

    echo '</div>';
 ?>


<style type="text/css">

.haop{color:black}
body{margin:0px;
	font-family: "SimHei";
}


.topbar{height:46px;width:100%;font-size:18px;text-align: center;line-height:46px;}
.topbar>*{
	color:white;background-color:rgb(139,189,58);width:50%;float:left;position: relative;;overflow: hidden;display: block;
}
.topbar>*:hover,.topbar>*:visited{
	color:white;text-decoration: none;
}
.leftSide {
	border-right:1px solid rgb(157,203,79);
}
.rightSide{
	
}
.triangle{
	filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=1);
	-moz-transform: rotate(45deg);
	-o-transform: rotate(45deg);
	-webkit-transform: rotate(45deg);
	transform: rotate(45deg);
	background: White;height:14px;width:14px;position: absolute;bottom:-8px;right:50%;
}

.leftinfo{height:95px;width:85px;float:left;
}

.price{text-align: center;color:rgb(219,87,13);font-size:18px;font-family: "Arial";line-height:30px;}
small{font-size:16px;margin-left:3px;}
.leftinfo1{
	
}
.minik{
	color:rgb(219,87,13);font-size:5px;
}
.distance{
	color:white;width:60px;height:15px;font-size:12px;line-height:16px;background-color:rgb(78,156,231);float:left;border-radius:20px;
	text-align:center;margin-top: 6px;margin-left:13px;
}


.rightinfo{float:left; overflow:auto;width:auto;
}

.title{
	color:black;font-size:20px;padding-top:3px;margin-left:10px;height:30px;color:#333;
}

.comment{
	line-height:20px;margin-top:10px;width:100%;display: block;
}
.good-rate{
	color:rgb(248,155,48);float:left;margin-left:10px
}

.total-comment{
	color:rgb(128,128,128);float:left;width:130px;margin-left:10px;
}

.haop{
	color:rgb(128,128,128);
}
.service-tag{color:white;background-color:rgb(249,133,76);width:30px;height:17px;border-radius:2px;line-height:17px;
	font-size:10px;text-align:center;float:left;margin-top:7px;margin-left: 10px;

}

.address{
	font-size:15px;width:200px;margin-left:10px;color:rgb(128,128,128);
}

#xiaoyu{
	color:rgb(222,222,222);font-size:50px;padding-left:85%;float:right;
	position: absolute;right: 18px;top: 30px;
}

.maiguo{
	color:white;background-color:rgb(185,215,137);width:50px;position:absolute;bottom:88px;margin-left: 230px;text-align: right;
}
.item{border-bottom:1px solid #D5D5D5;overflow: auto;padding-top:10px;position: relative;background: #FFF;width:100%;display: block;}

</style>