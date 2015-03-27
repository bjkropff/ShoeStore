<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    //require_once "src/Brand.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');


    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
        }

        function testGetStyle()
        {
            //Arrange
            $style = "KMart";
            $test_brand = new Brand($style);
            //Act
            $result = $test_brand->getStyle();
            //Assert
            $this->assertEquals($style, $result);
        }
        function testGetId()
        {
            //Arrange
            $style = "KMart";
            $id = 1;
            $test_brand = new Brand($style, $id);
            //Act
            $result = $test_brand->getId();
            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function testSetStyle()
        {
            //Arrange
            $style = "KMart";
            $id = 1;
            $test_brand = new Brand($style, $id);
            //Act
            $test_brand->setStyle("Target");
            //Assert
            $result = $test_brand->getStyle();
            $this->assertEquals("Target", $result);
        }

        function testSetId()
        {
            //Arrange
            $style = "KMart";
            $id = 1;
            $test_brand = new Brand($style, $id);
            //Act
            $test_brand->setId(1234);

            //Assert
            $result = $test_brand->getId();
            $this->assertEquals(1234, $result);
        }

        function testSave()
        {
            $style = "KMart";
            $id = 1;
            $test_brand = new Brand($style, $id);
            $test_brand->save();

            //Act
            $result = Brand::getAll();

            //Assert
            $this->assertEquals($test_brand, $result[0]);

        }

    }
?>
