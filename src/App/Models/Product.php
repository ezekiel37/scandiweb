<?php

namespace App\Models;

abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;


    public function getData(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function create($conn): string
    {
        foreach ($this as $key => $value) {
            if ($key != "conn") {
                $columns[] = "`".$key."`";
                $columnBindings[] = ':' .$key;
            }
        }
        $columnName = implode(', ', (array)$columns);

        $columnBind = implode(',', (array)$columnBindings);

        $sql = "INSERT INTO products($columnName) VALUES ($columnBind)";
        $result = $conn->prepare($sql);
        foreach ($this as $column => $value) {
            if ($column != "conn") {
                $result->bindValue(":" .$column, $value);
            }
        }
        $result->execute();
        return $conn->lastInsertId();
    }
}
