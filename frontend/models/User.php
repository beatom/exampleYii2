<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User as UserModel;
use frontend\models\User2Image;

class User extends Model
{

    protected $userModel;

    public $id;
    public $fb_id;
    public $vk_id;
    public $firstname;
    public $lastname;
    public $auth_key;
    public $password_hash;
    public $password_reset_token;
    public $email;
    public $show_email;
    public $skype;
    public $role;
    public $status;
    public $created_at;
    public $updated_at;
    public $phone;
    public $confirmed_email;
    public $confirmed_phone;
    public $confirmed_phone_code;
    public $password_reset_code;
    public $extra_phone1;
    public $extra_phone1_disable;
    public $extra_phone2;
    public $extra_phone2_disable;
    public $extra_phone3;
    public $extra_phone3_disable;
    public $extra_phone4;
    public $extra_phone4_disable;

    public $main_image;
    public $images;

    public function __construct($config = array()) {
        parent::__construct($config);

        $this->userModel = new UserModel();
    }

    public function scenarios() {
        $scenarios = $this->userModel->scenarios();
        $scenarios['edit'][] = 'main_image';
        $scenarios['edit'][] = 'images';

        return $scenarios;
    }

    public function rules()
    {

        $rules = $this->userModel->rules();

        return array_merge([
            ['main_image', 'safe'],
            ['images', 'safe'],
            ['email', 'checkEmail', 'on' => 'edit'],
        ], $rules);
    }

    public function attributeLabels()
    {

        return $this->userModel->attributeLabels();
    }

    public function checkPhone($attribute, $params)
    {

        $phone = $this->$attribute;

        // CHECK PHONE IS 10 DIGITS
        $phone = preg_replace('/[^0-9]/', '', (string) $phone);
        if(mb_strlen($phone) != 10) {
            $this->addError($attribute, 'Неверно указан телефон');
            return;
        }

        // CODE
        $code = mb_substr($phone, 0, 3);

        // NUMBER
        $number = mb_substr($phone, 3);
        $number = mb_substr($number, 0, 3) . '-' . mb_substr($number, 3, 2) . '-' . mb_substr($number, 5, 2);

        $this->$attribute = '(' . $code . ') ' . $number;
    }

    public function checkEmail($attribute, $params)
    {

        $email = $this->$attribute;
        $rows = UserModel::find()
                ->select(['id'])
                ->andFilterWhere(['email' => $email])
                ->andFilterWhere(['!=', 'id', $this->id])
                ->asArray()
                ->one();
        if(count($rows)) {
            $this->addError($attribute, Yii::t('user', 'signup_email_already_registered'));
            return;
        }
    }

    public function save()
    {

        // USER
        $user = UserModel::findOne($this->id);
        $user->scenario = 'edit';
        $user->load(['User' => $this->attributes]);
        $user->save();

        $image = new User2Image();
        $image->user_id    = $this->id;
        $image->main_image = $this->main_image;
        $image->images     = $this->images;

        if(User2Image::hasImages($this->id)) {
            $image->updateImages();
        }
        else {
            $image->addImages();
        }

        return true;
    }
}
