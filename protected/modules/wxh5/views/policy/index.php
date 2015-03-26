<?php
    $blockView = $this->createWidget('zii.widgets.CListView', array(
        'id' => 'build-list',
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

<div class="ios-list">

<?php 
    $blockView->run(); 
?>

	
</div>

<?php 
    echo '<div class="pagination-container">';
    echo '<a class="pagination previous' . ($currentPage==1?' disabled':'') . '" href="/wxh5/policy/index?PolicyPush_page=' . ($currentPage==1?1:$currentPage-1) . '"><span class="glyphicon glyphicon-chevron-left"></span></a>';
    echo '<a class="pagination next' . ($currentPage==$pageCount?' disabled':'') . '" href="/wxh5/policy/index?PolicyPush_page=' . ($currentPage==$pageCount?$currentPage:$currentPage+1) . '"><span class="glyphicon glyphicon-chevron-right"></span></a>';

    echo '</div>';
   ?>
<style type="text/css">
	#main-content{margin-top:10px;}
</style>