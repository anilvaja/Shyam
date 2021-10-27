@extends('layout')
@section('page_title','Booking List')
@section('container')
<html>
	<head>
	<script type="text/javascript" src="{{asset('frontend/js/jquery-2.1.4.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('frontend/js/underscore-min.js')}}"></script>
	<script type="text/javascript" src="{{asset('frontend/js/backbone.js')}}"></script>
	<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/bootstrap.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/prima.css')}}">
	</head>
	
	<body>
		<div class="text-center">
			<label id='title'>Seat Booking List</label>
		</div>
	

	
	
	<div class="table-responsive" style="padding:100px">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Sr. No</th>
                        <th>Booking Date</th>
						<th>Seats No</th>
						<th>From Date</th>
                        <th>To Date</th>
                        <th>Total booking Days</th>
					</tr>
				</thead>
				<tbody>
					
                    <?php $i= 1;?>
						@foreach($blist as $list)
							<tr>
								<td>{{$i++;}}</td>
								<td>{{$list->Booking_Date;}}</td>
								<td>{{$list->Seat_No;}}</td>
                                <td>{{$fd= $list->Booking_From_Date;}}</td>
                                <td>{{$ed = $list->Booking_To_Date;}}</td>
                                <td><?php 
                                $start_time = \Carbon\Carbon::parse($fd);
                                $finish_time = \Carbon\Carbon::parse($ed);
                                echo $result = $start_time->diffInDays($finish_time, false);?> 
                                </td>
							</tr>
						@endforeach
					
				</tbody>
			</table>
		</div>
	</body>
	
@endsection