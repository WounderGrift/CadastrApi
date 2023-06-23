<?php

namespace app\controllers;

use app\components\ApiComponent;
use yii\web\Controller;

class SiteController extends Controller
{
    private $apiComponent;

    public function __construct($id, $module, ApiComponent $apiComponent, $config = [])
    {
        $this->apiComponent = $apiComponent;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    //http://basic/web/site/webresult?cns=69:27:0000022:1306, 69:27:0000022:1307

    /**
     * @throws \yii\httpclient\Exception
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionWebresult($cns = null): string
    {
        if (!empty($cns))
            $data = $this->apiComponent->factory($cns);

        return $this->render('webresult', ['data' => $data ?? null]);
    }
}
