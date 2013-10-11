<?php
/**
 * Class GetAction
 * Get tags action
 *
 * @property ApiTagController $controller
 */
class GetAction extends ApiAction{
    public function run()
    {
        $model = new TagLocationMap();
        $model->setScenario('radius_limit');

        $model->setAttributes(Yii::app()->request->getAllParams());

        if ($model->validate()) {
            $this->controller->out($model->buildTagMap());
        } else {
            $this->controller->outError($model->getErrors(), ApiController::ERROR_VALIDATION, Yii::t('api', 'Validation error'));
        }
    }
} 