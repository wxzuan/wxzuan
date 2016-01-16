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
        //得到传输过来的字符串
        $string = \Yii::$app->session->getFlash('userbookingstring');
        //使用传输中的KEY值来加密数据
        $tokenString = \Yii::$app->security->encryptByKey(json_encode($string), $string['tokenstring']);
        $url = 'http://wxzuan.zuanzuanle.com/member/logistics/fitlogs/' . $string['id'] . '/' . $tokenString . '.html';
        //$url = 'http://' . $_SERVER['HTTP_HOST'] . '/member/logistics/fitlogs.html?token=' . $tokenString;
        return QrCode::png($url);
    }

}
