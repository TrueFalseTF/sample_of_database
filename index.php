<?php	
    require_once("function.php");
    require_once("database.php");

    $link = db_connect();   

    
    $product = position_generator($link, "product", false);
    $product_properties = position_generator($link, "product_properties", false);
    $product_propertiesV = position_generator($link, "product_properties_value", false);
    $product_propertiesV_originalit = position_generator($link, "product_properties_value", true, "value", "id_properties");

    $nuber_Page = 1;
    # по посту передаются свойства фильтра 
    # функционально формируется массив составляющий ответ   
    $sorted_product = $product;
    if(isset($_GET["sorted"])) {
        $_POST = exclusion_of_unsorted($_POST);

        foreach ($_POST as $key => $value)
            $determined_selected[$key] = $value;
        
        $sorted_product = res_sorted($product, $product_properties, $product_propertiesV, $_POST);

        if(isset($_POST["page"])) 
            $nuber_Page = $_POST["page"];
    };  


    #количество pages
    $length_product_properties = count($product_properties);
    $length_product = count($sorted_product);

    $row_Page = 3;    
    
    $Pages_amount = $length_product / $row_Page;
    if(($length_product % $row_Page) != 0 )        
        $Pages_amount = ceil($Pages_amount);

    #сокращение по $nuber_Page 
    $length_dell = $row_Page*($nuber_Page - 1);
    
    $Res_product = array_splice($sorted_product, 0, $length_dell); 
    $Res_product = array_splice($sorted_product, 0, $row_Page);

    include("pages/sample_page.php");
?>