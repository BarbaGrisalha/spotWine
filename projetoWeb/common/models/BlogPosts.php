<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blog_posts".
 *
 * @property int $post_id
 * @property int|null $user_id
 * @property string|null $title
 * @property string|null $content
 * @property string|null $image_url
 * @property string|null $created_at
 */
class BlogPosts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog_posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['content'], 'string'],
            [['created_at'], 'safe'],
            [['title', 'image_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'content' => 'Content',
            'image_url' => 'Image Url',
            'created_at' => 'Created At',
        ];
    }
}
