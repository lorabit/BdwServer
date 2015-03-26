<a class="ios-item" href="/wxh5/policy/view?id=<?php echo $data->id;?>">
	<div class="title"><?php 
	echo htmlentities($data->policy->comment);
	?></div>
	<div class="detail">
	<?php echo date('m-d H:i',$data->created_at);?></div>
</a>