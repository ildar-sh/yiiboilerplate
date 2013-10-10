<?php

/**
 * This is the model base class for the table "tag".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Tag".
 *
 * Columns in table "tag" available as properties of the model,
 * followed by relations of table "tag" available as properties of the model.
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Post[] $posts
 * @property TagPlace[] $tagPlaces
 */
abstract class BaseTag extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tag';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Tag|Tags', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, created_at', 'required'),
			array('name', 'length', 'max'=>512),
			array('updated_at', 'safe'),
			array('updated_at', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'posts' => array(self::MANY_MANY, 'Post', 'tag_post(tag_id, post_id)'),
			'tagPlaces' => array(self::HAS_MANY, 'TagPlace', 'tag_id'),
		);
	}

	public function pivotModels() {
		return array(
			'posts' => 'TagPost',
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'posts' => null,
			'tagPlaces' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}