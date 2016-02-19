<?php
/**
 * A protected API call to login a user
 * @uri /user/login
 */
class UserLoginResource extends Tonic\Resource {

	/**
     * @method POST
     */
    function login() {
        // parse request
        parse_str($this->request->data, $request);

        $user_name = $request['user_name'];
        $password = $request['password'];
                       
        // get the user from the credentials
        $user = User::GetByUserNamePassword($user_name, $password);
        
        // determine if the user is authorized
        $is_auth = false;
        
        // permissions
        if($user!=null){
            //set permissions arrary
            //$menu = User::GetMenuPermissionByEmail($email);

            $is_auth = true;                            
        }
        else{
            // return an unauthorized exception (401)
            $response = new Tonic\Response(Tonic\Response::UNAUTHORIZED);
            $response->body = 'Access denied';
            return $response;
        }

        // login if authorized
        if($is_auth = true){
            
            try{
            
                $fullPhotoUrl = '';
                                
                // set last login
                //User::SetLastLogin($user['users_id']);
            
                // return a subset of the user array
                /*
                $returned_user = array(
                    'roles_id' => $user['roles_id'],
                    'FirstName' => $user['FirstName'],
                    'LastName' => $user['LastName'],
                    'PhotoUrl' => $user['PhotoUrl'],
                    'FullPhotoUrl' => $fullPhotoUrl,
                    'Language' => $user['Language'],
                    'Role' => $user['Role'],
                    'SiteAdmin' => $user['SiteAdmin'],
                    'SiteId' => $user['SiteId'],
                    'UserId' => $user['UserId'],
                    'CanEdit' => $canEdit,
                    'CanPublish' => $canPublish,
                    'CanRemove' => $canRemove,
                    'CanCreate' => $canCreate,
                    'CanView' => $canView
                );*/
            
            
                // send token
                $params = array(
                    'user' => $user,
                    'token' => Utilities::CreateJWTToken($user['users_id'])
                );
                
                // return a json response
                $response = new Tonic\Response(Tonic\Response::OK);
                $response->contentType = 'application/json';
                $response->body = json_encode($params);
            
            }
            catch (Exception $e) {
                $response = new Tonic\Response(Tonic\Response::UNAUTHORIZED);
                $response->body = $e->getMessage();
                return $response;
            }
            
            return $response;
        }
        else{
            // return an unauthorized exception (401)
            $response = new Tonic\Response(Tonic\Response::UNAUTHORIZED);
            $response->body = 'Access denied';
            return $response;
        }
    }        
}


/**
 * A protected API call to login a user
 * @uri /user/forget
 * @foo
 */
class ForgetResource extends Tonic\Resource {

	/**
     * @method POST
     */
    function forget() {

    }

    function foo(){
        
    }


}

?>