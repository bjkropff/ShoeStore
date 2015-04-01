<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";
    $app = new Silex\Application();

    //$app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=shoes;user=brian;password=1234');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //user to the home page
    $app->get("/", function() use ($app) {
        return $app['twig']->render('home.html.twig');
    });

    //user to the stores page: READ ALL
    $app->get('/stores', function() use ($app){
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    //add from the stores page to the list of stores: CREATE
    $app->post("/stores", function() use ($app){
        $name = $_POST['name'];
        $new_store = new Store($name);
        $new_store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });


    //user to edit page (a single store) by id READ
    //NEED: a READ ALL for brands
    $app->get("/stores/{id}/edit", function($id) use ($app){
        $store = Store::find($id);
        return $app['twig']->render('name_edit.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'store_brands' => Brand::getAll()));
    });

    //edit store name: UPDATE
    $app->patch('/stores/{id}/edit', function($id) use ($app){
        $new_name = $_POST['new_name'];
        $store = Store::find($id);
        $store->update($new_name);
        return $app['twig']->render('name_edit.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'store_brands' => Brand::getAll()));
    });

    //delete store on store's page and return user to the stores page: DELETE
    $app->delete("/stores/{id}/delete", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    //delete all of the stores from the stores page
    //user to the stores page: DELETE ALL
    $app->delete("/delete_all_stores", function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
        });

    $app->post("/stores/addto", function() use ($app) {
        $store = Store::find($_POST['store_id']);
        $brand = Brand::find($_POST['brand_id']);

        $store->addBrand($brand);
        return$app['twig']->render('store.html.twig', array('store' => $store, 'brands'=> $store->getBrands(), 'store_brands' => Brand::getAll()))
    });

    //delete a brand from a store
    $app->delete("/stores/deletefrom", function($id) use ($app) {
        $store = Store::find($_POST['store_id']);
        $brand = Brand::find($_POST['brand_id']);
        $store->delete();
        return $app['twig']->render('stores.html.twig', array('stores' => $store, 'brand' => $store->getBrand(), 'store_brands' => Brand::getAll()));
    });

    //BRANDS
    //user to brands page: READ ALL
    $app->get('/brands', function() use ($app){
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    //add from brands page to the list of brands: CREATE
    $app->post('/brands', function () use ($app){
        $style = $_POST['style'];
        $new_brand = new Brand($style);
        $new_brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'every_store' => Store::getAll()));
    });

    //user to the styles page: READ
    //NEED : a READ ALL for stores
    $app->get("/brands/{id}/style", function($id) use ($app){
        $brand = Brand::find($id);
        return $app['twig']->render('style.html.twig', array('brand' => $brand), 'stores' => $brand->getStores(), 'every_store' => Store::getAll());
    });

    //edit brand name: UPDATE
    $app->patch('/brands/{id}/edit', function($id) use ($app) {
        $new_style = $_POST['new_style'];
        $brand = Brand::find($id);
        $brand->update($new_style);
        return $app['twig']->render('style.html.twig', array('brand' => $brand), 'stores' => $brand->getStores(), 'every_store' => Store::getAll());
    });

    //delete all of the brands: DELETE ALL
    //user to the brands page (now empty)
    $app->delete("/delete_all_brands", function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('brands.html.twig', array('brands' => Store::getAll()));
    });


    return $app
?>
