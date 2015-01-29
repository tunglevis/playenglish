<?php

class NewsController extends ApiController
{

    public function init(){
        parent::init();
    }

    public function actionList()
    {
//        $date = Yii::app()->request->getQuery('Date');
//        $page = Yii::app()->request->getQuery('Page');
//        $itemPerPage = Yii::app()->request->getQuery('ItemPerPage');
//
//        if($date)$date = date('Y-m-d',strtotime($date));

        $criteria = new CDbCriteria();
//        $criteria->select='t.id, t.title, t.time_start, t.time_end, t.date_start, t.addPlace';

        $criteria->addCondition('t.status="enable"');
        $criteria->limit = 20;

        $meohay= Meohay::model()->findAll($criteria);

        if(count($meohay)<1){
            $this->response(200, "Danh sách Mẹo hay rỗng",array('total'=>0,'news_list'=>array()));
        }

        $count_meohay = Meohay::model()->count('`status`=:status', array(':status' => 'enable'));

        $result = array(
            'total'=>$count_meohay,
//            'page'=>$page,
//            'number_per_page'=>$itemPerPage > $count_agenda ? $count_agenda : $itemPerPage,
            'news_list'=>array()
        );

        foreach($meohay as $key => $_meohay){

            $result['news_list'][] = array(
                'id'=>$_meohay->id,
                'title'=>$_meohay->title,
                'desc'=>$_meohay->desc,
                'image'=>$_meohay->getImageUrl()
            );
        }

        $this->response(200, "Danh sách Agenda", $result);
    }
}