<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test;user=brian;password=1234');


    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function test_get_name()
        {
            //Arrange
            $name = "KMart";
            $test_store = new Store($name);
            //Act
            $result = $test_store->getName();
            //Assert
            $this->assertEquals($name, $result);
        }
        function test_get_Id()
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

        function test_set_name()
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

        function test_set_id()
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

        function test_save()
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

        function test_get_all()
        {
            $name = "KMart";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            $name2 = "Walgreens";
            $id2 = 2;
            $test_store2 = new Store($name2, $id2);
            $test_store2->save();


            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function test_delete_all()
        {
            $name = "KMart";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            $name2 = "Walgreens";
            $id2 = 2;
            $test_store2 = new Store($name2, $id2);
            $test_store2->save();


            //Act
            Store::deleteAll();

            //Assert
            $result = Store::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            $name = "KMart";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            $name2 = "Walgreens";
            $id2 = 2;
            $test_store2 = new Store($name2, $id2);
            $test_store2->save();

            $result = Store::find($test_store2->getId());

            $this->assertEquals($test_store2, $result);
        }

        function test_update()
        {
            $name = "KMart";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            $new_name = "The Big K";

            $test_store->update($new_name);

            $result = $test_store->getName();
            $this->assertEquals($new_name, $result);

        }

        function test_delete()
        {
            $name = "KMart";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            $name2 = "Walgreens";
            $id2 = 2;
            $test_store2 = new Store($name2, $id2);
            $test_store2->save();

            $test_store->delete();

            $result = Store::getAll();
            $this->assertEquals([$test_store2], $result);
        }

        function test_addBrand()
        {
            $name = "KMart";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            $style = "Nike";
            $id = 77;
            $test_brand = new Brand($style, $id);
            $test_brand->save();

            $style2 = "Adidas";
            $id2 = 97;
            $test_brand2 = new Brand($style2, $id2);
            $test_brand2->save();

            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);

            $result = $test_store->getBrands();
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function test_getBrands()
        {
            $name = "KMart";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            $style = "Nike";
            $id2 = 77;
            $test_brand = new Brand($style, $id2);
            $test_brand->save();

            $style2 = "Adidas";
            $id3 = 33;
            $test_brand2 = new Brand($style2, $id3);
            $test_brand2->save();

            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);

            $result = $test_store->getBrands();
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

    }//closes class
?>
