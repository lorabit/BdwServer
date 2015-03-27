<?php
$path = Yii::app()->assetManager->publish(Yii::getPathOfAlias('admin.assets'));
        Yii::app()->clientScript->registerScriptFile($path . '/js/jquery.form.js');
?>

<div class="banner">
		<h1><?php if($model->isNewRecord){
			echo '保单管理';
		}else{
			echo '编号：'.htmlentities($model->id).' - '.htmlentities($model->user->nickname);
		}
		?></h1>
		<p>A Wechat Business Account Backend Based-on Yii Framework</p>
	
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


 
echo $form->textFieldGroup($model, 'user_id');
echo $form->textFieldGroup($model, 'latitude');
echo $form->textFieldGroup($model, 'longitude');
echo $form->textAreaGroup($model, 'comment');


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
					'data' => Policy::getStatusLabel(),
				)
			)
		);

echo $form->textFieldGroup($model, 'store_id');

?>

<div class="form-group"><label class="col-sm-3 control-label">操作</label><div class="col-sm-9"><button type="button" id="publish" class="btn btn-info">推送</button></div></div>

	</div>
</div>
<?php
$this->endWidget();
unset($form);
?>

<?php if(!$model->isNewRecord){?>

<div class="col-md-7 col-lg-6 col-lg-offset-1">
	<div class="panel">
		<legend>关联照片</legend>
		<div class="photo-list">
			<?php
				$photos = Photo::model()->findAll('policy_id='.$model->id);
				foreach ($photos as $photo) {
					echo '<div>
							<img src="'.$photo->getUrl().'" class="img-responsive"/>
						</div>';
				}
			?>
			<div id="new-photo">
				<form id="new-photo-form">
				<input type="file" id="new-file" name="attachment"/>
				<span class="glyphicon glyphicon-plus"></span>
				</form>
			</div>
		</div>
	</div>
</div>

<?php } ?>

<style type="text/css">
	.photo-list {float:left;}
	.photo-list div{
		float:left;
		height:100px;
		width:100px;
		background: #EEE;
		position: relative;
		overflow: hidden;
		margin:5px;
	}
	#new-photo input{
		height: 100px;
		width: 100px;
		position: absolute;
		top:0px;
		z-index:1;
		opacity: 0;
		cursor: pointer;;
	}

	#new-photo span{
		position: absolute;
		top:35px;
		left:35px;
		font-size:30px;
	}

</style>
<script type="text/javascript">
	var policy_id = <?php echo $model->id?>;
   $("#new-file").on("change", function(e) {
            $(this).attr("name", "attachment");
            $("#new-photo-form").ajaxSubmit({
                url:  "/app/photo/uploadphoto?policy_id="+policy_id,
                type: 'POST',
                dataType: 'json',
                success: function(json) {
                    $('#new-photo').before('<div><img src="'+json.url+' class="img-responsive"/></div>');
                }
            })
    });
   $('#publish').on('click',function(){
   		$.ajax({
   			url:'/admin/policy/publish?id='+policy_id,
   			success:function(json){
   				alert('推送给了'+json.count+'个商铺。');
   			}
   		});
   });
</script>
