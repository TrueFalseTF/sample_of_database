<?php
    function position_generator($link, $table, $originality = false, ...$arr_column) {

        if($originality === true) {
            $columns = NULL;
            
            foreach ($arr_column as $column){
                if (!isset($columns)) {
                    $columns = "`".$column."`";
                };
                $columns = $columns.", `".$column."`"; 
            };                
            $query = "SELECT DISTINCT ".$columns." FROM ".$table;
        } else if($originality == false){
            $query = "SELECT * FROM ".$table;
        }        
        $result = mysqli_query($link, $query);

        if (!$result)
            die(mysqli_error($link));

        $n = mysqli_num_rows($result);
        $position =  array();

        for ($i = 0; $i < $n; $i++)
        {
            $row = mysqli_fetch_assoc($result);
            $position[] = $row;
        }

        return $position;
    }

    function join_properties($link) {

        $result_del = mysqli_query($link, 
            "DELETE FROM `product_properties_value`");    
        if (!$result_del)
            die(mysqli_error($link));

        $result_join = mysqli_query($link, 
            "INSERT INTO `product_properties_value` (`id_product`,`id_properties`)
            SELECT `product`.`id`, `product_properties`.`id` 
            FROM `product`
            JOIN `product_properties`          
            ");    
        if (!$result_join)
            die(mysqli_error($link));
    }

    function changing_position_basket($link, $changing_position_id, $changing_position_sign) {

        if($changing_position_sign === "add") {
            
            $result_add = mysqli_query($link, 
                "SELECT * FROM product_catalog WHERE id=".$changing_position_id);    
            if (!$result_add)
                die(mysqli_error($link));

            $result_added = mysqli_query($link, 
                "SELECT * FROM users_basket WHERE id=".$changing_position_id);    
            if (!$result_added)
                die(mysqli_error($link));              
                
            
            $row_catalog = mysqli_fetch_assoc($result_add);
            $row_basket = mysqli_fetch_assoc($result_added); 
                
            if (NULL !== $row_basket) {
                $result_added = mysqli_query($link, 
                    "DELETE FROM users_basket WHERE id=".$changing_position_id);    
                if (!$result_added)
                    die(mysqli_error($link));              
            }


            $row_id = '"'.$row_catalog['id'].'"';
            $row_product = '"'.$row_catalog['product'].'"';
            $row_price = '"'.$row_catalog['price'].'"';
            $row_amount_product = 1;
            if(isset($row_basket['amount_product'])){
                $row_amount_product = $row_basket['amount_product'] + 1;
            }
                              
    
            $query = "INSERT INTO `users_basket` (`id`, `product`, `price`, `amount_product`) VALUES ("
            .$row_id.", "
            .$row_product.", "
            .$row_price.", "
            .$row_amount_product.")" 
            ;
            $result = mysqli_query($link, $query);
            if (!$result)
                die(mysqli_error($link));

            $result_added = mysqli_query($link, 
                "DELETE FROM product_catalog WHERE id=".$changing_position_id);    
            if (!$result_added)
                die(mysqli_error($link));  

            $query = "INSERT INTO `product_catalog` (`id`, `product`, `price`, `amount_product`) VALUES ("
            .$row_id.", "
            .$row_product.", "
            .$row_price.", "
            .$row_amount_product.")" 
            ;
            $result = mysqli_query($link, $query);
            if (!$result)
                die(mysqli_error($link));           

        } else if($changing_position_sign === "subtract") {
            
            $result_subtract = mysqli_query($link, 
                "SELECT * FROM product_catalog WHERE id=".$changing_position_id);    
            if (!$result_subtract)
                die(mysqli_error($link));

            $result_added = mysqli_query($link, 
                "SELECT * FROM users_basket WHERE id=".$changing_position_id);    
            if (!$result_added)
                die(mysqli_error($link));              
                
            
            $row_catalog = mysqli_fetch_assoc($result_subtract);
            $row_basket = mysqli_fetch_assoc($result_added); 
                
            if (NULL !== $row_basket) {
                $result_added = mysqli_query($link, 
                    "DELETE FROM users_basket WHERE id=".$changing_position_id);    
                if (!$result_added)
                    die(mysqli_error($link));



                $row_id = '"'.$row_catalog['id'].'"';
                $row_product = '"'.$row_catalog['product'].'"';
                $row_price = '"'.$row_catalog['price'].'"';
                $row_amount_product = $row_basket['amount_product'] - 1;
                if($row_amount_product > 0){
                    $query = "INSERT INTO `users_basket` (`id`, `product`, `price`, `amount_product`) VALUES ("
                    .$row_id.", "
                    .$row_product.", "
                    .$row_price.", "
                    .$row_amount_product.")" 
                    ;
                    
                    $result = mysqli_query($link, $query);

                    if (!$result)
                        die(mysqli_error($link));
                }
                if($row_amount_product >= 0){

                    $result_added = mysqli_query($link, 
                        "DELETE FROM product_catalog WHERE id=".$changing_position_id);    
                    if (!$result_added)
                        die(mysqli_error($link));

                    $query = "INSERT INTO `product_catalog` (`id`, `product`, `price`, `amount_product`) VALUES ("
                    .$row_id.", "
                    .$row_product.", "
                    .$row_price.", "
                    .$row_amount_product.")" 
                    ;
                        
                    $result = mysqli_query($link, $query);
    
                    if (!$result)
                        die(mysqli_error($link));
                }

            }
        }        
        
    };

    function clean_user_basket($link) {
        $result_clean_basket = mysqli_query($link, 
            "DELETE FROM users_basket");    
        if (!$result_clean_basket)
            die(mysqli_error($link));

        $old_position_product_catalog = position_generator($link, "product_catalog");

        $result_clean_catalog = mysqli_query($link, 
            "DELETE FROM product_catalog");    
        if (!$result_clean_catalog)
            die(mysqli_error($link));
            
        foreach($old_position_product_catalog as $row) {

            $row_id = '"'.$row['id'].'"';
            $row_product = '"'.$row['product'].'"';
            $row_price = '"'.$row['price'].'"';
            $row_amount_product = "0";

            $result_update_catalog = mysqli_query($link, 
                "INSERT INTO `product_catalog` (`id`, `product`, `price`, `amount_product`) VALUES ("
                .$row_id.", "
                .$row_product.", "
                .$row_price.", "
                .$row_amount_product.")");    
            if (!$result_update_catalog)
                die(mysqli_error($link));

        }
    };

    function order_sorting($link) {

        $relevant_position_order_basket = position_generator($link, 'users_basket');       

        $result_order_d = mysqli_query($link, 
            "DELETE FROM order_basket");    
        if (!$result_order_d)
            die(mysqli_error($link));


        foreach($relevant_position_order_basket as $row) {

            $row_id = '"'.$row['id'].'"';
            $row_product = '"'.$row['product'].'"';
            $row_price = '"'.$row['price'].'"';
            $row_amount_product = '"'.$row['amount_product'].'"';

            $result_update_catalog = mysqli_query($link, 
                "INSERT INTO `order_basket` (`id`, `product`, `price`, `amount_product`) VALUES ("
                .$row_id.", "
                .$row_product.", "
                .$row_price.", "
                .$row_amount_product.")");    
            if (!$result_update_catalog)
                die(mysqli_error($link));
        }

        $result_update_catalog = mysqli_query($link, 
            "UPDATE product_catalog SET amount_product = 0 WHERE amount_product > 0");    
        if (!$result_update_catalog)
            die(mysqli_error($link));
    };

    function res_sorted($arr_products, $arr_product_properties, $arr_product_propertiesV, $arr_POST) {

        #исключает из анализа нефильтруемые значения        
        $arr_length = count($arr_POST);
        for ($i = 1; $i <= $arr_length; $i++){
            $postString = substr($arr_POST[$i], 0, 21);
            if("Не выбрано |" == $postString) {
                unset($arr_POST[$i]);
            }
        }

        $Res_products;

        foreach ($arr_product_propertiesV as $propertieV) { #Перичесление значений свойств
            foreach ($arr_product_properties as $product_properties) { #перечисление наименований свойств
                if ($product_properties["id"] == $propertieV["id_properties"]) { #сравнение наименования и значения
                
                    if (isset($arr_POST[$product_properties["id"]]) &&
                        $arr_POST[$product_properties["id"]] != $propertieV["value"]) { #сравнение значения фильтра и значения свойства
                        
                        
                        foreach ($arr_products as $key => $product) { #удаление при несовпадении
                            if($propertieV["id_product"] == $product["id"]) {
                                unset($arr_products[$key]);
                            }
                        }                        
                    }
                }
            } 
        }        

        return $arr_products;
    };
?>