<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";
    $app = new Silex\Application();

    $app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=shoes;');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

//HOMEPAGE ROUTES

    //user to the home page
    $app->get("/", function() use ($app) {
        return $app['twig']->render('home.html.twig');
    });

//ALL STORES ROUTES

    //READ ALLS STORES
    $app->get('/stores', function() use ($app){
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    //CREATE STORE
    $app->post("/stores", function() use ($app){
        $name = $_POST['name'];
        $new_store = new Store($name);
        $new_store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    //DELETE ALL STORES
    $app->post("/delete_stores", function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

//SINGLE STORE ROUTES

    //READ, single
    //user to the named store page
    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);

        return $app['twig']->render('name.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'store_brands' => Brand::getAll()));
    });

    //ADD BRAND
    //add brand to the store:
    $app->post('/stores/{id}', function($id) use ($app){
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($id);
        $store->addBrand($brand);
        return $app['twig']->render('name.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'store_brands' => Brand::getAll()));
    });

    //UPDATE, name
    //edit store name
    $app->patch('/stores/{id}', function($id) use ($app){
        $new_name = $_POST['new_name'];
        $store = Store::find($id);
        $store->update($new_name);//Not working
        return $app['twig']->render('name.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'store_brands' => Brand::getAll()));
    });

    //DELETE STORE, single
    //delete store on store's page and return user to the stores page
    $app->delete("/stores", function() use ($app) {
        $id = $_POST['store_id'];
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

//ALL BRAND ROUTES

    //READ ALL
    $app->get('/brands', function() use ($app){
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    //CREATE Brand
    $app->post('/brands', function () use ($app){
        $new_brand = new Brand($_POST['style']);
        $new_brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'every_store' => Store::getAll()));
    });

    //DELETE ALL Brands
    $app->delete("/brands", function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

//SINGLE BRAND ROUTES
    //READ
    $app->get("/brands/{id}", function($id) use ($app){
        $brand = Brand::find($id);
        return $app['twig']->render('style.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'every_store' => Store::getAll()));
    });

    $app->post("/brands/{id}", function($id) use ($app){
        $store = Store::find($_POST['store_id']);
        $brand = Brand::find($id);
        $brand->addStore($store);
        return $app['twig']->render('style.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'every_store' => Store::getAll()));
    });

    //READ on edit page
    //user to edit page (a single brand) by id:
    $app->patch("/brands/{id}", function($id) use ($app){
        $brand = Brand::find($id);
        $brand->update($_POST['new_style']);
        return $app['twig']->render('style.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'every_store' => Store::getAll()));
    });

    $app->delete("/brand/delete", function() use ($app){
        $brand_id = $_POST['brand_id'];
        $brand = Brand::find($brand_id);
        $brand->delete();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    return $app
?>
