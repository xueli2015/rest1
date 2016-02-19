<?php
use \Firebase\JWT\JWT;
class Token
{
	// create JWT token, #ref: https://github.com/firebase/php-jwt, https://auth0.com/blog/2014/01/07/angularjs-authentication-with-cookies-vs-token/
    public static function CreateJWTToken($userId, $siteId){
	    
	    // create token
		$token = array(
		    'UserId' => $userId,
		    'SiteId' => $siteId,
		    'Expires' => (strtotime('NOW') + (3*60*60)) // expires in an hour
		);
		
		// create JWT token, #ref: https://github.com/firebase/php-jwt
		$jwt_token = JWT::encode($token, JWT_KEY);
		
		// return token
		return $jwt_token;
    }
    
    // validate JWT token
    public static function ValidateJWTToken(){

		$auth = isset($_SERVER['HTTP_X_AUTH']) ? $_SERVER['HTTP_X_AUTH'] : '';

		// locate token
		if(strpos($auth, 'Bearer') !== false){
		
			$jwt = str_replace('Bearer ', '', $auth);
			
			try{
			
				// decode token
				$jwt_decoded = JWT::decode($jwt, JWT_KEY, array('HS256'));
				
				if($jwt_decoded != NULL){
					
					// check to make sure the token has not expired
					if(strtotime('NOW') < $jwt_decoded->Expires){
						return $jwt_decoded;
					}
					else{
						return NULL;
					}
					
				}
				else{
					return NULL;
				}
			
				// return token
				return $jwt_decoded;
			
			} catch(Exception $e){
				return NULL;
			}
						
		}
		else{
			return NULL;
		}
				
    }

}
?>