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
