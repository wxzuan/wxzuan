<?php

namespace frontend\controllers;

use dosamigos\qrcode\QrCode;

class QrcodeController extends \common\controllers\BaseController {

    public function actionIndex() {
        $string = 'http://www.baidu.com';
        QrCode::png($string, './date/qrcode/img.png', 0, 6, 2);
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
        $url = $string['id'] . ',' . urlencode($tokenString);
        //$url = 'http://' . $_SERVER['HTTP_HOST'] . '/member/logistics/fitlogs.html?token=' . $tokenString;
        header("Content-type: image/jpeg");
        $QR = './date/qrcode/qrcode' . $string['id'] . '.png';
        $logo = './date/qrcode/logo.png';
        QrCode::png($url, './date/qrcode/qrcode' . $string['id'] . '.png', 0, 3, 2);
        $QR = imagecreatefromstring(file_get_contents($QR));
        $logo = imagecreatefromstring(file_get_contents($logo));
        $QR_width = imagesx($QR); //二维码图片宽度   
        $QR_height = imagesy($QR); //二维码图片高度   
        $logo_width = imagesx($logo); //logo图片宽度   
        $logo_height = imagesy($logo); //logo图片高度   
        $logo_qr_width = $QR_width / 5;
        $scale = $logo_width / $logo_qr_width;
        $logo_qr_height = $logo_height / $scale;
        $from_width = ($QR_width - $logo_qr_width) / 2;
        //重新组合图片并调整大小   
        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
        imagepng($QR);
        \Yii::$app->end();
    }

}
