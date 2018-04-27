<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
//用户模块

//注册路由
Route::rule('api/user/register','index/users/register');
//登录路由
Route::rule('api/user/login','index/users/login');
//改密路由
Route::rule('api/user/updatepassword','index/users/updatepassword');
//保存用户信息详情路由
Route::rule('api/user/saveuserinfo','index/users/saveuserinfo');
//查询单个用户的详情
Route::rule('api/user/queryone','index/users/queryone');
//上传图片
Route::rule('api/user/uploads','index/users/upload');



//商品模块

//发布商品
Route::rule('api/goods/saveGoods','index/goods/saveGoods');
//查询商品
Route::rule('api/goods/queryAllGoods','index/goods/queryAllGoods');
//查询发布者发布的商品
Route::rule('api/goods/queryPublishedGoods','index/goods/queryPublishedGoods');
//根据商品id查询商品详情
Route::rule('api/goods/queryGoodsDetail','index/goods/queryGoodsDetail');
//开始竞价
Route::rule('api/goods/auction','index/goods/auction');
//用户查询自己拍到的商品
Route::rule('api/goods/queryGetGoods','index/goods/queryGetGoods');


//管理员模块

//查询所有的用户信息
Route::rule('api/admin/queryAllUser','index/admin/queryAllUser');
//根据id删除人员信息
Route::rule('api/admin/deleteUserById','index/admin/deleteUserById');
//根据id查看人员信息
Route::rule('api/admin/queryUserById','index/admin/queryUserById');
//查询所有拍品信息
Route::rule('api/admin/queryAllGoods','index/admin/queryAllGoods');
//根据id查看拍品信息
Route::rule('api/admin/queryGoodsById','index/admin/queryGoodsById');
//根据id修改拍品信息
Route::rule('api/admin/updateGoodsById','index/admin/updateGoodsById');
//根据id删除拍品信息
Route::rule('api/admin/deleteGoodsById','index/admin/deleteGoodsById');
//新增拍品信息

//查询拍品类别
Route::rule('api/admin/queryGoodsType','index/admin/queryGoodsType');
//根据id查询拍品类别
Route::rule('api/admin/queryGoodsTypeById','index/admin/queryGoodsTypeById');
//修改拍品类别
Route::rule('api/admin/updateGoodsTypeById','index/admin/updateGoodsTypeById');
//删除拍品类别

//新增拍品类别














// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],
//     '[hello]'     => [
//         ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//         ':name' => ['index/hello', ['method' => 'post']],
//     ],

// ];
