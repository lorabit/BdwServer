

<div class="banner">
		<h1><?php if($model->isNewRecord){
			echo '创建店铺';
		}else{
			if(!empty($model->icon))
				echo '<img src="'.$model->icon.'" class="img-rounded"/>';
			echo htmlentities($model->name);
		}
		?></h1>
		<p>店铺管理</p>
	
</div>
<?php


/** @var TbActiveForm $form */
$form = $this->beginWidget(
    'booster.widgets.TbActiveForm',
    array(
        'id' => 'verticalForm',

    'type' => 'horizontal',
        'htmlOptions' => array('class' => ''), // for inset effect
    )
);
?>
<div class="col-md-7 col-lg-6 col-lg-offset-1">
<div class="panel">
	<legend>基本信息</legend>
		<?php


 
echo $form->textFieldGroup($model, 'name');
echo $form->textFieldGroup($model, 'user_id');
echo $form->textFieldGroup($model, 'icon');
echo $form->textFieldGroup($model, 'longitude');
echo $form->textFieldGroup($model, 'latitude');
echo $form->textFieldGroup($model, 'address');
echo $form->textFieldGroup($model, 'phone');
echo $form->textFieldGroup($model, 'fix_time');
echo $form->textFieldGroup($model, 'service');
echo $form->textAreaGroup($model, 'description');


$this->widget(
    'booster.widgets.TbButton',
    array('buttonType' => 'submit', 'label' => '保存')
);

?>
	</div>
</div>
<div class="col-md-5 col-lg-4">
<div class="panel">
	<legend>状态</legend>
		<?php
echo $form->radioButtonListGroup(
			$model,
			'status',
			array(
				'widgetOptions' => array(
					'data' => Store::getStatusLabel(),
				)
			)
		);

// echo $form->textFieldGroup($model, 'store_id');

?>
	</div>
</div>
<?php
$this->endWidget();
unset($form);

?>