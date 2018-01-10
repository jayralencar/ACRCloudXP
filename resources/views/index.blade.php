<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ACRCloud Experience</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">


</head>
<body ng-app="acrxp">
    <div class="container" ng-controller="appController">
        <div class="text-center">
            <h2>ACRCloud Experience</h2>
        </div>
        <hr>
        <div class="form-row justify-content-md-center" ng-show="status == 1">
            <div class="col-md-6">
                <form class="form-inline">
                    <div class="form-group">
                        <input type="file" name="file" onchange="angular.element(this).scope().upload(this.files)" accept="audio/*"/>
                    </div>
                </form>
            </div>
            <div class="col-md-2"> 
                <button ng-disabled="!file" class="btn btn-info" ng-click="send()">Enviar Música</button>
            </div>  
        </div>
        <div class="text-center" ng-show="status == 2"> 
            <h2><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Aguarde...</h2>
        </div>  
        <div class="row justify-content-md-center" ng-show="status == 3">
            <div class="alert alert-danger" ng-show="response.status.code != 0" role="alert">
                @{{response.status.msg}}
            </div>
            <div class="card" ng-show="response.status.code == 0" style="width: 18rem;">        
                <img ng-show="response.metadata.music[0].external_metadata.youtube" class="card-img-top" src="https://img.youtube.com/vi/@{{response.metadata.music[0].external_metadata.youtube.vid}}/0.jpg" alt="Card image cap">
                <div class="card-body">
                    <h3 class="card-title">@{{response.metadata.music[0].title}} </h3>
                    <h6 class="card-subtitle mb-2 text-muted">@{{msToTime(response.metadata.music[0].duration_ms)}}</h6>
                    <p class="card-text"><strong>Artista:</strong> @{{response.metadata.music[0].artists[0].name}}</p>
                    <p class="card-text"><strong>Album:</strong> @{{response.metadata.music[0].album.name}}</p>
                    <a href="https://www.youtube.com/watch?v=@{{response.metadata.music[0].external_metadata.youtube.vid}}" class="card-link" ng-show="response.metadata.music[0].external_metadata.youtube">Youtube</a>
                </div>
            </div>
        </div>

    </div>
    <script src="https://use.fontawesome.com/5b66ce007f.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
