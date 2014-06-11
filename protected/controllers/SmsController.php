<?php

class SmsController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actionSend() {

        $criteria = new CDbCriteria;
        $criteria->addInCondition("status", array(0));
        $criteria->limit = 20;
        $smsList = Sms::model()->findAll($criteria);
        foreach ($smsList as $sms) {
            $sms->send();
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}