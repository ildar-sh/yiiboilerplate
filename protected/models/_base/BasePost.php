<?php

/**
 * This is the model base class for the table "post".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Post".
 *
 * Columns in table "post" available as properties of the model,
 * followed by relations of table "post" available as properties of the model.
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $subject
 * @property string $text
 * @property boolean $is_media
 * @property string $created_at
 * @property string $updated_at
 * @property string $cx
 * @property string $cy
 * @property string $cx_p_cy
 * @property string $cx_m_cy
 * @property integer $post_id
 *
 * @property User[] $users
 * @property Tag[] $tags
 * @property Post $post
 * @property Post[] $posts
 * @property User $user
 */
abstract class BasePost extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'post';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Post|Posts', $n);
	}

	public static function representingColumn() {
		return 'text';
	}

	public function rules() {
		return array(
			array('text, created_at', 'required'),
			array('user_id, post_id', 'numerical', 'integerOnly'=>true),
			array('subject', 'length', 'max'=>2048),
			array('is_media, updated_at, cx, cy, cx_p_cy, cx_m_cy', 'safe'),
			array('user_id, subject, is_media, updated_at, cx, cy, cx_p_cy, cx_m_cy, post_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, user_id, subject, text, is_media, created_at, updated_at, cx, cy, cx_p_cy, cx_m_cy, post_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'users' => array(self::MANY_MANY, 'User', 'post_name_user(post_id, user_id)'),
			'tags' => array(self::MANY_MANY, 'Tag', 'tag_post(post_id, tag_id)'),
			'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
			'posts' => array(self::HAS_MANY, 'Post', 'post_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function pivotModels() {
		return array(
			'users' => 'PostNameUser',
			'tags' => 'TagPost',
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'user_id' => null,
			'subject' => Yii::t('app', 'Subject'),
			'text' => Yii::t('app', 'Text'),
			'is_media' => Yii::t('app', 'Is Media'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'cx' => Yii::t('app', 'Cx'),
			'cy' => Yii::t('app', 'Cy'),
			'cx_p_cy' => Yii::t('app', 'Cx P Cy'),
			'cx_m_cy' => Yii::t('app', 'Cx M Cy'),
			'post_id' => null,
			'users' => null,
			'tags' => null,
			'post' => null,
			'posts' => null,
			'user' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('subject', $this->subject, true);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('is_media', $this->is_media);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);
		$criteria->compare('cx', $this->cx, true);
		$criteria->compare('cy', $this->cy, true);
		$criteria->compare('cx_p_cy', $this->cx_p_cy, true);
		$criteria->compare('cx_m_cy', $this->cx_m_cy, true);
		$criteria->compare('post_id', $this->post_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}