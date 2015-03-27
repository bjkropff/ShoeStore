<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //require_once "src/Brand.php";
    require_once "src/Store.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');


    class StoreTest extends PHPUnit_Framework_TestCase
    {

        function testGetLoctation()
        {
            //Arrange
            $name = "KMart";
            $test_store = new Store($name);
            //Act
            $result = $test_store->getName();
            //Assert
            $this->assertEquals($name, $result);
        }
        function testGetId()
        {
            //Arrange
            $name = "KMart";
            $id = 1;
            $test_store = new Store($name, $id);
            //Act
            $result = $test_store->getId();
            //Assert
            $this->assertEquals($id, $result);
        }

    }//closes class
?>
