<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * SaveForm is the model behind the Manager.
 */

class SaveForm extends Model{

  	public $title;
  	public $genre;
  	public $type;
  	public $year;
  	public $country;
  	public $rating;
  	public $img;
  	public $description;
  	public $trailer;
  	public $id;


	public function rules()
    {
        return [
            // this property is are required
            [['title', 'genre', 'type', 'year', 'country','img','description','trailer',], 'required', 'message'=>'Введите данные!!'],
            ['img', 'file', 'extensions' => 'png, jpg', 'message'=>'Только png, jpg!!'],
        ];
    }
  public function upload(){
     if ($this->validate() && is_object($this->img)){
         $this->img->saveAs('../web/images/'. $this->img->baseName . '.' . $this->img->extension);
         return true;
     } 
     else{
         return false;
     }
  }
}