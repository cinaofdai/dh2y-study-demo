<?php
/**
 * Created by dh2y.
 * bolg: http://blog.csdn.net/sinat_22878395
 * Date: 2017/7/27 13:15
 * functional: 找回密码
 */

namespace app\modules\controllers;

use app\modules\models\Admin;
use yii;
use yii\web\Controller;
use yii\data\Pagination;

class ManageController extends Controller
{

    /**
     * 通过邮件找回密码
     * @return string
     * @throws yii\base\ExitException
     */
    public function actionMailChangePass(){
        $this->layout = false;

        $time = Yii::$app->request->get('timestamp');
        $username = Yii::$app->request->get('username');
        $token = Yii::$app->request->get('token');
        $model = new Admin();
        $my_token = $model->createToken($username,$time);
        if($my_token!=$token){
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        if(time()-$time>300){
            $this->redirect(['public/login']);
            Yii::$app->end();
        }

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if( $model->changePass($post)){
                Yii::$app->session->setFlash('info','密码修改成功');
            }
        }
        $model->username = $username;
        return $this->render('mail-change-pass',[
            'model' =>$model
        ]);
    }


    /**
     * 管理员列表
     * @return string
     */
    public function actionManagers(){

        $model = Admin::find();

        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['manage'];
        $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);

        $managers = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('managers',[
            'managers'=>$managers,
            'pager' => $pager
        ]);
    }

    /**
     * 添加管理员
     * @return string
     */
    public function actionReg(){
        $model = new Admin();
        if(Yii::$app->request->isPost){
            $post  = Yii::$app->request->post();
            if($model->reg($post)){
                Yii::$app->session->setFlash('info','添加成功');
            }else{
                Yii::$app->session->setFlash('info','添加失败');
            }
        }

        $model->adminpass = '';
        $model->repass = '';
        return $this->render('reg',[
            'model'=>$model
        ]);
    }

    public function actionDel(){
        $id = Yii::$app->request->get('id');
        if(empty($id)){
            $this->redirect(['manage/managers']);
        }
        $model = new Admin();
        if($model->deleteAll(['id'=>$id])){
            Yii::$app->session->setFlash('info','删除成功');
            $this->redirect(['manage/managers']);
        }
    }
}