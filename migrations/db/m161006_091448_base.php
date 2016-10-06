<?php

use yii\db\Migration;

class m161006_091448_base extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function Up()
    {
        $tableOptions = 'ENGINE=InnoDB';
        $transaction=$this->db->beginTransaction();
        try{
            $this->createTable('movies',[
               'id'=> $this->primaryKey(11),
               'date_create'=> $this->integer(11)->notNull(),
               'date_update'=> $this->integer(11)->notNull(),
               'name'=> $this->string(512)->null()->defaultValue(null),
               'date'=> $this->integer(11)->null()->defaultValue(null),
               'preview'=> $this->string(512)->null()->defaultValue(null),
               'director_id'=> $this->integer(11)->notNull(),
            ], $tableOptions);

            $this->createTable('directors',[
               'id'=> $this->primaryKey(11),
               'firstname'=> $this->string(512)->null()->defaultValue(null),
               'lastname'=> $this->string(512)->null()->defaultValue(null),
            ], $tableOptions);

            $this->createTable('users',[
               'id'=> $this->primaryKey(11),
               'createat'=> $this->integer(11)->notNull(),
               'updateat'=> $this->integer(11)->notNull(),
               'username'=> $this->string(255)->notNull(),
               'password'=> $this->string(40)->notNull(),
               'active'=> $this->integer(1)->null()->defaultValue(0),
               'email'=> $this->string(255)->null()->defaultValue(null),
               'authkey'=> $this->string(40)->notNull(),
               'authkeyexpired'=> $this->integer(11)->notNull(),
               'accessToken'=> $this->string(40)->notNull(),
            ], $tableOptions);
            $this->createIndex('username','{{%users}}','username',false);

            $transaction->commit();
        } catch (Exception $e) {
             echo 'Catch Exception '.$e->getMessage().' and rollBack this';
             $transaction->rollBack();
        }
    }

    public function Down()
    {
        $transaction=$this->db->beginTransaction();
        try{
            $this->dropTable('movies');
            $this->dropTable('users');
            $this->dropTable('directors');
            $transaction->commit();
        } catch (Exception $e) {
            echo 'Catch Exception '.$e->getMessage().' and rollBack this';
            $transaction->rollBack();
        }
    }
}
