<!DOCTYPE html>
<html>
<head>
	<title>Employee PDF</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

	<div class="container">
		<center>
			<h4>Employee List {{ $company['name'] }}</h4>
		</center>
		<br/>
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Email</th>
					<th>Balance</th>
				</tr>
			</thead>
			<tbody>
				@php $i=1 @endphp
				@foreach($employees as $p)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{$p->name}}</td>
					<td>{{$p->email}}</td>
					<td>{{$p->balance}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

	</div>

</body>
</html>