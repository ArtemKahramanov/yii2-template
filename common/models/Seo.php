<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "seo".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $opengraph
 * @property int $entity_id
 * @property int $entity_type
 */
class Seo extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'slug',//default name slug
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entity_id'], 'integer'],
            [['title', 'meta_keywords', 'entity_type'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 500],
            [['meta_description'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'slug' => 'Slug',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'entity_id' => 'Entity ID',
            'entity_type' => 'Entity Type',
        ];
    }

}
