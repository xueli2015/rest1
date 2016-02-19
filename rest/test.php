<?php

/**
 * @uri /test
 */
class TestResource extends Tonic\Resource {

    /**
     * @method GET
     */
    function testMethod() {
        //echo $this->request->userAgent;
        //echo json_encode(Utilities::GetJsonDataFile(DOCUMENT_ROOT.'/data/permission.json'));
        echo json_encode(Permission::getPermissionList());
    }

    /**
     * @method POST
     */
    function testPostMethod() {
        echo $this->request->userAgent;
    }

}
?>