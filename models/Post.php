<?php

namespace models;

class Post
{
    protected $conn;
    private $table='posts';
    // Post Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;
    //Constructor to connection with DB
    public function __construct($db)
    {
        $this->conn=$db;
    }
    //Read Posts
    public function read()
    {
        //Read query
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                ORDER BY
                                  p.created_at DESC';
        try {
            //Prepare statement
            $statement=$this->conn->prepare($query);
            //Execute query
            $statement->execute();
            return $statement;
        }catch (\PDOException $e)
        {
            die('error in read posts'.$e->getMessage());
        }

    }
    //Read single post
    public function readSingle()
    {
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                WHERE p.id=? LIMIT 0,1';
        try {
            //Prepare statement
            $statement=$this->conn->prepare($query);

            //bind id
            $statement->bindParam(1,$this->id);

            //Execute query
            $statement->execute();
            $row=$statement->fetch(\PDO::FETCH_ASSOC);

            //set properties
            $this->title=$row['title'];
            $this->author=$row['author'];
            $this->category_id=$row['category_id'];
            $this->category_name=$row['category_name'];
            $this->body=$row['body'];

        }catch (\PDOException $e)
        {
            die('error in read single post'.$e->getMessage());
        }
    }
    //Create post
    public function create()
    {
        //create query
        $query = 'INSERT INTO ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id';

        try {
            //prepare statement
            $statement=$this->conn->prepare($query);

            //clean data
            $this->title=htmlspecialchars(strip_tags($this->title));
            $this->author=htmlspecialchars(strip_tags($this->author));
            $this->category_id=htmlspecialchars(strip_tags($this->category_id));
            $this->body=htmlspecialchars(strip_tags($this->body));

            //bind value
            $statement->bindParam(':title',$this->title);
            $statement->bindParam(':body',$this->body);
            $statement->bindParam(':author',$this->author);
            $statement->bindParam(':category_id',$this->category_id);
            //Execute query
            if($statement->execute())
            {
                return true;
            }else{
                return false;
            }

        }catch (\PDOException $e)
        {
            die('error in created data'.$e->getMessage());
        }

    }
    //Update post
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                                SET title = :title, body = :body, author = :author, category_id = :category_id
                                WHERE id = :id';

        try {
            // Prepare statement
            $statement = $this->conn->prepare($query);

            // Clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $statement->bindParam(':title', $this->title);
            $statement->bindParam(':body', $this->body);
            $statement->bindParam(':author', $this->author);
            $statement->bindParam(':category_id', $this->category_id);
            $statement->bindParam(':id', $this->id);
            if($statement->execute()) {
                return true;
            }else
            {
                return false;
            }
        }catch (\PDOException $e)
        {
            die('error in updated post'.$e->getMessage());
        }
    }

    //Delete post
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        try {
            // Prepare statement
            $statement = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $statement->bindParam(':id', $this->id);

            //Execute query
            if($statement->execute())
            {
                return true;
            }else{
                return false;
            }
        }catch (\PDOException $e)
        {
            die('error in deleted post'.$e->getMessage());
        }
    }



}