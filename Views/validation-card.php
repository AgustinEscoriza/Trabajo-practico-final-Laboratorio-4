<?php

    require_once("nav.php");
//$total, $cardOwner, $cardNumber, $expirationMonth, $expirationYear, $cvv
?>

<main class = "py-5">
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="mb-4" style="color:white">Enter Billing Information</h1>
        </div>
    </div> 
    <section class = "mb-5">
        <div class = "container" style="text-align:center;">
                <form action="<?php echo FRONT_ROOT ?>Ticket/validateCreditCard" method="post" class="add-form bg-light-alpha p-5">                  
                         <div class="col-lg-4">
                                <div class="form-group"> <label for="total">
                                        <h6 style="color:white">Total Price: $<?php echo $total ?></h6>
                                        <input type="hidden" name="total" value="<?php echo $total?>" class="form-control">
                                        
                                    </label>
                                </div>
                         </div>
                    <div class ="row" style="display:inline;">
                         <div class="col-lg-4">
                              <div class="form-group"><label for="cardOwner">
                                        <h6 style="color:white">Card Owner</h6>
                                    </label> 
                                        <input type="text" name="cardOwner" placeholder="Card Owner Name" required
                                        class="form-control text-center"> </div>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group"><label for="cardNumber">
                                <h6 style="color:white">Card Number</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="cardNumber"
                                            placeholder="Valid card number" class="form-control text-center" required>
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                <i class="fa fa-credit-card mx-1"></i> </div>
                              </div>
                         </div>
                         
                    </div>
                    <div class ="row">
                                    <div class="col-sm-8">
                                        <div class="form-group"> <label><span class="hidden-xs">
                                                    <h6 style="color:white">Expiration Date</h6>
                                                </span></label>
                                            <div class="input-group"> <input type="number" placeholder="MM"
                                                    name="expirationMonth" class="form-control text-center" required>
                                                <input type="number" placeholder="YYYY" name="expirationYear"
                                                    class="form-control text-center" required> </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group mb-4"> <label data-toggle="tooltip" for="cvv"
                                                title="Three digit CV code on the back of your card">
                                                <h6 style="color:white">CVV <i
                                                        class="fa fa-question-circle d-inline"></i></h6>
                                            </label> <input type="text" name="cvv" required class="form-control text-center">
                                        </div>
                                    </div>
                    </div>

                    <div class ="row">
                         <?php
                           if(isset($addMessage) && $addMessage!=1){
                           echo $addMessage;
                           }
                         ?>   
                    </div>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Pay Secure</button>
               </form>

                <li class="list-group">
                        <?php if(!empty($ticketList)){ ?>
                        <a class="btn btn-warning"  href="<?php echo FRONT_ROOT; ?>Ticket/purchaseView">
                            Confirm Purchase</a>
                        <?php } ?>
                </li>

            <?php
            if (isset($addMessage) && $addMessage != "") {
                echo "<div class='alert alert-primary' role='alert'> $addMessage </div>";
            }
            ?>
        </div>
    </section>
</main>