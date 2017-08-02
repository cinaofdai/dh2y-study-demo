<?php

namespace app\modules\controllers;

use yii\web\Controller;
use Yii;

class CommonController extends Controller
{
    protected $actions = ['*'];
    protected $except = [];
    protected $mustLogin = [];

    public function behaviors(){
        return [
          'access'=>[
              'class' => \yii\filters\AccessControl::className(),
              'user'=> 'admin', //使用的用户组件。
              'only' => $this->actions,
              'except' => $this->except,
              'rules' =>[
                  [
                      'allow' => true,
                      'actions'=> empty($this->mustLogin)?[]:$this->mustLogin,
                      'roles' => ['@']
                  ],
                  [
                      'allow' => false,
                      'actions' => empty($this->mustLogin)?[]:$this->mustLogin,
                      'roles' => ['?']
                  ]
              ]
          ],

        ];
    }

    /*public function init()
    {
        if (Yii::$app->session['admin']['isLogin'] != 1) {
            return $this->redirect(['/admin/public/login']);
        }
    }*/
}
