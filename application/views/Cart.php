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
                <a href="/">Catalog</a>
            </div>
        </header>
        <main>
            <h2>Check Out</h2>
            <h3>Total: $<?=$total?></h3>
            <div class="box">
                <table>
                    <tr>
                        <th>Item name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
<?php
    if(!empty($orders)){
        foreach($orders as $order)
        {
?>
                    <tr>
                        <td><?=$order['item_name']?></td>
                        <td><?=$order['qty']?></td>
                        <td><?=$order['price']?></td>
                        <td><a href="delete/<?=$order['item_name']?>" class="x">x</a></td>
                    </tr>
<?php
        }
    }
?>
                </table>
            </div>
        </main>
        <footer>
<?php
    $message = $this->session->flashdata('message')
?>
            <p style="color: green;"><?=$message?></p>
            <h2>Billing Info</h2>
            <div class="information">
                <form action="bill" method="post">
                    <div>
                        <label for="name">Name: </label>
                        <input type="text" name="name" id="name">
                    </div>
                    <div>
                        <label for="address">Address: </label>
                        <input type="text" name="address" id="address">
                    </div>
                    <div>
                        <label for="card">Card Number: </label>
                        <input type="text" name="card_number" id="card">
                    </div>
                    <div>
                        <input type="submit" value="Submit Order" id="order">
                    </div>
                </form>
            </div>
        </footer>
    </div>
</body>
</html>