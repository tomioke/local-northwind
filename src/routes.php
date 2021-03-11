<?php

namespace PHPMaker2021\northwindapi;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // categories
    $app->any('/CategoriesList[/{CategoryID}]', CategoriesController::class . ':list')->add(PermissionMiddleware::class)->setName('CategoriesList-categories-list'); // list
    $app->any('/CategoriesAdd[/{CategoryID}]', CategoriesController::class . ':add')->add(PermissionMiddleware::class)->setName('CategoriesAdd-categories-add'); // add
    $app->any('/CategoriesView[/{CategoryID}]', CategoriesController::class . ':view')->add(PermissionMiddleware::class)->setName('CategoriesView-categories-view'); // view
    $app->any('/CategoriesEdit[/{CategoryID}]', CategoriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('CategoriesEdit-categories-edit'); // edit
    $app->any('/CategoriesDelete[/{CategoryID}]', CategoriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('CategoriesDelete-categories-delete'); // delete
    $app->group(
        '/categories',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{CategoryID}]', CategoriesController::class . ':list')->add(PermissionMiddleware::class)->setName('categories/list-categories-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{CategoryID}]', CategoriesController::class . ':add')->add(PermissionMiddleware::class)->setName('categories/add-categories-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{CategoryID}]', CategoriesController::class . ':view')->add(PermissionMiddleware::class)->setName('categories/view-categories-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{CategoryID}]', CategoriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('categories/edit-categories-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{CategoryID}]', CategoriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('categories/delete-categories-delete-2'); // delete
        }
    );

    // customers
    $app->any('/CustomersList[/{CustomerID}]', CustomersController::class . ':list')->add(PermissionMiddleware::class)->setName('CustomersList-customers-list'); // list
    $app->any('/CustomersAdd[/{CustomerID}]', CustomersController::class . ':add')->add(PermissionMiddleware::class)->setName('CustomersAdd-customers-add'); // add
    $app->any('/CustomersView[/{CustomerID}]', CustomersController::class . ':view')->add(PermissionMiddleware::class)->setName('CustomersView-customers-view'); // view
    $app->any('/CustomersEdit[/{CustomerID}]', CustomersController::class . ':edit')->add(PermissionMiddleware::class)->setName('CustomersEdit-customers-edit'); // edit
    $app->any('/CustomersDelete[/{CustomerID}]', CustomersController::class . ':delete')->add(PermissionMiddleware::class)->setName('CustomersDelete-customers-delete'); // delete
    $app->group(
        '/customers',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{CustomerID}]', CustomersController::class . ':list')->add(PermissionMiddleware::class)->setName('customers/list-customers-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{CustomerID}]', CustomersController::class . ':add')->add(PermissionMiddleware::class)->setName('customers/add-customers-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{CustomerID}]', CustomersController::class . ':view')->add(PermissionMiddleware::class)->setName('customers/view-customers-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{CustomerID}]', CustomersController::class . ':edit')->add(PermissionMiddleware::class)->setName('customers/edit-customers-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{CustomerID}]', CustomersController::class . ':delete')->add(PermissionMiddleware::class)->setName('customers/delete-customers-delete-2'); // delete
        }
    );

    // employees
    $app->any('/EmployeesList[/{EmployeeID}]', EmployeesController::class . ':list')->add(PermissionMiddleware::class)->setName('EmployeesList-employees-list'); // list
    $app->any('/EmployeesAdd[/{EmployeeID}]', EmployeesController::class . ':add')->add(PermissionMiddleware::class)->setName('EmployeesAdd-employees-add'); // add
    $app->any('/EmployeesView[/{EmployeeID}]', EmployeesController::class . ':view')->add(PermissionMiddleware::class)->setName('EmployeesView-employees-view'); // view
    $app->any('/EmployeesEdit[/{EmployeeID}]', EmployeesController::class . ':edit')->add(PermissionMiddleware::class)->setName('EmployeesEdit-employees-edit'); // edit
    $app->any('/EmployeesDelete[/{EmployeeID}]', EmployeesController::class . ':delete')->add(PermissionMiddleware::class)->setName('EmployeesDelete-employees-delete'); // delete
    $app->group(
        '/employees',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{EmployeeID}]', EmployeesController::class . ':list')->add(PermissionMiddleware::class)->setName('employees/list-employees-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{EmployeeID}]', EmployeesController::class . ':add')->add(PermissionMiddleware::class)->setName('employees/add-employees-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{EmployeeID}]', EmployeesController::class . ':view')->add(PermissionMiddleware::class)->setName('employees/view-employees-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{EmployeeID}]', EmployeesController::class . ':edit')->add(PermissionMiddleware::class)->setName('employees/edit-employees-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{EmployeeID}]', EmployeesController::class . ':delete')->add(PermissionMiddleware::class)->setName('employees/delete-employees-delete-2'); // delete
        }
    );

    // employeeterritories
    $app->any('/EmployeeterritoriesList[/{EmployeeID}/{TerritoryID}]', EmployeeterritoriesController::class . ':list')->add(PermissionMiddleware::class)->setName('EmployeeterritoriesList-employeeterritories-list'); // list
    $app->any('/EmployeeterritoriesAdd[/{EmployeeID}/{TerritoryID}]', EmployeeterritoriesController::class . ':add')->add(PermissionMiddleware::class)->setName('EmployeeterritoriesAdd-employeeterritories-add'); // add
    $app->any('/EmployeeterritoriesView[/{EmployeeID}/{TerritoryID}]', EmployeeterritoriesController::class . ':view')->add(PermissionMiddleware::class)->setName('EmployeeterritoriesView-employeeterritories-view'); // view
    $app->any('/EmployeeterritoriesEdit[/{EmployeeID}/{TerritoryID}]', EmployeeterritoriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('EmployeeterritoriesEdit-employeeterritories-edit'); // edit
    $app->any('/EmployeeterritoriesDelete[/{EmployeeID}/{TerritoryID}]', EmployeeterritoriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('EmployeeterritoriesDelete-employeeterritories-delete'); // delete
    $app->group(
        '/employeeterritories',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{EmployeeID}/{TerritoryID}]', EmployeeterritoriesController::class . ':list')->add(PermissionMiddleware::class)->setName('employeeterritories/list-employeeterritories-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{EmployeeID}/{TerritoryID}]', EmployeeterritoriesController::class . ':add')->add(PermissionMiddleware::class)->setName('employeeterritories/add-employeeterritories-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{EmployeeID}/{TerritoryID}]', EmployeeterritoriesController::class . ':view')->add(PermissionMiddleware::class)->setName('employeeterritories/view-employeeterritories-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{EmployeeID}/{TerritoryID}]', EmployeeterritoriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('employeeterritories/edit-employeeterritories-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{EmployeeID}/{TerritoryID}]', EmployeeterritoriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('employeeterritories/delete-employeeterritories-delete-2'); // delete
        }
    );

    // order_details
    $app->any('/OrderDetailsList[/{order_detail_id}]', OrderDetailsController::class . ':list')->add(PermissionMiddleware::class)->setName('OrderDetailsList-order_details-list'); // list
    $app->any('/OrderDetailsAdd[/{order_detail_id}]', OrderDetailsController::class . ':add')->add(PermissionMiddleware::class)->setName('OrderDetailsAdd-order_details-add'); // add
    $app->any('/OrderDetailsView[/{order_detail_id}]', OrderDetailsController::class . ':view')->add(PermissionMiddleware::class)->setName('OrderDetailsView-order_details-view'); // view
    $app->any('/OrderDetailsEdit[/{order_detail_id}]', OrderDetailsController::class . ':edit')->add(PermissionMiddleware::class)->setName('OrderDetailsEdit-order_details-edit'); // edit
    $app->any('/OrderDetailsDelete[/{order_detail_id}]', OrderDetailsController::class . ':delete')->add(PermissionMiddleware::class)->setName('OrderDetailsDelete-order_details-delete'); // delete
    $app->group(
        '/order_details',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{order_detail_id}]', OrderDetailsController::class . ':list')->add(PermissionMiddleware::class)->setName('order_details/list-order_details-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{order_detail_id}]', OrderDetailsController::class . ':add')->add(PermissionMiddleware::class)->setName('order_details/add-order_details-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{order_detail_id}]', OrderDetailsController::class . ':view')->add(PermissionMiddleware::class)->setName('order_details/view-order_details-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{order_detail_id}]', OrderDetailsController::class . ':edit')->add(PermissionMiddleware::class)->setName('order_details/edit-order_details-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{order_detail_id}]', OrderDetailsController::class . ':delete')->add(PermissionMiddleware::class)->setName('order_details/delete-order_details-delete-2'); // delete
        }
    );

    // orders
    $app->any('/OrdersList[/{OrderID}]', OrdersController::class . ':list')->add(PermissionMiddleware::class)->setName('OrdersList-orders-list'); // list
    $app->any('/OrdersAdd[/{OrderID}]', OrdersController::class . ':add')->add(PermissionMiddleware::class)->setName('OrdersAdd-orders-add'); // add
    $app->any('/OrdersView[/{OrderID}]', OrdersController::class . ':view')->add(PermissionMiddleware::class)->setName('OrdersView-orders-view'); // view
    $app->any('/OrdersEdit[/{OrderID}]', OrdersController::class . ':edit')->add(PermissionMiddleware::class)->setName('OrdersEdit-orders-edit'); // edit
    $app->any('/OrdersDelete[/{OrderID}]', OrdersController::class . ':delete')->add(PermissionMiddleware::class)->setName('OrdersDelete-orders-delete'); // delete
    $app->group(
        '/orders',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{OrderID}]', OrdersController::class . ':list')->add(PermissionMiddleware::class)->setName('orders/list-orders-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{OrderID}]', OrdersController::class . ':add')->add(PermissionMiddleware::class)->setName('orders/add-orders-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{OrderID}]', OrdersController::class . ':view')->add(PermissionMiddleware::class)->setName('orders/view-orders-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{OrderID}]', OrdersController::class . ':edit')->add(PermissionMiddleware::class)->setName('orders/edit-orders-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{OrderID}]', OrdersController::class . ':delete')->add(PermissionMiddleware::class)->setName('orders/delete-orders-delete-2'); // delete
        }
    );

    // products
    $app->any('/ProductsList[/{ProductID}]', ProductsController::class . ':list')->add(PermissionMiddleware::class)->setName('ProductsList-products-list'); // list
    $app->any('/ProductsAdd[/{ProductID}]', ProductsController::class . ':add')->add(PermissionMiddleware::class)->setName('ProductsAdd-products-add'); // add
    $app->any('/ProductsView[/{ProductID}]', ProductsController::class . ':view')->add(PermissionMiddleware::class)->setName('ProductsView-products-view'); // view
    $app->any('/ProductsEdit[/{ProductID}]', ProductsController::class . ':edit')->add(PermissionMiddleware::class)->setName('ProductsEdit-products-edit'); // edit
    $app->any('/ProductsDelete[/{ProductID}]', ProductsController::class . ':delete')->add(PermissionMiddleware::class)->setName('ProductsDelete-products-delete'); // delete
    $app->group(
        '/products',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ProductID}]', ProductsController::class . ':list')->add(PermissionMiddleware::class)->setName('products/list-products-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ProductID}]', ProductsController::class . ':add')->add(PermissionMiddleware::class)->setName('products/add-products-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ProductID}]', ProductsController::class . ':view')->add(PermissionMiddleware::class)->setName('products/view-products-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ProductID}]', ProductsController::class . ':edit')->add(PermissionMiddleware::class)->setName('products/edit-products-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ProductID}]', ProductsController::class . ':delete')->add(PermissionMiddleware::class)->setName('products/delete-products-delete-2'); // delete
        }
    );

    // region
    $app->any('/RegionList', RegionController::class . ':list')->add(PermissionMiddleware::class)->setName('RegionList-region-list'); // list
    $app->group(
        '/region',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', RegionController::class . ':list')->add(PermissionMiddleware::class)->setName('region/list-region-list-2'); // list
        }
    );

    // shippers
    $app->any('/ShippersList[/{ShipperID}]', ShippersController::class . ':list')->add(PermissionMiddleware::class)->setName('ShippersList-shippers-list'); // list
    $app->any('/ShippersAdd[/{ShipperID}]', ShippersController::class . ':add')->add(PermissionMiddleware::class)->setName('ShippersAdd-shippers-add'); // add
    $app->any('/ShippersView[/{ShipperID}]', ShippersController::class . ':view')->add(PermissionMiddleware::class)->setName('ShippersView-shippers-view'); // view
    $app->any('/ShippersEdit[/{ShipperID}]', ShippersController::class . ':edit')->add(PermissionMiddleware::class)->setName('ShippersEdit-shippers-edit'); // edit
    $app->any('/ShippersDelete[/{ShipperID}]', ShippersController::class . ':delete')->add(PermissionMiddleware::class)->setName('ShippersDelete-shippers-delete'); // delete
    $app->group(
        '/shippers',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ShipperID}]', ShippersController::class . ':list')->add(PermissionMiddleware::class)->setName('shippers/list-shippers-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ShipperID}]', ShippersController::class . ':add')->add(PermissionMiddleware::class)->setName('shippers/add-shippers-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ShipperID}]', ShippersController::class . ':view')->add(PermissionMiddleware::class)->setName('shippers/view-shippers-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ShipperID}]', ShippersController::class . ':edit')->add(PermissionMiddleware::class)->setName('shippers/edit-shippers-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ShipperID}]', ShippersController::class . ':delete')->add(PermissionMiddleware::class)->setName('shippers/delete-shippers-delete-2'); // delete
        }
    );

    // suppliers
    $app->any('/SuppliersList[/{SupplierID}]', SuppliersController::class . ':list')->add(PermissionMiddleware::class)->setName('SuppliersList-suppliers-list'); // list
    $app->any('/SuppliersAdd[/{SupplierID}]', SuppliersController::class . ':add')->add(PermissionMiddleware::class)->setName('SuppliersAdd-suppliers-add'); // add
    $app->any('/SuppliersView[/{SupplierID}]', SuppliersController::class . ':view')->add(PermissionMiddleware::class)->setName('SuppliersView-suppliers-view'); // view
    $app->any('/SuppliersEdit[/{SupplierID}]', SuppliersController::class . ':edit')->add(PermissionMiddleware::class)->setName('SuppliersEdit-suppliers-edit'); // edit
    $app->any('/SuppliersDelete[/{SupplierID}]', SuppliersController::class . ':delete')->add(PermissionMiddleware::class)->setName('SuppliersDelete-suppliers-delete'); // delete
    $app->group(
        '/suppliers',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{SupplierID}]', SuppliersController::class . ':list')->add(PermissionMiddleware::class)->setName('suppliers/list-suppliers-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{SupplierID}]', SuppliersController::class . ':add')->add(PermissionMiddleware::class)->setName('suppliers/add-suppliers-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{SupplierID}]', SuppliersController::class . ':view')->add(PermissionMiddleware::class)->setName('suppliers/view-suppliers-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{SupplierID}]', SuppliersController::class . ':edit')->add(PermissionMiddleware::class)->setName('suppliers/edit-suppliers-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{SupplierID}]', SuppliersController::class . ':delete')->add(PermissionMiddleware::class)->setName('suppliers/delete-suppliers-delete-2'); // delete
        }
    );

    // territories
    $app->any('/TerritoriesList[/{TerritoryID}]', TerritoriesController::class . ':list')->add(PermissionMiddleware::class)->setName('TerritoriesList-territories-list'); // list
    $app->any('/TerritoriesAdd[/{TerritoryID}]', TerritoriesController::class . ':add')->add(PermissionMiddleware::class)->setName('TerritoriesAdd-territories-add'); // add
    $app->any('/TerritoriesView[/{TerritoryID}]', TerritoriesController::class . ':view')->add(PermissionMiddleware::class)->setName('TerritoriesView-territories-view'); // view
    $app->any('/TerritoriesEdit[/{TerritoryID}]', TerritoriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('TerritoriesEdit-territories-edit'); // edit
    $app->any('/TerritoriesDelete[/{TerritoryID}]', TerritoriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('TerritoriesDelete-territories-delete'); // delete
    $app->group(
        '/territories',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{TerritoryID}]', TerritoriesController::class . ':list')->add(PermissionMiddleware::class)->setName('territories/list-territories-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{TerritoryID}]', TerritoriesController::class . ':add')->add(PermissionMiddleware::class)->setName('territories/add-territories-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{TerritoryID}]', TerritoriesController::class . ':view')->add(PermissionMiddleware::class)->setName('territories/view-territories-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{TerritoryID}]', TerritoriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('territories/edit-territories-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{TerritoryID}]', TerritoriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('territories/delete-territories-delete-2'); // delete
        }
    );

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->any('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
