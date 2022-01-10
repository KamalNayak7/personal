<?php
class PaymentPageProvider{
    private $con, $sqlData;

    public function  __construct($con, $input){
        $this->con=$con;
        $this->sqlData=$input;
    }
}
?>