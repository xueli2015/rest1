<?php

/**
 * 获得单一用户信息
 * @uri /customer/{customerId}
 */
class CustomerResource extends Tonic\Resource {

    /**
     * @method GET
     */
    function get($customerId) {
        // get token
		$token = Utilities::ValidateJWTToken();

		// check if token is not null
        if($token != NULL){ 
			
			$customer = Customer::GetByCustomerId($customerId);			

            // return a json response
            $response = new Tonic\Response(Tonic\Response::OK);
            $response->contentType = 'application/json';
            $response->body = json_encode($customer);

            return $response;
        }
        else{
            return new Tonic\Response(Tonic\Response::UNAUTHORIZED);
        }
    
    }
}

?>