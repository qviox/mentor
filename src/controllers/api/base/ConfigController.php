<?php

namespace qviox\mentor\controllers\api\base;

use function Matrix\identity;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;


class ConfigController extends Controller
{

    public $modelClass = 'api\models\Userupdate';
    public $enableCsrfValidation = false;
    public $return = array();

    public static function allowedDomains()
    {
        return [
            '*',
        ];
    }

    public function beforeAction($action)
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['*'],
            ],

        ];

        unset($behaviors['authenticator']);

        return $behaviors;
    }



}
