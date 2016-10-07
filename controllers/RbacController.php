<?php
namespace app\controllers;
 
use Yii;
use yii\console\Controller;
use app\models\User;
 
/**
 * Инициализация доступов
 * Изначально создается пользователи:
 * - admin с паролем admin с правами администратора
 * - moder с паролем moder с правами модератора
 * - user с паролем user с правами пользователя
 * запускается из консоли php yii rbac/init
 * @throws \Exception
 */
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        //$auth->removeAll(); //удаляем старые данные

        //Права редактора
        $editFilms = $auth->createPermission(User::PERMISSION_EDITFILMS);
        $auth->add($editFilms);

        //Добавляем роли
        $moder = $auth->createRole(User::ROLE_MODERATOR);
        $moder->description = User::getRoleList()[User::ROLE_MODERATOR];
        $auth->add($moder);
        $auth->addChild($moder,$editFilms);

        $admin = $auth->createRole(User::ROLE_ADMIN);
        $admin->description = User::getRoleList()[User::ROLE_ADMIN];
        $auth->add($admin);
        $auth->addChild($admin,$editFilms);
        
        //Заведение администратора
        if ($adminUser=User::findByUsername("admin")){
            $adminUser->delete();
        }
        $adminUser = new User();
        $adminUser->username = "admin";
        $adminUser->email = "admin@films.ru";
        $adminUser->setPassword("admin");
        $adminUser->activateUser();
        $adminUser->setRole(User::ROLE_ADMIN);
        if (!$adminUser->insert(false)){
            throw new \Exception("Unable to add user admin");
        }
        
        //Заведение модератора
        if ($moderUser=User::findByUsername("moder")){
            $moderUser->delete();
        }
        $moderUser = new User();
        $moderUser->username = "moder";
        $moderUser->email = "moder@films.ru";
        $moderUser->setPassword("moder");
        $moderUser->activateUser();
        $moderUser->setRole(User::ROLE_MODERATOR);
        if (!$moderUser->insert(false)){
            throw new \Exception("Unable to add user moder");
        }
    }
}