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
        <caption>Выборка товаров по свойствам</caption>
        <form action="./index.php" method="get">
            <input type=""> <!-- форма выбора и кнопка отправки -->
        </form>
        <tr>
            <th>№</th><th>Продукт</th><th>Категория</th><th>Цена</th>
            <?php foreach($product_properties as $cols): ?><th><?=$cols["name_properties"]?></th><?php endforeach;?>
        </tr>

        <!-- цикл ограничен допустимым количеством строк на странице -->
        <?php $pop = 0; foreach($sorted_products as $row): ?>
            <tr id="tr_<?=$row["id"]?>">
                <th><?=$row["id"]?></th>

                <th><?=$row["price"]?></th>

                <th><?=$row["category"]?></th>                

                <th><?=$row["amount_product"]?></th>
                <?php 

                #формирование массива СВОЙСТВ ТОВАРОВ строки               
                foreach($product_propertiesV as $ЗНАЧЕНИЕ_СВОЙСТВА): ?><th><?=$ЗНАЧЕНИЕ_СВОЙСТВА?></th><?php endforeach;?>
            </tr>
        <?php /* 
            if($row["id"] > $pop) {
                $pop = $row["id"];
            }  */          
        endforeach;?>
    </table>

    <!-- переключатель страниц (поискать на GB его реализацию) количество страниц берётся из index.php  -->

    <!-- 
    <div class="basket"> 
        <a href="index.php">Каталог</a><br>
        <?php /*$total_basket = 0;  $total_price = 0;
            foreach($position_catalogue as $row) {
            
            $total_basket += $row["amount_product"];
            $total_price += $row["price"] * $row["amount_product"];
            } */  ?>
        <span>Всего в корзине: </span><span id="in_total_basket"><?=$total_basket?></span><br>
        <span>Общая стоимость: </span><span id="in_total_price"><?=$total_price?></span> 
        <input type="button" onclick="clean_user_basket(); 
            CLIENT_clean_user_basket(<?=$pop?>, 'tr_');" value="Очистить корзину">
        <input type="button" onclick="sending_emeil();" value="Заказать">       
    <div>

     -->
</body>
<script src="./pages/js/engine.js"></script>
</html>