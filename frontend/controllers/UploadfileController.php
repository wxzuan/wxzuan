<?php

namespace frontend\controllers;

use frontend\models\forms\AddProductForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\UserProductAddress;
use common\models\Product;
use common\models\Account;
use yii\helpers\Url;
use \PDO;
use yii\web\UploadedFile;
use common\models\forms\UploadForm;
use common\models\Pic;
use yii\web\HttpException;
use yii\helpers\Html;
use yii\web\Response;

class UploadfileController extends \yii\web\Controller {

    /**
     * 商品列表
     * @return type
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * 上传商品图片
     */
    public function actionProductpic() {
        $user_id=\Yii::$app->user->getId();
        $p_params=Yii::$app->request->get();
        $product = Product::findOne($p_params['id']);
        if (!$product) {
            throw new NotFoundHttpException(Yii::t('app', 'Page not found'));
        }
        
        $picture = new UploadForm();
        $picture->file = UploadedFile::getInstance($product, 'product_s_img');
        if ($picture->file !== null && $picture->validate()) {
            Yii::$app->response->getHeaders()->set('Vary', 'Accept');
            Yii::$app->response->format = Response::FORMAT_JSON;

            $response = [];

            if ($picture->productSave()) {
                $response['files'][] = [
                    'name' => $picture->file->name,
                    'type' => $picture->file->type,
                    'size' => $picture->file->size,
                    'url' => $picture->getImageUrl(),
                    'thumbnailUrl' => $picture->getSmallImageUrl(),
                    'deleteUrl' => Url::to(['/uploadfile/deletepropic', 'id' => $picture->getID()]),
                    'deleteType' => 'POST'
                ];
            } else {
                $response[] = ['error' => Yii::t('app', 'Unable to save picture')];
            }
            @unlink($picture->file->tempName);
        } else {
            if ($picture->hasErrors()) {
                $response[] = ['error' => '上传错误'];
            } else {
                throw new HttpException(500, Yii::t('app', 'Could not upload file.'));
            }
        }
        return json_encode($response);
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

}
