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
       

       
        if ($id == null ) {

         

            $this->processCollectionRequest($method, $database);
          
        } 
        else if($id == "delete"){
            $this->processDeleteRequest($database);
        }
        else {
          
             $this->processResourceRequest($method, $database, $id);
        }
    }

    private function processDeleteRequest($database){

        $conn = $database->getConnection();
        echo "getting deleted...";
       

        $data = (array) json_decode(file_get_contents("php://input"), true);
        $deleted = $data["products"];

        
        $sql = "DELETE FROM products WHERE id IN (".implode(",", $deleted ) . ")";
        $stmt = $conn->prepare($sql);

        // $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        echo $stmt->rowCount();
        // $rows = $this->gateway->delete($id);

        // echo json_encode([
        //     "message" => "Product $id deleted",
        //     "rows" => $rows
        // ]);
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
                echo "inside POST request";

                $data = (array) json_decode(file_get_contents("php://input"), true);

                $d = file_get_contents('php://input'); 
              
                print_r($d);
                
                $conn = $database->getConnection();

                print_r($_POST[]);

                var_dump($database);

                $selectedType = $_POST["select"];

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
