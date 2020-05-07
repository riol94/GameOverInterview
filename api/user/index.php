<?php 
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: GET,POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '..\..\config\Database.php';
  include_once '..\..\models\User.php';
  include_once '..\..\models\Team.php';

  $requestMethod = $_SERVER["REQUEST_METHOD"];
  $database = new Database();
  $dbConnection = $database->connect();
  $user = new User($dbConnection);
  $team = new Team($dbConnection);

    switch ($requestMethod) {
        case 'GET':
            echo json_encode($user->findAllWithAverageAge());
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $user->user_id = $data->user_id;
            $user_response = $user->findOne();
            if(isset($user_response['team_id'])) {
                $team->team_id = $user_response['team_id'];
                $team_response = $team->findOne();
                if($team_response['status'] === "active"){
                    $user->team_id = $team_response['team_id'];
                    echo json_encode($user->findTeammates());
                } else {
                    $response = array("message" => $team_response, "success" => false );
                    echo json_encode($response);
                }
            }else {
                $response = array("message" => $user_response, "success" => false );
                echo json_encode($response);
            }
            break;
        default:
            echo json_encode(array(
              'message' => 'Request Method Not Supported', 'success' => false
            ));
            break;
    }