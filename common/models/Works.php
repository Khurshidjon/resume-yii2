<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "works".
 *
 * @property int $id
 * @property string $title
 * @property string $from_date
 * @property string|null $to_date Agar kiritilmagan bo'lsa demak hali ishlayapti shu yerda
 * @property string|null $description
 * @property string|null $person_id
 * @property string $updated_at
 * @property string $created_at
 */
class Works extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'works';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['updated_at', 'created_at'], 'required'],
            [['description'], 'string'],
            [['updated_at', 'created_at'], 'safe'],
            [['title', 'from_date', 'to_date', 'person_id'], 'string', 'max' => 255],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'description' => 'Description',
            'person_id' => 'Person ID',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

	public function behaviors()

	{

		return [

			'timestamp' => [

				'class' => 'yii\behaviors\TimestampBehavior',

				'attributes' => [

					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],

					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],

				],

				'value' => new Expression('NOW()'),

			],

		];

	}
}
