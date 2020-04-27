<?php

class Response {

    public $status;
    public $data;

    public function __construct($failureMessage = 'Operation failed') {

        $this->status = 'failure';
        $this->data = $failureMessage;
    }
}