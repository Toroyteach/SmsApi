<?php

class Database
{
    protected $connection = null;
    protected $key = CLICKATELL_KEY;
 
    public function __construct()
    {
        try {

            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
         
            if ( mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");   
            }

        } catch (Exception $e) {

            throw new Exception($e->getMessage());   

        }           
    }
 
    public function select($query = "" , $params = [])
    {
        try {

            $stmt = $this->executeStatement( $query , $params );
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);               
            $stmt->close();
 
            return $result;

        } catch(Exception $e) {

            throw New Exception( $e->getMessage() );

        }

        return false;
    }
 
    
    public function storeSms($query = "")
    {
        
        //stores the request to the database
        
        try {
            
            $stmt = $this->executeStatement($query);           
            $stmt->close();

            return $stmt;
            
        } catch(Exception $e) {
            
            throw New Exception( $e->getMessage() );
            
        } 

        return false;
        
    }
    
    public function storeSmsFromCallback($query = "")
    {
        
        //this method called after the call back url was called updated the sms to success
        
        
        try {
            
            $stmt = $this->executeStatement($query);            
            $stmt->close();

            return $stmt;
            
        } catch(Exception $e) {
            
            throw New Exception( $e->getMessage() );
            
        } 

        return false;
        
    }

    public function executeStatement($query = "")
    {

        try {
            
            $stmt = $this->connection->prepare( $query );
            
            // var_dump($stmt);
            // exit();
            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
    
            $stmt->execute();
    
            return $stmt;
    
        } catch(Exception $e) {
    
            throw New Exception( $e->getMessage() );
    
        }   
    }


}