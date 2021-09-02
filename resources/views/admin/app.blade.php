<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nupurbooks-@yield('title')</title>
    <link href="{{asset('Admincss/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('Admincss/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('Admincss/datepicker3.css')}}" rel="stylesheet">
    <link href="{{asset('Admincss/styles.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!--Custom Font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{asset('js/html5shiv.js')}}"></script>
    <script src="{{asset('js/respond.min.js')}}"></script>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span></button>
            <a class="navbar-brand" href="https://nupurbookcenter.com"><span>Nupur</span>Books</a>



        </div>
    </div><!-- /.container-fluid -->
</nav>



<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <div class="profile-sidebar">
     
        <div class="profile-usertitle">
            <div class="profile-usertitle-name">{{ Auth::user()->name }}</div>
            <div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="divider"></div>
<!--    <form role="search">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </form>
-->

    <ul class="nav menu">
        <li><a href="{{Route('adminorders')}}"><em class="fa fa-calendar">&nbsp;</em> Order</a></li>
        <li><a href="{{Route('adminaddbooks')}}"><em class="fa fa-bar-chart">&nbsp;</em> Add Books</a></li>
        <li><a href="{{Route('bookslist')}}"><em class="fa fa-clone">&nbsp;</em> Edit Books</a></li>
        <li><a href="{{Route('logoutt')}}"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
    </ul>
</div>
<style>
.pagination{
	z-index:2;
}
</style>
@yield('content')









<script src="{{asset('Adminjs/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('Adminjs/bootstrap.min.js')}}"></script>
<script src="{{asset('Adminjs/chart.min.js')}}"></script>
<script src="{{asset('Adminjs/chart-data.js')}}"></script>
<script src="{{asset('Adminjs/easypiechart.js')}}"></script>
<script src="{{asset('Adminjs/easypiechart-data.js')}}"></script>
<script src="{{asset('Adminjs/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('Adminjs/custom.js')}}"></script>
<script>
    window.onload = function () {
        var chart1 = document.getElementById("line-chart").getContext("2d");
        window.myLine = new Chart(chart1).Line(lineChartData, {
            responsive: true,
            scaleLineColor: "rgba(0,0,0,.2)",
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleFontColor: "#c5c7cc"
        });
    };
</script>

</body>
</html>












