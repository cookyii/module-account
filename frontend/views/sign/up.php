<?php
/**
 * up.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var \yii\web\View $this
 * @var Account\frontend\forms\SignUpForm $SignUpForm
 */

use cookyii\modules\Account;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

$this->title = \Yii::t('account', 'Sing up');

Account\frontend\assets\SignUpAssetBundle::register($this);

?>

<div class="box" ng-controller="SignUpController">
    <div class="box-logo">
        <?= Html::a(Html::img('/img/cookyii.png') . ' <strong>COOKYII</strong>frontend', ['/']) ?>
    </div>

    <div class="box-body">
        <?php
        /** @var \cookyii\widgets\angular\ActiveForm $form */
        $form = \cookyii\widgets\angular\ActiveForm::begin([
            'name' => 'SignUpForm',
            'action' => $SignUpForm->formAction(),
        ]);

        echo $form->field($SignUpForm, 'email')
            ->label(false)
            ->icon('envelope')
            ->textInput([
                'placeholder' => $SignUpForm->getAttributeLabel('email'),
            ]);

        echo $form->field($SignUpForm, 'name')
            ->label(false)
            ->icon('user')
            ->textInput([
                'placeholder' => $SignUpForm->getAttributeLabel('name'),
            ]);

        echo $form->field($SignUpForm, 'password')
            ->label(false)
            ->icon('lock')
            ->passwordInput([
                'placeholder' => $SignUpForm->getAttributeLabel('password'),
            ]);

        echo $form->field($SignUpForm, 'password_app')
            ->label(false)
            ->icon('lock')
            ->passwordInput([
                'placeholder' => $SignUpForm->getAttributeLabel('password_app'),
            ]);

        ?>
        <div class="row">
            <div class="col-xs-12 text-right">
                <?php
                $icon = FA::icon('cog', ['ng-show' => 'in_progress', 'class' => 'wo-animate'])->spin();

                echo Html::submitButton($icon . ' ' . Yii::t('account', 'Sign In'), [
                    'class' => 'btn btn-sm btn-primary btn-flat',
                    'ng-disabled' => 'in_progress',
                ]);
                ?>
            </div>
        </div>
        <?php
        \cookyii\widgets\angular\ActiveForm::end();

        $authAuthChoice = \yii\authclient\widgets\AuthChoice::begin([
            'baseAuthUrl' => ['/account/sign/auth'],
            'popupMode' => false,
            'autoRender' => false,
        ]);

        $AuthAuthChoiceClients = $authAuthChoice->getClients();

        if (!empty($AuthAuthChoiceClients)) {
            ?>
            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <?php
                foreach ($authAuthChoice->getClients() as $Client) {
                    $name = $Client->getName();
                    $icon = $name;
                    if ($icon === 'live') {
                        $icon = 'windows';
                    }
                    if ($icon === 'vkontakte') {
                        $icon = 'vk';
                    }
                    if ($icon === 'yandex') {
                        $icon = 'yahoo';
                    }

                    $icon = FA::icon($icon);

                    echo Html::a(
                        sprintf('%s Sign in using %s', $icon, $Client->getName()),
                        $authAuthChoice->createClientUrl($Client),
                        [
                            'class' => sprintf('btn btn-block btn-flat btn-social btn-%s', $name),
                        ]
                    );
                }
                ?>
            </div>
            <?php
        }
        \yii\authclient\widgets\AuthChoice::end();

        ?>

        <?= Html::a(Yii::t('account', 'Sign in'), ['/account/sign/in']) ?><br>
        <?= Html::a(Yii::t('account', 'I forgot my password'), ['/account/forgot-password']) ?>
    </div>
</div>