<?php
/**
 * SignController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\frontend\controllers;

use cookyii\Facade as F;
use cookyii\modules\Account;
use yii\helpers\Url;

/**
 * Class SignController
 * @package cookyii\modules\Account\frontend\controllers
 */
class SignController extends Account\frontend\components\Controller
{

    use Account\traits\SocialAuthCallbackTrait;

    public $cookieExpire = 86400;

    /**
     * @var string name or alias of the view file, which should be rendered in order to perform redirection.
     * If not set default one will be used.
     */
    public $redirectView;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->redirectView)) {
            $this->redirectView = '@vendor/yiisoft/yii2-authclient/views/redirect.php';
        }
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'auth' => [
                'class' => \yii\authclient\AuthAction::class,
                'redirectView' => $this->redirectView,
                'successCallback' => [$this, 'socialAuthCallback'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['in', 'up', 'auth', 'fill', 'fill-redirect'],
                'roles' => ['?', '@'],
            ],
            [
                'allow' => true,
                'actions' => ['out'],
                'roles' => ['@'],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIn()
    {
        if (!F::User()->isGuest) {
            return $this->redirect(['/']);
        }

        $this->layout = '//wide';

        /** @var Account\forms\SignInForm $SignInForm */
        $SignInForm = \Yii::createObject(Account\forms\SignInForm::class);

        return $this->render('in', [
            'SignInForm' => $SignInForm,
        ]);
    }

    /**
     * @return string
     */
    public function actionUp()
    {
        if (!F::User()->isGuest) {
            return $this->redirect(['/']);
        }

        $this->layout = '//wide';

        /** @var Account\forms\SignUpForm $SignUpForm */
        $SignUpForm = \Yii::createObject(Account\forms\SignUpForm::class);

        return $this->render('up', [
            'SignUpForm' => $SignUpForm,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionOut()
    {
        F::User()->logout();

        return $this->goHome();
    }

    /**
     * @return string
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionFill()
    {
        $Client = F::Session()->get('OAuthResponseClient');

        if (empty($Client)) {
            throw new \yii\web\BadRequestHttpException;
        }

        $this->layout = '//wide';

        /** @var Account\forms\FillAttributesForm $FillAttributesForm */
        $FillAttributesForm = \Yii::createObject(Account\forms\FillAttributesForm::class);

        return $this->render('fill', [
            'FillAttributesForm' => $FillAttributesForm,
        ]);
    }

    /**
     * @return string
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionFillRedirect()
    {
        F::Session()->remove('OAuthResponseClient');

        return $this->renderFile($this->redirectView, [
            'url' => Url::to(['/']),
            'enforceRedirect' => true,
        ]);
    }
}