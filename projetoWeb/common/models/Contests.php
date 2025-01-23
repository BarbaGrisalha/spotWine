<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contests".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $registration_start_date
 * @property string|null $registration_end_date
 * @property string|null $contest_start_date
 * @property string|null $contest_end_date
 * @property string|null $image_url
 * @property string|null $status
 *
 * @property Categories $category
 * @property ContestParticipations[] $contestParticipations
 */
class Contests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['description', 'status'], 'string'],
            [['registration_start_date', 'registration_end_date', 'contest_start_date', 'contest_end_date'], 'safe'],
            [['registration_start_date', 'registration_end_date', 'contest_start_date', 'contest_end_date'], 'date', 'format' => 'php:Y-m-d'], // Validações de data
            [['registration_start_date', 'registration_end_date', 'contest_start_date', 'contest_end_date'], 'default', 'value' => null], // Define nulo como valor padrão
            [['name'], 'string', 'max' => 100],
            [['image_url'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 10 * 1024 * 1024, 'tooBig' => 'O arquivo não pode exceder 10 MB.'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'category_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Categorias',
            'name' => 'Name',
            'description' => 'Description',
            'registration_start_date' => 'Início Inscrição',
            'registration_end_date' => 'Fim Inscrição',
            'contest_start_date' => 'Início Concurso',
            'contest_end_date' => 'Fim Concurso',
            'image_url' => 'Image Url',
            'imageFile' => 'Arquivo de Imagem',
            'status' => 'Status',
        ];
    }

    public $imageFile;
    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasOne(Categories::class, ['category_id' => 'category_id']);
    }

    /**
     * Gets query for [[ContestParticipations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContestParticipations()
    {
        return $this->hasMany(ContestParticipations::class, ['contest_id' => 'id']);
    }
}
