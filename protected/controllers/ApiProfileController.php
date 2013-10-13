<?php

class ApiProfileController extends ApiController
{
    /**
     * Declares class-based actions.
     */
    protected $_actions = array('get','getTest','profileGet','favoriteGet','favoritePost','favoriteDelete');

    public function filters()
    {
        return array(
            'apiAccessControl'
        );

    }

    public function accessRules()
    {
        return array(
            array('deny',
                'actions' => array('favoriteGet','favoritePost','favoriteDelete'),
                'users' => array('?'),
            ),
        );
    }

}