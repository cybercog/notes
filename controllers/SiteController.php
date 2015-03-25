<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\SignupForm;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\Note;
use app\models\NoteSearch;
use yii\web\Cookie;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'profile', 'home'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'profile', 'home'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return Yii::$app->user->isGuest ?
            $this->redirect(['note/index']) :
            $this->redirect(['site/home']);
    }

    public function actionHome($viewType = null)
    {
        if ($viewType) {
            Yii::$app->response->cookies->add(new Cookie(['name' => 'viewType', 'value' => $viewType]));
        } else {
            if ($cookie = Yii::$app->request->cookies->get('viewType')) {
                $viewType = $cookie->value;
            } else {
                $viewType = 'panel';
                Yii::$app->response->cookies->add(new Cookie(['name' => 'viewType', 'value' => $viewType]));
            }
        }

        $query = Note::find();
        $noteSearch = new NoteSearch();
        $noteSearch->setScenario('own');
        $noteProvider = $noteSearch->search(Yii::$app->request->queryParams, ['user_id' => Yii::$app->user->identity->id]);

        $curDate = getdate();
        $beginOfCurDay = \DateTime::createFromFormat('Y-n-j H:i:s', $curDate['year'] . '-' . $curDate['mon'] . '-' . $curDate['mday'] . ' 00:00:00')
            ->getTimestamp();
        $beginOfCurMonth = \DateTime::createFromFormat('Y-n-j H:i:s', $curDate['year'] . '-' . $curDate['mon'] . '-1 00:00:00')
            ->getTimestamp();

        return $this->render('/notes', [
            'cur' => 'own',
            'viewType' => $viewType,
            'notes' => $noteProvider->getModels(),
            'pagination' => $noteProvider->pagination,
            'sort' => $noteProvider->sort,
            'noteSearch' => $noteSearch,
            'notesCountDay' => $query->where(['>=', 'created_at', $beginOfCurDay])->andWhere(['user_id' => Yii::$app->user->identity->id])->count(),
            'notesCountMonth' => $query->where(['>=', 'created_at', $beginOfCurMonth])->andWhere(['user_id' => Yii::$app->user->identity->id])->count(),
        ]);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if (!Yii::$app->user->isGuest) {
            $model->name = Yii::$app->user->identity->name;
            $model->email = Yii::$app->user->identity->email;
        }

        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['supportEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', ['model' => $model]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', ['model' => $model]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', ['model' => $model]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'На ваш адрес электронной почты высланы дальнейшие инструкции..');
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Невозможно восстановить пароль. Попробуйте ещё раз.');
            }
        }

        return $this->render('requestPasswordResetToken', ['model' => $model]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Новый пароль был успешно сохранён.');
            return $this->goHome();
        }

        return $this->render('resetPassword', ['model' => $model]);
    }

    public function actionProfile()
    {
        $user = Yii::$app->user->identity;
        $profileModel = new \app\models\ProfileForm;
        $profileModel->attributes = $user->attributes;

        if ($profileModel->load(Yii::$app->request->post()) && $profileModel->editUser($user)) {
            Yii::$app->session->setFlash('profileChanged');

            return $this->refresh();
        }

        return $this->render('profile', ['profileModel' => $profileModel]);
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;

        if ($exception) {
            return $this->render('error', ['exception' => $exception]);
        } else {
            return $this->redirect('index');
        }
    }
}
