<?php
/**
 * @uri /example
 */
class ExampleResource extends Tonic\Resource {

    /**
     * @method GET
     * List
     */
    function exampleMethod() {
        //echo $this->request->userAgent;
        //echo json_encode(Utilities::GetJsonDataFile(DOCUMENT_ROOT.'/data/permission.json'));
        echo json_encode(Permission::getPermissionList());
    }

    /**
     * @method POST
     * insert
     */
    function examplePostMethod() {
        
        $response = new Tonic\Response(Tonic\Response::CREATED); //201
        $response->contentType = 'application/json';
        $response->body = json_encode($params);

        return $response;
    }

    /**
     * @method PUT
     * update all
     */
    function examplePutMethod() {
        echo $this->request->userAgent;
    }

    /**
     * @method PATCH
     * update where
     */
    function examplePatchMethod(){
        echo $this->request->userAgent;   
    }

    /**
     * @method DELETE
     * delete
     */
    function exampleDeleteMethod(){
        echo $this->request->userAgent;
    }

    /*

    const
        OK                              = 200,
        CREATED                         = 201,
        ACCEPTED                        = 202,
        NONAUTHORATIVEINFORMATION       = 203,
        NOCONTENT                       = 204,
        RESETCONTENT                    = 205,
        PARTIALCONTENT                  = 206,

        MULTIPLECHOICES                 = 300,
        MOVEDPERMANENTLY                = 301,
        FOUND                           = 302,
        SEEOTHER                        = 303,
        NOTMODIFIED                     = 304,
        USEPROXY                        = 305,
        TEMPORARYREDIRECT               = 307,

        BADREQUEST                      = 400,
        UNAUTHORIZED                    = 401,
        PAYMENTREQUIRED                 = 402,
        FORBIDDEN                       = 403,
        NOTFOUND                        = 404,
        METHODNOTALLOWED                = 405,
        NOTACCEPTABLE                   = 406,
        PROXYAUTHENTICATIONREQUIRED     = 407,
        REQUESTTIMEOUT                  = 408,
        CONFLICT                        = 409,
        GONE                            = 410,
        LENGTHREQUIRED                  = 411,
        PRECONDITIONFAILED              = 412,
        REQUESTENTITYTOOLARGE           = 413,
        REQUESTURITOOLONG               = 414,
        UNSUPPORTEDMEDIATYPE            = 415,
        REQUESTEDRANGENOTSATISFIABLE    = 416,
        EXPECTATIONFAILED               = 417,
        IMATEAPOT                       = 418, // RFC2324

        INTERNALSERVERERROR             = 500,
        NOTIMPLEMENTED                  = 501,
        BADGATEWAY                      = 502,
        SERVICEUNAVAILABLE              = 503,
        GATEWAYTIMEOUT                  = 504,
        HTTPVERSIONNOTSUPPORTED         = 505;
    */


}

/**
 * 初始化menu数据，用于测试
 * @uri /example/init/menu
 **/
class ExampleInitResource extends Tonic\Resource{

    /**
     * @method GET
     */
    function exampleInitMenu(){

        $rbac = new PhpRbac\Rbac();

        // 权限置空
        //Warning: This method removes all Roles, Permissions and Assignments from the database. Usually used for testing purposes.
        $rbac->reset(true);

        // {
        //     "permission":[
        //         {"name":"OrderFullList", "description":"Can list all orders from all channels.", "param":""},
        //         {"name":"OrderListEbay", "description":"Can List all orders from ebay. Params are channels id.", "param":""}
        //     ]
        // }

        // 根据 data/permission.json 和 role.json 产生基础数据
        $permissions = Permission::getPermissionList();

        foreach($permissions['permission'] as $_permission){
            echo($_permission['name']);
        }

        // 对 role 设置 permission

        // 向userid进行设置 role

    }

}


/**
 * 测试HTTP返回. 根据HTTP返回的status客户端进行对应处理。
 * API 端如果认为正确的数据输出，就返回 200， 如果API已经认为错误，可以向客户端输出 
 * 500错误；如果认为客户端无权限, 可以返回 500，返回的错误文字信息，依然可以放到 response的body部分。
 * @uri /example/http/:status
 * 例子：前台的URL可能是 http://YOURURL/example/http/OK 会返回 HTTP 200，并显示{"message":"successful"}
 * states 可以参考 https://github.com/peej/tonic/blob/master/src/Tonic/Response.php
 * 常用的返回
 * OK                              = 200, //能够正常返回
 * UNAUTHORIZED                    = 401, //没有访问权限，Token验证不成功
 * INTERNALSERVERERROR             = 500, //服务器内部错误，可以反映后台API存在错误
 **/
class ExampleHttpResource extends Tonic\Resource{

    /**
     * @method GET
     */
    function exampleHttp(){
        switch($this->status){
            case 'OK':
                $response = new Tonic\Response(Tonic\Response::OK);
                $response->contentType = 'application/json';
                $response->body = '{"message":"successful"}';
                break;
            case 'UNAUTHORIZED':
                $response = new Tonic\Response(Tonic\Response::UNAUTHORIZED);
                $response->contentType = 'application/json';
                $response->body = '{"message":"you don\'t have authorized. check your token."}';
                break;
            case 'INTERNALSERVERERROR':
                $response = new Tonic\Response(Tonic\Response::INTERNALSERVERERROR);
                $response->contentType = 'application/json';
                $response->body = '{"message":"there are some wrong in system."}';
                break;
            default:
                $response = new Tonic\Response(Tonic\Response::NOTFOUND);
                $response->contentType = 'application/json';
                $response->body = '{"message":"what happen?"}';
        }

        //return $this->status;
        return $response;
    }
}


/**
 * 检查Token是否存在，如果存在显示Token的值和所带的参数，如果不存在将返回一个 401 错误.
 * @uri /example/test
 */
class ExampleTestTokenResource extends Tonic\Resource{
	/**
	 * @method GET
	 */
	function get(){
        // get token
		$token = Utilities::ValidateJWTToken();

		// check if token is not null
        if($token != NULL){

        	$params = array(
        		'Token'=>$token,
        		'TokenCode' => $_SERVER['HTTP_X_AUTH'],
        		'Params'=>$_GET
        	);

            // return a json response
            $response = new Tonic\Response(Tonic\Response::OK);
            $response->contentType = 'application/json';
            $response->body = json_encode($params);

            return $response;
        }
        else{
            return new Tonic\Response(Tonic\Response::UNAUTHORIZED);
        }

	}

	/**
	 * @method POST
	 */
	function post(){
        // get token
		$token = Utilities::ValidateJWTToken();

		// check if token is not null
        if($token != NULL){

        	$params = array(
        		'Token'=>$token,
        		'TokenCode' => $_SERVER['HTTP_X_AUTH'],
        		'Params'=>$_POST
        	);

            // return a json response
            $response = new Tonic\Response(Tonic\Response::OK);
            $response->contentType = 'application/json';
            $response->body = json_encode($params);

            return $response;
        }
        else{
            return new Tonic\Response(Tonic\Response::UNAUTHORIZED);
        }

	}
}

/**
 * 获得一个测试用的Token值。
 * 如果要在客户端使用的话，在Authorization请求头设置这样的格式 ［X-AUTH: Bearer TOKENCODE]
 * @uri /example/token
 */
class ExampleTokenResource extends Tonic\Resource {
	/**
	 * @method GET
	 */
	function get(){
		// send token
        $params = array(
            'token' => Utilities::CreateJWTToken(0)
        );
        
        // return a json response
        $response = new Tonic\Response(Tonic\Response::OK);
        $response->contentType = 'application/json';
        $response->body = json_encode($params);

        return $response;

	}
}

/**
 * 获得服务器信息
 * @uri /example/server
 **/
class ExampleServerResource extends Tonic\Resource {

	/**
	 * @method GET
	 */
	function get(){
	    $params = $_SERVER;
        
        // return a json response
        $response = new Tonic\Response(Tonic\Response::OK);
        $response->contentType = 'application/json';
        $response->body = json_encode($params);

        return $response;
	}
}


?>