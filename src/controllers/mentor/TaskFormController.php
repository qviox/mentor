<?php

namespace qviox\mentor\controllers\mentor;
use qviox\mentor\models\scores\TaskInput;
use yii\web\Controller;
use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\db\Exception;
/**
 * Class SkillUserController
 * @package app\modules\admin\controllers
 */
class TaskFormController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@','?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function actionTest(){
        return $this->render('test');
    }
    /*
    public function actionSaveTaskData(){
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            $post=Yii::$app->request->post();
            if($post){
                $TaskInputs=$post['TaskInput'];
                foreach($TaskInputs as $idTaskInput=>$item){
                    $taskInput=TaskInput::findOne($idTaskInput);
                    if(!$taskInput)
                        return false;
                     $taskInput->saveTaskInputValue($item);
                }

            }
            if($files=$_FILES['TaskInputFile']['name']['TaskInputFiles']){
                foreach($files as $key=>$filename){
                    $taskInput=TaskInput::findOne($key);
                   $paths[]= $taskInput->saveTaskInputValueFile();
                }
            }
         $transaction->commit();
        } catch (Exception $e) {
            foreach($paths as $path){
                foreach(explode(';',$path) as $p){
                    unlink(Yii::getAlias('@'.$p));
                }
            }
            $transaction->rollback();
            return $e->getMessage();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }*/
}
