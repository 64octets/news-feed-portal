<?php

namespace Engine\Traits;

trait Query
{
    public function searchByFields($fields, $search)
    {
        if ($search == '') {
            return $this;
        }
        if (!$fields) {
            return $this;
        }

        for ($i=0; $i < count($fields); $i++) {
            if (is_array($fields[$i])) {
                $tableName = isset($this->propelTableName) ? $this->propelTableName : null;
                if (!$tableName) {
                    continue;
                }

                $items = [];
                foreach ($fields[$i] as $item) {
                    $items[] = $tableName . "." . trim($item);
                }
                $statement = implode(', " ", ', $items);
                $this->where("CONCAT($statement) LIKE ?", "%$search%");
            } else {
                $filter = 'filterBy'.$fields[$i];
                $this->$filter('%'.$search.'%');
            }

            if ($i < count($fields)-1) {
                $this->_or();
            }
        }

        return $this;
    }
}
