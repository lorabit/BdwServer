<?php
class ProblemController extends DefaultController{

	public function actionSubmitAnswer(){
		$raw_json = file_get_contents("php://input");
		$json = json_decode($raw_json);
		$test = new Test;
		$user = User::model()->find("id=".Yii::app()->user->id);
		$testee = Testee::model()->find("name=:name and gender=:gender and phone=:phone");
		if(empty($testee)){
			$testee = new Testee;
			$testee->name = $json->name;
			$testee->dob = $json->dob;
			$testee->gender = $json->gender;
			$testee->phone = $json->phone;
			$testee->save();
		}
		$test->testee_id = $testee->id;
		$test->tester_id = Yii::app()->user->id;
		$test->province = $user->province;
		$test->city = $user->city;
		$test->created_at = date(Yii::app()->controller->module->dateFormat);
		$test->raw_answer = $raw_json;
		$test->save();
		$this->renderJson(array(
			'success' => 1,
			'msg' => '我们将会在 7 日内通知受试人结果。'
		));
	}

	public function actionGetProblem(){
		$this->renderJson($this->getProblem());
	}

	public function getProblem(){
		return array(
			array(
				'title'=>'基本信息',
				'problems'=>array(
					array(
						'key' => 'blood_type',
						'title'=>'血型',
						'options' => array(
							'A','B','AB','O','不详'
						)
					),
					array(
						'key' => 'education',
						'title' => '文化程度',
						'options' => array(
							'文盲','小学','初中','高中/技专/中专','大学','研究生'
						)
					),
					array(
						'key' => 'living',
						'title' => '居住状况',
						'options' => array(
							'与老伴同住','与子女同住','独居','住养老院'
						)
					),
					array(
						'key' => 'diet_1',
						'title' => '饮食偏好',
						'options' => array(
							'荤食为主','素食为主','荤素搭配',
						)
					),
					array(
						'key' => 'diet_2',
						'title' => '饮食偏好',
						'options' => array(
							'嗜盐','嗜糖','嗜油','嗜辣',
						)
					),
					array(
						'key' => 'blood_pressure',
						'title' => '血压',
						'type' => 'number',
						'range' => array(20,200),
						'unit' => 'mmHg',
					),
					array(
						'key' => 'pulse',
						'title' => '脉率',
						'type' => 'number',
						'range' => array(20,200),
						'unit' => '次/分',
					),
					array(
						'key' => 'height',
						'title' => '身高',
						'type' => 'number',
						'range' => array(100,250),
						'unit' => 'cm',
					),
					array(
						'key' => 'weight',
						'title' => '体重	',
						'type' => 'number',
						'range' => array(20,200),
						'unit' => 'kg',
					),
					array(
						'key' => 'smoke',
						'title' => '吸烟（日）',
						'options' => array(
							'不吸','1-10支','11-20支','20支以上'
						)
					),
					array(
						'key' => 'alcohol',
						'title' => '饮酒（日）',
						'options' => array(
							'不饮','1-2两','3-5两	','6两以上'
						)
					),
					array(
						'key' => 'exercise',
						'title' => '体育锻炼',
						'options' => array(
							'每天','周少于4天','偶尔','不锻炼','轻微运动','中度运动','剧烈运动'
						)
					)
				)
			),
			array(
				'title'=>'运动',
				'problems'=>array(
					array(
						'key' => 'pace',
						'title'=>'步态分析',
						'type' => 'checkbox',
						'options'=>array(
							'起步迟缓','脚拖地面','走小碎步','步子不均匀','步子不连贯','不能走直线','摇晃','转身停顿'
						)
					),
					array(
						'key' => 'walk',
						'title'=>'行走',
						'type' => 'checkbox',
						'options'=>array(
							'需要辅助设施（如拐杖、助行器等）','需要旁人帮助'
						)
					),
				)
			),
			array(
				'title'=>'跌倒史',
				'problems'=>array(
					array(
						'key' => 'fall',
						'title'=>'近3月有跌倒史',
						'options' => array(
							'是','否'
						)
					),
					array(
						'key' => 'fall_hospital',
						'title'=>'因跌倒住院',
						'options' => array(
							'是','否'
						)
					),
				)
			),
			array(
				'title'=>'精神状态',
				'problems'=>array(
					
					array(
						'key' => 'delirium',
						'title'=>'谵妄',
						'options' => array(
							'是','否'
						)
					),
					array(
						'key' => 'dementia',
						'title'=>'痴呆',
						'options' => array(
							'是','否'
						)
					),
					array(
						'key' => 'behaviour',
						'title'=>'行为异常',
						'options' => array(
							'是','否'
						)
					),
					array(
						'key' => 'mentality',
						'title'=>'意识恍惚',
						'options' => array(
							'是','否'
						)
					),
				)
			),
			array(
				'title'=>'自控能力',
				'problems'=>array(
					array(
						'key' => 'incontinence',
						'title'=>'大便/小便失禁',
						'options' => array(
							'是','否'
						)
					),
					array(
						'key' => 'frequency',
						'title'=>'频率增加',
						'options' => array(
							'是','否'
						)
					),
					array(
						'key' => 'ureter',
						'title'=>'留置尿管',
						'options' => array(
							'是','否'
						)
					),
				)
			),
			array(
				'title'=>'感觉障碍',
				'problems'=>array(
					
					array(
						'key' => 'sight',
						'title'=>'视觉受损',
						'options' => array(
							'是','否'
						)
					),
					array(
						'key' => 'hearing',
						'title'=>'听觉受损',
						'options' => array(
							'是','否'
						)
					),
					array(
						'key' => 'logamnesia',
						'title'=>'感觉性失语',
						'options' => array(
							'是','否'
						)
					),
				)
			),
			array(
				'title'=>'睡眠情况',
				'problems'=>array(
					array(
						'key' => 'more_awake',
						'title'=>'多醒',
						'options' => array(
							'是','否'
						)
					),
					array(
						'key' => 'agrypnia',
						'title'=>'失眠',
						'options' => array(
							'是','否'
						)
					),
					array(
						'key' => 'somnambulism',
						'title'=>'梦游症',
						'options' => array(
							'是','否'
						)
					),
				)
			),
			array(
				'title'=>'相关疾病',
				'problems'=>array(
					array(
						'key' => 'disease',
						'title'=>'相关疾病',
						'type' => 'checkbox',
						'options'=>array(
							'神经科疾病','骨质疏松症','骨折史','低血压','药物/乙醇戒断','缺氧症'
						)
					),
				)
			),
			array(
				'title'=>'用药史',
				'problems'=>array(
					array(
						'key' => 'medicine',
						'title'=>'用药史',
						'type' => 'checkbox',
						'options'=>array(
							'新药','心血管药物','降压药','镇静、催眠药','戒断治疗','糖尿病用药','抗癫痫药','麻醉药','其他'
						)
					),
				)
			),
		);
	}

}