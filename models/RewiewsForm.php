<?php 
namespace app\models;

use Yii;
use yii\base\Model;

class RewiewsForm extends Model{

	public $username;
	public $msg;
	public $rating;

	public function rules()
    {
        return [
           [['username', 'msg'], 'required', 'message' => 'Введите данные!!']
        ];
    }
}
?>