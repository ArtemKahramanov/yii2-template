<?php

namespace frontend\modules\menu\models;

use frontend\modules\menu\Module;
use Yii;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property int $sort
 * @property int $parent_id
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    public static $menuTypes = [
        ['type' => 'Link', 'name' => 'Link'],
        ['type' => 'Dropmenu', 'name' => 'Dropmenu'],
        ['type' => 'Line', 'name' => 'Line'],
    ];

    public static $rols = [
        ['identify' => '*', 'label' => 'All'],
        ['identify' => '?', 'label' => 'Guest'],
        ['identify' => '@', 'label' => 'User'],
    ];

    public static $method = [
        ['id' => 0, 'name' => 'GET'],
        ['id' => 1, 'name' => 'POST'],

    ];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'required'],
            [['name'], 'unique'],
            [['sort'], 'double'],
            [['parent_id', 'method'], 'integer'],
            [['name', 'url', 'role', 'type', 'class'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Родитель',
            'Sort' => 'Сортировка',
            'Type' => 'Тип',
            'Role' => 'Роль',
            'method' => 'Метод',
            'class' => 'Класс',
        ];

    }

    protected function matchRole()
    {
        if ($this->role == '*') {
            return true;
        }
        if ($this->role === '?') {
            if (\Yii::$app->user->isGuest) {
                return true;
            }
        } elseif ($this->role === '@') {
            if (!\Yii::$app->user->isGuest) {
                return true;
            }
        }
        return false;
    }

    public function getDropMenuItems()
    {
        if ($this->type === 'Dropmenu') {
            return Menu::find()->where(['parent_id' => $this->id])->orderBy('sort')->all();
        }
    }


    public function createMenuItem($menu_item)
    {
        $item = [
            'label' => $menu_item->name,
            'url' => [$menu_item->url],
            'options' => ['class' => $menu_item->class],
            'template' => $this->getTemplate($menu_item->method)
        ];

        if ($menu_item->method == 1) {
            array_push($item, [
                'template' => '<a href="{url}" data-method="POST">{label}</a>'
            ]);
        }
        return $item;
    }

    public function transformToArray()
    {
        $items = [];
        foreach ($this->getDropMenuItems() as $menu_item) {
            if ($menu_item->matchRole()) {
                array_push($items, [
                    'label' => $menu_item->name,
                    'url' => [$menu_item->url],
                    'template' => $this->getTemplate($menu_item->method),
                ]);
            }
        }
        return $items;
    }

    public function sortDirection($direction, $num = 1){
        if($direction === 'up'){
             $this->sort+=$num;
        }else{
             $this->sort-=$num;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        $sort = $this->find()->where(['parent_id'=>0])->max('sort') + 1;
        $sort_item = Menu::find()->where(['id' => $this->parent_id])->one();
        $sort_item_max = Menu::find()->where(['parent_id' => $this->parent_id])->max('sort');
        if ($insert) {
            if ($this->parent_id == 0) {
                $this->sort = $sort;
                $this->save();
            } else {
                if ($sort_item_max > 1) {
                    $this->sort = $sort_item_max + 0.1;
                    $this->save();
                } else {
                    $this->sort = $sort_item->sort + 0.1;
                    $this->save();
                }
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        $module = \Yii::$app->getModule('menu');
        if ($this->parent_id == 0) {
            foreach ($this->find()->where(['>', 'sort', $this->sort])->all() as $sort) {
                $sort->sort -= 1;
                $sort->save();
            }
        } elseif ($this->parent_id > 0) {
            foreach ($this->find()->where(['>', 'sort', $this->sort])->andWhere(['parent_id' => $this->parent_id])->all() as $item) {
                $item->sort -= 0.1;
                $item->save();
            }
        }
        if ($this->type == 'Dropmenu' && $module->deletion_strategy == true) {
            Yii::$app->db->createCommand()->delete('menu', 'parent_id = ' . $this->id)->execute();
        } elseif ($module->deletion_strategy == false) {
            foreach ($this->find()->where(['parent_id' => $this->id])->all() as $child) {
                $max = $this->find()->where(['parent_id' => 0])->max('sort');
                $child->parent_id = 0;
                $child->sort = 0;
                $child->sort = $max + 1;
                $child->save();
            }
        }
        parent::afterDelete();
    }

    public function getTemplate($method)
    {
        if ($method == 0) {
            return '<a href="{url}">{label}</a>';
        } elseif ($method == 1) {
            return '<a href="{url}" data-method="POST">{label}</a>';
        }
    }

    public static function getMenu()
    {
        $menu = [];
        $module = \Yii::$app->getModule('menu');
        $menu_items = Menu::find()->where(['parent_id' => 0])->orderBy('sort')->all();
        foreach ($menu_items as $menu_item) {
            if ($menu_item->matchRole() == true) {
                if ($menu_item->parent_id == 0 && $menu_item->type === 'Link') {
                    array_push($menu, $menu_item->createMenuItem($menu_item));
                }
                if ($menu_item->parent_id == 0 && $menu_item->type === 'Dropmenu') {
                    array_push($menu, [
                        'label' => $menu_item->name,
                        'url' => [$menu_item->url],
                        'options' => ['class' => $module->dropmenu_class . " " . $menu_item->class],
                        'items' => $menu_item->transformToArray(),
                    ]);
                }
            }
        }
        return $menu;
    }
}
