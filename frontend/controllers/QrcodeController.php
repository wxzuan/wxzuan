<?php

namespace frontend\controllers;

use dosamigos\qrcode\QrCode;

class QrcodeController extends \common\controllers\BaseController {

    public function actionIndex() {
        $string = 'http://www.baidu.com';
        return QrCode::png($string);
    }

    /**
     * 联系我们
     * @return type
     */
    public function actionContact() {
        return $this->render('contact');
    }

    /**
     * 生成订单二维码
     */
    public function actionBookcode() {
        $string = Yii::$app->session->getFlash('userbookingstring');
        $tokenString = \Yii::$app->security->encryptByKey($string, $string['tokenstring']);
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/member/logistics/fitlogs.html?token=' . $tokenString;
        return QrCode::png($url);
    }

}
