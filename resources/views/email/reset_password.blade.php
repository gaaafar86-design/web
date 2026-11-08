@isset($user)
    <p>Please click on the following link to reset your password:</p>
    <a href="{{ route('user.reset.password', $token)}}">Reset Password</a>
@endisset

@isset($agent)
    <p>Please click on the following link to reset your password:</p>
    <a href="{{ route('agent.reset.password', $token)}}">Reset Password</a>
@endisset

@isset($admin)
    <p>Please click on the following link to reset your password:</p>
    <a href="{{ route('admin.reset.password', $token)}}">Reset Password</a>
@endisset
