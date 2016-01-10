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
use yii\web\NotFoundHttpException;

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
        $user_id = \Yii::$app->user->getId();
        $p_params = Yii::$app->request->get();
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
                    'url' => '/' . $picture->getImageUrl(),
                    'thumbnailUrl' => '/' . $picture->getOImageUrl(),
                    'deleteUrl' => Url::to(['/uploadfile/deletepropic', 'id' => $picture->getID()]),
                    'deleteType' => 'POST'
                ];
            } else {
                $response[] = ['error' => Yii::t('app', '上传错误')];
            }
            @unlink($picture->file->tempName);
        } else {
            if ($picture->hasErrors()) {
                $response[] = ['error' => '上传错误'];
            } else {
                throw new HttpException(500, Yii::t('app', '上传错误'));
            }
        }
        return $response;
    }
    /**
     * 删除商品图片
     */
    public function actionDeletepropic() {
        $user_id = \Yii::$app->user->getId();
        $p_params = Yii::$app->request->get();
        $delPic = Pic::find()->where(" id=:id AND user_id=:user_id ", [":id" => $p_params['id'], ":user_id" => $user_id])->one();
        if (!$delPic) {
            throw new NotFoundHttpException(Yii::t('app', 'Page not found'));
        }
        if ($delPic->delete()) {
            Yii::$app->response->getHeaders()->set('Vary', 'Accept');
            Yii::$app->response->format = Response::FORMAT_JSON;
            @unlink(Yii::$app->getBasePath() . '/web' . $delPic->pic_s_img);
            @unlink(Yii::$app->getBasePath() . '/web' . $delPic->pic_m_img);
            @unlink(Yii::$app->getBasePath() . '/web' . $delPic->pic_b_img);
            $response['files'][] = [
                'name' => TRUE
            ];
        } else {
            $response[] = ['error' => '删除失败'];
        }

        return $response;
    }
/**
     * 上传商品图片
     */
    public function actionUserpic() {
        $user=\Yii::$app->user->getIdentity();

        $picture = new UploadForm();
        $picture->file = UploadedFile::getInstance($user, 'litpic');
        if ($picture->file !== null && $picture->validate()) {
            Yii::$app->response->getHeaders()->set('Vary', 'Accept');
            Yii::$app->response->format = Response::FORMAT_JSON;

            $response = [];

            if ($picture->userSave()) {
                $response['files'][] = [
                    'name' => $picture->file->name,
                    'type' => $picture->file->type,
                    'size' => $picture->file->size,
                    'url' => '/' . $picture->getImageUrl(),
                    'thumbnailUrl' => '/' . $picture->getOImageUrl(),
                    'deleteUrl' => Url::to(['/uploadfile/deleteuserpic', 'id' => $picture->getID()]),
                    'deleteType' => 'POST'
                ];
            } else {
                $response[] = ['error' => Yii::t('app', '上传错误')];
            }
            @unlink($picture->file->tempName);
        } else {
            if ($picture->hasErrors()) {
                $response[] = ['error' => '上传错误'];
            } else {
                throw new HttpException(500, Yii::t('app', '上传错误'));
            }
        }
        return $response;
    }
    /**
     * 删除商品图片
     */
    public function actionDeleteuserpic() {
        $user=\Yii::$app->user->getIdentity();
        $p_params = Yii::$app->request->get();
        $delPic = Pic::find()->where(" id=:id AND user_id=:user_id ", [":id" => $p_params['id'], ":user_id" => $user->user_id])->one();
        if (!$delPic) {
            throw new NotFoundHttpException(Yii::t('app', 'Page not found'));
        }
        if ($delPic->delete()) {
            Yii::$app->response->getHeaders()->set('Vary', 'Accept');
            Yii::$app->response->format = Response::FORMAT_JSON;
            @unlink(Yii::$app->getBasePath() . '/web' . $delPic->pic_s_img);
            @unlink(Yii::$app->getBasePath() . '/web' . $delPic->pic_m_img);
            @unlink(Yii::$app->getBasePath() . '/web' . $delPic->pic_b_img);
            $response['files'][] = [
                'name' => TRUE
            ];
        } else {
            $response[] = ['error' => '删除失败'];
        }

        return $response;
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
                        'actions' => ['index','productpic','deletepropic','userpic'],
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
