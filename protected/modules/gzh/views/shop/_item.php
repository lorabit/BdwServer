<div class="coupon">
	<div class="store-name"><?php echo htmlentities($data->store->name);?></div>
	<div class="balance"><?php echo $data->balance;?>元<span class="balance-title">剩余金额</span></div>
	<button class="apply-coupon" type="button">立即使用</button>
</div>