<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property string $title
 * @property integer $genreid
 * @property integer $typeid
 * @property string $year
 * @property integer $countryid
 * @property string $rating
 * @property string $pricein
 * @property integer $pricesale
 * @property string $img
 * @property string $description
 * @property string $trailer
 *
 * @property Carts[] $carts
 * @property Genres $genre
 * @property Types $type
 * @property Countries $country
 * @property Rewiews[] $rewiews
 */
class Items extends \yii\db\ActiveRecord
{
    public $image;
    public $country;
    public $genre;
    public $type;
    public $rewiews;

    public function afterFind(){

        $this->image = '../web/images/'.$this->img;
        $this->country = Countries::find()->where(['id' => $this->countryid])->one()->name;
        $this->genre = Genres::find()->where(['id' => $this->genreid])->one()->name;
        $this->type = Types::find()->where(['id' => $this->typeid])->one()->name;
        $this->rewiews = Rewiews::find()->where(['itemid' => $this->id])->orderBy(['date'=> SORT_DESC])->all();
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'genreid', 'typeid', 'year', 'countryid', 'img', 'description', 'trailer'], 'required'],
            [['genreid', 'typeid', 'year', 'countryid', 'rating'], 'integer'],
            [['description'], 'string'],
            [['title', 'img', 'trailer'], 'string', 'max' => 255],
            [['genreid'], 'exist', 'skipOnError' => true, 'targetClass' => Genres::className(), 'targetAttribute' => ['genreid' => 'id']],
            [['typeid'], 'exist', 'skipOnError' => true, 'targetClass' => Types::className(), 'targetAttribute' => ['typeid' => 'id']],
            [['countryid'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['countryid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'genreid' => 'Genreid',
            'typeid' => 'Typeid',
            'year' => 'Year',
            'countryid' => 'Countryid',
            'rating' => 'Rating',
            'img' => 'Img',
            'description' => 'Description',
            'trailer' => 'Trailer',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Carts::className(), ['itemid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genres::className(), ['id' => 'genreid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Types::className(), ['id' => 'typeid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['id' => 'countryid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRewiews()
    {
        return $this->hasMany(Rewiews::className(), ['itemid' => 'id']);
    }
}
