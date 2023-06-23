<?php

namespace app\controllers;

use app\components\ApiComponent;
use yii\base\InvalidConfigException;
use yii\console\Controller;

class ConsoleController extends Controller
{
    private $apiComponent;
    public $cns;

    public function __construct($id, $module, ApiComponent $apiComponent, $config = [])
    {
        $this->apiComponent = $apiComponent;
        parent::__construct($id, $module, $config);
    }

    public function options($actionID): array
    {
        return ['cns'];
    }

    //php yii console/get-data --cns=69:27:0000022:1306,69:27:0000022:1307

    /**
     * @throws \yii\httpclient\Exception
     * @throws InvalidConfigException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionGetData()
    {
        $data = $this->apiComponent->factory($this->cns);

        $rows = [];
        foreach ($data as $dto)
        {
            $rows[] = $dto;
        }

        $this->displayTable(['cadastr_number', 'address', 'price', 'area', 'date_update'], $rows);
    }

    function displayTable(array $headers, $rows)
    {
        $columnWidths = [];

        foreach ($headers as $header) {
            $columnWidths[$header] = mb_strlen($header);
        }

        foreach ($rows as $row) {
            foreach ($row as $key => $value) {
                $length = mb_strlen($value);
                if (!isset($columnWidths[$key]) || $length > $columnWidths[$key]) {
                    $columnWidths[$key] = $length;
                }
            }
        }

        foreach ($headers as $header) {
            echo "| " . str_pad($header, $columnWidths[$header]) . " ";
        }
        echo "|" . PHP_EOL;

        foreach ($columnWidths as $width) {
            echo "+" . str_repeat("-", $width + 2);
        }
        echo "+" . PHP_EOL;

        foreach ($rows as $row) {
            foreach ($row as $key => $value) {
                echo "| " . str_pad($value, $columnWidths[$key]) . " ";
            }
            echo "|" . PHP_EOL;
        }
    }

}