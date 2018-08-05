<?php
/**
 * User: Tom2017 Date: 8/5/2018 Time: 3:50 AM
 */

namespace WebAppFramework;


use Di\Di;
use PDO;

abstract class ActiveRecord
{
    protected $fields;
    /**
     * @var array contains the original value of fields that have been changed
     */
    protected $changedFields;

    protected static $table;
    protected static $idField;

    public static function newFromId($id)
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE " . static::$idField . " = ?";
        $fields = Di::getDb()->execute($sql, [$id])->fetch();
        return new static($fields);
    }

    public function __construct($fields)
    {
        if (!static::$table || !static::$idField) {
            throw new \Exception("Active record object " . static::class . " is not configured properly.");
        }
        $this->fields = $fields;
    }

    public function get($name)
    {
        if (!isset($this->fields[$name])) {
            throw new \Exception("Attempted to get field $name that does not exist on " . static::class . ".");
        }
        return $this->fields[$name];
    }

    public function set($name, $value)
    {
        if (!isset($this->fields[$name])) {
            throw new \Exception("Attempted to set field $name that does not exist on " . static::class . ".");
        }

        if ($this->fields[$name] != $value) {
            // Store the original value to help with things like logging
            $this->changedFields[$name] = $this->fields[$name];
        }
    }

    public function save()
    {
        if (!count($this->changedFields)) {
            return;
        }

        $fieldsToSave = [];
        foreach ($this->changedFields as $key => $value) {
            $fieldsToSave[$key] = $this->fields[$value];
        }

        $this->changedFields = [];
    }
}