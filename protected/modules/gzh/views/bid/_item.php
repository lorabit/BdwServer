<a class="item" href="/gzh/bid/view?id=<?php echo $data->id; ?>">
	<div class="leftinfo">
		<div class="price">
			<span>
				<?php echo isset($data->price)?$data->price:'暂未出价';?>
			</span>
		</div>
		<span class="service-tag">
			<?php echo $data->time; ?>天
		</span>
		<?php if($data->pickup==1){?>
		<span class="service-tag">
			接车
		</span>
		<?php }?>
		<span class="distance geo-distance" data-longitude="<?php echo $data->store->longitude;?>" data-latitude="<?php echo $data->store->latitude;?>">
			   加载中
		</span>
	</div>
	<div class="rightinfo">

		<div class="title">
			<?php echo htmlentities($data->store->name);?>
		</div>
		<div class="comment">
			<div class="good-rate">
				<?php echo $data->store->goodRate;?><span class="haop">好评</span>
			</div>
			<div class="total-comment">
				<?php echo $data->store->comment_good+$data->store->comment_bad;?>人评价
			</div>
		</div>
    	<div class="address">
			西湖区某某路某某街道128号
		</div>
	</div>
</a>