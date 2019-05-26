var app = angular.module("myApp", ["ngRoute"]);
app.config(function($routeProvider){
    $routeProvider
    .when("/",{
        templateUrl : "view/indexView.html"
    })
    .when("/about",{
        templateUrl : "view/about.html"
    })
    .when("/blog",{
        templateUrl : "view/blog.html"
    })
    .when("/contact",{
        templateUrl : "view/contact.html"
    })
});