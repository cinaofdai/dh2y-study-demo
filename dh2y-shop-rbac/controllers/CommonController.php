<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Category;
use app\models\Cart;
use app\models\User;
use app\models\Product;
use Yii;

class CommonController extends Controller
{

    protected $actions = ['*'];
    protected $except = [];
    protected $mustLogin = [];
    protected $verbs = [];

    public function behaviors(){
        return [
          'access' => [
              'class'=>\yii\filters\AccessControl::className(),
              'only' => $this->actions,
              'except' => $this->except,
              'rules'=>[
                  [
                      'allow' => false,
                      'actions'=>empty($this->mustLogin)?[]:$this->mustLogin,
                      'roles'=>['?']
                  ],
                  [
                      'allow' => true,
                      'actions'=>empty($this->mustLogin)?[]:$this->mustLogin,
                      'roles'=>['@']
                  ]
              ]
          ],
          'verbs'=>[
              'class'=>\yii\filters\VerbFilter::className(),//访问方式过滤
              'actions'=>$this->verbs
          ]

        ];
    }

    public function init()
    {
        $menu = Category::getMenu();
        $this->view->params['menu'] = $menu;
        $data = [];
        $data['products'] = [];
        $total = 0;
        if (Yii::$app->session['isLogin']) {
            $usermodel = User::find()->where('username = :name', [":name" => Yii::$app->session['loginname']])->one();
            if (!empty($usermodel) && !empty($usermodel->userid)) {
                $userid = $usermodel->userid;
                $carts = Cart::find()->where('userid = :uid', [':uid' => $userid])->asArray()->all();
                foreach($carts as $k=>$pro) {
                    $product = Product::find()->where('productid = :pid', [':pid' => $pro['productid']])->one();
                    $data['products'][$k]['cover'] = $product->cover;
                    $data['products'][$k]['title'] = $product->title;
                    $data['products'][$k]['productnum'] = $pro['productnum'];
                    $data['products'][$k]['price'] = $pro['price'];
                    $data['products'][$k]['productid'] = $pro['productid'];
                    $data['products'][$k]['cartid'] = $pro['cartid'];
                    $total += $data['products'][$k]['price'] * $data['products'][$k]['productnum'];
                }
            }
        }
        $data['total'] = $total;
        $this->view->params['cart'] = $data;
        $tui = Product::find()->where('istui = "1" and ison = "1"')->orderby('createtime desc')->limit(3)->all();
        $new = Product::find()->where('ison = "1"')->orderby('createtime desc')->limit(3)->all();
        $hot = Product::find()->where('ison = "1" and ishot = "1"')->orderby('createtime desc')->limit(3)->all();
        $sale = Product::find()->where('ison = "1" and issale = "1"')->orderby('createtime desc')->limit(3)->all();
        $this->view->params['tui'] = (array)$tui;
        $this->view->params['new'] = (array)$new;
        $this->view->params['hot'] = (array)$hot;
        $this->view->params['sale'] = (array)$sale;
    }
}
