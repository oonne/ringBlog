<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_account;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {

        if (!$this->hasErrors()) {
            $account = $this->getAccount();
            if (!$account) {
                $this->addError($attribute, '用户名或密码错误');
            }else if (!$account->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码错误');
            }
        }else{
            return $this->goHome();
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'rememberMe' => '记住密码'
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $account = $this->getAccount();
            $account->generateAuthKey();
            $account->save(false);
            return Yii::$app->user->login($account, $this->rememberMe ? 3600 * 24 * 3 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds SuperAccount by [[username]]
     *
     * @return SuperAccount|null
     */
    public function getAccount()
    {
        if ($this->_account === null) {
            $this->_account =  User::findByUserName($this->username);
        }

        return $this->_account;
    }
}
