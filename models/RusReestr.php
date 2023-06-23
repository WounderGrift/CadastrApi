<?php

namespace app\models;

use app\dto\RusReestrDTO;
use DateTime;
use DateTimeZone;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "rus_reestr".
 *
 * @property int $id
 * @property string|null $cadastr_number
 * @property string|null $address
 * @property float|null $price
 * @property float|null $area
 * @property string|null $date_create
 * @property string|null $date_update
 */
class RusReestr extends \yii\db\ActiveRecord
{
    /**
     * @throws \Exception
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'date_create',
                'updatedAtAttribute' => 'date_update',
                'value' => (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rus_reestr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'area'], 'number'],
            [['date_create', 'date_update'], 'safe'],
            [['cadastr_number', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cadastr_number' => 'Cadastr Number',
            'address' => 'Address',
            'price' => 'Price',
            'area' => 'Area',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
        ];
    }

    public function toDto(): RusReestrDTO
    {
        return new RusReestrDTO(
            $this->cadastr_number,
            $this->address,
            $this->price,
            $this->area,
            $this->date_update
        );
    }
}
