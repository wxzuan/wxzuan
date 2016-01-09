<?php

namespace frontend\controllers;

use dosamigos\qrcode\QrCode;
use dosamigos\qrcode\formats\MailTo;

class QrcodeController extends \yii\web\Controller {

    public function actionIndex() {
        $string='http://www.baidu.com';
        return QrCode::png($string);
    }

    /**
     * 联系我们
     * @return type
     */
    public function actionContact() {
        return $this->render('contact');
    }

}
