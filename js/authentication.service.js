app.factory('AuthenticationService', Service);

function Service($http, $localStorage,$rootScope) {
    var service = {};

    service.Login = Login;
    service.Logout = Logout;
    service.AdminLogin = AdminLogin;
    
    return service;

    function Login(email, password, callback) {
        $http.post('/consultorio/api/paciente/login.php', { email: email, password: password })
            .then(function (response) {
            // login successful if there's a token in the response
            if (response.data.jwt) {
                // store username and token in local storage to keep user logged in between page refreshes
                $localStorage.currentUser = { 
                    email: email,
                    jwt: response.data.jwt,
                    idPaciente : response.data.idPaciente,
                    nombre : response.data.nombre,
                    apellidos: response.data.apellidos,
                    fechaNacimiento: response.data.fechaNacimiento,
                    peso : response.data.peso,
                    telefono: response.data.telefono,
                    admin: false
                };
                $rootScope.name = response.data.nombre;

                // add jwt token to auth header for all requests made by the $http service
                $http.defaults.headers.common.Authorization = 'Bearer ' + response.data.jwt;
                
                $rootScope.logged=true;
                // execute callback with true to indicate successful login
                callback(true);
            } else {
                // execute callback with false to indicate failed login
                callback(false);
            }
        });
    }
    
    function AdminLogin(email, password, callback) {
        $http.post('/consultorio/api/administrativo/login.php', { email: email, password: password })
            .then(function (response) {
            // login successful if there's a token in the response
            if (response.data.jwt) {
                // store username and token in local storage to keep user logged in between page refreshes
                $localStorage.currentUser = { 
                    email: email,
                    jwt: response.data.jwt,
                    idPaciente : response.data.idPaciente,
                    nombre : response.data.nombre,
                    apellidos: response.data.apellidos,
                    fechaNacimiento: response.data.fechaNacimiento,
                    peso : response.data.peso,
                    telefono: response.data.telefono,
                    admin : true
                };
                $rootScope.name = response.data.nombre;

                // add jwt token to auth header for all requests made by the $http service
                $http.defaults.headers.common.Authorization = 'Bearer ' + response.data.jwt;
                
                $rootScope.logged=true;
                $rootScope.admin = true;
                // execute callback with true to indicate successful login
                callback(true);
            } else {
                // execute callback with false to indicate failed login
                callback(false);
            }
        });
    }

    
    
    function Logout() {
        // remove user from local storage and clear http auth header
        $rootScope.logged = false;
        $rootScope.admin=false;
        delete $localStorage.currentUser;
        $http.defaults.headers.common.Authorization = '';
    }
}