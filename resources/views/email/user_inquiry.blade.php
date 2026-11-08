<h2>You have received a new inquiry for the property: {{ $property->name }}</h2>
<h4>Sender's Information:</h4>
<p>Name: {{ ucwords($request->name) }}</p>
<p>Email: {{ $request->email }}</p>
<p>Phone: {{ $request->phone }}</p>
<h4>Message:</h4>
<p>{{ $request->message }}</p>
