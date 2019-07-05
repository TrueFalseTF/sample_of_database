<?php
    define('MYSQL_SERVER','localhost');
    define('MYSQL_USER', 'root');
    define('MYSQL_PASSWORD', '');
    define('MYSQL_DB', 'sample_of_database');

    function db_connect() {
        $link = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB)
            # DB должна быть уже создана
            or die("Error: ".mysqli_error($link));
        if(!mysqli_set_charset($link, "utf8")){
            print("Error: ".mysqli_error($link));
        }

        # NOT EXISTS

        # Можно запилить функцию, но зачеееем...

        $result_create_product = mysqli_query($link, 
            "CREATE TABLE IF NOT EXISTS `sample_of_database`.`product` ( 
                `id` INT NULL AUTO_INCREMENT ,
                `Name` VARCHAR(42) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                `Category` VARCHAR(42) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
                `Price` INT NOT NULL , 
                PRIMARY KEY (`id`))");    
        if (!$result_create_product)
            die(mysqli_error($link));

        $result_create_prorerties = mysqli_query($link, 
            "CREATE TABLE IF NOT EXISTS `sample_of_database`.`product_properties` ( 
                `id` INT NULL AUTO_INCREMENT , 
                `Name_properties` VARCHAR(42) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
                PRIMARY KEY (`id`))");    
            if (!$result_create_prorerties)
                die(mysqli_error($link));

        $result_create_prorertiesV = mysqli_query($link, 
            "CREATE TABLE IF NOT EXISTS `sample_of_database`.`product_properties_value` ( 
                `id` INT NULL AUTO_INCREMENT , 
                `id_product` INT NOT NULL , 
                `id_properties` INT NOT NULL , 
                `value` VARCHAR(42) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
                PRIMARY KEY (`id`))");    
            if (!$result_create_prorertiesV)
                die(mysqli_error($link));

        return $link;
    }
?>