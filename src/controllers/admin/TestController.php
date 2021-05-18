<?php
namespace qviox\mentor\controllers\admin;
use Yii;
use yii\web\Controller;
use qviox\mentor\models\TestMentor;
class TestController extends Controller
{

    public function actionIndex()
    {
        echo 12321;die();
        // регистрируем ресурсы:
        \qviox\mentor\MentorAssetsBundle::register($this->view);
        $datas = TestMentor::find()->all();
        return $this->render('index',[
            'datas' => $datas
        ]);
    }
}