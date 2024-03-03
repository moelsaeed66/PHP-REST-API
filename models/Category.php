<?php

namespace models;

class Category
{
    protected $conn;
    private $table='categories';
    public $name;
    public $id;
    public $created_at;
    public function __construct($db)
    {
        $this->conn=$db;
    }
    //Create category
    public function create()
    {
        //create query
        $query='INSERT INTO'.$this->table.'SET name=:name';
        try {
            //prepare statement
            $statement=$this->conn->prepare($query);

            //clean data
            $this->name=htmlspecialchars(strip_tags($this->name));

            //bind value
            $statement->bindParam(':name',$this->name);
            //Execute query
            if($statement->execute())
            {
                return true;
            }else
            {
                return false;
            }

        }catch (\PDOException $e)
        {
            die('error in created category'.$e->getMessage());
        }
    }
    //Read category
    public function read()
    {
        //Read query
        $query = 'SELECT
        id,
        name,
        created_at
      FROM
        ' . $this->table . '
      ORDER BY
        created_at DESC';
        try {
            //prepare statement
            $statement=$this->conn->prepare($query);

            //Execute query
            $statement->execute();
            return $statement;
        }catch (\PDOException $e)
        {
            die('error in read categories'.$e->getMessage());
        }
    }
    //Read single_Category
    public function read_single()
    {
        //Read query
        $query='SELECT id,name,created_at FROM '.$this->table.' WHERE id=?
         LIMIT 0,1 ';
        try {
            //prepare statement
            $statement=$this->conn->prepare($query);

            //bind id
            $statement->bindParam(1,$this->id);

            //Execute query
            $statement->execute();

            //Get category
            $row=$statement->fetch(\PDO::FETCH_ASSOC);

            //set properties
            $this->id=$row['id'];
            $this->name=$row['name'];
        }catch (\PDOException $e)
        {
            die('error in read single category'.$e->getMessage());
        }
    }

    //Update Category
    public function update()
    {
        //Update query
        $query= $query = 'UPDATE ' .
            $this->table . '
    SET
      name = :name
      WHERE
      id = :id';
        try {
            //Prepare Statement
            $statement=$this->conn->prepare($query);

            //Clean Data
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->id=htmlspecialchars(strip_tags($this->id));

            //Bind Value
            $statement->bindParam(':name',$this->name);
            $statement->bindParam(':id',$this->id);

            //Execute query
            if($statement->execute()){
                return true;
            }


        }catch (\PDOException $e)
        {
            die('error in update category'.$e->getMessage());
        }
    }

    //Delete category
    public function delete()
    {
        //Delete Query
        $query='DELETE FROM '.$this->table.' WHERE id=:id';
        try {
            //Prepare statement
            $statement=$this->conn->prepare($query);

            //Bind value
            $statement->bindParam(':id',$this->id);

            //Execute query
            if($statement->execute())
            {
                return true;
            }
        }catch (\PDOException $e)
        {
            die('error in delete category'.$e->getMessage());
        }

    }



}