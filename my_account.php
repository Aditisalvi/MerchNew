<?php include('user-sidenav.php');?>
<head>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css">
    <link rel="stylesheet" href="http://localhost/Merch/style.css"> 
   
    <link rel="stylesheet" href="http://localhost/Merch/Common/Styles/style1.css">
    <link rel="stylesheet" href="http://localhost/Merch/Common/Styles/style2.css">
</head>
<section class="py-5">
    <div class="container" style="margin-right:50px;">
        <div class="card" style="border-radius:32px;">
            <div class="card-body">
                <div class="w-100 justify-content-between d-flex">
                    <h4><b>Orders</b></h4>
                    <!-- <a href="./?p=edit_account" class="btn btn btn-dark">
                        <div class="fa fa-user-cog"></div> Manage Account
                    </a> -->
                </div>
                <hr class="border-warning">
                <div class="products-area-wrapper tableView">
                    <thead>
                        <div class="products-header">
                            <div class="product-cell"><span>#</span></div>
                            <div class="product-cell"><span>DateTime</span></div>
                            <div class="product-cell"><span>Transaction ID</span></div>
                            <div class="product-cell"><span>Amount</span></div>
                            <div class="product-cell"><span>Order Status</span></div>
                        </div>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT o.*,concat(c.firstname,' ',c.lastname) as client from `orders` o inner join clients c on c.id = o.client_id where o.client_id = '" . $_settings->userdata('id') . "' order by unix_timestamp(o.date_created) desc ");
                        while ($row = $qry->fetch_assoc()):
                            ?>
                            <div class="products-row">
                                <div class="product-cell" style="text-align:center"><span>
                                        <?php echo $i++ ?>
                                    </span></div>
                                <div class="product-cell" style="text-align:center"><span>
                                        <?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?>
                                    </span></div>
                                <div class="product-cell" style="text-align:center;decoration:none"><span><h6><?php echo md5($row['id']); ?></h6></span>
                                </div>
                                <div class="product-cell" style="text-align:center"><span>
                                        <?php echo number_format($row['amount']) ?>
                                    </span></div>
                                <div class="product-cell" style="text-align:center"><span>
                                        <?php if ($row['status'] == 0): ?>
                                            <span class="badge badge-light text-dark">Pending</span>
                                        <?php elseif ($row['status'] == 1): ?>
                                            <span class="badge badge-primary">Packed</span>
                                        <?php elseif ($row['status'] == 2): ?>
                                            <span class="badge badge-warning">Out for Delivery</span>
                                        <?php elseif ($row['status'] == 3): ?>
                                            <span class="badge badge-success">Delivered</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Cancelled</span>
                                        <?php endif; ?>
                                    </span></div>
                            </div>
                        <?php endwhile; ?>
                    </tbody>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function cancel_book($id) {
        start_loader()
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=update_book_status",
            method: "POST",
            data: { id: $id, status: 2 },
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("an error occured", 'error')
                end_loader()
            },
            success: function (resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    //alert_toast("Product cancelled successfully", 'success')
                    setTimeout(function () {
                        location.reload()
                    }, 2000)
                } else {
                    console.log(resp)
                    alert_toast("an error occured", 'error')
                }
                end_loader()
            }
        })
    }
    $(function () {
        $('.view_order').click(function () {
            uni_modal("Order Details", "./admin/orders/view_order.php?view=user&id=" + $(this).attr('data-id'), 'large')
        })
        $('table').dataTable();

    })
</script>