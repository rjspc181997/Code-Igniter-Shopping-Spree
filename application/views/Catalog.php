<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog</title>
    <link rel="stylesheet" href="<?=base_url('assets/style1.css')?>" type="text/css">
</head>
<body>
    <div class="container">
        <header>
            <div class="header-L">
                <h1>My Store</h1>
            </div>
            <div class="header-R">
                <a href="Items/cart">Cart(<?=$cart==null || $cart=="Buy"?$cart=0:$cart?>)</a>
            </div>
        </header>
        <main>
           
<?php
    foreach($products as $product){
?>                <div>
                    <form action="buy" method="post">
                        <img src="<?=base_url('assets/img/'.$product['filename'])?>" alt="<?=$product['name']?>">
                            <p><?=$product['name']?> <span>$<?=$product['price']?></span></p>
                            <input type="number" name="<?=$product['name']?>" min="0" max="100" class="quantity" placeholder="0">
                            <input type="submit" value="Buy" class="buy" name="click">
                        </form>
                </div>
<?php
    }
?>
            
        </main>
    </div>
</body>
</html>