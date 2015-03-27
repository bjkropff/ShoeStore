<?php

    /**
    * @backupGlobals disabled
    * $backupStaticAttribute disabled
    */

    //require_once __DIR__."/../src/Brands.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');

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



    }//closes class
?>
