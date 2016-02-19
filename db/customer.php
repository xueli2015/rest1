<?php
// Customers DAO
class Customer{

	//gets a customer for a specific $customerId
	//public static function GetByCustomerId($customerId) : $row



	//gets a customer for a specific $customerId
	public static function GetByCustomerId($customerId){
        try{
        
            $db = DB::get();
            
            $q = "SELECT customer_id, customer_gender, customer_name, customer_firstname, customer_lastname, customer_company, customer_idno, customer_dob, customer_email_address, customer_default_address_id, customer_telephone, customer_fax, customer_password, customer_newsletter, customer_hearfrom, customer_referredby, customer_type_id, guest_flag, uuid_for_find_password, last_order_purchase_date,has_complete_order, last_complete_order_date, has_fraud_order, last_faud_order_date, has_charge_back_order, last_charge_back_order_date, country_name, channel_id, edmstatus, facebook_user_id, customer_source, agent
            		FROM wdb_customer
        		 	WHERE customer_id=?";
                    
            $s = $db->prepare($q);
            $s->bindParam(1, $customerId);
            
            $s->execute();
            
            $row = $s->fetch(PDO::FETCH_ASSOC);        
    
    		if($row){
    			return $row;
    		}
        
        } catch(PDOException $e){
            die('[Customer::GetByCustomerId] PDO Error: '.$e->getMessage());
        }

	}

    /**
     * {customer_id, b, c}
     */
    public static function GetCustomersInfo($fields){

        switch ()
        case 'customer_id' fields .= 'l.customer_id customer_id';

        $q =    fields .
                "    FROM wdb_customer c, wdb_log l
                    WHERE customer_id=?";
    }
}
?>