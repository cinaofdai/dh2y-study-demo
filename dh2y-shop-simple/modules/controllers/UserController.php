<?php
/**
 * Created by dh2y.
 * bolg: http://blog.csdn.net/sinat_22878395
 * Date: 2017/7/28 9:51
 * functional: 功能说明
 */

namespace app\modules\controllers;

use app\models\Profile;
use Yii;
use app\models\User;
use yii\data\Pagination;
use yii\web\Controller;

class UserController extends Controller
{
    /**
     * 用户列表
     * @return string
     */
    public function actionUsers()
    {
        $model = User::find()->joinWith('profile');
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['user'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $users = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('users', ['users' => $users, 'pager' => $pager]);
    }

    /**
     * 添加用户
     * @return string
     */
    public function actionReg()
    {
        $model = new User;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->reg($post)) {
                Yii::$app->session->setFlash('info', '添加成功');
            }
        }
        $model->userpass = '';
        $model->repass = '';
        return $this->render("reg", ['model' => $model]);
    }

    /**
     * 删除用户
     * @throws \yii\db\Exception
     */
    public function actionDel()
    {
        try{
            $userid = (int)Yii::$app->request->get('userid');
            if (empty($userid)) {
                throw new \Exception();
            }
            $trans = Yii::$app->db->beginTransaction();
            if ($obj = Profile::find()->where('uid = :id', [':id' => $userid])->one()) {
                $res = Profile::deleteAll('uid = :id', [':id' => $userid]);
                if (empty($res)) {
                    throw new \Exception();
                }
            }
            if (!User::deleteAll('uid = :id', [':id' => $userid])) {
                throw new \Exception();
            }
            $trans->commit();
        } catch(\Exception $e) {
            if (Yii::$app->db->getTransaction()) {
                $trans->rollback();
            }
        }
        $this->redirect(['user/users']);
    }
}