<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blog_posts".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property string|null $image_url
 * @property string|null $created_at
 *
 * @property BlogTags[] $blogTags
 * @property Comments[] $comments
 * @property User $user
 */
class BlogPosts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $imageFile;

    public static function tableName()
    {
        return 'blog_posts';
    }

    public function rules()
    {
        return [
            [['user_id', 'title', 'content'], 'required'],
            [['user_id'], 'integer'],
            [['content'], 'string'],
            [['created_at'], 'safe'],
            [['title', 'image_url'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2], // Máximo 2MB
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'content' => 'Content',
            'image_url' => 'Image URL',
            'created_at' => 'Created At',
            'imageFile' => 'Upload Image',
        ];
    }

    /**
     * Realiza o upload da imagem
     */
    public function upload()
    {
        if (!$this->validate()) {
            return false;
        }

        $uploadPath = Yii::getAlias('@webroot/uploads/blog');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true); // Cria o diretório, se necessário
        }

        $fileName = uniqid() . '.' . $this->imageFile->extension;
        $filePath = $uploadPath . '/' . $fileName;

        if ($this->imageFile->saveAs($filePath, false)) {
            $this->image_url = '/uploads/blog/' . $fileName; // Caminho relativo para salvar no banco
            return true;
        }

        return false;
    }

    /**
     * Gets query for [[BlogTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogTags()
    {
        return $this->hasMany(BlogTags::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['blog_post_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function beforeValidate()
    {
        if (empty($this->user_id)) {
            $this->user_id = Yii::$app->user->id; // Define o ID do usuário logado, se não estiver definido
        }

        return parent::beforeValidate();
    }
}
