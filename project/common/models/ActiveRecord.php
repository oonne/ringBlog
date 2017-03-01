<?php

namespace common\models;

use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

class ActiveRecord extends \yii\db\ActiveRecord
{
    private $_lastChangedAttributes = [];
    private $_lastSavedAttributes = [];

    /**
     * @return array the timestamp behavior config
     */
    public function timestampBehavior()
    {
        return [
            'class' => TimestampBehavior::className(),
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => false,
            'value' => function () {
                return new Expression('NOW()');
            }
        ];
    }

    /**
     * @inheritdoc
     * @see \yii\db\BaseActiveRecord::afterSave()
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->_lastChangedAttributes = $changedAttributes;
        foreach (array_keys($this->_lastChangedAttributes) as $name) {
            $this->_lastSavedAttributes[$name] = $this->$name;
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Get the model unique id
     *
     * @return NULL|string
     */
    public function getUniqueId()
    {
        $uniqueId = null;
        if ($this->getPrimaryKey() !== null) {
            $uniqueId = static::getTableSchema()->fullName . '_' . $this->getPrimaryKey();
        }
        return $uniqueId;
    }

    /**
     * @return array
     */
    public function getLastChangedAttributes()
    {
        return $this->_lastChangedAttributes;
    }

    /**
     * @return array
     */
    public function getLastSavedAttributes()
    {
        return $this->_lastSavedAttributes;
    }
}