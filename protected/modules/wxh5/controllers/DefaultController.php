<?php

class DefaultController extends Controller
{
	public $layout = 'wxh5.views.layouts.layout';
	public function actionIndex()
	{
		$this->render('index');
	}
}