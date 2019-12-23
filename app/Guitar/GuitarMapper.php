<?php

namespace App\Guitar;

class GuitarMapper
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getGuitars()
    {
        $sql = "SELECT * FROM `guitars` g";

        $stmt = $this->db->query($sql);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new GuitarEntity($row);
        }
        return $results;
    }

    public function getGuitarById($guitarId)
    {
        $sql = "SELECT * FROM `guitars` g WHERE g.id=:guitarId";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(["guitarId" => $guitarId]);
        $result = $stmt->fetch();

        if (!$result) {
            throw new \Exception("could not find record", 404);
        }

        return new GuitarEntity($result);
    }

    public function save(GuitarEntity $guitar)
    {
        $sql = "INSERT INTO `guitars`
            (name, price, qty) VALUES
            (:name, :price, :qty)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "name" => $guitar->getName(),
            "price" => $guitar->getPrice(),
            "qty" => $guitar->getQty(),
        ]);

        if (!$result) {
            throw new \Exception("could not save record", 500);
        }

        return $this->getGuitarById($this->db->lastInsertId());
    }

    public function update(GuitarEntity $guitar)
    {
        $sql = "UPDATE `guitars`
            SET `name` = :name, `price` = :price, `qty` = :qty
            WHERE `id` = :id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "name" => $guitar->getName(),
            "price" => $guitar->getPrice(),
            "qty" => $guitar->getQty(),
            "id" => $guitar->getId()
        ]);

        if (!$result) {
            throw new \Exception("could not update record", 500);
        }

        return $this->getGuitarById($guitar->getId());
    }

    public function delete($guitarId)
    {
        $this->getGuitarById($guitarId);

        $sql = "DELETE FROM `guitar` WHERE `id` = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["id"=> $guitarId]);
    }
}