<?php
    function verificaUsuari($user)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT count(username) FROM users WHERE (username='$user' OR mail='$user')";
            actualizarLastSignIn($user);
            $existeix = $db->query($sql);
            $resultado = $existeix->fetch();
            
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
        
        return ($resultado[0]==1 ? true : false);
    }

    function getHashPass($user)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT passHash FROM users WHERE username='$user' OR mail='$user'";
            actualizarLastSignIn($user);
            $pass = $db->query($sql);
            $resultado = $pass->fetch();
            
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
        
        return ($resultado);   
    }

    function actualizarLastSignIn($user)
    {
        require('connecta_db_persistent.php');
        try{
            $sql = "UPDATE users SET lastSignIn = CURRENT_TIMESTAMP WHERE username='$user' or mail='$user'";
            $existeix = $db->query($sql);
                        
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }

    function registrarUsuari($user, $email, $firstName, $lastName, $passHash)
    {
        require('connecta_db_persistent.php');
        try{
            $activationCode = hash('sha256',rand());
            $sql = "INSERT INTO users(mail, username, userFirstName, userLastName, passHash, lastSignIn, active, activationCode) values ('$email','$user','$firstName','$lastName','$passHash', CURRENT_TIMESTAMP, 0, '$activationCode')";
            session_start();
            $_SESSION['usuari'] = $user;
            $existeix = $db->query($sql);
            
        } catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }

    function existeixUsername($user)
    {
        require('connecta_db_persistent.php');
        try{
            $sql = "SELECT count(username) FROM users WHERE username='$user'";
            $existeix = $db->query($sql);
            $resultado = $existeix->fetch();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
        
        return ($resultado[0]==1 ? true : false);
    }

    function existeixEmail($email)
    {
        require('connecta_db_persistent.php');
        try{
            $sql = "SELECT count(*) FROM users WHERE mail='$email'";
            $existeix = $db->query($sql);
            $resultado = $existeix->fetch();
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
        
        return ($resultado[0]==1 ? true : false);
    }
    
    function getActivationCode($user)
    {
        require('connecta_db_persistent.php');

        try{
            $sql = "SELECT activationCode FROM users WHERE username='$user' OR mail='$user'";
            $activationCode = $db->query($sql);
            $resultado = $activationCode->fetch();
            
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
        
        return ($resultado); 
    }





