<div class="banner">
        <h1>店铺查询</h1>
        <p>Store List</p>
    
</div>

<div class="col-md-12 col-lg-10 col-lg-offset-1">
<div class="panel">
<?php

$this->widget(
    'booster.widgets.TbExtendedGridView',
    array(
        'id'=>'user-list',
        'ajaxUrl' => $this->createUrl('index'),
        'filter' => $model,
        'ajaxUpdate'=>false,
        // 40px is the height of the main navigation at bootstrap
        'dataProvider' => $dataProvider,
        'columns' => array(
         
            array(
                'name' => 'id',
                'headerHtmlOptions' => array('style' => 'width: 60px'),
            ),
            array(
                'name' => 'name',
                'type' => 'raw',
                'value' => '"<a href=\"/admin/store/update?id=".$data->id."\">".htmlentities($data->name)."</a>"'
            ),
            array(
                'name' => 'description',
            ),
            array(
                'name' => 'created_at',
            ),
            array(
                'header' => '操作',
                'type'=>'raw',
                'value'=>'"<a href=\"/admin/store/update/id/".$data->id."\"><span class=\"glyphicon glyphicon-wrench\"></span></a>"',
            ),

        ),
    )
);
?>
</div>
</div>