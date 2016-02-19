<?php
/**
 * author: xueli
 * date: 2016-1-26 created
 * 常用工具函数，为了方便代码管理，Utilities 的函数中不要使用 try catch 丢出异常。将异常放到Data和Rest层去。
 **/
use \Firebase\JWT\JWT;
class Utilities
{
    // create JWT token, #ref: https://github.com/firebase/php-jwt, https://auth0.com/blog/2014/01/07/angularjs-authentication-with-cookies-vs-token/
    public static function CreateJWTToken($userId){
	    
	    // create token
		$token = array(
		    'UserId' => $userId,
		    'Expires' => (strtotime('NOW') + (3*60*60)) // expires in an hour
		);
		
		// create JWT token, #ref: https://github.com/firebase/php-jwt
		$jwt_token = JWT::encode($token, JWT_KEY);
		
		// return token
		return $jwt_token;
    }

    // uses curl to execute and retrieve the response from a URL
	public static function GetJsonData($url, $assoc){
		$ch = curl_init();

	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_URL, $url);

	    $data = curl_exec($ch);
	    $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    curl_close($ch);

	    if ($resultCode == 200) {
	        return json_decode($data, $assoc);
	    } else {
	        return false;
	    }
	}

	// 从文件获取Json
	// 如果成功返回 Array 
	public static function GetJsonDataFile($file){
		// Read the file contents into a string variable,
		// and parse the string into a data structure
		$str_data = file_get_contents($file);
		
		if ($str_data){
			return json_decode($str_data,true);

		}else{	//return false
			return false;
		}
		
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