<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class FilterForm extends Model{

    public $type;
    public $country;
    public $genre;
    public $year;
    public $rating;

	public function getProp($prop){
		return $this->$prop;
	}

	public function rules()
    {
        return [
            // this property is are required
           //['type', 'radio']           
        ];
    }
  public function search($post){
      $where = [];
      $order = [];
      $session = Yii::$app->session;
      $session->open();
        if ($post['type']){          
             $session['type'] = $post['type'];
        }
        if ($session['type']){
          ArrayHelper::setValue($where, 'typeid', $session['type']);
        }
        if($post['FilterForm']['country'] != 0){
          $session['country'] = $post['FilterForm']['country'];
        }
        else{
           $session->remove('country');
        }
        if ($session['country']){
          ArrayHelper::setValue($where, 'countryid', $session['country']);
        }
        if($post['FilterForm']['genre'] != 0){
          $session['genre'] = $post['FilterForm']['genre'];
        }
        else{
           $session->remove('genre');
        }
        if ($session['genre']){
          ArrayHelper::setValue($where,'genreid', $session['genre']);
        }
        if($post['year']){
            $session['year'] = $post['year'];
        }
        if($session['year']){
          switch($session['year']){
              case 'up': ArrayHelper::setValue($order,'year', SORT_ASC); break;
              case 'down': ArrayHelper::setValue($order,'year', SORT_DESC); break;
            }
        }
        if($post['rating']){
            $session['rating'] = $post['rating'];
        }
        if($session['rating']){
          switch($session['rating']){
              case 'up': ArrayHelper::setValue($order,'rating', SORT_ASC); break;
              case 'down': ArrayHelper::setValue($order,'rating', SORT_DESC); break;
            }
        }




        if (isset($post['reset-button'])){
          $session->remove('type');
          $session->remove('country');
          $session->remove('genre');
          $session->remove('year');
          $session->remove('rating');
          $filter = [];
        }
      return [
        'where' => $where,
        'order' => $order
      ];
  }
}