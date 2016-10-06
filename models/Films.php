<?php

namespace app\models;

use Yii;
use app\models\Directors;
/**
 * Films - модель фильма, реализует методы доступа и модель поведения
 *
 * @property integer $id - идентификатор
 * @property name
 * @property date_create / дата создания записи
 * @property date_update / дата обновления записи
 * @property preview / путь к картинке постера фильма
 * @property date / дата выхода фильма
 * @property director_id / ид режиссера в таблице режиссеры
 */
class Films extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'movies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['dateInner', 'date', 'format' => 'php:d.m.Y'],
            [['name'], 'string'],
            [['preview'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'date_create' => 'Дата создания записи',
            'date_update' => 'Дата обновления записи',
            'dateInner' => 'Дата',
            'preview' => 'Постер',
            'post' => 'Содержание',
            'director' => 'Режисер',
        ];
    }
    
    public function getDirector(){
        return Directors::hasOne(Directors::className(), ['id' => 'director_id']);
    }
    
    /**
     * Геттеры и сеттеры виртуального поля DateInner, 
     * предназначенный для визуального отображения даты выхода фильма (поле date)
     * @param type string $value - строковое значение времени
     * @return type int - значение времени по Unix
     */
    public function setDateInner($value){
        return $this->date = $value ? strtotime($value) : null;
    }

    /**
     * @return type string - строковое значение времени
     */
    public function getDateInner(){
        return $this->date ? date("d.m.Y", $this->date) : '';
    }

    /**
     * Геттеры и сеттеры виртуального поля filmsInPage
     * предназначенного для хранения соответствующего поля в куках
     * используется в настройках отображения колличества фильмов на странице
     * @return type int - значение filmsInPage из куков
     */
    public static function getFilmsInPage(){
        return filter_input(INPUT_COOKIE, 'filmsInPage');
    }
    
    /**
     * Установка filmsInPage в куки
     * @param type $value - значение filmsInPage
     */
    public static function setFilmsInPage($value){
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'filmsInPage',
            'value' => $value,
        ]));
    }
    
    /**
     * Действие перед сохранение новости
     * при добавление устанавливается значение createat,
     * updateat при любом сохранении
     * @param type $insert
     * @return boolean
     */
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        if ($insert){
            $this->createat = time();
        }
        if (!isset($this->date) || $this->date ==0){
            $this->date = time();
        }
        $this->updateat = time();
        return true;
    }
    
}
