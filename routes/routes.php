<?php
Flight::set('flight.views.path', 'app/');

Flight::route('/', function(){
    Flight::render('Views/homepage.php');
});
Flight::route('/menu', function(){
    Flight::render('Views/menu.php');
});
Flight::route('/update-menu/@id', function($id){
    Flight::render('Views/update-menu.php', array('id' => $id));
});
Flight::route('/add-menu', function(){
    Flight::render('Views/add-menu.php');
});
Flight::route('/add-category', function(){
    Flight::render('Views/add-category.php');
});
Flight::route('/orders', function(){
    Flight::render('Views/orders.php');
});
Flight::route('/cart', function(){
    Flight::render('Views/shopping-cart.php');
});
Flight::route('/my_orders', function(){
    Flight::render('Views/my-orders.php');
});
Flight::route('/order-details/@id', function($id){
    Flight::render('Views/order-items.php', array('id' => $id));
});
Flight::route('/accounts', function(){
    Flight::render('Views/accounts.php');
});
Flight::route('/profile', function(){
    Flight::render('Views/profile.php');
});
Flight::route('/logout', function(){
    Flight::render('Views/system_logout.php');
});
// Route for handling 403 Forbidden error
Flight::map('error403', function(){
    Flight::render('Views/error/403.php');
});
// Route for handling 404 Not Found error
Flight::map('notFound', function(){
    Flight::render('Views/error/404.php');
});
// Route for handling 405 Method Not Allowed error
Flight::map('methodNotAllowed', function(){
    Flight::render('Views/error/405.php');
});