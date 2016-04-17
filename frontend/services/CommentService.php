<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author qinyangsheng
 */

namespace frontend\services;

use common\models\Logistics;
use common\models\Comment;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use \Yii;
use \PDO;
use yii\helpers\Url;
use app\modules\member\controllers\LogisticsController;
use common\models\User;

class CommentService {

    /**
     * 
     * @return type
     */
    public static function findOnePrivateC($user_id) {
        return Comment::find()->where('to_user_id=:toUser AND is_public=0', [':toUser' => $user_id])->count();
    }

    /**
     * 
     * @param int $data
     * @return \yii\data\ActiveDataProvider
     */
    public static function findRepays($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 5;
        }
        $query = Comment::find()->Where('top_id=:top_id', [':top_id' => $data['top_id']])->orderBy(" id asc ")->limit($data['limit']);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $data['limit']]);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return ['models' => $models, 'pages' => $pages];
    }

    /**
     * 
     * @param int $data
     * @return \yii\data\ActiveDataProvider
     */
    public static function findComments($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }
        $model = new Comment();
        $dataProvider = new ActiveDataProvider([
            'query' => $model->find()->Where('is_public=:isp and top_id=0 and c_type="article" ',[':isp'=>$data['is_public']])->orderBy(" id desc ")->limit($data['limit']),
            'pagination' => [
                'pagesize' => $data['limit'],
            ]
        ]);
        return $dataProvider;
    }

    /**
     * 
     * @param int $data
     * @return \yii\data\ActiveDataProvider
     */
    public static function findMyLogiss($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }

        $query = Logistics::find()->Where('publis_user_id=:user_id', [':user_id' => $data['user_id']])->orderBy(" fee_lock asc,id desc ");
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $data['limit']]);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return ['models' => $models, 'pages' => $pages];
    }

    /**
     * 
     * @param int $data
     * @return \yii\data\ActiveDataProvider
     */
    public static function findMyBooks($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }

        $query = Logistics::find()->Where('fit_user_id=:user_id', [':user_id' => $data['user_id']])->orderBy(" fee_lock asc,id desc ");
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $data['limit']]);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return ['models' => $models, 'pages' => $pages];
    }

    /**
     * 
     * @param int $data
     * @return \yii\data\ActiveDataProvider
     */
    public static function findMyGifts($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }

        $query = Logistics::find()->Where('to_user_id=:user_id', [':user_id' => $data['user_id']])->orderBy(" fee_lock asc,id desc ");
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $data['limit']]);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return ['models' => $models, 'pages' => $pages];
    }

    public static function findIndexLists($limit) {
        return Product::find()->limit($limit)->orderBy(" product_id desc ")->all();
    }

}
