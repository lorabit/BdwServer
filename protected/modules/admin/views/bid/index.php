<div class="banner">
        <h1>保单查询</h1>
        <p>Policy List</p>
    
</div>

<div class="col-md-12 col-lg-10 col-lg-offset-1">
<div class="panel">
<?php

$this->widget(
    'booster.widgets.TbExtendedGridView',
    array(
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
                'name' => 'policy_id',
                'type' => 'raw',
                'value' => '$data->policy->comment'
          ),
            array(
                'name' => 'store_id',
                'type' => 'raw',
                'value' => '$data->store->name'
            ),
            array(
                'name' => 'price',
            ),
            array(
                'name' => 'time',
            ),
            array(
                'name' => 'pickup',
            ),
            array(
                'name' => 'created_at',
            ),

        ),
    )
);
?>
</div>
</div>