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

<?php 
    // echo '<div class="pagination-container">';
    // echo '<a class="pagination previous' . ($currentPage==1?' disabled':'') . '" href="/crowd/mobile/index/Task_page/' . ($currentPage==1?1:$currentPage-1) . '"><span class="glyphicon glyphicon-chevron-left"></span></a>';
    // echo '<a class="pagination next' . ($currentPage==$pageCount?' disabled':'') . '" href="/crowd/mobile/index/Task_page/' . ($currentPage==$pageCount?$currentPage:$currentPage+1) . '"><span class="glyphicon glyphicon-chevron-right"></span></a>';

    // echo '</div>';
   ?>

<div class="policy-list">

<?php 
    $blockView->run(); 
?>
	
</div>

<style type="text/css">
    .policy-list{
        width:100%;
        overflow: auto;
    }
    .policy-list .list-view{
        padding:0px;
    }
    .policy-list .item{
        padding-top:10px;
        padding-bottom:10px;
        background: #FFF;
        border-bottom:1px solid #E8E8E8;
        overflow: auto;
        width: 100%;
        display: block;
        color:#333;
    }
    .policy-list .leftSide{
        float:left;width:80px;
        padding-left:10px;
    }
    .policy-list .leftSide .status{
        width:100%;
        margin-top:5px;
        border-radius: 8px;
        font-size:11px;
        line-height:20px;
        text-align: center;
        background: #f9854c;
        color:#FFF;
    }
    .policy-list .leftSide .icon{width:100%;height:60px;overflow: hidden;;}
    .policy-list .leftSide img{width:100%;}
    .policy-list .rightSide{padding-left:10px;float:left;}
    .policy-list .rightSide .description{height:50px;line-height:25px;font-size:16px;}
    .policy-list .rightSide .time{color:#999;}
    .policy-list .rightSide .detail{color:#999;}
</style>