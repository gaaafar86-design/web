@isset($user)
    <p>Please click on the following link to complete your registration:</p>
    <a href="{{ route('user.register.verify', $token)}}">Verify Email</a>
@endisset

@isset($agent)
    <p>Please click on the following link to complete your registration:</p>
    <a href="{{ route('agent.register.verify', $token)}}">Verify Email</a>
@endisset

@isset($adminUser)
    <p>Your account has been created.</p>
    <p>Account Info:</p>
    <p>Name: {{ $adminUser->name }}</p>
    <p>Email: {{ $adminUser->email }}</p>
    <p>Phone: {{ $adminUser->phone }}</p>
    <p>Password: {{ $request->password }}</p>
    <b>You can change your account info later in your dashboard.</b>
    <hr>
    <p>Please click on the following link to complete your registration:</p>
    <a href="{{ route('user.register.verify', $token)}}">Verify Email</a>
@endisset

@isset($adminAgent)
    <p>Your account has been created.</p>
    <p>Account Info:</p>
    <p>Name: {{ $adminAgent->name }}</p>
    <p>Email: {{ $adminAgent->email }}</p>
    <p>Phone: {{ $adminAgent->phone }}</p>
    <p>Password: {{ $request->password }}</p>
    <b>You can change your account info later in your dashboard.</b>
    <hr>
    <p>Please click on the following link to complete your registration:</p>
    <a href="{{ route('agent.register.verify', $token)}}">Verify Email</a>
@endisset
