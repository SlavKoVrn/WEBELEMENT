<?php

use yii\db\Migration;

/**
 * Class m210820_085819_add_auto_fields
 */
class m210820_085819_add_auto_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('auto', 'vehicle_number', $this->string(20));
        $this->addColumn('auto', 'color', $this->string(20));
        $this->addColumn('auto', 'paid', $this->tinyInteger(1));
        $this->addColumn('auto', 'comment', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('auto', 'vehicle_number');
        $this->dropColumn('auto', 'color');
        $this->dropColumn('auto', 'paid');
        $this->dropColumn('auto', 'comment');
    }

}
