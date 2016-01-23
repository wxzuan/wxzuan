<?php

namespace common\models;

use Yii;
use common\models\LinkageType;

/**
 * This is the model class for table "web_linkage".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string $ename
 * @property string $eaname
 * @property string $cvalue
 */
class Linkage extends \yii\db\ActiveRecord {

    /**
     * 
     * @param type $value
     * @return string
     * 获得值与中文名,
     */
    public static function getValueChina($value = "qys_none", $stringtype = "question") {
        $questid = LinkageType::find()->where("ename=:ename", [":ename" => $stringtype])->one();
        if ($value === "qys_none") {
            //$result = Yii::app()->db->createCommand("select eaname,cvalue from {{linkage}} where type_id=" . $questid->id)->queryAll(true);
            $result = Linkage::find()->select('eaname,cvalue')->where('type_id=' . $questid->id)->all();
            if ($result) {
                $newarray = array();
                foreach ($result as $key => $value) {
                    $newarray[$value->cvalue] = $value->eaname;
                }
                return $newarray;
            } else {
                return ["1" => '无数据'];
            }
        } else {
            //$result = Linkage::model()->find("type_id=:type_id AND cvalue=:cvalue", array(":type_id" => $questid->id, ":cvalue" => $value));
            $result = Linkage::find()->where("type_id=:type_id AND cvalue=:cvalue", [":type_id" => $questid->id, ":cvalue" => $value])->one();
            if (!$result) {
                return '';
            } else {
                return $result->eaname;
            }
        }
#
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'web_linkage';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type_id'], 'integer'],
            [['ename', 'eaname', 'cvalue'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'ename' => 'Ename',
            'eaname' => 'Eaname',
            'cvalue' => 'Cvalue',
        ];
    }

}
