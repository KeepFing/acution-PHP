<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;


class Goods extends Controller
{

	//用户发布商品信息

	public function saveGoods(){
		$goods_id = md5(uniqid((mt_rand()),true));
		$goods_name = Request::instance()->post('goods_name');
		$user_id = Request::instance()->post('userid');
		$initprice = Request::instance()->post('initprice');
		$finnalprice = Request::instance()->post('finnalprice');
		$appendtime = Request::instance()->post('appendtime');

		$row = Db::execute('insert into goods_t(goods_id,goods_name,initprice,finnalprice,appendtime) values(:goods_id,:goods_name,:initprice,:finnalprice,:appendtime)',['goods_id'=>$goods_id,'goods_name'=>$goods_name,'initprice'=>$initprice,'finnalprice'=>$finnalprice,'appendtime'=>$appendtime]);
		if ($row == 1) {
			$row1 = Db::execute('insert into user_goods_t(user_id,goods_id)  values(:user_id,:goods_id)',['user_id'=>$user_id,'goods_id'=>$goods_id]);
			if ($row == 1) {
				$obj = array('code' => '0','msg' => '新增拍品成功');
			} else {
				$obj = array('code' => '1', 'msg' => '新增失败');
			}
			
		} else {
			$obj = array('code' => '1', 'msg' => '新增失败');
		}
		return json($obj);
	}


	//查询所有的商品

	public function queryAllGoods(){

		$page = Request::instance()->post('page');
		$limit = Request::instance()->post('limit');
		$left = ($page*$limit)-($limit*1);
		$right = (1*$limit);
		$data = Db::query('select * from goods_t order by appendtime desc limit :left,:right',['left'=>$left,'right'=>$right]);

		$obj = array('code' => '0', 'data' => $data ,'msg' => '查询成功');

		return json($obj);
	}

	//用户查看个人的发布商品信息

	public function queryPublishedGoods(){

		$user_id = Request::instance()->post('userid');
		$page = Request::instance()->post('page');
		$limit = Request::instance()->post('limit');
		$left = ($page*$limit)-($limit*1);
		$right = (1*$limit);
		$list = Db::query('select * from goods_t,user_goods_t where goods_t.goods_id=user_goods_t.goods_id and user_id=:user_id limit :left,:right',['user_id'=>$user_id,'left'=>$left,'right'=>$right]);
		$total = Db::query('select count(*) as count from goods_t,user_goods_t where goods_t.goods_id=user_goods_t.goods_id and user_id=:user_id',['user_id'=>$user_id]);
		$data = array('list' => $list,'total'=>$total[0] );
		$obj = array('code' => '0', 'data' => $data,'msg' => '查询成功');
		return json($obj);
	}

	//根据商品id查询商品详情

	public function queryGoodsDetail(){
		$goods_id = Request::instance()->post('goods_id');
		$data = Db::query('select * from goods_t g,user_goods_t ug,user_t u where g.goods_id=ug.goods_id and u.user_id=ug.user_id and g.goods_id=:goods_id',['goods_id'=>$goods_id]);
		$obj = array('code' => '0','data'=>$data,'msg'=>'查询成功' );
		return json($obj);
	}

	//开始竞拍

	public function auction(){
		$goods_id = Request::instance()->post('goods_id');
		$user_id = Request::instance()->post('user_id');
		$row = Db::execute('update user_goods_t set auction_user_id = :auction_user_id where goods_id = :goods_id',['auction_user_id'=>$user_id,'goods_id'=>$goods_id]);
		if ($row == 1) {
			$obj = array('code' => '0','msg'=>'竞价成功' );
		} else {
			$obj = array('code' => '1','msg'=>'竞价失败' );
		}
		return json($obj);
	}

	//用户查询自己拍到的商品

	public function queryGetGoods(){
		$user_id = Request::instance()->post('user_id');
		$page = Request::instance()->post('page');
		$limit = Request::instance()->post('limit');
		$list = Db::query('select * from user_goods_t ug,goods_t g where ug.goods_id=g.goods_id and ug.auction_user_id=:auction_user_id limit :left,:right',['auction_user_id'=>$user_id,'left'=>$left,'right'=>$right]);
		$total = Db::query('select count(*) as count from user_goods_t ug,goods_t g where ug.goods_id=g.goods_id and ug.auction_user_id=:auction_user_id',['auction_user_id'=>$user_id]);
		$obj = array('code' => '0','data'=>$total,'msg'=>'查询成功' );
		return json($obj);
	}
}
