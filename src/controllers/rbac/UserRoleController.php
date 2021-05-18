<?php

namespace qviox\mentor\controllers\rbac;
use qviox\mentor\models\rbac\URole;
use qviox\mentor\models\rbac\UserURole;
use qviox\mentor\models\search\UserSearch;
use qviox\mentor\models\User;
use qviox\mentor\models\UserUType;
use qviox\mentor\models\UType;
use Yii;
use yii\helpers\ArrayHelper;
/**
 * ParticipantsController implements the CRUD actions for User model.
 */
class UserRoleController extends RuleController
{
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchUserRole(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        $role=$model->userURole ?? new UserURole();
        $roles = ArrayHelper::map(URole::find()->all(), 'id', 'label');

        $utype = $model->userUType??new UserUType();
        $utypes = ArrayHelper::map(UType::find()->all(), 'id', 'label');
        $succes="";
        if(Yii::$app->request->post()["UserURole"]["user_role_id"]==="0"){
            if(UserURole::deleteAll(['user_id'=>$model->id]))
                $succes.='Роль успешно изменена.';

//            return $this->redirect(['update', 'id' => $model->id]);
        }
        else{
            if ($role->load(Yii::$app->request->post()) && $role->save()) {
                $succes.=' Роль успешно изменена.';
//                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        if ($utype->load(Yii::$app->request->post()) && $utype->save()) {
            $succes.='Тип успешно изменен.';
        }
if($succes){
    Yii::$app->session->setFlash('success', $succes);
    return $this->redirect(['update', 'id' => $model->id]);
}


        return $this->render('update', [
            'model' => $model,
            'roles' => $roles,
            'role' => $role,
            'utype'=>$utype,
            'utypes'=>$utypes
        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
