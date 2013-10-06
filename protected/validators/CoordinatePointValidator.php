<?php

class CoordinatePointValidator extends CoordinateValidator
{
    public $cx_field = 'cx';
    public $cy_field = 'cy';

    public $makeCoordinates = false;
    public $reanimateCoordinates = false;

    /**
     * @param CActiveRecord $object
     * @param string $attribute
     */
    protected function validateAttribute($object, $attribute)
    {

        $value = $object->getAttribute($attribute);

        if (empty($value) && $this->reanimateCoordinates) {
            $object->setAttribute($attribute, $object->getAttribute($this->cx_field) . ':' . $object->getAttribute($this->cy_field));
        }

        $value = $object->getAttribute($attribute);

        if (!$this->validatePoint($value, $object)) {
            $this->addError($object, $attribute, !empty($this->message) ? $this->message : Yii::t('app', 'Wrong point coordinates'));
        } else if ($this->makeCoordinates) {
            $object->setAttribute($this->cx_field, $this->genCoordinate($value, 'x'));
            $object->setAttribute($this->cy_field, $this->genCoordinate($value, 'y'));
        }
    }

    /**
     * @param $value
     * @param $asix
     * @return null
     */
    protected function genCoordinate($value, $asix)
    {
        $xy = explode(':', $value, 2);
        if (!is_array($xy) || count($xy) != 2) {
            return null;
        }
        $result = array();
        $result['x'] = $xy[0];
        $result['y'] = $xy[1];
        return $result[$asix];
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validatePoint($value)
    {
        if ($this->validateCoordinate($this->genCoordinate($value, 'x')) && $this->validateCoordinate($this->genCoordinate($value, 'y'))) {
            return true;
        } else {
            return false;
        }
    }
} 