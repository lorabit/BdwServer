<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	 /**
     * 权限过滤处理器
     */
    public function filters() {
        return array(
            'accessControl',
            array(
                'application.filters.UserVisitFilter'
            ),
        );
    }

   /**
     * 自身定义的JSON格式渲染
     * @param type $data
     * @param type $callback
     */
    public function renderJson($data, $callback = false) {
        $this->layout = false;
        $prefix = $postfix = '';
        if ($callback) {
            $prefix = htmlspecialchars($callback, ENT_QUOTES) . '(';
            $postfix = ')';
        }
        header('Content-type: application/json');

        echo $prefix . CJSON::encode($data) . $postfix;

        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }

    public function loadModel($clazz)
    {
        $model = null;
        if(isset($_REQUEST['id']))
        {
            $model = $clazz::model()->findByPk($_REQUEST['id']);
        }
        if($model === null)
            throw new CHttpException(404, Yii::t('Job', 'The requested page does not exist.'));
        
        return $model;
    }

}