<?php

namespace app\models;

use Yii;
use app\models\Films;
/**
 * Режисеры - модель режисеров
 *
 * @property integer $id - идентификатор
 * @property string firstname / имя режиссера
 * @property string lastname / фамилия режиссера
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
    
    public static function getAll(){
        $rows = self::find()->all();
        $result = [];
        foreach($rows as $row){
            $result[$row->id] = $row->firstname. ' ' . $row->lastname;
        }
        return $result;
    }
    
    public function getFilms(){
        return Films::hasMany(Films::className(), ['director_id' => 'id']);
    }
    
    public function getFullName(){
        return $this->firstname.' '.$this->lastname;
    }
    
}
