<?php
class Student{
    private $db;
    private $table = 'users';

    // Constructor: Initialize the database connection
    public function __construct($db) {
        $this->db = $db;
    }


      // Method to add a new student
      public function upsertStudent($fname,$lname,$gender,$email,$comment,$website,$entry_time, $id=null) {
        $fname = $this->db->conn->real_escape_string($fname);
        $lname = $this->db->conn->real_escape_string($lname);
        $gender = $this->db->conn->real_escape_string($gender);
        $comment = $this->db->conn->real_escape_string($comment);
        $website = $this->db->conn->real_escape_string($website);
        $entry_time = $this->db->conn->real_escape_string($entry_time);

        if(is_null($id)){
            $sql = "INSERT INTO $this->table (fname,lname,gender,email,comment,website,entry_time) VALUES('$fname','$lname','$gender','$email','$comment','$website','$entry_time')";
        }else{
            $sql = "UPDATE $this->table SET fname='$fname',lname='$lname'gender='$gender'email='$email' comment='$comment'website='$website'entry_time='$entry_time' WHERE id = $id";
        }

        return $this->db->query($sql);
    }


     // Method to retrieve a single student by ID
     public function getStudentById($id) {
        $id = (int) $id;

        $sql = "SELECT * FROM $this->table WHERE id = $id";
        $result = $this->db->query($sql);

        return $result->fetch_assoc();
    }

    // Method to retrieve all students
    public function getAllStudents() {
        $sql = "SELECT * FROM $this->table";
        $result = $this->db->query($sql);

        $students = array();
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }

        return $students;
    }

  

    // Method to delete a student
    public function deleteStudent($id) {
        $id = (int) $id;

        $sql = "DELETE FROM $this->table WHERE id = $id";
        return $this->db->query($sql);
    }
}