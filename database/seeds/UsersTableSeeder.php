<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //例子
//        $users = factory(User::class)->times(50)->make();
//        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());
//
//        $user = User::find(1);
//        $user->name = '夏赵建';
//        $user->email = 'xzj8023tp@163.com';
//        $user->password = bcrypt('13277161350xzj');
//        $user->save();
        //添加50个用户
        factory('App\Models\User',50)->create([
            'password' => bcrypt('13277161350xzj'),
        ]);
    }
}
