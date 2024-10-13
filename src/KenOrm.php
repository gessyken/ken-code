<?php

require_once 'DB.php';

/**
 * @method static all()
 * @method static create(array $data)
 * @method static find(int $id)
 * @method static findOrFail(int $id)
 * @method save()
 * @method delete()
 */
abstract class KenOrm
{
    /**
     * @return array
     */
    public static function all() : array
    {
        $table = strtolower(get_called_class() . 's');
        $db = DB::mysql();
        $data = $db->query("SELECT * FROM {$table}")->fetchAll(PDO::FETCH_OBJ);
        $result = [];
        foreach ($data as $item) {
            $class = get_called_class();
            $obj = new $class();
            foreach ($item as $key => $value) {
                $obj->{$key} = $value;
            }
            $result[] = $obj;
        }
        return $result;
    }

    /**
     * @param int $id
     * @return object
     */
    public static function find($id) : object
    {
        $table = strtolower(get_called_class() . 's');
        $db = DB::mysql();
        $data = $db->query("SELECT * FROM {$table} WHERE id = {$id}")->fetch(PDO::FETCH_OBJ);
        $class = get_called_class();
        $obj = new $class();
        foreach ($data as $key => $value) {
            $obj->{$key} = $value;
        }
        return $obj;
    }

    /**
     * @param array $data
     * @return void
     */
    public static function create(array $data)
    {
        $table = strtolower(get_called_class() . 's');
        $sql = "INSERT INTO {$table} (";
        foreach ($data as $key => $value) {
            $sql .= $key . ',';
        }
        $sql = rtrim($sql, ',') . ') VALUES (';
        foreach ($data as $value) {
            $sql .= "'" . $value . "',";
        }
        $sql = rtrim($sql, ',') . ');';
        $db = DB::mysql();
        $db->query($sql);
        
        return self::find($db->lastInsertId());
        
    }

    /**
     * @return void
     */
    public function save()
    {
        $table = strtolower(get_called_class() . 's');
        $db = DB::mysql();
        
        if (isset($this->id)) {
            // Update existing record
            $sql = "UPDATE {$table} SET ";
            foreach ($this as $key => $value) {
                if ($key !== 'id') {
                    $sql .= "{$key} = :{$key},";
                }
            }
            $sql = rtrim($sql, ',') . " WHERE id = :id";
            $stmt = $db->prepare($sql);
            $this->id = $this->id; // Ensure id is set for update
            $stmt->execute((array)$this);
        } else {
            // Create new record
            $sql = "INSERT INTO {$table} (";
            foreach ($this as $key => $value) {
                if ($key !== 'id') {
                    $sql .= "{$key},";
                }
            }
            $sql = rtrim($sql, ',') . ') VALUES (';
            foreach ($this as $key => $value) {
                if ($key !== 'id') {
                    $sql .= ":{$key},";
                }
            }
            $sql = rtrim($sql, ',') . ');';
            $stmt = $db->prepare($sql);
            $stmt->execute((array)$this);
            $this->id = $db->lastInsertId();
        }
    }

    /**
     * @return void
     */
    public function delete()
    {
        $table = strtolower(get_called_class() . 's');
        $db = DB::mysql();
        $stmt = $db->prepare("DELETE FROM {$table} WHERE id = :id");
        $stmt->execute([':id' => $this->id]);
    }
}
