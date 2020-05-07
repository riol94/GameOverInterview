<?php 
    class Team {
        private $conn;
        private $table = 'teams';

        public $team_id;
        public $team_name;
        public $dateofplay;
        public $numofplayers;
        public $timetoplay;
        public $status;
        public $score;
        public $timeofactivation;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function findOne() {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE team_id = ? LIMIT 1;';
            try {
                $statement = $this->conn->prepare($query);
                $statement->bindParam(1, $this->team_id);
                $statement->execute();
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                extract($row);
                return array(
                        'team_id' => $team_id,
                        'team_name' => $team_name,
                        'dateofplay' => $dateofplay,
                        'numofplayers' => $numofplayers,
                        'timetoplay' => $timetoplay,
                        'status' => $status,
                        'score' => $score,
                        'timeofactivation' => $timeofactivation
                );
            } catch (PDOException $e) {
                return array('message' => 'Something went wrong with the Service, Try again later', 'succes' => false);
            }
        }

        public function findAvarageAgeByActiveTeam() {
            $query = "SELECT AVG(u.age) as average_age, t.team_name FROM users u LEFT JOIN teams t ON t.team_id = u.team_id WHERE t.status = ? GROUP BY t.team_name;";
            try {
                $statement = $this->conn->prepare($query);
                $statement->bindParam(1, $this->status);
                $statement->execute();
               
                $num = $statement->rowCount();

                if($num > 0) {
                    $teams_arr = array();
                    $teams_arr['data'] = array();

                    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);

                        $team = array(
                            'team_name' => $team_name,
                            'average_age' => $average_age
                        );

                        array_push($teams_arr['data'], $team);
                    }
                    $teams_arr['success'] = true;
                    return $teams_arr;

                } else {
                    return array('message' => 'No Active Team Found', 'succes' => false);
                }
            } catch (PDOException $e) {
                return array('message' => 'Something went wrong with the Service, Try again later', 'succes' => false);
            }
        }
    }