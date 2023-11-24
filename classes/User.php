<?php 
 include 'Connection.php';
// inheritance - 


class User extends Connection {

    public function signUp($request){
        $firstname = $request['first_name']; // $_POST['first_name']
        $lastname = $request['last_name'];
        $username = $request['username'];
        $password = $request['password'];

        $hashed_password = password_hash($password,PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (first_name,last_name,username,password) VALUES('$firstname','$lastname','$username','$hashed_password')";

        if($this->conn->query($sql)){
            header('location: ../views/sign-in.php');
            exit;
        }else{
            die("ERROR: ".$this->conn->error);
        }
    }

    public function signIn($username,$password){
        $sql = "SELECT * FROM users WHERE username = '$username'";

        if($result = $this->conn->query($sql)){
            // make sure that there is no duplicate username
            if($result->num_rows == 1){
                $user = $result->fetch_assoc();
                if(password_verify($password,$user['password'])){
                    session_start();
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['full_name'] = $user['first_name']." ".$user['last_name'];
                    $_SESSION['username'] = $user['username'];

                    header('location: ../views/dashboard.php');
                    exit;
                }else{
                    die("ERROR: password don't match".$this->conn->error);
                }
            }else{
                die("ERROR: Username not found ".$this->conn->error);
            }
        }else{
            die("ERROR: ".$this->conn->error);
        }
    }
    public function all_users(){
       $sql = "SELECT * FROM users";

        if($result = $this->conn->query($sql)){
            return $result;
        }else{
            die("ERROR: ".$this->conn->error);
        }
    }

}