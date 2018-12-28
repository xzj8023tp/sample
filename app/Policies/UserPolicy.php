<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     *授权策略方法
     * @param User $currentUser  当前用户实例（登录用户）
     * @param User $user   进行授权的用户实例
     * @return bool
     */
    public function update(User $currentUser,User $user)
    {
        //当两个id相同时，则表示相同的用户，进行授权，否则抛出异常
        return $currentUser->id === $user->id;
    }
}
