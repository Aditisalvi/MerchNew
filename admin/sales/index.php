<style>
    table td,
    table th {
        padding: 3px !important;
    }
</style>
<?php
include('../Common/admin-sidenav-header.php');
?>
<div class="app-content" style="padding-bottom: 24px">
    <div class="app-content-header">
        <h1 class="app-content-headerText">Sales Report</h1>

    </div>
    <div></div>
    <br />
    <?php
    $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date("Y-m-d", strtotime(date("Y-m-d") . " -7 days"));
    $date_end = isset($_GET['date_end']) ? $_GET['date_end'] : date("Y-m-d");
    ?>
    <div class="card ">
        <div class="card-header">
            <h5 class="card-title">Sales Report</h5>
        </div>
        <div class="card-body">
            <form id="filter-form">
                <div class="row align-items-end">
                    <div class="form-group col-md-3">
                        <label for="date_start">Date Start</label>
                        <input type="date" class="form-control form-control-sm" name="date_start"
                            value="<?php echo date("Y-m-d", strtotime($date_start)) ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="date_start">Date End</label>
                        <input type="date" class="form-control form-control-sm" name="date_end"
                            value="<?php echo date("Y-m-d", strtotime($date_end)) ?>">
                    </div>
                    <div class="form-group col-md-1">
                        <button class="btn  btn-block btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
                    </div>
                    <!-- <div class="form-group col-md-1">
                        <button class="btn btn-block btn-success btn-sm" type="button" id="printBTN"><i class="fa fa-print"></i> Print</button>
                    </div> -->
                </div>
            </form>
            <hr>
            <div id="printable">
                <div>
                    <h3 class="text-center m-0"><b>Sales Report</b></h3>
                    <!-- <p class="text-center m-0">Date Between <?php //echo $date_start ?> and <?php //echo $date_end ?></p> -->
                    <hr>
                </div>
                <div class="products-area-wrapper tableView">
                    <!-- <colgroup>
                    <col width="5">
                    <col width="10">
                    <col width="10">
                    <col width="10">
                    <col width="10">
                    <col width="10">
                </colgroup> -->
                    <thead>
                        <div class="products-header">
                            <div class="product-cell"><span>#</span></div>
                            <div class="product-cell"><span>Date Time</span></div>
                            <div class="product-cell"><span>Product</span></div>
                            <div class="product-cell"><span>Client</span></div>
                            <div class="product-cell"><span>QTY</span></div>
                            <div class="product-cell"><span>Amount</span></div>
                        </div>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT * FROM `sales` where date(date_created) between '{$date_start}' and '{$date_end}' order by unix_timestamp(date_created) desc ");
                        while ($row = $qry->fetch_assoc()):
                            $olist = $conn->query("SELECT ol.*,p.title,p.brand,concat(c.firstname,' ',c.lastname) as name,c.email,o.date_created FROM order_list ol inner join orders o on o.id = ol.order_id inner join `products` p on p.id = ol.product_id inner join clients c on c.id = o.client_id  where ol.order_id = '{$row['order_id']}' ");
                            while ($roww = $olist->fetch_assoc()):
                                ?>
                                <div class="products-row">
                                    <div class="product-cell"><span>
                                            <?php echo $i++ ?>
                                        </span></div>
                                    <div class="product-cell"><span>
                                            <?php echo $row['date_created'] ?>
                                        </span></div>
                                    <div class="product-cell"><span>
                                            <p class="m-0">
                                                <?php echo $roww['title'] ?>
                                            </p>
                                            <p class="m-0"><small>By:
                                                    <?php echo $roww['brand'] ?>
                                                </small></p>
                                        </span></div>
                                    <div class="product-cell"><span>
                                            <p class="m-0">
                                                <?php echo $roww['name'] ?>
                                            </p>
                                            <p class="m-0"><small>Email:
                                                    <?php echo $roww['email'] ?>
                                                </small></p>
                                        </span></div>
                                    <div class="product-cell"><span>
                                            <?php echo $roww['quantity'] ?>
                                        </span></div>
                                    <div class="product-cell"><span>
                                            <?php echo number_format($roww['quantity'] * $roww['price']) ?>
                                        </span></div>
                                </div>
                            <?php endwhile; ?>
                        <?php endwhile; ?>
                        <?php if ($qry->num_rows <= 0): ?>
                            <tr>
                                <td class="text-center" colspan="6">No Data...</span>
                    </div>
                    </tr>
                <?php endif; ?>
                </tbody>
            </div>
        </div>
    </div>
</div>
<noscript>
    <style>
        .m-0 {
            margin: 0;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .table {
            border-collapse: collapse;
            width: 100%
        }

        .table tr,
        .table td,
        .table th {
            border: 1px solid gray;
        }
    </style>
</noscript>
<script>
    $(function () {
        $('#filter-form').submit(function (e) {
            e.preventDefault()
            location.href = "./?page=sales&date_start=" + $('[name="date_start"]').val() + "&date_end=" + $('[name="date_end"]').val()
        })

        $('#printBTN').click(function () {
            var rep = $('#printable').clone();
            var ns = $('noscript').clone().html();
            start_loader()
            rep.prepend(ns)
            var nw = window.document.open('', '_blank', 'width=900,height=600')
            nw.document.write(rep.html())
            nw.document.close()
            nw.window.print()
            setTimeout(function () {
                nw.close()
                end_loader()
            }, 500)
        })
    })
</script>