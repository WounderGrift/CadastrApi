<?php

namespace app\components;

use app\dto\RusReestrDTO;
use app\models\RusReestr;
use DateTime;
use DateTimeZone;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\httpclient\Client;
use yii\httpclient\Exception;
use yii\web\ForbiddenHttpException;

class ApiComponent extends Component
{
    const BASE_URL = 'https://api.pkk.bigland.ru/test/plots';

    /**
     * @throws InvalidConfigException
     * @throws Exception
     * @throws ForbiddenHttpException
     * @throws \Exception
     */
    public function factory(string $cns): array
    {
        $cns = $this->parseCn($cns);
        if (!$cns)
            return [];

        $modelsToReturn = [];
        $numberNeedUpdate = [];

        foreach ($cns as $number) {
            /** @var RusReestr $model */
            $model = RusReestr::find()->where(['cadastr_number' => $number])->one();

            if (empty($model)) {
                $numberNeedUpdate[] = $number;
            } else {
                $utcTimeZone = new DateTimeZone('UTC');
                $currentDate = new DateTime('now', $utcTimeZone);
                $updatedDateTime = new DateTime($model->date_update, $utcTimeZone);
                $interval = $currentDate->diff($updatedDateTime);

                if ($interval->days > 0 || ($interval->days == 0 && $interval->h >= 1)) {
                    $numberNeedUpdate[] = $number;
                } else {
                    $modelsToReturn[] = $model->toDto();
                }
            }
        }

        if (!empty($numberNeedUpdate)) {
            $newDataCollection = $this->getDataFromApi($numberNeedUpdate);

            if (!$newDataCollection)
                return [];

            foreach ($newDataCollection as $newData) {
                /** @var RusReestr $model */
                $model = RusReestr::find()->where(['cadastr_number' => $newData->cadastr_number])->one();
                $model = $this->saveData($model, $newData);
                if (!empty($model)) {
                    $modelsToReturn[] = $model->toDto();
                }
            }
        }

        return $modelsToReturn;
    }

    public function getDataFromApi(array $cns): ?array
    {
        try {
            $client = new Client();

            $request = $client->createRequest()
                ->setMethod('GET')
                ->setUrl(self::BASE_URL)
                ->setContent($this->parseRequest($cns))
                ->setHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]);

            $response = $request->send();

            if ($response->isOk) {
                $data = $response->getData();

                if (empty($data))
                    throw new ForbiddenHttpException ('Bad Request', 400);

                $request = [];
                foreach ($data as $item)
                    $request[] = $this->parseResponse($item);

                return $request;
            } else {
                throw new ForbiddenHttpException('Bad Request', 400);
            }
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function parseCn($cns): array|bool
    {
        return preg_split('/[,\s]+/', $cns, -1, PREG_SPLIT_NO_EMPTY);
    }

    private function parseRequest(array $cns): string
    {
        $json = [
            'collection' => [
                'plots' => $cns
            ]
        ];

        return Json::encode($json);
    }

    private function parseResponse(array $data): RusReestrDTO
    {
        return new RusReestrDTO(
            $data['number'],
            $data['attrs']['plot_address'],
            floatval($data['attrs']['plot_price']),
            floatval($data['attrs']['plot_area']),
            date('Y-m-d H:i:s')
        );
    }

    private function saveData(?RusReestr $model, RusReestrDTO $dto): ?RusReestr
    {
        if (!$model)
            $model = new RusReestr();

        $model->cadastr_number = $dto->cadastr_number;
        $model->address = $dto->address;
        $model->price = $dto->price;
        $model->area = $dto->area;
        $model->date_update = $dto->date_update;

        if ($model->save())
            return $model;

        return null;
    }
}