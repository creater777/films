<?php

use yii\db\Exception;
use yii\db\Migration;
use yii\helpers\VarDumper;
use yii\helpers\Console;
use app\models\Films;
use app\models\Directors;

class m161006_092300_filmsModelInsert extends Migration
{
    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $model = new Films();
        $model->setAttributes([
            'id' => '1',
            'name' => 'Дом странных детей Мисс Перегрин',
            'date_create' => '100',
            'date_update' => '100',
            'preview' => '',
            'date' => '100',
            'director_id' => '1',
        ], false);
        if(!$model->save()){
            $this->stderr('Fail save model with attributes '
                .VarDumper::dumpAsString($model->getAttributes()).' with errors '
                .VarDumper::dumpAsString($model->getErrors()));
                throw new Exception('Fail save $model');
        }
        
        $model = new Directors();
        $model->setAttribute([
            'id' => '1',
            'firstname' => 'Тим',
            'lastname' => 'Бёртон',
        ], false);
        if(!$model->save()){
            $this->stderr('Fail save model with attributes '
                .VarDumper::dumpAsString($model->getAttributes()).' with errors '
                .VarDumper::dumpAsString($model->getErrors()));
                throw new Exception('Fail save $model');
        }
    }

    public function safeDown()
    {
        $this->truncateTable('{{%films}} CASCADE');
        Films::deleteAll([]);
    }

    protected function stderr($message)
    {
        Console::output(Console::ansiFormat($message, [Console::FG_PURPLE]));
    }
}
