<?php

// User model
class User{

	// generate token
	public static function SetToken($userId){
		
		try{

            $db = DB::get();
		
			// create a token
    		$token = $userId.uniqid();
    		
    		$q = "UPDATE Users SET Token = ? WHERE UserId=?";
    		
    		$s = $db->prepare($q);
            $s->bindParam(1, $token);
            $s->bindParam(2, $userId);
            
            $s->execute();
    		
    		return $token;
        
		} catch(PDOException $e){
            die('[User::SetToken] PDO Error: '.$e->getMessage());
        } 
	}

    // Gets a user for a specific user name and password
    public static function GetByUserNamePassword($user_name, $password){
        
        try{
         
            $db = DB::get();
            
            //$q = "SELECT roles_id, users_id, users_name, users_password, users_email, users_status, token
            //        FROM wdb_users WHERE users_name=? AND users_status = 1";
            // 暂时使用原有的加密方式
            $q = "SELECT roles_id, users_id, users_name, users_password, users_email, users_status, token
                    FROM wdb_users WHERE users_name=? AND users_password=old_password(?) AND users_status = 1";

            
            $s = $db->prepare($q);
            $s->bindParam(1, $user_name);
            $s->bindParam(2, $password);
            
            $s->execute();
            
            $row = $s->fetch(PDO::FETCH_ASSOC);

            if($row){ //sucess
                return $row;
            }else{//failure
                return null;
            }
        
            /*
            if($row){
                
                $hash = $row["users_password"];
            
                // need to check the password
                $hash_cost_log2 = 8; // Base-2 logarithm of the iteration count used for password stretching
                $hash_portable = FALSE; // Not portable
            
                $hasher = new PasswordHash($hash_cost_log2, $hash_portable);
                
                if($hasher->CheckPassword($password, $hash)){ // success
                    unset($hasher);
                    return $row;
                }
                else{ // failure
                    unset($hasher);
                    return null;
                }
                

                if(md5($password) == $hash){ //success
                    return $row;
                }
                else{ //failure
                    return null;
                }
            }
            */
            
        } catch(PDOException $e){
            die('[User::GetByEmailPassword] PDO Error: '.$e->getMessage());
        }
        
    }


	// Gets a user for a specific token
	public static function GetByToken($token, $userId){

        try{
        
    		$db = DB::get();
            
            $q = "SELECT roles_id, users_id, users_name, users_password, users_email, users_status
        			FROM wdb_users WHERE token=? AND users_id=?";
                    
            $s = $db->prepare($q);
            $s->bindParam(1, $token);
            $s->bindParam(2, $userId);
            
            $s->execute();
            
            $row = $s->fetch(PDO::FETCH_ASSOC);        
    
    		if($row){
    			return $row;
    		}
        
        } catch(PDOException $e){
            die('[User::GetByToken] PDO Error: '.$e->getMessage());
        }
        
	}

}

?>