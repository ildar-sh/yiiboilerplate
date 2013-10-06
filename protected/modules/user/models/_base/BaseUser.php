<?php

/**
 * This is the model base class for the table "user".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "User".
 *
 * Columns in table "user" available as properties of the model,
 * followed by relations of table "user" available as properties of the model.
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $key
 * @property string $created_at
 * @property string $updated_at
 * @property string $role
 * @property boolean $is_active
 * @property string $last_login
 * @property string $password
 *
 * @property UserSettings[] $userSettings
 * @property UserPlace[] $userPlaces
 * @property UserSocial[] $userSocials
 */
abstract class BaseUser extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'user';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'User|Users', $n);
	}

	public static function representingColumn() {
		return 'username';
	}

	public function rules() {
		return array(
			array('username', 'required'),
			array('password', 'length', 'max'=>255),
			array('email, key, created_at, updated_at, role, is_active, last_login', 'safe'),
			array('email, key, created_at, updated_at, role, is_active, last_login, password', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, username, email, key, created_at, updated_at, role, is_active, last_login, password', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'userSettings' => array(self::HAS_MANY, 'UserSettings', 'user_id'),
			'userPlaces' => array(self::HAS_MANY, 'UserPlace', 'user_id'),
			'userSocials' => array(self::HAS_MANY, 'UserSocial', 'user_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'username' => Yii::t('app', 'Username'),
			'email' => Yii::t('app', 'Email'),
			'key' => Yii::t('app', 'Key'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'role' => Yii::t('app', 'Role'),
			'is_active' => Yii::t('app', 'Is Active'),
			'last_login' => Yii::t('app', 'Last Login'),
			'password' => Yii::t('app', 'Password'),
			'userSettings' => null,
			'userPlaces' => null,
			'userSocials' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('key', $this->key, true);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);
		$criteria->compare('role', $this->role, true);
		$criteria->compare('is_active', $this->is_active);
		$criteria->compare('last_login', $this->last_login, true);
		$criteria->compare('password', $this->password, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}