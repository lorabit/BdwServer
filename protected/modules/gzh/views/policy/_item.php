<a class="item" href="/gzh/bid/index?id=<?php echo $data->id;?>">
	<div class="leftSide">
		<div class="icon"><img src="<?php echo $data->iconurl;?>"></div>
		<div class="status"><span><?php echo $data->getStatusLabel($data->status);?></span></div>
	</div>
	<div class="rightSide">
		<div class="description"><?php echo htmlentities($data->comment);?></div>
		<div class="time">询价时间：<?php echo date('Y-m-d H:i:s',$data->created_at);?></div>
		<div class="detail">定损价格：<span class="price"><?php echo $data->quote;?></span> 车型：<?php echo $data->car_model;?></div>
	</div>
</a>