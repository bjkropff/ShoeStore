<?php

    /**
    * @backupGlobals disabled
    * $backupStaticAttribute disabled
    */

    require_once __DIR__."/../src/Store.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test;user=brian;password=1234');

    class Brand
    {
        private $style;
        private $id;
        function __construct($new_style, $new_id = null)
        {
            $this->style = $new_style;
            $this->id = $new_id;
        }

        //Setters
        function setStyle($new_style)
        {
            $this->style = (string) $new_style;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        //Getters
        function getStyle()
        {
            return $this->style;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO brands (style) VALUES ('{$this->getStyle()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_brand = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = array();
            foreach($returned_brand as $brand){
                $style = $brand['style'];
                $id = $brand['id'];
                $new_brand = new Brand($style, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands *;");
        }

        static function find($search_id)
        {
            $found_brand = null;
            $all_brands = Brand::getAll();
            foreach($all_brands as $brand){
                $brand_id = $brand->getId();
                if($brand_id == $search_id){
                    $found_brand = $brand;
                }
            }
            return $found_brand;
        }

        function update($new_info)
        {
            $GLOBALS['DB']->exec("UPDATE brands SET style '{$new_info}' WHERE id = {$this->getId()};");
            $this->setStyle($new_info);
        }



    }//closes class
?>
