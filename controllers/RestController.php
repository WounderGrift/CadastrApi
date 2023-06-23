<?php

namespace app\controllers;

use app\components\ApiComponent;
use Yii;
use yii\rest\Controller;
use yii\web\Response;

class RestController extends Controller
{
    private $apiComponent;

    public function __construct($id, $module, ApiComponent $apiComponent, $config = [])
    {
        $this->apiComponent = $apiComponent;
        parent::__construct($id, $module, $config);
    }

//     curl --location 'http://basic/web/rest/get-data?cns=69%3A27%3A0000022%3A1306%2C%2069%3A27%3A0000022%3A1307' \
//     --header 'Content-Type: application/json' \
//     --header 'Accept: application/json'

    /**
     * @throws \yii\httpclient\Exception
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionGetData($cns): ?array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = $this->apiComponent->factory($cns);

        if (!empty($data))
            return $data;
        return null;
    }
}