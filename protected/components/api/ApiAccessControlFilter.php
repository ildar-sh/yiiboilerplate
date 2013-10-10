<?php
class ApiAccessControlFilter extends CAccessControlFilter{

    protected function preFilter($filterChain)
    {
        if(Yii::app()->getRequest()->getParam('token',null)){
            $identity = new ApiIdentity(Yii::app()->getRequest()->getParam('token',null));
            if($identity->authenticate()){
                Yii::app()->user->login($identity);
            }
        }
        return parent::preFilter($filterChain);
    }
}