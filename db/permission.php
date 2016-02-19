<?php
// permission 的信息放到 /data/permission.json 数据中保存，没有放到数据库
// permission.json 因为是后台，可以不考虑性能问题。
// 整个权限系统使用 phprbac （用户－角色－权限模型），参考 http://www.phprbac.net
// 为了简化整个系统，Role和 Permission 只保留了层
class Permission{

	//获得整个Permission清单。为了简单期间，我们的Permission只保留一级。
	public static function getPermissionList(){

		$permissionList = Utilities::GetJsonDataFile(DOCUMENT_ROOT.'/data/permission.json');
		
		return $permissionList;

		// if($permissionList != false){
		// 	return $permissionList;

		// }else{ //return false
		// 	die( '[Permission::getPermissionList] JSON Error: '.DOCUMENT_ROOT.'/data/permission.json has issue.');
		// }
		
	}
}
?>