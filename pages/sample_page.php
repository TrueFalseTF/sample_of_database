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
    <form action="./index.php?sorted" method="post"> 
        <table class="table product_table">    
            <caption>Выборка товаров по свойствам</caption>        
            <tr>
                <?php $colsAmount = spanValue($length_product_properties);
                    function spanValue($length_product_properties) {
                        return (string)$span = 4 + $length_product_properties; }; ?>            
                <td colspan=<?=$colsAmount?>>               
                    <!--  #цикл из свойств и значений -->
                    <?php foreach($product_properties as $properties): ?>                                                                          
                        <select name=<?=$properties["id"]?>>
                            <?php if(isset($determined_selected)) { if(isset($determined_selected[$properties["id"]])) {$determined_value = $determined_selected[$properties["id"]];}} ?>
                            <option >Не выбрано | <?=$properties["name_properties"]?></option>

                            <?php foreach($product_propertiesV_originalit  as $propertiesV_originalit): ?>                                    
                                <?php if ($properties["id"] === $propertiesV_originalit["id_properties"]) :?>
                                    <?php if ( is_null($propertiesV_originalit["value"]) ) continue; ?>
                                    <option <?php if(isset($determined_value)) { if($determined_value == $propertiesV_originalit["value"]){ echo("selected");  };};?> value=<?=$propertiesV_originalit["value"]?>>
                                        <?=$propertiesV_originalit["value"]?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach;?>

                        </select>                            
                    <?php endforeach;?>
                    <input type="submit" value="Отфильтровать">
                </td>                               
            </tr>       
            
            
            <tr>
                <th>№</th><th>Продукт</th><th>Категория</th><th>Цена</th>
                <?php foreach($product_properties as $cols): ?><th><?=$cols["name_properties"]?></th><?php endforeach;?>
            </tr>

            
            <?php foreach($Res_product as $row): ?>
                <tr id="tr_<?=$row["id"]?>">
                    <td><?=$row["id"]?></td>

                    <td><?=$row["name"]?></td>

                    <td><?=$row["category"]?></td>                

                    <td><?=$row["price"]?></td>

                    <?php foreach($product_properties as $properties): ?>
                        <?php foreach($product_propertiesV as $propertiesV): ?>
                            <?php if ($row["id"] == $propertiesV["id_product"] && $properties["id"] == $propertiesV["id_properties"]): ?>
                                <td><?=$propertiesV["value"]?></td>
                            <?php endif; ?>                        
                        <?php endforeach;?>
                    <?php endforeach;?>
                </tr>
            <?php endforeach;?>
        </table>
    <!-- переключатель страниц, № страницы по POST -->
    
        <ul>
            <li><input type="submit" name="page" value="1"></li>
            <li>. . .</li>
            <?php if ($Pages_amount > 2): ?>
                <?php for ($i = 2;$i < $Pages_amount;$i++ ): ?>                    
                    <li><input type="submit" name="page" value=<?='"'.$i.'"'?>></li>                  
                <?php endfor; ?>
            <?php endif;?>
            <li>. . .</li>
            <?php if ($Pages_amount > 1): ?>
                <li><input type="submit" name="page" value=<?='"'.$Pages_amount.'"'?>></li>
            <?php endif;?>
        </ul>    
    </form>
</body>
<script src="./pages/js/engine.js"></script>
</html>