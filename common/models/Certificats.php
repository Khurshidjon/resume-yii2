<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "certificats".
 *
 * @property int $id
 * @property string $title
 * @property string|null $filename
 * @property string|null $person_id
 * @property string $updated_at
 * @property string $created_at
 */
class Certificats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'certificats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'updated_at', 'created_at'], 'required'],
            [['updated_at', 'created_at'], 'safe'],
            [['title', 'filename', 'person_id'], 'string', 'max' => 255],
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
            'filename' => 'Filename',
            'person_id' => 'Person ID',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
