<?php

namespace app\modules\member\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use frontend\models\forms\SearchProcessForm;
use common\models\Product;
use common\models\Pic;

class ProductController extends \common\controllers\BaseController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'buyed', 'rate', 'changeimg', 'selectimg'],
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

    /**
     * 默认为我的商品列表
     * @return type
     */
    public function actionIndex() {
        return $this->render('product_index');
    }

    /**
     * 已购商品
     * @return type
     */
    public function actionBuyed() {
        return $this->render('product_buyed');
    }

    /**
     * 物流进度
     * @return type
     */
    public function actionRate() {

        $model = new SearchProcessForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $this->refresh();
            if ($resultR) {
                Yii::$app->session->setFlash('success', '更新成功');
                $this->redirect('/public/notices.html');
                Yii::$app->end();
            }
        } else {
            return $this->render('product_rate', ['model' => $model]);
        }
    }

    /**
     * 选择商品图片
     * @return type
     */
    public function actionSelectimg() {
        $p_param = Yii::$app->request->get();
        $user_id = Yii::$app->user->getId();
        if (isset($p_param['id'])) {

            $oneProduct = Product::find("product_id=:id", [':id' => $p_param['id']])->one();
            if ($oneProduct) {
                $query = Pic::find()->where('user_id=:user_id',[':user_id' => $user_id]);
                $countQuery = clone $query;
                $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => '9']);
                $models = $query->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
                return $this->render('product_selectimg', ['model' => $oneProduct,'models'=>$models,'pages'=>$pages]);
                Yii::$app->end();
            }
        }
        $error = '不存在此商品';
        $notices = array('type' => 2, 'msgtitle' => '错误的操作', 'message' => $error, 'backurl' => Url::toRoute('/member/product/index'), 'backtitle' => '返回');
        Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
        $this->redirect(Url::toRoute('/public/notices'));
    }

    /**
     * 单个商品修改
     * @return type
     */
    public function actionChangeimg() {
        $p_param = Yii::$app->request->get();
        if (isset($p_param['id'])) {
            $oneProduct = Product::find("product_id=:id", [':id' => $p_param['id']])->one();
            if ($oneProduct) {
                return $this->render('product_changeimg', ['model' => $oneProduct]);
                Yii::$app->end();
            }
        }
        $error = '不存在此商品';
        $notices = array('type' => 2, 'msgtitle' => '错误的操作', 'message' => $error, 'backurl' => Url::toRoute('/member/product/index'), 'backtitle' => '返回');
        Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
        $this->redirect(Url::toRoute('/public/notices'));
    }

}
