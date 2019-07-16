<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">    
    <title>Магазин</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./pages/css/styles.css">    
</head>
<body>
    <a href="./index.php"><h4 class="h4">Главная</h4></a>  
    <table class="table product_table">
        <caption>Выборка товаров по свойствам</caption>
        
        <tr>
            <?php $colsAmount = spanValue($length_product_properties);
                function spanValue($length_product_properties) {
                    return (string)$span = 4 + $length_product_properties; }; ?>
            <th colspan=<?=$colsAmount?>>            
                <form action="./index.php?sorted" enctype="multipart/form-data" method="post">        

                    <!--  #цикл из свойств и значений -->
                    <p><input type="submit" value="Отфильтровать">
                        <?php foreach($product_properties as $properties): ?>                                                                          
                            <select size="1" name=<?=$properties["id"]?>>
                                <option>Выберите <?=$properties["name_properties"]?></option>
                                <?php foreach($product_propertiesV_originalit  as $propertiesV_originalit): ?>                                    
                                    <?php if ($properties["id"] === $propertiesV_originalit["id_properties"]) :?>
                                        <?php if ( is_null($propertiesV_originalit["value"]) ) continue; ?>
                                        <option value=<?=$propertiesV_originalit["value"]?>><?=$propertiesV_originalit["value"]?></option>
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
        <?php $pop = 0; foreach($Res_product as $row): ?>
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


</body>
<script src="./pages/js/engine.js"></script>
</html>