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
        protected function tearDown()
        {
            Store::deleteAll();
            //Brand::deleteAll();
        }

        function testGetName()
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
            $this->assertEquals(true, is_numeric($result));
        }

        function testSetName()
        {
            //Arrange
            $name = "KMart";
            $id = 1;
            $test_store = new Store($name, $id);
            //Act
            $test_store->setName("Target");
            //Assert
            $result = $test_store->getName();
            $this->assertEquals("Target", $result);
        }

        function testSetId()
        {
            //Arrange
            $name = "KMart";
            $id = 1;
            $test_store = new Store($name, $id);
            //Act
            $test_store->setId(1234);

            //Assert
            $result = $test_store->getId();
            $this->assertEquals(1234, $result);
        }

        function testSave()
        {
            $name = "KMart";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals($test_store, $result[0]);

        }

    }//closes class
?>
