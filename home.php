<!-- Header-->
<header class="bg-dark py-5" style="background-image: URL('assets/homebanner.png'); height: 800px">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder"></h1>
            <p class="lead fw-normal text-white-50 mb-0"></p>
        </div>
    </div>
</header>
<!-- Section-->
<style>
    .book-cover {
        object-fit: contain !important;
        height: auto !important;
    }

    .product-item {
        border: 1px solid #ddd;
        transition: transform 0.2s;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .product-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .product-item .card-img-top {
        max-height: 220px;
    }

    .product-item .card-body {
        height: 100px;
    }

    .product-item h5 {
        font-size: 1.1rem;
    }

    .product-item span {
        font-size: 0.9rem;
        display: block;
        margin-top: 5px;
    }

    .product-item p {
        font-size: 0.85rem;
        color: #777;
    }

    .product-item .btn {
        padding: 5px 12px;
        font-size: 0.85rem;
    }
</style>
<section class="">
    <div class="container px-lg-2 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
            $products = $conn->query("SELECT * FROM `products` where status = 1 order by rand() limit 8 ");
            while ($row = $products->fetch_assoc()):
                $upload_path = base_app . '/uploads/product_' . $row['id'];
                $img = "";
                if (is_dir($upload_path)) {
                    $fileO = scandir($upload_path);
                    if (isset($fileO[2]))
                        $img = "uploads/product_" . $row['id'] . "/" . $fileO[2];
                }
                foreach ($row as $k => $v) {
                    $row[$k] = trim(stripslashes($v));
                }
                $inventory = $conn->query("SELECT * FROM inventory where product_id = " . $row['id']);
                $inv = array();
                while ($ir = $inventory->fetch_assoc()) {
                    $inv[] = number_format($ir['price']);
                }
                ?>
                <div class="col mb-5">
                    <div class="card product-item">
                        <!-- Product image-->
                        <img class="card-img-top w-100 book-cover" src="<?php echo validate_image($img) ?>" alt="..." />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="">
                                <!-- Product name-->
                                <h5 class="fw-bolder">
                                    <?php echo $row['title'] ?>
                                </h5>
                                <!-- Product price-->
                                <?php foreach ($inv as $k => $v): ?>
                                    <span><b>Price: </b>
                                        <?php echo $v ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                            <p class="m-0"><small>By:
                                    <?php echo $row['brand'] ?>
                                </small></p>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 mt-3  border-top-0 bg-transparent" ">
                            <div class="text-center">
                                <a class="btn btn-flat btn-primary "
                                    href=".?p=view_product&id=<?php echo md5($row['id']) ?>">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
