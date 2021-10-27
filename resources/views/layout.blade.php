<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>@yield('page_title')</title>
<style>
    /* Add some padding on document's body to prevent the content
    to go underneath the header and footer */
    body{        
        padding-top: 60px;
        padding-bottom: 40px;
    }
    .container{
        width: 80%;
        margin: 0 auto; /* Center the DIV horizontally */
    }
    .fixed-header, .fixed-footer{
        width: 100%;
        position: fixed;        
        background: #0b494f;
        padding: 10px 0;
        color: #fff;
    }
    .fixed-header{
        top: 0;
    }
    .fixed-footer{
        bottom: 0;
    }    
    /* Some more styles to beutify this example */
    nav a{
        color: #fff;
        text-decoration: none;
        padding: 7px 25px;
        display: inline-block;
    }
    .container p{
        line-height: 200px; /* Create scrollbar to test positioning */
    }
</style>
</head>
<body>
    <div class="fixed-header">
        <div class="container">
            <nav>
            Welcome <b>{{Session::get('ADMIN_Name')}}</b>
                <a href="booking">Home</a>
                <a href="bookinglist">Booking Record</a>
                <a href="admin/logout">Logout</a>
               
            </nav>
        </div>
    </div>
    
    @section('container')
     @show  
    <div class="fixed-footer">
        <div class="container">Copyright &copy; 2021 Numerator</div>        
    </div>
</body>
</html>
