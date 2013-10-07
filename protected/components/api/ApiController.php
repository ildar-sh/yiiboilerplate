<?php
class ApiController extends Controller
{

    const ERROR_VALIDATION = 701;

    /**
     * @param $in
     * @param $http_status int
     * @param bool $standart
     *     {
     *          "status":0,
     *          "message":"",
     *          "result": %ANSWER%
     *      }
     * @param int $status
     * @param string $message
     * @param string $type
     *      auto - detect answer type from $_GET['_ans']
     *              if $_GET['_ans'] empty use 'json'
     *      json  - json/jsonp
     *      xml - xml document
     * @throws ApiException
     * @return bool
     */
    public static function out($in, $http_status = 200, $standart = true, $status = 0, $message = "", $type = 'auto')
    {
        // set the status
        $status_header = 'HTTP/1.1 ' . $http_status .' '.self::_getStatusCodeMessage($http_status);
        header($status_header);


        if($standart)
            $in = array(
                'status' => $status,
                'message' => $message,
                'result' => $in,
            );

        if(Yii::app()->getRequest()->getParam('_debug')) {
            header('Content-Type: text/html');
            Yii::app()->controller->render('application.views.api.debug', array('debug' => print_r($in, true)));
            return;
        }
        if($type == 'auto')
            $type = Yii::app()->getRequest()->getParam('_ans','json');
        switch ($type) {
            case 'xml':
                echo self::makeXml($in);
                break;
            case 'json':
                echo self::makeJson($in);
                break;
            default:
                throw new ApiException('Wrong answer type'.(string)$type);
                break;

        }
    }

    /**
     * Wrapper for self::out
     *
     * @see ApiController::out
     *
     * @param $in
     * @param $status
     * @param $message
     * @param $type
     * @return bool
     */
    public static function outError($in,$status,$message,$type = 'auto'){
        return self::out($in,200,true,$status,$message,$type);
    }

    /**
     * @param $status
     * @return string
     */
    private static function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : 'NOT OKAY';
    }

    /**
     * @todo
     * @param $in
     */
    public static function makeXml($in)
    {
        //header('Content-Type: text/xml');
        header('Content-Type: text/plain');
        die('@TODO');
    }

    /**
     * @param mixed $struct
     * @return mixed
     */
    private static function jsonRemoveUnicodeSequences($struct)
    {
        return str_replace("\/", '/', preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct)));
    }

    /**
     * @param $in
     * @return string
     */
    public static function makeJson($in)
    {
        $json = self::jsonRemoveUnicodeSequences($in);

        // "Tidy"
        $json = str_replace('<br>', '<br />', $json);
        $json = str_replace('&nbsp;', '&#160;', $json); // for XHTML


        if(!Yii::app()->controller->isCachingStackEmpty()) {
            return Yii::app()->controller->renderDynamic('ApiController::makeJsonp', $json);
        } else {
            return self::makeJsonp($json);
        }
    }

    /**
     * @param $json
     * @return string
     */
    public static function makeJsonp($json)
    {
        header('Content-Type: text/plain');
        return (Yii::app()->getRequest()->getParam('callback'))
            ? (Yii::app()->getRequest()->getParam('callback')."($json)")
            : $json;
    }

//    /**
//     * @param string $actionID
//     */
//    public function run($actionID)
//    {
//        if(YII_DEBUG)
//            try {
//                return parent::run($actionID);
//            } catch (ApiException $e) {
//                $this->out($e->getHash(),true,0,"",'json');
//            }
//        else
//            parent::run($actionID);
//    }

    public static function actionError404(){
        self::out(null,404,true,'404',Yii::t('api','Check REST method, and parameters'),'json');
    }

    public static function actionError400(){
        self::out(null,400,true,'400',Yii::t('api','Check REST method, and parameters'),'json');
    }
    public static function actionError403(){
        self::out(null,403,true,'403', Yii::t('api','You are not authorized to perform this action.'),'json');
    }

    public function filterApiAccessControl($filterChain)
    {
        $filter=new ApiAccessControlFilter();
        $filter->setRules($this->accessRules());
        $filter->filter($filterChain);
    }
}