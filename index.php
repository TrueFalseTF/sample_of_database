<?php	
    require_once("function.php");
    require_once("database.php");

    $link = db_connect();   

    
    $product = position_generator($link, "product", false);
    $product_properties = position_generator($link, "product_properties", false);
    $product_propertiesV = position_generator($link, "product_properties_value", false);
    $product_propertiesV_originalit = position_generator($link, "product_properties_value", true, "value", "id_properties");
    

    $length_product_properties = count($product_properties);
    $length_product = count($product);

    $row_page = 3;
    
    $pages_amount = $length_product / $row_page;
    /*
    $position_basket = position_generator($link, "users_basket");    
   
    if(isset($_GET["clean_basket"])){
        header(200);
        clean_user_basket($link);
    }

    if(isset($_GET["sending_emeil"])){
        header(200);
        $string_position_basket = serialize($position_basket);

        include("mailer/smart.php"); 
        //mail("dimon_mcensk@mail.ru", "Форма заказа из магазина",  $string_position_basket, "From:dimon_mcensk@mail.ru");
        order_sorting($link);
    }
    

    if(isset($_GET["open_basket"])) {

        include("pages/shopping_basket.php");                
    } else {        
        if(isset($_GET["changing_user_basket"])){
            header(200);
            changing_position_basket($link, $_GET["id"], $_GET["sign"]);
        };
        include("pages/catalogue.php");
    } 
    */ 

    # по гету передаются свойства фильтра 
    # функционально формируется массив составляющий его    
    $sorted_products = $product;
    if(isset($_GET["_"])){
        $Res_product = res_sorted($product, $product_propertiesV, $_GET);        
             
        include("pages/sample_page.php");
    };   
    include("pages/sample_page.php");
?>