<?php
/**
 * Created by dh2y.
 * bolg: http://blog.csdn.net/sinat_22878395
 * Date: 2017/7/25 19:33
 * functional: 功能说明
 */

namespace app\controllers;

use app\models\User;
use Yii;
use yii\web\Controller;

class MemberController extends Controller
{
    public $layout = 'layout';

    public function actionAuth()
    {
        if (Yii::$app->request->isGet) {
            $url = Yii::$app->request->referrer;
            if (empty($url)) {
                $url = "/";
            }
            Yii::$app->session->setFlash('referrer', $url);
        }
        $model = new User();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->login($post)) {
                //$url = Yii::$app->session->getFlash('referrer');
                //return $this->redirect($url);
            }
        }
        return $this->render("auth", ['model' => $model]);
    }


    public function actionLogout()
    {
        Yii::$app->session->remove('loginname');
        Yii::$app->session->remove('isLogin');
        if (!isset(Yii::$app->session['isLogin'])) {
            return $this->goBack(Yii::$app->request->referrer);
        }
    }


    /**
     * 通过电子邮箱注册
     * @return string
     */
    public function actionReg()
    {
        $model = new User;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->regByMail($post)) {
                Yii::$app->session->setFlash('info', '电子邮件发送成功');
            }
        }
        return $this->render('auth', ['model' => $model]);
    }


}