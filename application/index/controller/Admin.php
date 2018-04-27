<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;

/**
* 
*/
class Admin extends Controller
{
	//查询所有的用户信息
	public function queryAllUser(){
		$realname = Request::instance()->post('realname');
		$sex = Request::instance()->post('sex');
		$page = Request::instance()->post('page');
		$limit = Request::instance()->post('limit');
		$left = ($page*$limit)-($limit*1);
		$right = (1*$limit);
		$data = Db::query('select * from user_t limit :left,:right',['left'=>$left,'right'=>$right]);
		$obj = array('code' => '0','data'=>$data,'msg'=>'查询成功');
		return json($obj);
	}

	//根据id删除人员信息

	public function deleteUserById(){
		$user_id = Request::instance()->post('user_id');
		$row = Db::execute('delete from user_t where user_id=:user_id',['user_id'=>$user_id]);
		if ($row == 1) {
			$obj = array('code' => '0', 'msg'=>'删除成功');
		} else {
			$obj = array('code' => '1', 'msg'=>'删除失败');
		}
		return json($obj);
	}

	//根据id查看人员信息

	public function queryUserById(){
		$user_id = Request::instance()->post('user_id');
		$data = Db::query('select * from user_t where user_id=:user_id',['user_id'=>$user_id]);
		$obj = array('code' =>'0','data'=>$data,'msg'=>'查询成功');
		return json($obj);
	}

	//查询所有拍品信息

	public function queryAllGoods(){
		$page = Request::instance()->post('page');
		$limit = Request::instance()->post('limit');
		$left = ($page*$limit)-($limit*1);
		$right = (1*$limit);
		$data = Db::query('select * from goods_t g,goods_type_t g_t,goodstype_t gt where g.goods_id = g_t.goods_id and gt.type_id = g_t.type_id limit :left,:right',['left'=>$left,'right'=>$right]);
		$obj = array('code' => '0', 'data' => $data,'msg'=>'查询成功');
		return json($obj);
	}
	//根据id查看拍品信息

	public function queryGoodsById(){
		$id = Request::instance()->post('goodsId');
		$data = Db::query('select * from goods_t g,goods_type_t g_t,goodstype_t gt where g.goods_id = g_t.goods_id and gt.type_id = g_t.type_id and g.goods_id = :id',['id'=>$id]);
		if ($data == null) {
			$obj = array('code' => '0', 'data' => $data , 'msg' => '没有查询到相关信息');
		} else {
			$obj = array('code' => '1', 'data' => $data , 'msg' => '查询成功');
		}
		return json($obj);
	}

	//根据id修改拍品信息

	public function updateGoodsById(){
		$id = Request::instance()->post('goodsId');
		$goodsName = Request::instance()->post('goodsName');
		$initPrice = Request::instance()->post('initPrice');
		$finnalPrice = Request::instance()->post('finnalPrice');
		$row = Db::execute('UPDATE goods_t SET goods_name = :goodsName,initprice = :initprice, finnalprice = :finnalprice WHERE goods_id = :goods_id',['goodsName'=>$goodsName,"initprice"=>$initPrice,"finnalprice"=>$finnalPrice,'goods_id'=>$id]);
		if ($row == 1) {
			$obj = array('code' => '0', 'msg'=>'修改成功');
		} else {
			$obj = array('code' => '1', 'msg'=>'修改失败');
		};
		return json($obj);
	}


	//根据id删除拍品信息

	public function deleteGoodsById(){
		$id = Request::instance()->post('goodsId');
		Db::startTrans();
		try{
			$row1 = Db::execute('delete from goods_t where goods_id = :goods_id',['goods_id'=>$id]);
			$row2 = Db::execute('delete from goods_type_t where goods_id = :goods_id',['goods_id'=>$id]);
		    // 提交事务
		    Db::commit();    
		} catch (\Exception $e) {
		    // 回滚事务
		    Db::rollback();
		};
		if ($row2 == 1) {
			$obj = array('code' => '0', 'msg'=>'删除成功');
		} else {
			$obj = array('code' => '1', 'msg'=>'删除失败');
		};
		return json($obj);	
	}


	//新增拍品信息

	//查询拍品类别

	public function queryGoodsType(){
		$page = Request::instance()->post('page');
		$limit = Request::instance()->post('limit');
		$left = ($page*$limit)-($limit*1);
		$right = (1*$limit);
		$data = Db::query('select * from goodstype_t limit :left,:right',['left'=>$left,'right'=>$right]);
		if ($data == null) {
			$obj = array('code' => '0', 'data' => $data , 'msg' => '没有查询到相关信息');
		} else {
			$obj = array('code' => '1', 'data' => $data , 'msg' => '查询成功');
		}
		return json($obj);
	}

	//根据id查询拍品类别

	public function queryGoodsTypeById(){
		$id = Request::instance()->post('typeId');
		$data = Db::query('select * from goodstype_t where type_id = :id',['id'=>$id]);
		if ($data == null) {
			$obj = array('code' => '0', 'data' => $data , 'msg' => '没有查询到相关信息');
		} else {
			$obj = array('code' => '1', 'data' => $data , 'msg' => '查询成功');
		}
		return json($obj);
	}


	//修改拍品类别

	public function updateGoodsTypeById(){
		$id = Request::instance()->post('typeId');
		$row = Db::execute('update goodstype_t set type = :typeName,reamrk = :reamrk where type_id = :id',['typeName'=>$typeName,'reamrk'=>$reamrk,'id'=>$id]);
		if ($row1 == 1) {
			$obj = array('code' => '0', 'msg'=>'修改成功');
		} else {
			$obj = array('code' => '1', 'msg'=>'修改失败');
		};
		return json($obj);	
	}

	//删除拍品类别

	public function deleteGoodsTypeById(){
		$id = Request::instance()->post('typeId');
		$row = Db::execute('delete from goodstype_t where type_id = :id',['id'=>$id]);
		if($row == 1){
			$obj = array('code' => '0' , 'msg' => '删除成功');
		}
	}
	
	//新增拍品类别
}