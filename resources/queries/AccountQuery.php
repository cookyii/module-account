<?php
/**
 * AccountQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\queries;

use cookyii\modules\Account;

/**
 * Class AccountQuery
 * @package cookyii\modules\Account\resources\queries
 *
 * @method \cookyii\modules\Account\resources\Account|array|null one($db = null)
 * @method \cookyii\modules\Account\resources\Account[]|array all($db = null)
 */
class AccountQuery extends \yii\db\ActiveQuery
{

    use \cookyii\db\traits\query\ActivatedQueryTrait,
        \cookyii\db\traits\query\DeletedQueryTrait;

    /**
     * @param integer|array $id
     * @return static
     */
    public function byId($id)
    {
        $this->andWhere(['id' => $id]);

        return $this;
    }

    /**
     * @param integer|array $Facebook_id
     * @return static
     */
    public function byFacebookId($Facebook_id)
    {
        return $this->bySocialId(Account\resources\AccountAuthFacebook::className(), $Facebook_id);
    }

    /**
     * @param integer|array $Github_id
     * @return static
     */
    public function byGithubId($Github_id)
    {
        return $this->bySocialId(Account\resources\AccountAuthGithub::className(), $Github_id);
    }

    /**
     * @param integer|array $Google_id
     * @return static
     */
    public function byGoogleId($Google_id)
    {
        return $this->bySocialId(Account\resources\AccountAuthGoogle::className(), $Google_id);
    }

    /**
     * @param integer|array $Linkedin_id
     * @return static
     */
    public function byLinkedinId($Linkedin_id)
    {
        return $this->bySocialId(Account\resources\AccountAuthLinkedin::className(), $Linkedin_id);
    }

    /**
     * @param integer|array $Live_id
     * @return static
     */
    public function byLiveId($Live_id)
    {
        return $this->bySocialId(Account\resources\AccountAuthLive::className(), $Live_id);
    }

    /**
     * @param integer|array $Twitter_id
     * @return static
     */
    public function byTwitterId($Twitter_id)
    {
        return $this->bySocialId(Account\resources\AccountAuthTwitter::className(), $Twitter_id);
    }

    /**
     * @param integer|array $Vkontakte_id
     * @return static
     */
    public function byVkontakteId($Vkontakte_id)
    {
        return $this->bySocialId(Account\resources\AccountAuthVkontakte::className(), $Vkontakte_id);
    }

    /**
     * @param integer|array $Yandex_id
     * @return static
     */
    public function byYandexId($Yandex_id)
    {
        return $this->bySocialId(Account\resources\AccountAuthYandex::className(), $Yandex_id);
    }

    /**
     * @param string|array $token
     * @return static
     */
    public function byToken($token)
    {
        $this->andWhere(['token' => $token]);

        return $this;
    }

    /**
     * @param string|array $name
     * @return static
     */
    public function byName($name)
    {
        $this->andWhere(['name' => $name]);

        return $this;
    }

    /**
     * @param string|array $email
     * @return static
     */
    public function byEmail($email)
    {
        $this->andWhere(['email' => $email]);

        return $this;
    }

    /**
     * @param string|array $login
     * @return static
     */
    public function byLogin($login)
    {
        $this->andWhere(['login' => $login]);

        return $this;
    }

    /**
     * @param string $query
     * @return static
     */
    public function search($query)
    {
        $words = explode(' ', $query);

        $this->andWhere([
            'or',
            array_merge(['or'], array_map(function ($value) {
                return ['like', 'id', $value];
            }, $words)),
            array_merge(['or'], array_map(function ($value) {
                return ['like', 'name', $value];
            }, $words)),
            array_merge(['or'], array_map(function ($value) {
                return ['like', 'email', $value];
            }, $words)),
        ]);

        return $this;
    }

    /**
     * @param string $class
     * @param integer|array $social_id
     * @return $this|static
     */
    protected function bySocialId($class, $social_id)
    {
        /** @var \cookyii\modules\Account\resources\queries\AbstractAccountAuthQuery $SocialQuery */
        $SocialQuery = $class::find();

        /** @var \cookyii\modules\Account\resources\AbstractAccountAuth $Social */
        $Social = $SocialQuery
            ->bySocialId($social_id)
            ->one();

        if (empty($Social)) {
            return $this->andWhere('1=0');
        } else {
            $this->byId($Social->account_id);
        }

        return $this;
    }
} 