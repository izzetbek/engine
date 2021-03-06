<?php
namespace core\entities\User;

use core\entities\Training\Training;
use core\entities\Webinar\Webinar;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $surname
 * @property string $company
 * @property string $phone
 * @property string $thumb
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email_confirm_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $role
 * @property Network[] $networks
 * @property Webinar[] $webinars
 * @property Training[] $trainings
 */

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_WAIT = 0;
    const STATUS_ACTIVE = 10;

    const DEFAULT_ROLE = 'user';
    const DEFAULT_THUMB = 'default.png';

    const SAVE_FOLDER = 'users';

    public static function create($username, $name, $surname, $company, $phone, $thumb, $email, $password, $role)
    {
        $user = new self();
        $user->username = $username;
        $user->name = $name;
        $user->surname = $surname;
        $user->company = $company;
        $user->phone = $phone;
        $user->thumb = (!empty($thumb))? $thumb : self::DEFAULT_THUMB;
        $user->email = $email;
        $user->setPassword(!empty($password)? $password : Yii::$app->security->generateRandomString());
        $user->created_at = time();
        $user->status = self::STATUS_ACTIVE;
        $user->generateAuthKey();
        $user->role = (!empty($role))? $role : self::DEFAULT_ROLE;
        return $user;
    }

    public function edit($username, $name, $surname, $company, $phone, $thumb, $email, $role)
    {
        $this->username = $username;
        $this->name = $name;
        $this->surname = $surname;
        $this->company = $company;
        $this->phone = $phone;
        $this->thumb = $thumb;
        $this->email = $email;
        $this->role = $role;
        $this->updated_at = time();
    }

    public function deactivate()
    {
        $this->status = self::STATUS_WAIT;
    }

    public function activate()
    {
        $this->status = self::STATUS_ACTIVE;
    }


    public static function requestSignup($username, $name, $surname, $company, $phone, $thumb, $email, $password)
    {
        $user = new self();
        $user->username = $username;
        $user->name = $name;
        $user->surname = $surname;
        $user->company = $company;
        $user->phone = $phone;
        $user->thumb = $thumb;
        $user->email = $email;
        $user->setPassword($password);
        $user->created_at = time();
        $user->status = self::STATUS_WAIT;
        $user->generateEmailConfirmToken();
        $user->generateAuthKey();
        $user->role = self::DEFAULT_ROLE;
        return $user;
    }

    public function confirmSignup()
    {
        if(!$this->isWait()) {
            throw new \DomainException('User is already active');
        }
        $this->status = self::STATUS_ACTIVE;
        $this->removeEmailConfirmToken();
    }

    public static function signupByNetwork($network, $identity)
    {
        $user = new self();
        $user->created_at = time();
        $user->status = self::STATUS_ACTIVE;
        $user->generateAuthKey();
        $user->networks = [Network::create($network, $identity)];
        return $user;
    }

    public function attachNetwork($network, $identity)
    {
        $networks = $this->networks;
        foreach ($networks as $current) {
            if($current->isFor($network, $identity)) {
                throw new \DomainException('Network is already attached');
            }
            $networks[] = Network::create($network, $identity);
            $this->networks = $networks;
        }
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SaveRelationsBehavior::className(),
                'relations' => ['networks'],
            ]
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function getNetworks()
    {
        return $this->hasMany(Network::className(), ['user_id' => 'id']);
    }

    public function getWebinars()
    {
        return $this->hasMany(Webinar::className(), ['id' => 'webinar_id'])->viaTable('{{%users_webinars}}', ['user_id' => 'id']);
    }

    public function getTrainings()
    {
        return $this->hasMany(Training::className(), ['id' => 'trainings_id'])->viaTable('{{%users_trainings}}', ['users_id' => 'id']);
    }

    public function getOnlineTests()
    {
        return $this->hasMany(Training::className(), ['id' => 'online_tests_id'])->viaTable('{{%users_online_tests}}', ['users_id' => 'id']);
    }


    private function generateEmailConfirmToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString();
    }

    private function removeEmailConfirmToken()
    {
        $this->email_confirm_token = null;
    }

    public function requestPasswordReset()
    {
        if (!empty($this->password_reset_token) && self::isPasswordResetTokenValid($this->password_reset_token)) {
            throw new \DomainException('Password resetting has already been requested.');
        }
        $this->generatePasswordResetToken();
    }

    public function resetPassword($password)
    {
        if(empty($this->password_reset_token)) {
            throw new \DomainException('Password resetting was not requested yet.');
        }
        $this->setPassword($password);
        $this->removePasswordResetToken();
    }

    /**
     * @inheritdoc
     */
    public function isActive()
    {
        return ($this->status === self::STATUS_ACTIVE);
    }

    /**
     * @inheritdoc
     */
    public function isWait()
    {
        return ($this->status === self::STATUS_WAIT);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    private function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    private function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    private function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    private function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
