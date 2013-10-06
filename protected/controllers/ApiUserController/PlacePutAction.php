<?php
/**
 * Class PlacePutAction
 * Change user place
 *
 * @property ApiUserController $controller
 */
class PlacePutAction extends ApiAction
{
    /**
     * @param $id
     */
    public function run($id)
    {
        $user_place = UserPlace::findByPkForUser($id,User::current()->id);

        if (!$user_place)
            $this->controller->forward('apiV0/error404');

        $user_place->setAttributes(Yii::app()->getRequest()->getAllParams());;
        $user_place->setScenario('place_put');


        if ($user_place->validate()) {
            $this->controller->out($user_place->save());
        } else {
            $this->controller->outError($user_place->getErrors(), ApiController::ERROR_VALIDATION, Yii::t('api', 'Validation error'));
        }
    }
}