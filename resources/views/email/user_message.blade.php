<p>You have received a new message from {{ $agent->name }}.</p>
<p>Click on the following link to see the message: </p>
<a href="{{ route('user.messages.reply', $message)}}">Visit Message</a>
