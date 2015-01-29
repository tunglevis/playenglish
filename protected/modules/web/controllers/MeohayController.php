<?php

class MeohayController extends WebController {

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
                'actions' => array('error', 'search','index', 'captcha', 'list', 'detail', 'create', 'step', 'note', 'update', 'updateStep', 'crawler'),
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

    public function actionCrawler($url, $type){
//        set_time_limit(0);
        header('Content-Type: text/html; charset=utf-8');

        Yii::import('ext.simple_html_dom');

        $html = new simple_html_dom($url);

        $content = '';

        foreach($html->find('div.box_news p') as $e){
            $content .= $e->innertext;
        }
        foreach($html->find('div.box_news_old') as $e){
            $content .= $e->innertext;
        }

        $parse_content = new simple_html_dom($content);
        foreach($parse_content->find('a') as $e){
            $news = new NewsSport();
            $news->type = $type;
            $news->link = $e->href;
            $html_1 = new simple_html_dom($e->href);
            $imgs = $html_1->find('img');
            $news->image = $imgs[0]->src;

            $title = $html_1->find('div.link-title b');
            $title = $title[0]->innertext.'<br/>';
            $news->title = $title;

            $content_1 = '';
            //Find content of news
            foreach($html_1->find('div.box_news_detail') as $e_1){
                $content_1 .= $e_1->innertext;
            }
            $news->content = $content_1;


            if ($news->validate()) {
                $news->insert();
            }else{
                continue;
            }
        }

        echo "crawler thành công";
//        $html = new simple_html_dom('http://m.sutzo.com/tin-tuc/n192560/Yoann-Gourcuff-Tieu-Zidane-hoi-sinh-ruc-ro.html');
//
//        $imgs = $html->find('img');
//        echo $imgs[0]->src . '<br>';
//
//        $content = '';
//        //Find content of news
//        foreach($html->find('div.box_news_detail') as $e){
//            $content .= $e->innertext;
//            echo $content.'<br/>';
//        }
    }

    public function actionSearch($name=null){
        $criteria = new CDbCriteria;
//        $criteria->select = 't.name, t.alias, t.content';
        $criteria -> select='t.id';
        $criteria->condition = "MATCH (`title`, `desc`) AGAINST ('$name' IN BOOLEAN MODE) AND t.status = 'ENABLE'";
        $criteria->order = 't.id DESC';

        $dataProvider = new CActiveDataProvider('Meohay', array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 10,
                //'totalItemCount' => 'page',
                'pageVar' => 'paged',
            ),
        ));

        $viewed_meohay = $this->_getCookieViewedMeohay();
        $new_knowledge = $this->_getNewsKnowledge();
        $new_today = $this->_getToday();
        $marketPrice = $this->_getMarket();

        $this->render('list', array('title_page'=>'Kết quả tìm kiếm phù hợp với: '.$name, 'dataProvider'=>$dataProvider, 'viewed_meohay'=>$viewed_meohay, 'new_knowledge'=>$new_knowledge, 'new_today'=>$new_today, 'market_price'=>$marketPrice));
    }
    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     * 
     * @param $id, $alias of type meohay
     * @return page list meohay
     */
    public function actionList($type = null) {
        $this->layout = '//layouts/main';
        
        $type_meohay = null;
        $title_page = null;
        
        switch ($type){
            case 'lam-dep':
                $title_page = 'Làm đẹp';
                $type_meohay = 'MAKEUP';
                break;
            case 'suc-khoe':
                $title_page =  'Sức khỏe';
                $type_meohay = 'HEATHY';
                break;
            case 'gia-dinh':
                $title_page = 'Gia đình';
                $type_meohay = 'FAMILY';
                break;
            case 'thu-cong':
                $title_page = 'Thủ công';
                $type_meohay = 'HANDMADE';
                break;
            case 'dia-diem':
                $title_page = 'Địa điểm';
                $type_meohay = 'PLACE';
                break;
        }

        $this->title = $title_page.' - Mẹo nhỏ cuộc sống';
        $this->nav_header = $type_meohay;

        $criteria = new CDbCriteria();
        $criteria -> select='t.id';

        $criteria->compare('t.type', $type_meohay);
        $criteria->compare('t.status', 'ENABLE');
        $criteria->order = 't.created DESC';

        $dataProvider = new CActiveDataProvider('Meohay', array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 10,
                //'totalItemCount' => 'page',
                'pageVar' => 'paged',
            ),
        ));
        
        $viewed_meohay = $this->_getCookieViewedMeohay();
        $new_knowledge = $this->_getNewsKnowledge();
        $new_today = $this->_getToday();
        $marketPrice = $this->_getMarket();
        
        $this->render('list', array('title_page'=>$title_page, 'dataProvider'=>$dataProvider, 'viewed_meohay'=>$viewed_meohay, 'new_knowledge'=>$new_knowledge, 'new_today'=>$new_today, 'market_price'=>$marketPrice));
    }

    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     * 
     * @param $id, $alias of meohay detail 
     * @return page detail meohay
     */
    public function actionDetail($id = null, $alias = null) {
        $this->layout = '//layouts/main';

        $meohay = Meohay::model()->getMeohay($id);

        $this->title = $meohay['title'];
        $this->desc = $meohay['desc'];

        $same_meohay = $this->_getSameMeohay($meohay['type'], $id);
        $viewed_meohay = $this->_getCookieViewedMeohay();
        $new_knowledge = $this->_getNewsKnowledge();
        $new_today = $this->_getToday();
        $marketPrice = $this->_getMarket();
        $new_meohay = $this->_getNewMeohay();
        
        //set cookie meohay was viewed

        $cookies_viewed_meohay = '';

        if(isset(Yii::app()->request->cookies['view_meohay'])){
            $cookies_viewed_meohay = Yii::app()->request->cookies['view_meohay']->value;
            
            if(strpos($cookies_viewed_meohay, $id) === false){
                
                if(substr_count($cookies_viewed_meohay,',') == 4){
                    $cookies_viewed_meohay = substr($cookies_viewed_meohay,0,strrpos($cookies_viewed_meohay,','));
                }
                $cookies_viewed_meohay = $id.','.$cookies_viewed_meohay;
            }
        } else {
            $cookies_viewed_meohay = $id;
        }

        $cookies = new CHttpCookie('view_meohay', $cookies_viewed_meohay);
        $cookies->expire = time() + 24*60*60;

        Yii::app()->request->cookies['view_meohay'] = $cookies;

        $this->_setCountView($id);

        if($meohay['step'])
            $this->render('detail_meohay',array('meohay'=>$meohay, 'same_meohay'=>$same_meohay, 'viewed_meohay'=>$viewed_meohay, 'new_knowledge'=>$new_knowledge, 'new_today'=>$new_today, 'market_price'=>$marketPrice));
        else
            $this->render('detail_meohay_no_step',array('new_meohay' => $new_meohay ,'meohay'=>$meohay, 'same_meohay' => $same_meohay, 'viewed_meohay'=>$viewed_meohay, 'new_knowledge'=>$new_knowledge, 'new_today'=>$new_today, 'market_price'=>$marketPrice));
    }

    public function _setCountView($meonho_id = null){
        $session = Yii::app()->session;

        if (empty($session['view_meonho']))
        {
            $meonho = Meohay::model()->findByPk($meonho_id);
            $meonho->viewed += 1;
            $meonho->update();
            $session['view_meonho'] = $meonho_id;
        }
        else {
            $array_id = explode(',',$session['view_meonho']);
            if(!in_array($meonho_id, $array_id)) {
                $meonho = Meohay::model()->findByPk($meonho_id);
                $meonho->viewed += 1;
                $meonho->update();
                array_push($array_id, $meonho_id);
                $session['view_meonho'] = implode(',', $array_id);
            }
        }
    }

    public function _getNewMeohay(){
        $criteria = new CDbCriteria();
        $criteria -> select='t.id';

        $criteria->compare('t.status', 'ENABLE');
        $criteria->order = 't.id DESC';
        $criteria->limit = 5;

        $meohay = Meohay::model()->findAll($criteria);

        $result = array();

        foreach ($meohay as $value)  $result[] = $value->getMeohay();

        return $result;
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
        $criteria->limit = 6;
        
        $meohay = Meohay::model()->findAll($criteria);
        
        $result = array();
        
        foreach ($meohay as $value) {
            if(count($result)<5){
                if($value->id != $id) $result[] = $value->getMeohay();
                else continue;
            }
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

    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     * 
     * @param
     * @return page create meohay
     */
    public function actionCreate() {
        $this->layout = '//layouts/main';

        $model = new Meohay();

        $imgConf = Yii::app()->params->meohay;
        $tempPath = "upload/temp/meohay/" . Yii::app()->getSession()->sessionID . "/";
        if (!file_exists($tempPath))
            mkdir($tempPath, 0777, true);

        if (isset($_POST['Meohay'])) {
            Yii::import('ext.MyDateTime');
            $post = Yii::app()->request->getPost('Meohay');
            $model->attributes = $post;
//            $model->user_id = $this->user->id;
            $model->user_id = 13;
            $model->status = 'PENDING';
            $model->image = 'default';
            $model->has_step = 1;
            $model->created = MyDateTime::getCurrentTime();
            Yii::import('ext.TextParser');
            $model->alias = $model->alias ? $model->alias : $model->title;
            $model->alias = TextParser::toSEOString($model->alias);
            if ($model->validate()) {
//                var_dump($model->validate());
//                var_dump($model->getErrors());
                $model->setIsNewRecord(TRUE);
                $model->insert();

                /////// IMAGES ////////
                $path = $imgConf['path'] . "{$model->id}/";
                if (!file_exists($path))
                    mkdir($path, 0777, true);

                $source = NULL;
                if ($post['upload_method'] == 'file') {
                    $source = 'browse_file';
                } else {
                    $source = $post['image_url'];
                }

                Yii::import('ext.wideimage.lib.WideImage');
                $img = WideImage::load($source);

                foreach ($imgConf['img'] as $key => $imgInfo) {
                    $img = $img->resize($imgInfo['width'], $imgInfo['height'], 'outside', 'down');
                    $img = $img->resizeCanvas($imgInfo['width'], $imgInfo['height'], 'center', 'center', null, 'down');
                    $img->saveToFile($path . $key . '.jpg', $imgInfo['quality']);
                }

                $model->image = '300';

                $model->update();

                Myext::deleteDir("upload/temp/meohay/", FALSE);
                unset(Yii::app()->session['contentPath']);

                $this->redirect(array('/web/meohay/step', 'm_id' => $model->id, 'step' => 1));
                Yii::app()->user->setFlash('success', "Post {$model->title} was added successful!");
                $this->refresh();
            }
        }

        $this->render('create', array('model' => $model));
    }

    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     * 
     * @param
     * @return page create meohay
     */
    public function actionStep($m_id = null, $step = null) {
        $this->layout = '//layouts/main';

        $model = new StepCreateContent('search');

        $imgConf = Yii::app()->params->meohay;

        if (isset($_POST['StepCreateContent'])) {
            Yii::import('ext.MyDateTime');
            $post = Yii::app()->request->getPost('StepCreateContent');
            $model->attributes = $post;
            $this->manager->id ? ($model->manager_id = $this->manager->id) : ($model->user_id = Yii::app()->user->id);
            $model->image = 'default';
            $model->step = $step;
            $model->meohay_id = $m_id;
            $model->created = MyDateTime::getCurrentTime();
            if ($model->validate()) {
//                var_dump($model->validate());
//                var_dump($model->getErrors());
                $model->setIsNewRecord(TRUE);
                $model->insert();

                /////// IMAGES ////////
                $path = $imgConf['path'] . "{$model->meohay_id}/step_{$model->id}/";
                if (!file_exists($path))
                    mkdir($path, 0777, true);

                if (
                        ($post['upload_method'] == 'file' && $_FILES['browse_file']['size']) ||
                        ($post['upload_method'] == 'url' && $post['image_url'])
                ) {
                    $source = NULL;
                    if ($post['upload_method'] == 'file') {
                        $source = 'browse_file';
                    } else {
                        $source = $post['image_url'];
                    }

                    Yii::import('ext.wideimage.lib.WideImage');
                    $img = WideImage::load($source);

                    foreach ($imgConf['img'] as $key => $imgInfo) {
                        $img = $img->resize($imgInfo['width'], $imgInfo['height'], 'outside', 'down');
                        $img = $img->resizeCanvas($imgInfo['width'], $imgInfo['height'], 'center', 'center', null, 'down');
                        $img->saveToFile($path . $key . '.jpg', $imgInfo['quality']);
                    }

                    $model->image = '300';
                    
                    $model->update();
                }

                Yii::app()->user->setFlash('success', "Post {$model->name} was added successful!");
                if ($_POST['cmd'] == 'Next')
                    $this->redirect(array('/web/meohay/step', 'm_id' => $m_id, 'step' => ($step + 1)));
                elseif ($_POST['cmd'] == 'End')
                    $this->redirect(array('/web/meohay/note', 'id' => $m_id));
            }
        }

        $this->render('create_step', array('model' => $model, 'step' => $step));
    }
    
    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     * 
     * @param int $id of meohay
     * @return update column note, tip of that meohay
     */
    
    public function actionNote($id = null) {
        $model = Meohay::model()->findByPk($id);
        
        if (isset($_POST['Meohay'])) {
            $post = Yii::app()->request->getPost('Meohay');
            $model->attributes = $post;
            
            if ($model->validate()) {
                $model->setIsNewRecord(FALSE);
                
                $model->update();
                
                $this->redirect(array('/web/meohay/update', 'id' => $id));
            }
            
        }
        
        $this->render('create', array('model' => $model));
    }
    
    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     * 
     * @param 
     * @return 
     */
    public function actionUpdate($id = null) {
        $model = Meohay::model()->with('stepCreateContents')->findByPk($id);

        $imgConf = Yii::app()->params->meohay;
        $tempPath = $imgConf['path'] . "{$model->id}/";
        if (!file_exists($tempPath))
            mkdir($tempPath, 0777, true);

        if (isset($_POST['Meohay'])) {
            Yii::import('ext.MyDateTime');
            $post = Yii::app()->request->getPost('Meohay');
            //             echo "<pre>";print_r($post);echo "</pre>";die;
            $model->attributes = $post;

            $model->created = $model->created ? $model->created : MyDateTime::getCurrentTime();
            $model->changed = MyDateTime::getCurrentTime();
            $model->manager_id = $model->manager_id ? $model->manager_id : $this->manager->id;
            if ($model->validate()) {
                Yii::import('ext.TextParser');
                $model->alias = $model->alias ? $model->alias : $model->name;
                $model->alias = TextParser::toSEOString($model->alias);
                $model->setIsNewRecord(FALSE);

                /////// IMAGES ////////
                $path = $imgConf['path'] . "{$model->id}/";
                if (!file_exists($path))
                    mkdir($path, 0777, true);

                if (
                        ($post['upload_method'] == 'file' && $_FILES['browse_file']['size']) ||
                        ($post['upload_method'] == 'url' && $post['image_url'])
                ) {
                    $source = NULL;
                    if ($post['upload_method'] == 'file') {
                        $source = 'browse_file';
                    } else {
                        $source = $post['image_url'];
                    }

                    Yii::import('ext.wideimage.lib.WideImage');
                    $img = WideImage::load($source);

                    foreach ($imgConf['img'] as $key => $imgInfo) {
                        $img = $img->resize($imgInfo['width'], $imgInfo['height'], 'outside', 'down');
                        $img = $img->resizeCanvas($imgInfo['width'], $imgInfo['height'], 'center', 'center', null, 'down');
                        $img->saveToFile($path . $key . '.jpg', $imgInfo['quality']);
                    }

                    $model->image = '300';
                }

                if (trim($model->content)) {
                    // upload content images
                    Yii::import('ext.Myext');
                    $model->content = Myext::saveContentImages($model->content, $path, array(
                                'image_x' => $imgConf['img']['body']['width'],
                                'image_y' => $imgConf['img']['body']['height'],
                            ));
                }

                $model->update();

                Yii::app()->user->setFlash('success', "Post {$model->title} was updated successful!");
                $this->refresh();
            }
        }
        $this->render('create', array('model'=>$model));
    }
    public function actionUpdateStep($id) {
        $model = StepCreateContent::model()->findByPk($id);

        $imgConf = Yii::app()->params->meohay;

        if (isset($_POST['StepCreateContent'])) {
            Yii::import('ext.MyDateTime');
            $post = Yii::app()->request->getPost('StepCreateContent');
            $model->changed = MyDateTime::getCurrentTime();
            if ($model->validate()) {
//                var_dump($model->validate());
//                var_dump($model->getErrors());
                $model->setIsNewRecord(FALSE);
                $model->update();

                /////// IMAGES ////////
                $path = $imgConf['path'] . "{$model->meohay_id}/step_{$model->id}/";
                if (!file_exists($path))
                    mkdir($path, 0777, true);

                if (
                        ($post['upload_method'] == 'file' && $_FILES['browse_file']['size']) ||
                        ($post['upload_method'] == 'url' && $post['image_url'])
                ) {
                    $source = NULL;
                    if ($post['upload_method'] == 'file') {
                        $source = 'browse_file';
                    } else {
                        $source = $post['image_url'];
                    }

                    Yii::import('ext.wideimage.lib.WideImage');
                    $img = WideImage::load($source);

                    foreach ($imgConf['img'] as $key => $imgInfo) {
                        $img = $img->resize($imgInfo['width'], $imgInfo['height'], 'outside', 'down');
                        $img = $img->resizeCanvas($imgInfo['width'], $imgInfo['height'], 'center', 'center', null, 'down');
                        $img->saveToFile($path . $key . '.jpg', $imgInfo['quality']);
                    }

                    $model->image = '300';
                }

                $model->update();

                Yii::app()->user->setFlash('success', "Update {$model->name} was added successful!");
            }
        }
        $this->render('create_step', array('model' => $model));
    }
}
