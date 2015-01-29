<?php

class PageController extends WebController {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('error', 'index', 'captcha','course'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionError() {
        $this->layout = '//layouts/main';

        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else {

                $view = 'error';
                if (in_array($error['code'], array(404))) {
                    $view .= $error['code'];
                }
                $this->render($view, $error);
            }
        }
    }

    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     * 
     * @param 
     * @return page home of site 
     */
    public function actionIndex() {
        $this->layout = '//layouts/main';
        $this->nav_header = 'home';



        $this->render('index', array());
    }

    public function actionCourse($id = null) {
        $this->layout = '//layouts/main';
        $this->nav_header = 'home';



        $this->render('course', array());
    }
    //get newest knowledge
    private function _getNewsKnowledge(){
        $aryData = array();
        //list 3 knowledge newest
        $criteria_knowledge = new CDbCriteria();
        $criteria_knowledge->select='t.id';

        $criteria_knowledge->compare('t.status', 'ENABLE');
        $criteria_knowledge->order = 't.created DESC';
        $criteria_knowledge->limit = 3;

        $new_knowledge= NewKnowledge::model()->findAll($criteria_knowledge);

        foreach ($new_knowledge as $knowledge) {
            $aryData[] = $knowledge->getKnowledge();
        }
        return $aryData;
    }

    //get newest today-tip
    private function _getToday(){
        $aryData = array();
        //list 1 newest today-tip
        $criteria_today = new CDbCriteria();
        $criteria_today->select='t.id';

        $criteria_today->compare('t.status', 'ENABLE');
        $criteria_today->order = 't.created DESC';
        $criteria_today->limit = 1;

        $new_today= Today::model()->findAll($criteria_today);

        foreach ($new_today as $today) {
            $aryData[] = $today->getToday();
        }
        return $aryData;
    }

    //get newest market
    private function _getMarket(){
        $aryData = array();
        $today = date('Y-m-d',time());
        $yesterday = date('Y-m-d',strtotime(' -1 day'));

        //list today of Market
        $criteria_today = new CDbCriteria();
        $criteria_today->select='t.id';

        $criteria_today->addCondition('t.status="ENABLE"');
        $criteria_today->order = 't.type DESC';
        $criteria_today->addCondition('t.`created`>"'.$yesterday.'"');
        $criteria_today->addCondition('t.`created`<"'.$today.'"');

        $yesterdayMarket= MarketPrices::model()->findAll($criteria_today);

        foreach ($yesterdayMarket as $price) {
            $aryData['yesterday'][] = $price->getMarketPrices();
        }

        //list yesterday of Market
        $criteria_today = new CDbCriteria();
        $criteria_today->select='t.id';

        $criteria_today->addCondition('t.status="ENABLE"');
        $criteria_today->order = 't.type DESC';
        $criteria_today->addCondition('t.`created`>"'.$today.'"');

        $todayMarket= MarketPrices::model()->findAll($criteria_today);

        foreach ($todayMarket as $price) {
            $aryData['today'][] = $price->getMarketPrices();
        }

        return $aryData;
    }

    private function _getCookieViewedMeohays() {
        if(empty(Yii::app()->request->cookies['view_meohay'])) return false;

        $viewed_meohay = Yii::app()->request->cookies['view_meohay']->value;

        $meohay_ids = explode(',', $viewed_meohay);

        $meohays = array();
        foreach($meohay_ids as $index => $meohay_id){
            $meohay_id = intval($meohay_id);
            
            if(!$meohay_id || !is_int($meohay_id)) continue;
            
            $meohays[] = Meohay::model()->getMeohay($meohay_id);
        }

        return $meohays;
    }
}
