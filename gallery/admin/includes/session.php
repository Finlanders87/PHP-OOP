<?php


class Session {
    
    private $signed_in = false;
    public $user_id;
    public $message;
    public $counts;
    
    
    function __construct() {
       
        session_start();
        $this->visitor_count();
        $this->check_the_login();
        $this->check_message();
    }
    
    
    
    
    public function message($msg="") {
        
        if(!empty($msg)) {
            $_SESSION['message'] = $msg;
        }
        else {
            return $this->message;
        }
    }
    
    
    
    private function check_message() {
        
        if(isset($_SESSION['message'])) {
            
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        else {
            
            $this->message = "";
        }
    }
    
    
    public function visitor_count() {
        
        if(isset($_SESSION['counts'])) {
            
            return $this->counts = $_SESSION['counts']++;    
        }
        else {
        
           return $_SESSION['counts'] = 1;
        }
    }
    

    
    
        // On sisään kirjautunut.
    public function is_signed_in() {
        
        return $this->signed_in;
    }
    
    
        // Kirjaudutaan sisään.
    public function login($user) {
        
        if($user) {
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signed_in = true;
        }    
    }
    
    
        // Kirjaudutaan ulos.
    public function logout() {
        
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;    
    }
    

    private function check_the_login() {
        
        if(isset($_SESSION['user_id'])) {
            
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        }
        
            // Jos käyttäjää ei löydy.
        else {
            unset($this->user_id);
            $this->signed_in = false;
        } 
    }
    
    
}  // class Session

$session = new Session();
$message = $session->message();





?>