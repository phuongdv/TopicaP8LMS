<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Acl
 * Access Control list
 * @author CaoPV <vancao.vn@gmail.com>
 */
class Acl
{
	/**
	 * Check quyền quản trị
	 */
	function isAdmin(){

	}

	/**
	 * Check quyền sinh viên
	 */
	function isStudent(){

	}

	function check(){
		require_once 'interaction_base_web.php';
		$interaction_base_web=new Interaction_base_web();
		var_dump($interaction_base_web->hello());
	}

	function check2(){

		require_once 'interaction_base_web.php';
		$interaction_base_web=new Interaction_base_web();
		$interaction_base_web->hello();


//check roleid
		/*function checkRoleID($userid){
			global $CFG;
			$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);

			$mysqli->select_db($CFG->dbname);

			$mysqli->query("SET NAMES 'utf8'");

			$sqlRole="SELECT DISTINCT r.id roleid
  FROM mdl_user u
  INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
  INNER JOIN mdl_context ct ON ct.id = ra.contextid
  INNER JOIN mdl_course c ON c.id = ct.instanceid
  INNER JOIN mdl_role r ON r.id = ra.roleid
  INNER JOIN mdl_course_categories cc ON cc.id = c.category

  WHERE u.id =$userid
  limit 0,1";

			$OneRole = $mysqli->query($sqlRole);

			if (mysqli_num_rows($OneRole) > 0){
				while($vv = $OneRole->fetch_assoc())
				{
					$roleid=$vv['roleid'];

				}
				return $roleid;
			}
			else {
				return 0;
			}*/
	}
}