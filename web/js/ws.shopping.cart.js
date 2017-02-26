var host = window.location.href.split('.')[0] + '.php';
var getItemsPath = host + '/shopping/cart';
var changeQuantityPath = host + '/shopping/cart/quantity/{itemId}/{quantity}';
var removePath = host + '/shopping/cart/remove/{itemId}';
var addPath = host + '/shopping/cart/add/{productId}';
var shoppingCart = null;

var shoppingCartModule = angular.module('shoppingCartModule', [])
    .config(function ($interpolateProvider) {
        $interpolateProvider.startSymbol('{').endSymbol('}');
    });

shoppingCartModule.controller('ShoppingCartController', function ($scope, $http) {
    var total = 0;
    shoppingCart = this;
    shoppingCart.items = {};

    shoppingCart.total = function () {
        return total;
    }

    shoppingCart.updateTotalPrice = function () {
        total = 0;
        angular.forEach(shoppingCart.items, function (value, key) {
            total = total + value.sum;
        });
    }

    $http.get(getItemsPath)
        .then(function (response) {
            var items = {};
            angular.forEach(response.data.items, function (value, key) {
                items[value.id] = value;
            });
            shoppingCart.items = items;
            shoppingCart.updateTotalPrice();
        });

    shoppingCart.increment = function (item) {
        shoppingCart.quantity(item, parseInt(item.quantity) + 1);
        shoppingCart.updateTotalPrice();
    };

    shoppingCart.decrement = function (item) {
        shoppingCart.quantity(item, parseInt(item.quantity) - 1);
    };

    shoppingCart.quantityChanged = function (item) {
        shoppingCart.quantity(item, item.quantity);
    };

    shoppingCart.quantity = function (item, quantity) {
        var path = changeQuantityPath.replace('{itemId}', item.id);
        path = path.replace('{quantity}', quantity);
        $http.get(path)
            .then(function (response) {
                shoppingCart.items[item.id] = response.data;
                shoppingCart.updateTotalPrice();
            });
    };

    shoppingCart.remove = function (item) {
        var path = removePath.replace('{itemId}', item.id);
        $http.get(path)
            .then(function (response) {
                delete shoppingCart.items[response.data.id];
                shoppingCart.updateTotalPrice();
            });
    };

    shoppingCart.add = function (productId) {
        var path = addPath.replace('{productId}', productId);
        $http.get(path)
            .then(function (response) {
                shoppingCart.items[productId] = response.data;
                shoppingCart.updateTotalPrice();
            });
    };

});