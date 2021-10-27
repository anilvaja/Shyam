@extends('layout')
@section('page_title','Booking')
@section('container')
<html>
	<head>
	<script type="text/javascript" src="{{asset('frontend/js/jquery-2.1.4.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('frontend/js/underscore-min.js')}}"></script>
	<script type="text/javascript" src="{{asset('frontend/js/backbone.js')}}"></script>
	<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/bootstrap.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/prima.css')}}">
	</head>
	<title>
	Numerator SEAT RESERVATION
	</title>
	<body>
		<div class="text-center">
			<label id='title'>NUMERATOR SEAT RESERVATION</label>
		</div>
	

	
		<form class='form-inline selectionForm'>
			
			<div class="form-group required">
				<label for="name">Start Date</label>
				<input type="date" name="start_date" id ="start_date" required>
			</div>
			<div class="form-group required">
				<label for="name">End Date</label>
				<input type="date" name="end_date" id="end_date" required>
			</div>
			<div style="display:none">
			<div class="form-group required">
				<label for="name">Name:</label>
				<input type="text" class="form-control" id='name' value="{{Session::get('ADMIN_Name')}}">
			</div>
			<div class="form-group required">
				<label for="seats">Number Of Seats:</label>
				<input type="number" id='seats' class="form-control" placeholder="3" Value="1"/>
			</div>
			</div>
			<div class="text-center">
				<button type="button" class="btn btn-primary btn-lg submitBtn" id="submitSelection">Start Selecting</button>
			</div>

			<div class="text-center">
				<font color="Red"><label class="error"></label></font>
			</div>

		</form>
		<div class="screen-ui">
			<div id="screen">
				<font color="white">SCREEN</font>		
			</div>
			
			<table class="table" id="table-screen">
				<thead id="screen-head">
					<tr>
						<script type="text/template" id='table-screen-header'>
			   				<% _.each(_.range(0,columns+1),function(item){ %>
			   					<% if(item==0) {%>
			            			<th></th>
			            		<% } else {%>
			            			<th><%= item %></th>
			            		<% } %>
			    			<% }) %>
			    		</script>
		    		</tr>
		    	</thead>
		    	<tbody id="screen-body">
		    		<script type="text/template" id='table-screen-body'>
		    			<% _.each(rows,function(row){ %>
		    				<tr id='table-screen-row'>
		    					<td><%=row%></td>
		    					<% _.each(_.range(1,columns+1),function(column){ %>
		    						<% var id=(_.indexOf(rows,row)*columns)+column; var reservedSeats=JSON.parse(localStorage.getItem('ReservedSeats')); if(reservedSeats!=null && _.indexOf(reservedSeats,String(id))!=-1) {%>
			            				<td><img src="{{asset('frontend/img/reserved-seat.png')}}" class="reserved-seat" id="<%=id%>"/></td>
			            			<% }else {%>
			            				<td><img src="{{asset('frontend/img/empty-seat.png')}}" class="empty-seat" id="<%=id%>"/></td>		       
			            			<% }}) %>
	    					</tr>
	    				<% }) %>
					</script>	
		    	</tbody>
			</table>

			<div class="text-center">
				<button type="button" class="btn btn-primary btn-lg submitBtn" id="confirmSelection">Confirm Selection</button>
				<div class="screen-map">
				<label for="empty-seat-map">Selected Seat</label>
				<img src="{{asset('frontend/img/booked-seat.png')}}" class="booked-seat-map" id="booked-seat-map">
				<br/>
				<label for="">Reserved Seat</label>
				<img src="{{asset('frontend/img/reserved-seat.png')}}" class="reserved-seat-map" id="reserved-seat-map">
				<br/>
				<label for="">Empty Seat</label>
				<img src="{{asset('frontend/img/empty-seat.png')}}" class="empty-seat-map" id="empty-seat-map">
			</div>	
			</div>
					
		</div>
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Name</th>
						<th>Number of Seats</th>
						<th>Seats</th>
					</tr>
				</thead>
				<tbody id="ticket-sold-info">
					<script type="text/template" id='table-ticket-info'>
						<% _.each(items,function(item){%>
							<tr>
								<td><%-item.names%></td>
								<td><%-item.numbers%></td>
								<td><%-item.seats%></td>
							</tr>
						<%})%>
					</script>
				</tbody>
			</table>
		</div>
	</body>
	<script>
var BookedSeats = [];
var Rows=["A","B","C","D","E","F","G","H","I","J","k"];
var Columns=10;
var TotalSeats=Rows.length*Columns;

function convertIntToSeatNumbers(seats){
	var bookedSeats="";
	_.each(seats,function(seat){
		var row=Rows[parseInt(parseInt(seat)/12)];
		var column=parseInt(seat)%12;
		if(column==0){
			column=12;
		}
		if(_.indexOf(seats,seat)==seats.length-1){
			bookedSeats=bookedSeats+row+column;
		}
		else{
			bookedSeats=bookedSeats+row+column+",";
		}
	});
	return bookedSeats;
}

var InitialView = Backbone.View.extend({
	events:{
		"click #submitSelection": "submitForm"
	},
	submitForm : function(){
		//var sd = document.getElementsById("start_date").value;
		//var ed = document.getElementsById("end_date").value;
		//var diffTime = Math.abs(ed - sd);
		//var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

		var reservedseats=JSON.parse(localStorage.getItem('ReservedSeats'));
		var availableSeats=TotalSeats;
		var selectedNumberOfSeats=$('#seats').val();
		if(reservedseats!=null)
			availableSeats=TotalSeats-reservedseats.length;
		if(!$('#name').val()){
			$(".error").html("Name is required");
		}
		if(!$('#start_date').val()){
			$(".error").html("Start Date is required");
		}
		
		if(!$('#end_date').val()){
			$(".error").html("End date is required");
		}
		
		else if(!selectedNumberOfSeats){
			$(".error").html("Number of seats is required");
		}
		else if(parseInt(selectedNumberOfSeats)>availableSeats){
			$(".error").html("You can only select "+availableSeats+" seats")
		}
		else
		{
			$(".error").html("");
			screenUI.showView();
		}
	}
});
var initialView = new InitialView({el:$('.selectionForm')});

var ScreenUI=Backbone.View.extend({
	events:{
		"click .empty-seat,.booked-seat":"toggleBookedSeat",
		"click #confirmSelection":"bookTickets"
	},
	initialize:function(){
		var tableheaderTemplate = _.template($("#table-screen-header").html());
		var tableBodyTemplate=_.template($("#table-screen-body").html());
		var data={"rows":Rows,"columns":Columns};
		$("#screen-head").after(tableheaderTemplate(data));
		$("#screen-body").after(tableBodyTemplate(data));	
	},
	hideView:function(){
		$(this.el).hide();
	},
	showView:function(){
		$(this.el).show();
	},
	toggleBookedSeat:function(event){
		var id="#"+event.currentTarget.id;
		if($(id).attr('class')=='empty-seat' && BookedSeats.length<$('#seats').val()){
			BookedSeats.push(id.substr(1));
			$(id).attr('src','frontend/img/booked-seat.png');
			$(id).attr('class','booked-seat');

		}
		else if($(id).attr('class')=='booked-seat'){
			BookedSeats=_.without(BookedSeats,id.substr(1));
			$(id).attr('src','frontend/img/empty-seat.png');
			$(id).attr('class','empty-seat');
		}
	},
	updateTicketInfo:function(){
		var bookedSeats=convertIntToSeatNumbers(BookedSeats);
		$("#ticket-sold-info").append("<tr><td>"+$('#name').val()+"</td><td>"+$('#seats').val()+"</td><td>"+bookedSeats+"</td></tr>");
	},
	bookTickets:function(){
		if(BookedSeats.length==parseInt($('#seats').val())) {
			$(".error").text("");
			var reservedseats=JSON.parse(localStorage.getItem('ReservedSeats'))||[];
			_.each(BookedSeats,function(bookedSeat){
				reservedseats.push(bookedSeat);
			});
			var nameSeatsJSON=JSON.parse(localStorage.getItem('NameSeatsJSON'))||{};
			nameSeatsJSON[$('#name').val()]=BookedSeats;
			localStorage.setItem('NameSeatsJSON',JSON.stringify(nameSeatsJSON));
			localStorage.setItem('ReservedSeats',JSON.stringify(reservedseats));
			this.updateTicketInfo();
			window.location.reload();
		}
		else{
			$(".error").html("Please select exactly "+ $('#seats').val()+" seats");
		}		
	},
});

var screenUI = new ScreenUI({el:$('.screen-ui')});
screenUI.hideView();

var TicketInfo=Backbone.View.extend({
	initialize:function(){
		var items=[];
		var json=JSON.parse(localStorage.getItem('NameSeatsJSON'));
		if(json!=null){
		_.each(json,function(key,value){
			var name=value;
			var number=key.length;
			var bookedSeats=convertIntToSeatNumbers(key);
			items.push({names:name,numbers:number,seats:bookedSeats});
		});
		var data={"items":items};
		var ticketInfoBody=_.template($("#table-ticket-info").html());
		$("#ticket-sold-info").html(ticketInfoBody(data));
		}
	}
});

var ticketInfo=new TicketInfo({el:$('.table-responsive')});


	</script>
</html>
@endsection