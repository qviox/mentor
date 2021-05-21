<?php

namespace qviox\mentor\controllers\admin;

use app\components\statistics\CourseGenerator;
use app\models\forms\LoginForm;
use app\models\User;
use app\models\UserPoints;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Default controller for the `admin` module
 */
class ImportController extends RuleController
{


    public function actionImportQuiz() {
        if ($import = UploadedFile::getInstanceByName('import') ) {
          $handle = fopen( $import->tempName,'r');
          $i=0;
            while (($row = fgetcsv($handle,0,';')) !== false) {

                $up = new UserPoints();

                $up->user_id = $row[0];
                $up->points = $row[1];
                $up->info = 'Квиз '.date('d.m.Y');
                $up->save();
                $i++;

            }

            Yii::$app->session->setFlash('success', 'Ипортировано балов для '.$i.' пользователей');

          return  $this->redirect('/admin/default/import-quiz');
        }

        return $this->render('import_quiz');
    }


}
