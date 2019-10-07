<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m181030_134915_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->unique(),
            'url' => $this->string(255),
            'sort' => $this->integer()->defaultValue(0),
            'parent_id' => $this->integer()->defaultValue(0),
            'type' => $this->string(155),
            'role' => $this->string(2),
            'method' => $this->integer()->defaultValue(0),
            'class' => $this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('menu');
    }
}
