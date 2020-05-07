<?php 
    class User {
        private $conn;
        private $table = 'users';

        public $id;
        public $user_id;
        public $team_id;
        public $firstName;
        public $lastName;
        public $nickName;
        public $email;
        public $age;
        public $picture;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function findTeammates(){
            $query = 'SELECT * FROM ' . $this->table . ' WHERE team_id = ? AND user_id != ?';
            try {
                $statement = $this->conn->prepare($query);
                $statement->bindParam(1, $this->team_id);
                $statement->bindParam(2, $this->user_id);
                $statement->execute();
               
                $num = $statement->rowCount();

                if($num > 0) {
                    $users_arr = array();
                    $users_arr['data'] = array();

                    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);

                        $user = array(
                            'id' => $id,
                            'user_id' => $user_id,
                            'team_id' => $team_id,
                            'firstName' => $firstName,
                            'lastName' => $lastName,
                            'nickName' => $nickName,
                            'email' => $email,
                            'age' => $age,
                            'picture' => $picture
                        );

                        array_push($users_arr['data'], $user);
                    }
                    $users_arr['success'] = true;
                    return $users_arr;

                } else {
                    return array('message' => 'No User Found');
                }
            } catch (PDOException $e) {
                return array('message' => 'Something went wrong with the Service, Try again later', 'succes' => false);
            }

            
        }

        public function findAllWithAverageAge(){
            $query = 'SELECT age FROM ' . $this->table;
            try {
                $statement = $this->conn->prepare($query);
                $statement->execute();
               
                $num = $statement->rowCount();

                if($num > 0) {
                    $users_arr = array();
                    $users_arr['avAge'] = 0;

                    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);

                        $user = array('age' => $age);
                        $users_arr['avAge'] += (int)$age;
                    }

                    $users_arr['avAge'] = round($users_arr['avAge'] / $num);
                    $users_arr['success'] = true;
                    return $users_arr;

                } else {
                    return 'No User Found';
                }
            } catch (PDOException $e) {
                return array('message' => 'Something went wrong with the Service, Try again later', 'succes' => false);
            }

            
        }

        public function findOne() {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE user_id = ? LIMIT 1;';
            try {
                $statement = $this->conn->prepare($query);
                $statement->bindParam(1, $this->user_id);
                $statement->execute();
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                $num = $statement->rowCount();
                if($num > 0) {
                    extract($row);
                    return array(
                        'id' => $id,
                        'user_id' => $user_id,
                        'team_id' => $team_id,
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'nickName' => $nickName,
                        'email' => $email,
                        'age' => $age,
                        'picture' => $picture
                    );
                }
                else {
                    return 'No User Found';
                }

            } catch (PDOException $e) {
                return array('message' => 'Something went wrong with the Service, Try again later', 'succes' => false);
            }
            
        }
    }
