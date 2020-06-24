<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use function GuzzleHttp\headers_from_lines;
use Illuminate\Http\Request;
//登录的数据库
use App\Model\Users;
//COOKIE
use Illuminate\Support\Facades\Cookie;
class IndexController extends Controller
{
    //页面
    public function index(){
        if(request()->isMethod("get")){
            return view("/Admin/Login/login");
        }
    }
    //登录
    public function login(){
        $name = request()->post("email");
        $password = request()->post("password");
        //判断是否为空
        if(empty($name) || empty($password)){
            //有一项为空就返回登录页面
            return redirect("/Login")->with("get","请填写Email，密码，填写不能为空");
        }
        //查询是否有这个账号
        $desc = Users::where("email",$name)->first();
        //判断
        if(!$desc){
            //没有这个账号
            return redirect("/Login")->with("get","请填写正确的账号和密码");
        }
        //判断密码是否正确
        $res = password_verify($password,$desc->password);
        if($res){
//            setcookie("pid",$desc,time()+3600*1,"/");
            //存到Cookie里
            Cookie::queue("pid",$desc,2);
            header("Refresh:2;url='/user/center'");
            echo "验证成功";
        }else{
            return redirect("/Login")->with("get","请填写正确的账号和密码");
        }

    }
    //注册页面
    public function add(){
        return view("/Admin/Login/registered");
    }
    //注册方法
    public function registered(){
        if(request()->isMethod("post")){
                $name = request()->except("_token");
                $name["reg_time"] = time();
                //*********************验证用户填写的是否为空
                if(empty($name["user_name"])){
                    return redirect("/user/reg")->with("get","用户名不能为空");
                }
                if(empty($name["email"])){
                    return redirect("/user/reg")->with("get","Email不能为空");
                }
                if(empty($name["password"])){
                    return redirect("/user/reg")->with("get","密码不能为空");
                }
                if(empty($name["pwd"])){
                    return redirect("/user/reg")->with("get","确认密码不能为空");
                }
                if($name["password"] != $name["pwd"]){
                    return redirect("/user/reg")->with("get","请把密码和确认密码必须保持一致。");
                }
                //**********************验证数据库是否存在
                $desc=Users::where("user_name",$name["user_name"])->get()->toArray();
                if($desc){
                    return redirect("/user/reg")->with("get","用户名已存在，请跟换用户名");
                }
                //*********************结束验证用户填写的是否为空
                $password = password_hash($name["password"],PASSWORD_BCRYPT);
                $data=[
                    "user_name"=>$name["user_name"],
                    "email"=>$name["email"],
                    "password"=>$password,
                    "reg_time"=>$name["reg_time"],
                ];
                $red = Users::insert($data);
                if($red){
                    return redirect("/Login")->with("get","注册成功，请重新登录");
                }
        }
        dd("页面正在检修，请稍后在来");
    }
    public function center(){
        if(!isset($_COOKIE["pid"])){
            return redirect("/Login")->with("get","请先登录!");
        }
        dump(date("Y-m-d H:i:s",time()+10));
        dd("接电话");



        
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    





}
