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
        
        <tr>
            <?php $colsAmount = spanValue($length_product_properties);
                function spanValue($length_product_properties) {
                    return (string)$span = 4 + $length_product_properties; }; ?>
            <th colspan=<?=$colsAmount?>>            
                <form action="./index.php" method="get">        

                    <!--  #цикл из свойств и значений -->
                    <p><input type="submit" value="Отфильтровать">
                        <?php foreach($product_properties as $properties): ?>                         
                            <select size="1" name="hero[]">
                                <option >Выберите <?=$properties["name_properties"]?></option>
                                <?php foreach($product_propertiesV_originalit  as $propertiesV_originalit): ?>                                    
                                    <?php if ($properties["id"] === $propertiesV_originalit["id_properties"]) :?>
                                        <?php if ( is_null($propertiesV_originalit["value"]) ) continue; ?>
                                        <option value="<?=(string)$propertiesV_originalit["id_properties"]?>"><?=$propertiesV_originalit["value"]?></option>
                                    <?php endif; ?>
                                <?php endforeach;?>
                            </select>
                        <?php endforeach;?>
                    </p>
                </form>
            </th>           
        </tr>
        
        
        
        <tr>
            <th>№</th><th>Продукт</th><th>Категория</th><th>Цена</th>
            <?php foreach($product_properties as $cols): ?><th><?=$cols["name_properties"]?></th><?php endforeach;?>
        </tr>
        

        <!-- цикл ограничен допустимым количеством строк на странице -->
        <?php $pop = 0; foreach($sorted_products as $row): ?>
            <tr id="tr_<?=$row["id"]?>">
                <th><?=$row["id"]?></th>

                <th><?=$row["name"]?></th>

                <th><?=$row["category"]?></th>                

                <th><?=$row["price"]?></th>

                <?php foreach($product_properties as $properties): ?>
                    <?php foreach($product_propertiesV as $propertiesV): ?>
                        <?php if ($row["id"] == $propertiesV["id_product"] && $properties["id"] == $propertiesV["id_properties"]): ?>
                            <th><?=$propertiesV["value"]?></th>
                        <?php endif; ?>                        
                    <?php endforeach;?>
                <?php endforeach;?>
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