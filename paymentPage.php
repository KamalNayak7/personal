<?php

require_once("includes/header.php");
require_once("includes/config.php");

$entityId = $_GET["id"];
$username=$_SESSION["userLoggedIn"];

$payment = new Entity($con ,$entityId);
$entityName = $payment->getName();
$amountINR = $payment->getAmountInr();
$thumbnail = $payment->getThumbnail();

if(!isset($_GET["id"])){
    ErrorMessage::show("No ID is passed into page");
    
}else{
           $query= $con->prepare("SELECT * FROM billing WHERE entityId=:entityId AND username=:username");
           $query->bindValue(":entityId",$entityId);
           $query->bindValue(":username",$username);
           $query->execute();
                
           $sqlData = $query->fetch(PDO::FETCH_ASSOC);

    if($query->rowCount() > 1){
        return;
    } 

    if($query->rowCount() == 1){
        $query1=$con->prepare("UPDATE billing SET username=:username, entityId=:entityId, entityName=:entityName,amountINR=:amountINR,
                                billDate=CURRENT_TIME(), expiryDateTime= DATE_ADD(CURRENT_TIME(), INTERVAL 48 HOUR) WHERE (username=:username AND entityId=:entityId)");
                                 $query1->bindValue(":username",$username);
                                 $query1->bindValue(":entityId",$entityId);
                                 $query1->bindValue(":entityName",$entityName);
                                 $query1->bindValue(":amountINR",$amountINR);
                                 $query1->execute();
    }
    else{
                       
                $query2 = $con->prepare("INSERT INTO billing(username, entityName, entityId, amountINR, billDate, expiryDateTime) 
                                     VALUES(:username, :entityName,  :entityId, :amountINR, CURRENT_TIME(), DATE_ADD(CURRENT_TIME(), INTERVAL 48 HOUR))");
                $query2->bindValue(":username",$username);
                $query2->bindValue(":entityId",$entityId);
                $query2->bindValue(":entityName",$entityName);
                $query2->bindValue(":amountINR",$amountINR);
                $query2->execute();
    }
   
    
}
 ?>

 <div class="paymentInfoContainer  column">

    <div  class="formSection">

        <form method="POST">
            <h2> Payment Details</h2>

            <?php
                $customerPayment = new customerPayment($con, $entityId, $username);

                $entityName = isset($_POST["entityName"]) ?  $_POST["entityName"] : $customerPayment->getEntityName();
                $amountINR = isset($_POST["amountINR"]) ?  $_POST["amountINR"] : $customerPayment->getAmountINR();

                
                
            ?>
            
            <img src='<?php echo $thumbnail?>'   readonly>

            <input type="text" name="entityName" placeholder="Movie /Series Name" value="<?php echo $entityName;?>"  readonly>
            <input type="text" name="amountINR" placeholder="Amount" value="<?php echo $amountINR ;?> INR"  readonly>

            
           <div class ="buyButton">
            <a href="billing.php?id=<?php echo $entityId;?>">BUY</a>
          </div>

          <div id= "paypal-button-container"></div>
        
</form>
            <script src="https://www.paypal.com/sdk/js?client-id=AVAX6Hf2y5C99_Fm52ft-2HUfYImtsA7ZjxYa_8QMTb53ADN27faQH7nOdBw857zsPqAFMpsH9ofzzUc&disable-funding=credit,card"></script>
           
            <script>
                paypal.Buttons({
                    style:{
                        color:'blue',
                        shape:'pill'
                    },
                    createOrder: function(data, actions) {
                    // This function sets up the details of the transaction, including the amount and line item details.
                    return actions.order.create({
                        purchase_units: [{
                        amount: {
                            value: '<?php echo $amountINR;?>'
                        }
                        }]
                    });
                    },
                    onApprove: function(data, actions) {
                    // This function captures the funds from the transaction.
                    return actions.order.capture().then(function (details) {
                     console.log(details)
                     window.location.replace("http://localhost:3030/kamalflix/success.php")
                })
                    },
                    onCancel:function(data){
                        window.location.replace("http://localhost:3030/kamalflix/index.php")
                     }
                }).render('#paypal-button-container');
                //This function displays Smart Payment Buttons on your web page.
            </script>
 </div>              