<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;

header("Access-Control-Allow-Origin: *");
class Users extends Controller
{
	//登录功能
	public function login(){

		$username = Request::instance()->post('username');
		$password = md5(Request::instance()->post('password'));
		$res = Db::query('select count(*) as count from user_t where username=:username and password=:password',['username' => $username,'password' => $password]);
		if ($res[0]['count'] == 1) {
			$obj = array('code' => '0', 'msg' => '登录成功');
			return json($obj);
		} else {
			$obj = array('code' => '1', 'msg' => '用户名或密码错误');
			return json($obj);
		}
	}
	//注册功能
	public function register(){
		$userid = md5(uniqid((mt_rand()),true));
		$username = Request::instance()->post('username');
		$password = md5(Request::instance()->post('password'));
		$realname = Request::instance()->post('realname');
		$sex = md5(Request::instance()->post('sex'));
		$phone = Request::instance()->post('phone');
		$address = md5(Request::instance()->post('address'));
		$email = Request::instance()->post('email');
		$idcard = md5(Request::instance()->post('idcard'));
		$res = Db::query('select count(*) as count from user_t where username=:username',['username' => $username]);
		if ($res[0]['count'] == 1) {
			$obj = array('code' => '0', 'msg' => '用户名已存在');
			return json($obj);
		} else {
			$row = Db::execute('insert into user_t values(:id,:username,:password,:realname,:sex,:phone,:address,:email,:idcard)',['id'=>$userid,'username'=>$username,'password'=>$password,'realname'=>$realname,'sex'=>$sex,'phone'=>$phone,'address'=>$address,'email'=>$email,'idcard'=>$idcard]);
			if($row == 1){
				$res = array('code' => '0','msg' => '注册成功' );
				return json($res);
			}else{
				$res = array('code' => '1','msg' => '注册失败' );
				return json($res);
			}
		}		
	}

	//修改密码功能
	public function updatepassword(){
		$userid = Request::instance()->post('id');
		$oldpassword = md5(Request::instance()->post('oldpassword'));
		$newpassword = md5(Request::instance()->post('newpassword'));
		
		$res = Db::query('select count(*) as count from user_t where user_id=:userid and password=:password',['userid' => $userid,'password' => $oldpassword]);
		if ($res[0]['count'] != 1) {
			$obj = array('code' => '1','input' => $res[0]['count'], 'msg' => '旧密码不正确');
			return json($obj);
		} else {
			$row = Db::execute('update user_t set password=:password where user_id=:userid',['password'=>$newpassword,'userid'=> $userid]);
			if ($row == 1) {
				$obj = array('code' => '0','msg' => '改密成功' );
				return json($obj);
			} else {
				$obj = array('code' => '1','msg' => '改密失败' );
				return json($obj);
			}
		}
	}
	//修改用户信息

	public function saveuserinfo(){
		$id = Request::instance()->post('id');
		$username = Request::instance()->post('username');
		$realname = Request::instance()->post('realname');
		$sex = Request::instance()->post('sex');
		$phone = Request::instance()->post('phone');
		$address = Request::instance()->post('address');
		$email = Request::instance()->post('email');
		$idcard = Request::instance()->post('idcard');

		$row = Db::execute('update user_t set username=:username,sex=:sex,realname=:realname,phone=:phone,address=:address,email=:email,idcard=:idcard where user_id=:id',['id' => $id,'username' => $username,'sex' => $sex,'realname' => $realname,'phone' => $phone,'email' => $email,'address' => $address,'idcard'=>$idcard]);
		if ($row == 1) {
			$obj = array('code' =>'0' ,'msg' => '保存信息成功' );
			return json($obj);
		} else {
			$obj = array('code' =>'1' ,'msg' => '保存信息失败' );
			return json($obj);
		}
		
	}
	//查询用户信息
	public function queryone(){
		$id = Request::instance()->post('id');
		$data = Db::query('select user_id,username,realname,sex,phone,address,email,idcard from user_t where user_id=:id',['id' => $id]);
		if ($data == null) {
			$obj = array('code' => '0', 'data' => $data , 'msg' => '没有查询到相关信息');
		} else {
			$obj = array('code' => '1', 'data' => $data , 'msg' => '查询成功');
		}
		
		return json($obj);

	}

	//上传图片
	public function upload(){
		
		$file = request()->file('image');
    
	    // 移动到框架应用根目录/public/uploads/ 目录下
	    if($file){
	        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
	        if($info){
	            // 成功上传后 获取上传信息
	            // 输出 jpg
	            //$address = $info->getExtension();
	            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
	            //$address = $info->getSaveName();
	            // 输出 42a79759f284b767dfcb2a0197904287.jpg
	            $obj = array('name' => $info->getSaveName());
	            return json($obj);
	        }else{
	            // 上传失败获取错误信息
	            echo $file->getError();
	        }
	    }
	}
}
