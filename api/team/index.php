<?php 
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '..\..\config\Database.php';
  include_once '..\..\models\User.php';
  include_once '..\..\models\Team.php';

  $requestMethod = $_SERVER["REQUEST_METHOD"];
  $database = new Database();
  $dbConnection = $database->connect();
  $team = new Team($dbConnection);

  switch ($requestMethod) {
    case 'GET':
        $team->status = "active";
        $response = $team->findAvarageAgeByActiveTeam();
        echo json_encode($response);
        break;
    default:
        echo json_encode(array(
          'message' => 'Request Method Not Supported',
          'success' => false
        ));
        break;
  }