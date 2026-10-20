<p>We had to change some of your account information.</p>
<p>Your new information:</p>
<p>Name: {{ $request->name }}</p>
<p>Email: {{ $request->email }}</p>
<p>Phone: {{ '09' . $request->phone }}</p>
<p>Password: {{ $request->password }}</p>
<b>You can change your account info later in your dashboard.</b>
<hr>
<a href="{{ isset($user) ? route('user.login') : route('agent.login') }}">Login Now</a>
