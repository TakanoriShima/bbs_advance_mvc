<?php
    class Comment{
        public $id;
        public $message_id;
        public $name;
        public $body;
        public $created_at;
        
        public function __construct($message_id="", $name="", $body=""){
            $this->message_id = $message_id;
            $this->name = $name;
            $this->body = $body;
        }
    }