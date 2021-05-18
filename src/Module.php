<?php
namespace qviox\mentor;
use yii\base\Module as BaseModule;
class Module extends BaseModule
{
    public $controllerNamespace = 'qviox\mentor\controllers';

    public $userTable;
    public $uploads;
    public $adminEmails;
    public $userAttributes=[
        'name'=>'name',
        'surname'=>'surname',
    ];
}