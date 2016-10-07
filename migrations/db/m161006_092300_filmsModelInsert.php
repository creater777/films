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
            'preview' => '',
            'date' => '1475821264',
            'director_id' => '1',
        ], false);
        if(!$model->save()){
            $this->stderr('Fail save model with attributes '
                .VarDumper::dumpAsString($model->getAttributes()).' with errors '
                .VarDumper::dumpAsString($model->getErrors()));
                throw new Exception('Fail save $model');
        }
        $model = new Films();
        $model->setAttributes([
            'id' => '2',
            'name' => 'Глубоководный горизонт',
            'preview' => '/films/web/img/2/thumb-2.jpg',
            'date' => '1473714000',
            'director_id' => '2',
        ], false);
        if(!$model->save()){
            $this->stderr('Fail save model with attributes '
                .VarDumper::dumpAsString($model->getAttributes()).' with errors '
                .VarDumper::dumpAsString($model->getErrors()));
                throw new Exception('Fail save $model');
        }
        
        $model = new Directors();
        $model->setAttributes([
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
        $model = new Directors();
        $model->setAttributes([
            'id' => '2',
            'firstname' => 'Питер',
            'lastname' => 'Берг',
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
