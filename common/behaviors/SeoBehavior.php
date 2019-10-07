<?php

namespace common\behaviors;

use common\models\Seo;
use yii\base\Behavior;
use \yii\validators\Validator;


class SeoBehavior extends Behavior
{
    public $title;
    public $slug;
    public $meta_description;
    public $meta_keywords;
    public $entity_type;

    public function events()
    {
        return [
            Seo::EVENT_AFTER_FIND => 'getData',
            Seo::EVENT_AFTER_UPDATE => 'updateData',
            Seo::EVENT_AFTER_INSERT => 'setData',
        ];
    }

    public function attach($owner)
    {
        parent::attach($owner);
        $owner->validators[] = Validator::createValidator('string', $this->owner, 'title', ['max' => 155]);
        $owner->validators[] = Validator::createValidator('string', $this->owner, 'slug', ['max' => 155]);
        $owner->validators[] = Validator::createValidator('string', $this->owner, 'meta_keywords', ['max' => 155]);
        $owner->validators[] = Validator::createValidator('string', $this->owner, 'meta_description', ['max' => 255]);
        $owner->validators[] = Validator::createValidator('string', $this->owner, 'entity_type', ['max' => 155]);
        $this->entity_type = get_class($this->owner);
    }

    public function setData()
    {
        $seo = new Seo();
        $seo->title = !empty($this->owner->title) ? $this->owner->title : $this->owner->name;
        $seo->slug = $this->owner->slug;
        $seo->meta_description = $this->owner->meta_description;
        $seo->meta_keywords = $this->owner->meta_keywords;
        $seo->entity_id = $this->owner->id;
        $seo->entity_type = $this->entity_type;
        $seo->save();
    }

    public function getData()
    {
        $seo = $this->getSeo();

        if (!empty($seo)) {
            $this->owner->meta_description = $seo->meta_description;
            $this->owner->meta_keywords = $seo->meta_keywords;
            $this->owner->title = $seo->title;
            $this->owner->slug = $seo->slug;

        }
    }

    public function updateData()
    {
        $seo = $this->getSeo();
        if (!empty($seo)) {
            $seo->title = !empty($this->owner->title) ? $this->owner->title : $this->owner->name;
            $seo->slug = $this->owner->slug;
            $seo->meta_description = $this->owner->meta_description;
            $seo->meta_keywords = $this->owner->meta_keywords;
            $seo->entity_id = $this->owner->id;
            $seo->entity_type = $this->entity_type;
            return $seo->validate() ? $seo->save() : false;
        }else {
            $this->setData();
        }
    }

    public function getSeo()
    {
        return Seo::find()->where(['entity_type' => $this->entity_type, 'entity_id' => $this->owner->id])->one();
    }
}
