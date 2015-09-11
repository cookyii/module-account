<?php
/**
 * Google.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\resources\Account\Auth;

/**
 * Class Google
 * @package cookyii\modules\Account\resources\Account\Auth
 */
class Google extends AbstractSocial
{

    /**
     * @return \cookyii\modules\Account\resources\Account\Auth\queries\AccountGoogleQuery
     */
    public static function find()
    {
        return new \cookyii\modules\Account\resources\Account\Auth\queries\AccountGoogleQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_google}}';
    }
}