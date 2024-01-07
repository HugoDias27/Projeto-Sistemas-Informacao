<?php

namespace frontend\controllers;

use common\models\Imagem;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Produto;
use yii\data\Pagination;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['cliente'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    // Método que vai para o index do site onde apresenta todos os produtos
    public function actionIndex()
    {
        $query = Produto::find();

        $paginacao = new Pagination(['defaultPageSize' => 9, 'totalCount' => $query->count()]);

        $produtos = $query->offset($paginacao->offset)->limit($paginacao->limit)->all();

        $imagens = [];
        foreach ($produtos as $produto) {
            $primeiraImagem = $produto->getImagens()->orderBy(['id' => SORT_ASC])->one();
            if ($primeiraImagem) {
                $imagens[$produto->id] = $primeiraImagem;
            }
        }

        return $this->render('index', ['produtos' => $produtos, 'paginacao' => $paginacao, 'imagens' => $imagens]);
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    // Método que faz o login
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user_id = Yii::$app->user->identity->getId();
            $userRoles = Yii::$app->authManager->getRolesByUser($user_id);

            foreach ($userRoles as $role) {
                if ($role->name === 'cliente') {
                    return $this->goBack();
                } else {
                    Yii::$app->user->logout();
                    return $this->redirect('/projeto/backend/web');
                }
            }
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    // Método que faz o logout
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    // Método que vai para a página de contactos
    public function actionContact()
    {
        return $this->render('contact');
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    // Método que vai para a página sobre
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    // Método que permite registar o utilizador
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->goHome();
        }

        return $this->render('signup', ['model' => $model,]);
    }
}
