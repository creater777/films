<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use app\models\Directors;
/**
 * Films - модель фильма, реализует методы доступа и модель поведения
 *
 * @property integer $id - идентификатор
 * @property string name
 * @property integer date_create / дата создания записи
 * @property integer date_update / дата обновления записи
 * @property string preview / путь к картинке постера фильма
 * @property integer date / дата выхода фильма
 * @property integer director_id / ид режиссера в таблице режиссеры
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
            [['director_id'], 'integer'],
            //[['preview'], 'image',  'skipOnEmpty' => false],
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
     * Действие перед сохранением
     * @param type $insert
     * @return boolean
     */
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        if ($insert){
            $this->date_create = time();
        }
        $this->date_update = time();
        $file = UploadedFile::getInstance($this, 'preview');
        if (!$file){
            return true;
        }

        $dir = __DIR__ . '/../web/img/';
        if (!file_exists($dir . $this->id . '/')){
            mkdir($dir . $this->id . '/');
        }
        $nameThumb = $this->id . '/' . 'thumb-' . $this->id;
        $nameOrigin = $this->id . '/' . $this->id;
        $ext = '.' . $file->getExtension();

        $uploaded = $file->saveAs( $dir . $nameOrigin . $ext);
        if (!$uploaded){
            return false;
        }
        
        $img = Image::getImagine()->open($dir . $nameOrigin . $ext);
        $size = $img->getSize();
        $width = 200;
        $height = round($size->getHeight() * $width/$size->getWidth());
        $box = new Box ($width, $height);
        $img->resize($box)->save($dir . $nameThumb. $ext);
        $this->preview = Url::base() . '/img/'. $nameThumb . $ext;

        return true;
    }
    
}
