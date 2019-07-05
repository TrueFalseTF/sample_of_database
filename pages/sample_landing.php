<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">    
    <title>Магазин</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./pages/css/styles.css">    
</head>
<body>    
    <table class="table product_table">
        <caption>Корзина</caption>
        <tr>
            <th>№</th><th>Продукт</th><th>Цена</th><th>В корзине</th>
        </tr>
        <?php $pop = 0; foreach($position_basket as $row): ?>
            <tr id="tr_<?=$row["id"]?>">
                <th><?=$row["id"]?></th>

                <th><?=$row["product"]?></th>

                <th><?=$row["price"]?></th>                

                <th id="<?=$row['id']?>"><?=$row["amount_product"]?></th>
            </tr>
        <?php   
            if($row["id"] > $pop) {
                $pop = $row["id"];
            }            
        endforeach;?>
    </table>

    <div class="basket"> 
        <a href="index.php">Каталог</a><br>
        <?php $total_basket = 0;  $total_price = 0;
            foreach($position_catalogue as $row) {
            
            $total_basket += $row["amount_product"];
            $total_price += $row["price"] * $row["amount_product"];
        } ?>
        <span>Всего в корзине: </span><span id="in_total_basket"><?=$total_basket?></span><br>
        <span>Общая стоимость: </span><span id="in_total_price"><?=$total_price?></span> 
        <input type="button" onclick="clean_user_basket(); 
            CLIENT_clean_user_basket(<?=$pop?>, 'tr_');" value="Очистить корзину">
        <input type="button" onclick="sending_emeil();" value="Заказать">       
    <div>
</body>
<script src="./pages/js/engine.js"></script>
</html>