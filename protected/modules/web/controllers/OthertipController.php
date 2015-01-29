<?php

class OthertipController extends WebController {

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
                'actions' => array('error', 'today', 'captcha','knowledge'),
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
     * @param $id, $alias of meohay today
     * @return page detail today 
     */
    public function actionToday($id = null, $alias = null) {
        $this->layout = '//layouts/main';

        $viewed_meohay = $this->_getCookieViewedMeohay();
        $new_knowledge = $this->_getNewsKnowledge();
        $marketPrice = $this->_getMarket();
        $today = Today::model()->getToday($id);

        $this->render('detail_today', array('today'=>$today, 'viewed_meohay'=>$viewed_meohay, 'new_knowledge'=>$new_knowledge,'market_price'=>$marketPrice));
    }
    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     * 
     * @param $id, $alias of meohay knowledge
     * @return page detail today 
     */
    public function actionKnowledge($id = null, $alias = null) {
        $this->layout = '//layouts/main';
        
        $this->render('detail_knowledge');
    }

    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     *
     * @param $type of meohay
     * @return same meohay
     */
    public function _getSameMeohay($type = null, $id = null) {
        $criteria = new CDbCriteria();
        $criteria -> select='t.id';

        $criteria->compare('t.type', $type);
        $criteria->compare('t.status', 'ENABLE');
        $criteria->order = 't.created DESC';
        $criteria->limit = 5;

        $meohay = Meohay::model()->findAll($criteria);

        $result = array();

        foreach ($meohay as $value) {
            if($value->id != $id) $result[] = $value->getMeohay();
            else continue;
        }

        return $result;
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

    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     *
     * @param
     * @return array branches has viewd for 1 day ago
     */
    private function _getCookieViewedMeohay() {
        if(empty(Yii::app()->request->cookies['view_meohay'])) return false;

        $viewed_meohay = Yii::app()->request->cookies['view_meohay']->value;

        $meohay_ids = explode(',', $viewed_meohay);

        foreach($meohay_ids as $index => $meohay_id){
            $meohay_id = intval($meohay_id);
            if(!$meohay_id || !is_int($meohay_id)) unset($meohay_ids[$index]);
        }

        $meohay= array();
        foreach($meohay_ids as $meohay_id){
            $meohay[] = Meohay::model()->getMeohay($meohay_id);
        }
        return $meohay;
    }
}
