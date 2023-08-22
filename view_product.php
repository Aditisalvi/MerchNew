<?php 
 $products = $conn->query("SELECT * FROM `products`  where md5(id) = '{$_GET['id']}' ");
 if($products->num_rows > 0){
     foreach($products->fetch_assoc() as $k => $v){
         $$k= stripslashes($v);
     }
    $upload_path = base_app.'/uploads/product_'.$id;
    $img = "";
    if(is_dir($upload_path)){
        $fileO = scandir($upload_path);
        if(isset($fileO[2]))
            $img = "uploads/product_".$id."/".$fileO[2];
        // var_dump($fileO);
    }
    $inventory = $conn->query("SELECT * FROM inventory where product_id = ".$id);
    $inv = array();
    while($ir = $inventory->fetch_assoc()){
        $inv[] = $ir;
    }
 }
?>
<style>
        /* Inline styles for the related products section */
        .py-5 {
            padding: 3rem 0;
            background-color: #f8f8f8;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        .mb-4 {
            margin-bottom: 1.5rem;
        }
        .row {
            margin: -15px;
        }
        .col {
            padding: 15px;
        }
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
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <div class="product-image-container">
                    <img class="product-image" loading="lazy" id="display-img" src="<?php echo validate_image($img) ?>" alt="Product Image" />
                </div>
                <div class="mt-2 row gx-2 gx-lg-3 row-cols-4 row-cols-md-3 row-cols-xl-4 justify-content-start">
                    <?php 
                        foreach($fileO as $k => $img):
                            if(in_array($img,array('.','..')))
                                continue;
                    ?>
                    <!-- Display additional images here if needed -->
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-6 product-details-col">
                <h1 class="product-title display-5 fw-bolder border-bottom border-primary pb-1"><?php echo $title ?></h1>
                <p class="product-author m-0"><small>By: <?php echo $brand ?></small></p>
                <div class="product-price fs-5 mb-5">&#x20b9;<span id="price"><?php echo number_format($inv[0]['price']) ?></span><br>
                    <span class="product-availability"><small><b>Available Stock:</b> <span id="avail"><?php echo $inv[0]['quantity'] ?></span></small></span>
                </div>
                <div class="change-size">
                    <label>Size:</label>
                    <select class="form-select" style="max-width:6rem;">
                        <option>S</option>
                        <option>M</option>
                        <option>L</option>
                        <option>XL</option>
                        <option>2XL</option>
                    </select>
                </div>
                <br>
                <form action="" id="add-cart">
                    <div class="product-quantity d-flex">
                        <input type="hidden" name="price" value="<?php echo $inv[0]['price'] ?>">
                        <input type="hidden" name="inventory_id" value="<?php echo $inv[0]['id'] ?>">
                        <input class="quantity-input form-control text-center me-3" id="inputQuantity" type="number" value="1" style="max-width: 5rem" name="quantity" />
                        <button class="add-to-cart-btn btn btn-warning flex-shrink-0" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Add to Cart
                        </button>
                    </div>
                </form>
                <p class="product-description lead"><?php echo stripslashes(html_entity_decode($description)) ?></p>
            </div>
        </div>
    </div>
</section>

<style>
    /* Add this CSS to improve the appearance */
    .product-image-container {
        border: 1px solid #ddd;
        padding: 10px;
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .product-image {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    .product-details-col {
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .product-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .product-author {
        font-size: 14px;
        color: #777;
    }

    .product-price {
        font-size: 20px;
        font-weight: bold;
        margin-top: 20px;
    }

    .product-availability {
        font-size: 14px;
        color: #777;
    }

    .quantity-input {
        max-width: 3rem;
    }

    .add-to-cart-btn {
        background-color: #f0c14b;
        border-color: #a88734 #9c7e31 #846a29;
        font-size: 16px;
        padding: 10px 20px;
        border-radius: 3px;
        color: #111;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .add-to-cart-btn:hover {
        background-color: #f0c14b;
    }

    .product-description {
        font-size: 16px;
        margin-top: 30px;
        line-height: 1.6;
    }
</style>
<!-- Related items section-->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Related products</h2>
        <div class="row gx-4 gx-lg-5 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php 
            $products = $conn->query("SELECT * FROM `products` where status = 1 and (category_id = '{$category_id}' or sub_category_id = '{$sub_category_id}') and id !='{$id}' order by rand() limit 4 ");
            while($row = $products->fetch_assoc()):
                $upload_path = base_app.'/uploads/product_'.$row['id'];
                $img = "";
                if(is_dir($upload_path)){
                    $fileO = scandir($upload_path);
                    if(isset($fileO[2]))
                        $img = "uploads/product_".$row['id']."/".$fileO[2];
                }
                $inventory = $conn->query("SELECT * FROM inventory where product_id = ".$row['id']);
                $_inv = array();
                foreach($row as $k=> $v){
                    $row[$k] = trim(stripslashes($v));
                }
                while($ir = $inventory->fetch_assoc()){
                    $_inv[] = number_format($ir['price']);
                }
            ?>
            <div class="col mb-5">
                <div class="product-item card" style="border: 1px solid #ddd; transition: transform 0.2s; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <img src="<?php echo validate_image($img) ?>" alt="Product Image" class="card-img-top w-100 book-cover" style="max-height: 220px; object-fit: contain;">
                    <div class="card-body p-4">
                        <h5 class="fw-bolder" style="font-size: 1.1rem;"><?php echo $row['title'] ?></h5>
                        <?php foreach($_inv as $k=> $v): ?>
                            <span style="font-size: 0.9rem;"><b>Price: </b><?php echo $v ?></span>
                        <?php endforeach; ?>
                        <p class="m-0"><small style="font-size: 0.85rem;">By: <?php echo $row['brand'] ?></small></p>
                    </div>
                    <div class="card-footer p-4 pt-0 mt-5 border-top-0 bg-transparent ">
                        <div class="text-center">
                            <a class="btn btn-flat btn-primary" href=".?p=view_product&id=<?php echo md5($row['id']) ?>" style="padding: 5px 12px; font-size: 0.85rem;">View</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<script>
    var inv = $.parseJSON('<?php echo json_encode($inv) ?>');
    $(function(){
        $('.view-image').click(function(){
            var _img = $(this).find('img').attr('src');
            $('#display-img').attr('src',_img);
            $('.view-image').removeClass("active")
            $(this).addClass("active")
        })
        $('.p-size').click(function(){
            var k = $(this).attr('data-id');
            $('.p-size').removeClass("active")
            $(this).addClass("active")
            $('#price').text(inv[k].price)
            $('[name="price"]').val(inv[k].price)
            $('#avail').text(inv[k].quantity)
            $('[name="inventory_id"]').val(inv[k].id)

        })

        $('#add-cart').submit(function(e){
            e.preventDefault();
            if('<?php echo $_settings->userdata('id') ?>' <= 0){
                uni_modal("","login.php");
                return false;
            }
            start_loader();
            $.ajax({
                url:'classes/Master.php?f=add_to_cart',
                data:$(this).serialize(),
                method:'POST',
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("an error occured",'error')
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status=='success'){
                        alert_toast("Product added to cart.",'success')
                        $('#cart-count').text(resp.cart_count)
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                    }
                    end_loader();
                }
            })
        })
    })
</script>