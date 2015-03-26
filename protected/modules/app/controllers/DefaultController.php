<?php

class DefaultController extends Controller
{

    
    CONST APICODE_SUCCESS = 0;
    CONST APICODE_FAILED = 1;
    
	public function actionIndex()
	{
		$this->render('index');
	}
}