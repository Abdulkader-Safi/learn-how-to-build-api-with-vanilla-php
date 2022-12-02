<?php

class Category
{
  // DB stuff
  private $conn;
  private $table = 'categories';

  // Category Properties
  public $id;
  public $name;
  public $create_at;

  // Constructor
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Get Categories
  public function read()
  {
    // Select query
    $query = "SELECT 
                id,
                name,
                created_at
              FROM 
                " . $this->table;

    // Prepare statement
    $stmt = $this->conn->Prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Get Category by ID
  public function read_single()
  {
    // Select query Where ID
    $query = "SELECT 
                id,
                name,
                created_at
              FROM 
                " . $this->table . "
              WHERE
                id = ?
              LIMIT 0,1";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->id);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set properties
    $this->id = $row['id'];
    $this->name = $row['name'];
  }

  // Create Categories
  public function create()
  {
    // Create query
    $query = "INSERT 
                INTO " . $this->table . "
              SET 
                name = :name";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->name = htmlspecialchars(strip_tags($this->name));

    // Bind data
    $stmt->bindParam(":name", $this->name);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Update Categories
  public function update()
  {
    // Update query
    $query = "UPDATE 
                  " . $this->table . "
                SET 
                  name = :name
                WHERE 
                  id = :id";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":id", $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Delete Category
  public function delete()
  {
    // Delete Query
    $query = "DELETE 
              FROM 
                " . $this->table . "
              WHERE 
                id = :id";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(":id", $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    printf("Error: %s.\n", $stmt->error);

    return false;
  }
}
