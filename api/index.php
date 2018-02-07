<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Spordivõistluse ajavõtusüsteem</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<br/>
<div class="container">
    <h3 align="center">Spordivõistluse ajavõtusüsteem</h3>
    <br/>
    <div ng-app="myapp" ng-controller="usercontroller" ng-init="displayData()">

        <button type="button" onclick="startTheTest()" class="btn btn-primary">Alusta</button>

        <button type="button" onclick="clearTheTimes()" class="btn btn-primary">Tühjenda</button>

        <table class="table table-bordered">
            <tr>
                <th class="id">ID</th>
                <th class="name">Nimi</th>
                <th class="chipID">chipID</th>
                <th class="entry_time">Finišikoridoris</th>
                <th class="finish_time">Finišijoonel</th>
            </tr>
            <tr ng-repeat="x in data">
                <td class="id">{{x.id}}</td>
                <td class="name">{{x.name}}</td>
                <td class="chipID">{{x.chipID}}</td>
                <td class="time">{{x.entry_time}}</td>
                <td class="time">{{x.finish_time}}</td>
            </tr>
        </table>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.7/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script>
<script src="./moment.js"></script>
</body>
</html>

<script>
    var app = angular.module("myapp", []);
    app.controller("usercontroller", function ($scope, $http, $interval) {
        $scope.displayData = function () {
            $http.get("select.php")
                .then(function onSuccess(response) {
                    $scope.data = response.data;
//                    $(document).ready(function () {
//                        convertTimestamp();
//                    });
                });
        };
        $interval($scope.displayData, 1000);
    });

    function startTheTest() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "dummy_data.php", true);
        xmlhttp.send();
    }

    function clearTheTimes() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "reset.php", true);
        xmlhttp.send();
    }

//    function convertTimestamp (){
//        $('.time').each(function (i) {
//            var timestamp = $(this).html().split(".")[0];
//            var ms = $(this).html().split(".")[1];
//            var date = moment.unix(timestamp).format("DD MMMM YYYY - HH:mm:ss") + "." + ms;
//            $(this).replaceWith('<td class="time">' + date + '</td>');
//        });
//    }
</script>