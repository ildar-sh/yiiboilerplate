<?php

/**
 * This is the model base class for the table "feed_external_item".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "FeedExternalItem".
 *
 * Columns in table "feed_external_item" available as properties of the model,
 * followed by relations of table "feed_external_item" available as properties of the model.
 *
 * @property integer $id
 * @property string $url
 * @property string $created_at
 * @property integer $feed_external_id
 * @property string $title
 * @property string $text
 * @property string $date
 * @property string $updated_at
 * @property string $guid
 *
 * @property FeedExternal $feedExternal
 */
abstract class BaseFeedExternalItem extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'feed_external_item';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'FeedExternalItem|FeedExternalItems', $n);
	}

	public static function representingColumn() {
		return 'url';
	}

	public function rules() {
		return array(
			array('url, created_at, feed_external_id, text', 'required'),
			array('feed_external_id', 'numerical', 'integerOnly'=>true),
			array('url', 'length', 'max'=>2000),
			array('title', 'length', 'max'=>512),
			array('guid', 'length', 'max'=>256),
			array('date, updated_at', 'safe'),
			array('title, date, updated_at, guid', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, url, created_at, feed_external_id, title, text, date, updated_at, guid', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'feedExternal' => array(self::BELONGS_TO, 'FeedExternal', 'feed_external_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'url' => Yii::t('app', 'Url'),
			'created_at' => Yii::t('app', 'Created At'),
			'feed_external_id' => null,
			'title' => Yii::t('app', 'Title'),
			'text' => Yii::t('app', 'Text'),
			'date' => Yii::t('app', 'Date'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'guid' => Yii::t('app', 'Guid'),
			'feedExternal' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('url', $this->url, true);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('feed_external_id', $this->feed_external_id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('date', $this->date, true);
		$criteria->compare('updated_at', $this->updated_at, true);
		$criteria->compare('guid', $this->guid, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}