

<div class="banner">
		<h1><?php 

				echo '<img src="'.$user->avatar.'" class="img-rounded"/>';
			echo htmlentities($user->nickname);
		
		?></h1>
		<p>发送消息</p>
	
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


 
echo $form->textFieldGroup($msg, 'title');
echo $form->textAreaGroup($msg, 'content');
$this->widget(
    'booster.widgets.TbButton',
    array('buttonType' => 'submit', 'label' => '保存')
);

?>
	</div>
</div>
<div class="col-md-5 col-lg-4">
<div class="panel">
	<legend>类型</legend>
		
	</div>
</div>
<?php
$this->endWidget();
unset($form);

?>