<?php 
    namespace DAO;

    use DAO\IUserDAO as IUserDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\User as User;
    
    class UserDAOmysql implements IUserDAO{

        private $connection;
        private $tableName = "users";


        public function Add(User $newUser){

            try{
                if($this->checkUserNameExistence($newUser->getUserName())==0){

                  $query = "INSERT INTO ".$this->tableName." (idUser, idRole, userName, userEmail, userPassword, userState) VALUES (:idUser, :idRole, :userName, :userEmail, :userPassword, :userState)";

                  $parameters['idUser'] = $newUser->getIdUser();
                  $parameters['idRole'] = 2;
                  $parameters['userName'] = $newUser->getUserName();
                  $parameters['userEmail'] = $newUser->getUserEmail();
                  $parameters['userPassword'] = $newUser->getUserPassword();
                  $parameters['userState'] = 1;

                  $this->connection = Connection::GetInstance();

                  $this->connection->ExecuteNonQuery($query,$parameters,QueryType::Query);

                  $message = 'Usuario registrado exitosamente';

                }else{
                    throw new \PDOException("El nombre de usuario ya esta en uso");
                }
            }
            catch(\PDOException $ex){
                $message = $ex->getMessage();
            }
            return $message;
        }

        public function AddFBuser(User $newUser){

            try{
                //if($this->checkUserNameExistence($newUser->getUserName())==0){

                  $query = "INSERT INTO ".$this->tableName." (idUser, idRole, userName, userEmail, userPassword, userState, fbAccesToken ) VALUES (:idUser, :idRole, :userName, :userEmail, :userPassword, :userState, :fbAccesToken )";

                  $parameters['idUser'] = $newUser->getIdUser();
                  $parameters['idRole'] = 2;
                  $parameters['userName'] = $newUser->getUserName();
                  $parameters['userEmail'] = $newUser->getUserEmail();
                  $parameters['userPassword'] = rand(8,20);
                  $parameters['userState'] = 1;
                  $parameters['fbId'] = $newUser->getfbId();
                  $parameters['fbAccesToken'] = $newUser->getfbAccesToken();

                  $this->connection = Connection::GetInstance();

                  $this->connection->ExecuteNonQuery($query,$parameters,QueryType::Query);

                  $message = 'Usuario registrado exitosamente';

                //}else{
                    //throw new \PDOException("El nombre de usuario ya esta en uso");
                //}
            }
            catch(\PDOException $ex){
                //$message = $ex->getMessage();
                throw $ex;
            }
            return $message;
        }

        public function checkUserNameExistence ($userName)
        {
            $condition = 0;
            $u = new User();
            $u = $this->read($userName);
            if($u){
                $condition = 1;
            }
            return $condition;
        }

        public function read ($userNameLogin)
        {
            $query= "SELECT *FROM users WHERE userName = :userName";
            $parameters['userName'] = $userNameLogin;

            try{
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query,$parameters,QueryType::Query);
            }
            catch(\PDOException $ex){
                throw $ex;
            }
            
            //var_dump($resultSet);

            if (!empty($resultSet)){
                return $this->mapear($resultSet);
            }else{
                return false;
            }
        }

        protected function mapear ($value)
        {
            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                $u= new User();
                $u->setIdUser ($p['idUser']);
                $u->setUserName ($p['userName']);
                $u->setUserEmail($p['userEmail']);
                $u->setUserPassword ($p['userPassword']);
                $u->setUserRole($p['idRole']);
                $u->setUserState($p['userState']);
                return $u;
            }, $value);
                 
            return count($resp) > 1 ? $resp : $resp['0'];
        }
/*

        public function getAuditorium($id){

            $query = "SELECT * FROM".$this->tableName "WHERE ".$this->tableName.".id ='$id'";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,array(),QueryType::Query);

            return $result;
        }

        public function delete($id){
            $query = "CALL Auditorium_Delete(?)";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::Query);
            
        }
*/
    }
    
?>