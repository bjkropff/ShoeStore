<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";
    $app = new Silex\Application();

    $app['debug'] = true;

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

    //user to the stores page: READ store ALL
    $app->get('/stores', function() use ($app){
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    //user to the stores page: DELETE ALL stores
    $app->delete("/delete_all_stores", function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    //add from the stores page to the list of stores: CREATE store
    $app->post("/stores", function() use ($app){
        $name = $_POST['name'];
        $new_store = new Store($name);
        $new_store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    //user to the named store page: READ store, single
    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('name.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'store_brands' => Brand:: getAll()));
    });

    //user to edit page (a single store) by id: READ
    $app->get("/stores/{id}/edit", function($id) use ($app){
        $store = Store::find($id);
        return $app['twig']->render('name_edit.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'store_brands' => Brand::getAll()));
    });

    //edit store name: UPDATE
    $app->patch('/stores/{id}', function($id) use ($app){
        $new_name = $_POST['new_name'];
        $store = Store::find($id);
        $store->update($new_name);//Not working
        return $app['twig']->render('name.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'store_brands' => Brand::getAll()));
    });

    //delete store on store's page and return user to the stores page: DELETE store, single
    $app->delete("/stores/{id}/delete", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });


    //user to brands page: READ ALL
    $app->get('/brands', function() use ($app){
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    //add from brands page to the list of brands: CREATE
    $app->post('/brands', function () use ($app){
        $new_brand = new Brand($_POST['style']);
        $new_brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'every_store' => Store::getAll()));
    });

    //user to the brands page: DELETE ALL
    $app->delete("/delete_all_brands", function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('brands.html.twig', array('brands' => Store::getAll()));
    });

    //user to the styles page: READ
    $app->get("/brands/{id}", function($id) use ($app){
        $brand = Brand::find($id);
        return $app['twig']->render('style.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'every_store' => Store::getAll()));
    });

    //user to edit page (a single brand) by id: READ
    $app->get("/brands/{id}/edit", function($id) use ($app){
        $brand = Brand::find($id);
        return $app['twig']->render('style_edit.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'every_store' => Store::getAll()));
    });

    return $app
?>
