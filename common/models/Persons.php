<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "persons".
 *
 * @property int $id
 * @property string $firstname
 * @property string|null $lastname
 * @property string|null $middlename
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $address
 * @property string|null $avatar
 * @property string|null $hobbies
 * @property string $updated_at
 * @property string $created_at
 */
class Persons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname'], 'required'],
            [['address', 'hobbies'], 'string'],
            [['updated_at', 'created_at', 'avatar'], 'safe'],
            [['firstname', 'lastname', 'middlename', 'phone', 'email'], 'string', 'max' => 255],
            [['email'], 'unique'],
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'middlename' => 'Middlename',
            'phone' => 'Phone',
            'email' => 'Email',
            'address' => 'Address',
            'avatar' => 'Avatar',
            'hobbies' => 'Hobbies',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
    public function getWorks()
    {
    	return $this->hasMany(Works::className(), ['person_id' => 'id']);
    }


	public function getEducation()
	{
		return $this->hasMany(Educations::className(), ['person_id' => 'id']);
	}
}
