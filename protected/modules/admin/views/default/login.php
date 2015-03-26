<div class="banner">
        <h1>后台管理系统登录</h1>
        <p>A Wechat Business Account Backend Based-on Yii Framework</p>
    
</div>

<div class="col-md-12 col-lg-10 col-lg-offset-1">
<div class="panel">
<?php


/** @var TbActiveForm $form */
$form = $this->beginWidget(
    'booster.widgets.TbActiveForm',
    array(
        'id' => 'verticalForm',
    )
);
 
echo $form->textFieldGroup($model, 'phone');
echo $form->passwordFieldGroup($model, 'password');
?>
<button class="btn btn-default">登录</button>
<?php
$this->endWidget();
unset($form);

?>
</div>
</div>