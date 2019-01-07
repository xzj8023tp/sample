<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        //必须登录才能操作的动作
        $this->middleware('auth',['except'=>['show','create','store','index','confirmEmail']
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
        $statuses = $user->statuses()
                         ->orderBy('created_at','desc')
                         ->paginate(10);
        return view('users.show',compact('user','statuses'));
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
//        Auth::login($user);
//        session()->flash('success', "$user->name,welcome to bbs");
//        return redirect()->route('users.show', [$user]);
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
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
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }
    //删除用户
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);//虽然前端做了授权策略，但是控制器里也要做一次
        $user->delete();
        session()->flash('success','成功删除用户！');
        return back();
    }
    //发送邮件
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';//视图
        $data = compact('user');
        $from = 'xzj8023tp@163.com';
        $name = 'xzj';
        $to = $user->email;
        $subject = "感谢注册 Sample 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }
    //邮件激活
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;//激活后设为空，防止重复利用来激活
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }
}
