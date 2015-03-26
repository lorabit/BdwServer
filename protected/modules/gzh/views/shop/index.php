<?php
    $blockView = $this->createWidget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        //'ajaxUpdate' => 'build-list-container',
        //'updateSelector' => '#build-list-container .pagination',
        //'htmlOptions' => array('class' => 'widget-view', 'style' => 'overflow:auto'),
        //'itemsCssClass' => 'build-items',
        'template' => '{items}',
        'itemView' => '_item',
    ));
    $pagination = $dataProvider->getPagination();
    $currentPage = $pagination->getCurrentPage() + 1;
    $pageCount = $pagination->getPageCount();
    $itemCount = $pagination->getItemCount();
    $pageSize = $pagination->getPageSize();

    $start = ($currentPage - 1) * $pageSize + 1;
    $count = min($pageSize, ($itemCount - $start + 1));
    $end = $start + $count - 1;
?>

<div class="coupon-list">

<?php 
    $blockView->run(); 
?>
    
</div>

<style type="text/css">
    .coupon{width:100%;border-bottom:1px dashed #DDD;padding:15px;background: #FFF;overflow: auto;clear: both;}
    .store-name{font-size: 20px;width:100%;}
    .balance{float:left;width:50%;font-size:22px;color:#F40;}
    .balance span{font-size: 13px;color:#999;margin-left:6px;}
    .apply-coupon{
        border:1px dotted #CCC;
        background:#FFF;
        border-radius: 10px;
        float:right;
        font-size:15px;
        width:100px;
        height:30px;
        line-height: 30px;
        color:#555;
    }
</style>