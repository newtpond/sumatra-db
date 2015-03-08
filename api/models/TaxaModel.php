<?php

class TaxaModel {

    /**
     *
     */
    public function listFamilies()
    {
        $db = Database::getInstance();
        $query = $db->prepare('SELECT class_name as class, type FROM classes LEFT JOIN class_types ON classes.class_type = class_types.id');
        $query->execute();
        $res = $query->fetchAll();
        if(count($res) > 0) {
            return $res;
        }
        return false;
    }

    /**
     *
     */
    public function listItems($name)
    {
        $db = Database::getInstance();

        $classExists = false;
        foreach($this->listFamilies() as $row) {
            if($row->class === $name) {
                $classExists = true;
                break;
            }
        }
        if($classExists) {
            $query = $db->prepare("SELECT id as _id, CONCAT(server , path) as path, title, FROM_UNIXTIME(created) as added, user_name as added_by FROM $name LEFT JOIN users ON {$name}.created_by = users.user_id LIMIT 10");
            $query->execute();
            $res = $query->fetchAll();
            if(count($res) > 0) {
                return $res;
            } else {
                return [];
            }
        }
        return false;
    }

    /**
     *
     */
    public function rowsCount($name)
    {
        $db = Database::getInstance();
        $query = $db->prepare("SELECT 1 FROM $name");
        $query->execute();
        return count($query->fetchAll());
    }

    /**
     *
     */
    public function showItem($name, $id)
    {
        $db = Database::getInstance();

        $classExists = false;
        foreach($this->listFamilies() as $row) {
            if($row->class === $name) {
                $classExists = true;
                break;
            }
        }
        if($classExists) {
            $query = $db->prepare("SELECT $name.id as _id, CONCAT(server , path) as path, title, FROM_UNIXTIME(created) as added, user_name as added_by FROM $name LEFT JOIN users ON {$name}.created_by = users.user_id WHERE id = :id LIMIT 1");
            $query->execute(array(':id' => $id));
            $res = $query->fetch();
            if($res !== false) {
                $query_meta = $db->prepare("SELECT tag as `key`, value FROM {$name}_metadata LEFT JOIN bind_{$name}_meta ON {$name}_metadata.id = bind_{$name}_meta.meta_id WHERE file_id = :id");
                $query_meta->execute(array(':id' => $id));
                $meta = $query_meta->fetchAll();
                if(count($meta) < 1) {
                    $meta = false;
                }
                $res->meta = $meta;
                return $res;
            }
        }
        return false;
    }
}