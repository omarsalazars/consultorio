var app = angular.module("myApp", ["ngRoute"]);
app.config(function($routeProvider){
    $routeProvider
    .when("/",{
        templateUrl : "view/indexView.html"
    })
    .when("/about",{
    })
    .when("/blog",{
        templateUrl : "view/blog.html"
    })
    .when("/contact",{
        templateUrl : "view/contact.html"
    })
});