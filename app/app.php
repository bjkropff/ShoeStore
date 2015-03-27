<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";
    $app = new Silex\Application();
    //$app['debug'] = true;
    $DB = new PDO('pgsql:host=localhost;dbname=shoes');
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('home.html.twig');
    });

    $app->get('/stores', function() use ($app){
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    $app->post("/stores", function() use ($app){
        $name = $_POST['name'];
        $new_store = new Store($name);
        $new_store->save();

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    $app->get("/stores/{id}/edit", function($id) use ($app){
        $store = Store::find($id);
        return $app['twig']->render('edit.html.twig', array('store' =>$store)); //,'brands' =>$store->getBrands()));
    });

    $app->patch('/stores/{id}/edit', function($id) use ($app){
        $update_store = $_POST['new_store'];
        $new_store = Store::find($id);
        $new_store->update($update_store);

        return $app['twig']->render('edit.html.twig', array('store' => $new_store));
    });
    $app->delete("/stores/{id}/delete", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    $app->delete("/delete_all_stores", function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
        });



    $app->get('/brands', function() use ($app){
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    $app->post('/brands', function () use ($app){
        $style = $_POST['style'];
        $new_brand = new Brand($style);
        $new_brand->save();

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    $app->get("/brands/{id}/style", function($id) use ($app){
        $brand = Brand::find($id);
        return $app['twig']->render('style.html.twig', array('brand' =>$brand));
    });

    $app->delete("/delete_all_brands", function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('brands.html.twig', array('brands' => Store::getAll()));
    });


    return $app
?>
