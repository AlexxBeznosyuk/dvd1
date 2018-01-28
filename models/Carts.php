<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carts".
 *
 * @property integer $id
 * @property integer $itemid
 * @property integer $orderid
 * @property string $date
 * @property integer $pricein
 *
 * @property Items $item
 */
class Carts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['itemid', 'orderid', 'pricein'], 'required'],
            [['itemid', 'orderid', 'pricein'], 'integer'],
            [['date'], 'safe'],
            [['itemid'], 'exist', 'skipOnError' => true, 'targetClass' => Items::className(), 'targetAttribute' => ['itemid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'itemid' => 'Itemid',
            'orderid' => 'Orderid',
            'date' => 'Date',
            'pricein' => 'Pricein',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Items::className(), ['id' => 'itemid']);
    }
}
