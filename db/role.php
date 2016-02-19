<?php
// role的信息放到 /data/role.json 数据中保存，没有放到数据库
// role.json 因为是后台，可以不考虑性能问题。
// 整个权限系统使用 phprbac （用户－角色－权限模型），参考 http://www.phprbac.net
// 为了简化整个系统，Role和Permission只保留了层
class Role{

	//获得整个Role清单。为了简单期间，我们的Role只保留一级。
	public static function getRoleList(){

		$roleList = Utilities::GetJsonDataFile(DOCUMENT_ROOT.'/data/role.json');
		
		return $roleList;

	}
}
?>