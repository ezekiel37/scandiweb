<?php

namespace App\Controller;

use App\Models\Book;
use App\Models\Dvd;
use App\Models\Furniture;
use PDO;

class ProductController
{
    public function processRequest(string $method, $database, ?string $id): void
    {
        if ($id == null) {
            $this->processCollectionRequest($method, $database);
        } elseif ($id == "delete") {
            $this->processDeleteRequest($database);
        } elseif ($id == "check") {
            $this->processResourceRequest($method, $database, $id);
        } else {
            http_response_code(404);
            echo "404 not found";
        }
    }

    private function processDeleteRequest($database)
    {
        $conn = $database->getConnection();
        echo "getting deleted...";


        $data = (array) json_decode(file_get_contents("php://input"), true);
        $deleted = $data["products"];


        $sql = "DELETE FROM products WHERE id IN (".implode(",", $deleted) . ")";
        $stmt = $conn->prepare($sql);



        $stmt->execute();

        echo $stmt->rowCount();
    }

    private function processResourceRequest(string $method, $database, string $id): void
    {
        $conn = $database->getConnection();
        $data = (array) json_decode(file_get_contents("php://input"), true);

        $sku = $data["sku"];

        if (!$sku) {
            http_response_code(404);
            echo json_encode(["message" => "Product not found"]);
        }


        $sql = "SELECT *
                FROM products
                WHERE sku = :sku";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":sku", $sku, PDO::PARAM_INT);

        $stmt->execute();

        echo $stmt->rowCount();
    }

    private function processCollectionRequest(string $method, $database): void
    {
        switch ($method) {
            case "GET":
                $conn = $database->getConnection();
                $sql = "SELECT *
                FROM products";

                $stmt = $conn->query($sql);

                $data = [];

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

                echo json_encode($data);

                break;

            case "POST":

                $data = (array) json_decode(file_get_contents("php://input"), true);

                $conn = $database->getConnection();

                $selectedType = $data["select"];

                echo "selectedType: " . $selectedType;

                $productSelect = [
                'Book'=> $book = new Book(),
                'Dvd'=> $dvd = new Dvd(),
                'Furniture'=> $furniture = new Furniture(),
                ];
                $productSelect[$selectedType]->getData($data);
                $id = $productSelect[$selectedType]->create($conn);

                http_response_code(201);
                echo json_encode([
                    "message" => "Product created",
                    "id" => $id
                ]);
                break;

            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }
}
