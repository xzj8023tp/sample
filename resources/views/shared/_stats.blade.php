<div class="stats">
    <a href="{{ route('users.attentions', $user->id) }}">
        <strong id="following" class="stat">
            {{ count($user->attention) }}
        </strong>
        关注
    </a>
    <a href="{{ route('users.fans', $user->id) }}">
        <strong id="followers" class="stat">
            {{ count($user->fans) }}
        </strong>
        粉丝
    </a>
    <a href="{{ route('users.show', $user->id) }}">
        <strong id="statuses" class="stat">
            {{ $user->statuses()->count() }}
        </strong>
        动态
    </a>
</div>