<!doctype html>
<html lang="en">
    <head>
        <?php require 'view/assets.php' ?>
    </head>

    <body ng-app="myApp">
        <?php require 'view/header.html'; ?>

        <div ng-view style="margin-top:30vh;"></div>

        <?php require 'view/footer.html'; ?>

    </body>

    <script>
        var app = angular.module("myApp", ["ngRoute"]);
        app.config(function($routeProvider){
            $routeProvider
            .when("/",{
                templateUrl : "view/indexView.html"
            })
            .when("/about",{
                templateUrl : "view/about.html",
                controller : "aboutController"
            })
            .when("/blog",{
                templateUrl : "view/blog.html"
            })
            .when("/contact",{
                templateUrl : "view/contact.html"
            })
            .when("/elements",{
                templateUrl : "view/elements.html"
            })
            .when("/doctors",{
                templateUrl : "view/doctors.html"
            })
            .when("/departments",{
                templateUrl : "view/departments.html"
            })
            .when("/services",{
                templateUrl : "view/services.html"
            })
            .when("/login",{
                templateUrl : "view/login.html"
            })
            .when("/signin",{
                templateUrl : "view/signin.html",
                controller : "signinController"
            });
        });
        
        app.controller("aboutController",function($scope){
            
        });
        app.controller("signinController",function($scope,$http){
            $scope.login = function(){
                $http({
                    method : "POST",
                    url : "http://localhost/consultorio/api/paciente/create.php",
                    data : {
                        "nombre" : $scope.nombre,
                        "apellidos" : $scope.apellidos,
                        "fechaNacimiento" : $scope.fechaNacimiento,
                        "peso" : $scope.peso,
                        "telefono" : $scope.telefono,
                        "email" : $scope.email,
                        "password" : $scope.password
                    }
                }).then(
                    function success(response){
                        $scope.data = response.data;
                        alert('Tu usuario se ha creado correctamente');
                    },
                    function error(response){
                        $scope.data = response.statusText;
                    }
                );
            }
        });
    </script>

</html>