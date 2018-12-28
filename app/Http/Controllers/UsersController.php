<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        //必须登录才能操作的动作
        $this->middleware('auth',['except'=>['show','create','store']
        ]);
        //只有没有登录才能操作的动作
        $this->middleware('guest',['only'=>['create']]);//注册页面
    }

    public function create()
    {
        return view('users.create');
    }
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }
    //注册用户
    public function store(Request $request)
    {
        //传参验证
        $this->validate($request,[
            'name'             =>'required|max:50',
            'email'            =>'required|email|unique:users|max:255',
            'password'         =>'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success', "$user->name,welcome to bbs");
        return redirect()->route('users.show', [$user]);
    }
    public function edit(User $user)
    {
        $this->authorize('update',$user);//用户控制器中使用 authorize 方法来验证用户授权策略
        return view('users.edit',compact('user'));
    }
    public function update(User $user, Request $request)
    {
        $this->authorize('update',$user);//用户控制器中使用 authorize 方法来验证用户授权策略
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);
        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user->id);
    }
}
