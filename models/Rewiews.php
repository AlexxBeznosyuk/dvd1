<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rewiews".
 *
 * @property integer $id
 * @property string $username
 * @property string $date
 * @property integer $itemid
 * @property string $msg
 *
 * @property Items $item
 */
class Rewiews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rewiews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'itemid', 'msg'], 'required'],
            [['date'], 'integer'],
            [['itemid'], 'integer'],
            [['msg'], 'string'],
            [['username'], 'string', 'max' => 255],
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
            'username' => 'Username',
            'date' => 'Date',
            'itemid' => 'Itemid',
            'msg' => 'Msg',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Items::className(), ['id' => 'itemid']);
    }
    
    public function afterFind(){

		$monthes = [
			1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 4 => 'Апреля', 5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 
			8 => 'Августа', 9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
		];

		$this->date = date('j ', $this->date). $monthes[date('n', $this->date)].date(', Y', $this->date);
	}
}
