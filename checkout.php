<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<?php
$total = 0;
$qry = $conn->query("SELECT c.*,p.title,i.price,p.id as pid from `cart` c inner join `inventory` i on i.id=c.inventory_id inner join products p on p.id = i.product_id where c.client_id = " . $_settings->userdata('id'));
while ($row = $qry->fetch_assoc()):
    $total += $row['price'] * $row['quantity'];
endwhile;
?>
<section class="text-black-50" style="width:100%;padding-top:50px">
    <div class="container">
        <div class="card" style="border-radius:32px;">
            <div class="card-body"></div>
            <h2 class="text-center"><b>Checkout</b></h2>
            <hr class="border-dark">
            <form action="" id="place_order">
                <form class="row g-3">
                    <div style="padding-left:50px;">
                        <h4><b> Contact Details</b></h4>
                    </div>

                    <div class="row">
                        <div class="col-sm" style="padding-left:60px;">
                            <input class="form-control" type="text" name="Name" placeholder="Name"
                                aria-label="Name"><br>
                        </div>
                        <div class="col-sm" style="padding-right:100px;">
                            <input class="form-control" type="number" name="Mobile_no" placeholder="Mobile No"
                                aria-label="Mobile No"><br>
                        </div>
                    </div>


                    <div style="padding-left:50px;">
                        <h4><b> Address</b></h4>
                    </div>
                    <div class="row">
                        <div class="col-sm-7 w-25" style="padding-left:60px;">
                            <input class="form-control" type="number" placeholder="Pin Code" aria-label="Pin Code"><br>
                        </div>
                        <div class="col-sm  w-50" style="padding-left:50px;">
                            <input class="form-control" type="text" placeholder="City/District"
                                aria-label="City/District"><br>
                        </div>
                        <div class="col-sm  w-50" style="padding-right:100px;">
                            <input class="form-control" type="text" placeholder="State" aria-label="State"><br>
                        </div>
                    </div>
                    <div class="form-group col address-holder" style="padding-left:50px;padding-right:100px;">
                        <h5>
                            <label for="" class="control-label">Delivery Address</label>
                            <textarea id="" cols="30" rows="3" name="delivery_address" class="form-control"
                                placeholder="Address"
                                style="resize:none"><?php echo $_settings->userdata('default_delivery_address') ?></textarea>
                        </h5>
                    </div>

                    <br><br>
                    <div class="row row-col-1 justify-content-center">
                        <div class="col-6">
                            <div class="form-group col mb-0">
                                <label for="" class="control-label">Order Type</label>
                            </div>
                            <div class="form-group d-flex pl-2">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input custom-control-input-primary" type="radio"
                                        id="customRadio4" name="order_type" value="2" checked="">
                                    <label for="customRadio4" class="custom-control-label">For Delivery</label>
                                </div>
                                <div class="custom-control custom-radio ml-3">
                                    <input
                                        class="custom-control-input custom-control-input-primary custom-control-input-outline"
                                        type="radio" id="customRadio5" name="order_type" value="1">
                                    <label for="customRadio5" class="custom-control-label">For Pick up</label>
                                </div>
                            </div>

                            <div class="col">
                                <span>
                                    <h4><b>Total:</b>
                                        <?php echo number_format($total) ?>
                                    </h4>
                                </span>
                            </div>
                            <hr>
                            <div class="col my-3">
                                <h4 class="text-muted">Payment Method</h4>
                                <div class="d-flex w-100 justify-content-between">
                                    <button class="btn  btn-dark">Cash on Delivery</button>
                                    <!-- <span id="paypal-button"></span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="padding-left:50px;">
                        <h4><b> Credit/Debit Card</b></h4>
                    </div>
                    <div class="row">
                        <div class="col-sm-7 w-50" style="padding-left:60px;">
                            <input class="form-control" type="number" name="card_number" placeholder="Card Number"
                                aria-label="Card Number"><br>
                        </div>
                        <div class="col-sm w-75" style="padding-right:100px;">
                            <input class="form-control" type="text" name="card_name" placeholder="Name on card"
                                aria-label="Name on card"><br>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm w-50" style="padding-left:60px;">
                            <input class="form-control" type="text" name="card_expiry" placeholder="Valid Thru(MM/YY)"
                                aria-label="Validity"><br>
                        </div>
                        <div class="col-sm w-50" style="padding-right:100px;">
                            <input class="form-control" type="text" name="cvv" placeholder="CVV" aria-label="CVV"><br>
                        </div>
                    </div>

                    <!-- <div class="" style="padding-left:600px;"><a href="./?p=otp"
                            class="btn btn-primary" id="btn_pay" name="btn_pay">Pay now</a></div> -->
                            <button class="btn btn-primary" id="btn_pay" name="btn_pay">Pay now</button>
                    <input type="hidden" name="amount" value="<?php echo $total ?>">
                    <input type="hidden" name="payment_method" value="online payment">
                    <input type="hidden" name="paid" value="0">

                </form>
        </div>
    </div>
</section>
<script>
    paypal.Button.render({
        env: 'sandbox', // change for production if app is live,

        //app's client id's
        client: {
            sandbox: 'AdDNu0ZwC3bqzdjiiQlmQ4BRJsOarwyMVD_L4YQPrQm4ASuBg4bV5ZoH-uveg8K_l9JLCmipuiKt4fxn',
            //production: 'AaBHKJFEej4V6yaArjzSx9cuf-UYesQYKqynQVCdBlKuZKawDDzFyuQdidPOBSGEhWaNQnnvfzuFB9SM'
        },

        commit: true, // Show a 'Pay Now' button

        style: {
            color: 'blue',
            size: 'small'
        },

        payment: function (data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            //total purchase
                            amount: {
                                total: '<?php echo $total; ?>',
                                currency: 'PHP'
                            }
                        }
                    ]
                }
            });
        },

        onAuthorize: function (data, actions) {
            return actions.payment.execute().then(function (payment) {
                // //sweetalert for successful transaction
                // swal('Thank you!', 'Paypal purchase successful.', 'success');
                payment_online()
            });
        },

    }, '#paypal-button');

    function payment_online() {
        $('[name="payment_method"]').val("Online Payment")
        $('[name="paid"]').val(1)
        $('#place_order').submit()
    }
    $(function () {
        $('[name="order_type"]').change(function () {
            if ($(this).val() == 2) {
                $('.address-holder').hide('slow')
            } else {
                $('.address-holder').show('slow')
            }
        })
        $('#place_order').submit(function (e) {
            e.preventDefault()
            start_loader();
            $.ajax({
                url: 'classes/Master.php?f=place_order',
                method: 'POST',
                data: $(this).serialize(),
                dataType: "json",
                error: err => {
                    console.log(err)
                    alert_toast("an error occured", "error")
                    end_loader();
                },
                success: function (resp) {
                    if (!!resp.status && resp.status == 'success') {
                        alert_toast("Order Successfully placed.", "success")
                        setTimeout(function () {
                            location.replace('./')
                        }, 2000)
                    } else {
                        console.log(resp)
                        alert_toast("an error occured", "error")
                        end_loader();
                    }
                }
            })
        })
    })
</script>