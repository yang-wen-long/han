<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//登录的数据库
use App\Model\Users;
use App\Model\Token;
//COOKIE
use Illuminate\Support\Facades\Cookie;
//REDIS
use Illuminate\Support\Facades\Redis;
class UserController extends Controller
{
    /**
     *用户注册
     * @param Request $request
     */
    public function reg(Request $request){
            //这个是接过来的参数去除那个
            //$name = request()->except("_token");
            //用户名
            $name = $request->input("name");
            //邮箱
            $email = $request->input("email");
            //密码
            $pass1 = $request->input("password");
            //确认密码
            $pass2 = $request->input("pwd");
            //添加时间
            $time= time();
            //*********************验证用户填写的是否为空
            if(empty($name)){
                $response = [
                    "error" => 50001,
                    "msg"   => "用户名不能为空"
                ];
                return $response;
            }
            if(empty($email)){
                $response = [
                    "error" => 50002,
                    "msg"   => "Email不能为空"
                ];
                return $response;
            }
            if(empty($pass1)){
                $response = [
                    "error" => 50003,
                    "msg"   => "密码不能为空"
                ];
                return $response;
            }
            if(empty($pass2)){
                $response = [
                    "error" => 50004,
                    "msg"   => "确认密码不能为空"
                ];
                return $response;
            }
            //长度
            $len=strlen($pass1);
            //判断是否长度大于6位
            if($len < 4){
                $response = [
                    "error" => 50005,
                    "msg"   => "密码长度必须大于4位"
                ];
                return $response;
            }
            if($pass1 != $pass2){
                $response = [
                    "error" => 50006,
                    "msg"   => "请把密码和确认密码必须保持一致"
                ];
                return $response;
            }
            //**********************验证数据库是否存在
            $desc=Users::where("user_name",$name)->get()->toArray();
            if($desc){
                $response = [
                    "error" => 50007,
                    "msg"   => "用户名已存在，请跟换用户名"
                ];
                return $response;
            }
            $desc=Users::where("email",$email)->get()->toArray();
            if($desc){
                $response = [
                    "error" => 50008,
                    "msg"   => "Email已存在，请跟换Email"
                ];
                return $response;
            }
            //*********************结束验证用户填写的是否为空
            $password = password_hash($pass1,PASSWORD_BCRYPT);
            $data=[
                "user_name" => $name,
                "email" => $email,
                "password" => $password,
                "reg_time" => $time,
            ];
            $red = Users::insert($data);
            if($red){
                $response = [
                    "error" => 0,
                    "msg"   => "注册成功"
                ];
                return $response;
            }else{
                $response = [
                    "error" => 50009,
                    "msg"   => "注册失败"
                ];
                return $response;
            }
    }
    /*
     *用户登录
     *@param Request request
     */
    public function  login(Request $request){
        $name     = $request -> input("email");
        $password = $request -> input("password");
        //判断是否为空
        if(empty($name) || empty($password)){
            //有一项为空就返回登录页面
            $response = [
                "error" => 50010,
                "msg"   => "请填写Email，密码，填写不能为空"
            ];
            return $response;
        }
        //查询是否有这个账号
        $desc = Users::where("email",$name)->first();
        //判断
        if(!$desc){
            //没有这个账号
            $response = [
                "error" => 50011,
                "msg"   => "请填写正确的账号和密码"
            ];
            return $response;
        }
        //判断密码是否正确
        $res = password_verify($password,$desc->password);
        if($res == true){
            //生成token
            $resmd = $desc -> user_id . $desc -> password . time();
            $mdpump = $desc -> user_id . $desc -> user_name . time();
            //进行加密剪切
            $token = substr(md5($resmd),16,16) . substr(md5($mdpump),20,12);
            /*【将数据存到数据库
            $data = [
                "user_id"=>$desc->user_id,
                "token"=>$token,
                "time"=>time()
            ];
            Token::insert($data)】*/;
            Redis::set($token,$desc->user_id);
            $response = [
                "error" => 0,
                "msg"   => "登录成功",
                "token" => $token
            ];
        }else{
            $response = [
                "error" => 50012,
                "msg"   => "请填写正确的账号和密码"
            ];
        }
        return $response;
    }
    /*
    *登录完成
    **@param Request $request
    **/
    public function center(){
        $token = $_GET["token"];
        //根据token进数据库查询是否存在
        //$res = Token::where("token",$token)->first();
        $res = Redis::get($token);
        if($res){
            //已登陆
            $user_name = Users::where("user_id",$res)->value("user_name");
            echo "欢迎".$user_name."来到个人中心";
        }else{
            //未登录
            echo "未登录";
        }

    }



















}
