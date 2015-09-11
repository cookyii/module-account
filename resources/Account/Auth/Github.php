<?php
/**
 * Github.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\resources\Account\Auth;

/**
 * Class Github
 * @package cookyii\modules\Account\resources\Account\Auth
 */
class Github extends AbstractSocial
{

    /**
     * @return \cookyii\modules\Account\resources\Account\Auth\queries\AccountGithubQuery
     */
    public static function find()
    {
        return new \cookyii\modules\Account\resources\Account\Auth\queries\AccountGithubQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_github}}';
    }
}