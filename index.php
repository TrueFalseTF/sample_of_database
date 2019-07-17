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


    $row_Page = 3;
    $nuber_Page = 1;
    
    $Pages_amount = $length_product / $row_Page;
    if(($length_product % $row_Page) != 0 )        
        $Pages_amount = ceil($Pages_amount);
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
    $sorted_product = $product;
    if(isset($_GET["sorted"])) {
        $determined_selected = "";
        
        $sorted_product = res_sorted($product, $product_properties, $product_propertiesV, $_POST);
    };
    if(isset($_GET["Page_sorted"])) {
        $determined_selected = "";
        
        $sorted_product = res_sorted($product, $product_properties, $product_propertiesV, $_POST);
        $nuber_Page = $_GET["Page_sorted"];         
    };

    #сокращение по $nuber_Page 
    $length_dell = $row_Page*($nuber_Page - 1);
    
    $Res_product = array_splice($sorted_product, 0, $length_dell); 
    $Res_product = array_splice($sorted_product, 0, $row_Page);

    include("pages/sample_page.php");
?>