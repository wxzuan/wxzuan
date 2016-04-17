<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use frontend\models\forms\SayingForm;
use common\models\User;
use yii\helpers\Url;
use common\models\Comment;

class SayController extends \common\controllers\BaseController {

    /**
     * 回复一个评论
     */
    public function actionRepay() {
        $top_id = \Yii::$app->request->get('id');
        if (empty($top_id)) {
            echo 1;
            \Yii::$app->end();
        }
        $model = new \frontend\models\forms\RepayForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $pid = $model->save();
            $this->refresh();
            $this->redirect(Url::toRoute('/say/article/' . $pid) . '?end=true');
            \Yii::$app->end();
        } else {
            $model->setAttributes(['top_id' => $top_id]);
            return $this->renderAjax('ajax_repay', ['model' => $model]);
        }
    }

    /**
     * 显示一个文章的信息
     * @return type
     */
    public function actionArticle() {
        $id = \Yii::$app->request->get('id');
        $idTrue = true;
        if (empty($id)) {
            $idTrue = FALSE;
        }
        if ($idTrue) {
            $articleInfo = Comment::find()->where('id=:id', [':id' => $id])->one();
            if (!$articleInfo) {
                $idTrue = FALSE;
            } else {
                if ($articleInfo->is_public === 0 && (\Yii::$app->user->getId() !== $articleInfo->to_user_id || \Yii::$app->user->getId() !== $articleInfo->user_id)) {
                    $idTrue = FALSE;
                }
            }
        }
        if (!$idTrue) {
            $error = '当前评论不存在或者已经被禁止显示';
            $notices = array('type' => 2, 'msgtitle' => '错误的访问', 'message' => $error, 'backurl' => Url::toRoute('/say/index'), 'backtitle' => '返回');
            Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
            $this->redirect(Url::toRoute('/public/notices'));
        }
        return $this->render('article', ['articleInfo' => $articleInfo]);
    }

    /**
     * 吐槽区首页
     * @return type
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * 个人私用页面
     * @return type
     */
    public function actionPrivate() {
        return $this->render('private');
    }

    /**
     * 发布一个说说
     * @return type
     */
    public function actionSaying() {

        $model = new SayingForm();
        $p_param = Yii::$app->request->get();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $pid = $model->save();
            if ($pid) {
                $error = '吐槽成功';
                $this->refresh();
                $notices = array('type' => 2, 'msgtitle' => '操作成功', 'message' => $error, 'backurl' => Url::toRoute('/say/article/' . $pid), 'backtitle' => '查看吐槽');
                Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
                $this->redirect(Url::toRoute('/public/notices'));
            } else {
                return $this->render('saying', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('saying', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'saying', 'article', 'repay'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'saying', 'article', 'repay'],
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
