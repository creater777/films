<?php
namespace tests\codeception\unit\models;

use Yii;
use yii\codeception\TestCase;
use app\models\Films;
use Codeception\Specify;

class FilmsTest extends TestCase{
    
    use Specify;
    
    private $_news;
    
    protected function setUp() {
        parent::setUp();
        $this->_news = new Films();
    }


    protected function tearDown(){
        parent::tearDown();
        $this->_news->delete();
    }

    public function testFilmsDateInner(){
        $date = date("d.m.Y");
        $this->_news->dateInner=$date;
        $news = $this->_news;
        $this->specify('Проверка геттера и сеттера для поля date', function () use ($date, $news) {
            expect('date должна установиться', strtotime($date) == $news->date)->true();
        });
    }
    
    public function testFilmsSave(){
        $this->_news->subj='subj';
        $this->_news->post='post';
        $this->_news->save(false);
        $news = $this->_news;
        $this->specify('Проверка автозаполнения при сохранени', function () use ($news) {
            expect('date должна установиться', $news->date != 0)->true();
            expect('createat должна установиться', $news->createat != 0)->true();
            expect('updateat должна установиться', $news->updateat != 0)->true();
        });        
    }
}
