<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $repassword;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            [['password','repassword'], 'required'],
            [['password','repassword'], 'string', 'min' => 6],
            ['verifyCode','captcha'],
            //如果验证码没在SiteController下面，需要制定所在的控制器，如在LoginController下：
            //['verifyCode', 'captcha','captchaAction'=>'login/captcha','message'  =>'验证码错误'],
            
            ['repassword','compare','compareAttribute'=>'password','message'=>'两次密码不一致'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'email'=>'邮箱',
            'password'=>'密码',
            'repassword'=>'重复密码',
            'verifyCode'=>'验证码'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->created_at = time();
        $user->updated_at = time();
        
        return $user->save() ? $user : null;
    }
}
