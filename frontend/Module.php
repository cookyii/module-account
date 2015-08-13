<?php
/**
 * Module.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\frontend;

use cookyii\modules\Account;

/**
 * Class Module
 * @package cookyii\modules\Account\frontend
 */
class Module extends \yii\base\Module implements \yii\base\BootstrapInterface
{

    public $defaultRoute = 'sign/in';

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getI18n()
            ->translations['account'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages',
        ];
    }
}