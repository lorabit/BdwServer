<?php

class PublicController extends Controller
{

	public function actionPhoto($id){
		$photo = Photo::model()->find('id=:id',array('id'=>$id));
		if($photo)
			$photo->sendFile();
		else
			$this->renderText('No such photo.');
	}
}