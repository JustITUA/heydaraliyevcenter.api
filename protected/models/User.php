<?php

class User extends CActiveRecord {
    /**
     * The followings are the available columns in table 'user':
     * @var integer $id
     * @var string $phone
     * @var string $phone_code
     * @var string $first_name
     * @var string $middle_name
     * @var string $last_name
     * @var string $password
     * @var string $email
     * @var string photo
     * @var int is_active
     * @var string activation_code
     */

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    var $salt = "u*^7gi5f40jhgdh755";

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('phone', 'required', 'message' => 'Заполнены не все поля'),
            array('phone', 'unique', 'message' => 'Пользователь с таким номером телефона уже существует.'),
            array('first_name, middle_name, last_name, password, email, photo', 'length', 'max' => 128),
            array('email', 'email'),
            array('phone', 'length', 'max' => 16),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'profile' => array(self::HAS_MANY, 'UserProfile', 'user_id'),
            'contacts' => array(self::HAS_MANY, 'UserContacts', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Id',
            'phone' => 'Phone',
            'first_name' => 'MiddleName',
            'middle_name' => 'LastName',
            'last_name' => 'Salt',
            'password' => 'Password',
            'salt' => 'FirstName',
            'email' => 'Email',
            'photo' => 'Photo',
            'is_active' => 'IsActive',
            'activation_code' => 'ActivationCode',
            'phone_code' => 'PhoneCode'
        );
    }

    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($userphone, $token, $timestamp) {
        return $this->hashPassword($userphone, $this->password, $timestamp, $this->salt) === $token;
    }

    /**
     * Generates the password hash.
     * @param string password
     * @param string salt
     * @return string hash
     */
    public function hashPassword($userphone, $password, $timestamp, $salt) {
        return md5($salt . $userphone . $salt . $password . $salt . $timestamp);
    }

}