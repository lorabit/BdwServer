

<div class="banner">
		<h1><?php if($model->isNewRecord){
			echo '创建账号';
		}else{
			if(!empty($model->avatar))
				echo '<img src="'.$model->avatar.'" class="img-rounded"/>';
			echo htmlentities($model->realname);
		}
		?></h1>
		<p>账号管理</p>
	
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


 
echo $form->textFieldGroup($model, 'realname');
echo $form->textFieldGroup($model, 'phone');
echo $form->textFieldGroup($model, 'password');
echo $form->textFieldGroup($model, 'province');
echo $form->textFieldGroup($model, 'city');
echo $form->textFieldGroup($model, 'center_name');
echo $form->textFieldGroup($model, 'title');
$this->widget(
    'booster.widgets.TbButton',
    array('buttonType' => 'submit', 'label' => '保存')
);

?>
	</div>
</div>
<div class="col-md-5 col-lg-4">
<div class="panel">
	<legend>角色</legend>
		<?php
echo $form->radioButtonListGroup(
			$model,
			'user_group',
			array(
				'widgetOptions' => array(
					'data' => User::getUserGroupLabel(),
				)
			)
		);


?>
	</div>
</div>
<?php
$this->endWidget();
unset($form);

?>