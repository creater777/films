<?php

namespace app\models;

use Yii;
use app\models\Films;
/**
 * Режисеры - модель режисеров
 *
 * @property integer $id - идентификатор
 * @property id
 * @property firstname / имя режиссера
 * @property lastname / фамилия режиссера
 * 
 */
class Directors extends \yii\db\ActiveRecord{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'directors';
    }
    
    public function getFilms(){
        return Films::hasMany(Films::className(), ['director_id' => 'id']);
    }
    
    public function getFullName(){
        return $this->firstname.' '.$this->lastname;
    }
    
}
