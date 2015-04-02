<?php

    /**
    * @backupGlobals disabled
    * $backupStaticAttribute disabled
    */

    require_once __DIR__."/../src/Store.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes;user=brian;password=1234');

    class Store
    {
        private $name;
        private $id;
        function __construct($new_name, $new_id = null)
        {
            $this->name = $new_name;
            $this->id = $new_id;
        }

        //Setters
        function setName($new_name)
        {
            $this->name = (string)$new_name;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        //Getters
        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO stores (name) VALUES ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = array();
            foreach($returned_stores as $store){
                $name = $store['name'];
                $id = $store['id'];
                $new_store = new Store($name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores *;");
        }

        static function find($search_id)
        {
            $found_store = null;
            $all_stores = Store::getAll();
            foreach($all_stores as $store){
                $store_id = $store->getId();
                if($store_id == $search_id){
                    $found_store = $store;
                }
            }
            return $found_store;
        }

        function update($new_info)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET name '{$new_info}' WHERE id = {$this->getId()};");
            $this->setName($new_info);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
            //$GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE store_id = {$this->getId()};");
        }

        function addBrand($brand)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$brand->getId()}, {$this->getId()});");
        }

        function getBrands()
        {
            $statement = $GLOBALS['DB']->query("SELECT brands.* FROM stores
                JOIN brands_stores ON (stores.id = brands_stores.store_id)
                JOIN brands ON (brands.id = brands_stores.brand_id)
                WHERE stores.id = {$this->getId()};");

            $all_brands = $statement->fetchAll(PDO::FETCH_ASSOC);

            $brands = array();
            foreach($all_brands as $brand){
                $style = $brand['style'];
                $id = $brand['id'];
                $new_brand = new Brand($style, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        function deleteBrand($brand)
        {
            $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE (brands_id, stores_id) = ({$brand->getId()}, {$this->getId()});");
        }



    }//closes class
?>
