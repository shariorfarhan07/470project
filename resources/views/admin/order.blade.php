@extends('admin.app')
@section('title','add product')
@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Order list</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Order list</h1>
        </div>
    </div><!--/.row-->







    <div class="container">

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Adress</th>
                <th scope="col">Invoice</th>

            </tr>
            </thead>
            <tbody>

            @foreach ($orders as $order)
            <tr>
                <th scope="row">{{$order->id}}</th>

                <th scope="row">{{$order->first_name.$order->last_name}}</th>
                <td>{{$order->phone}}</td>
                <td>{{$order->address.' '.$order->city }}</td>
                <td>{{$order->created_at}}<a href="#">Invoice</a></td>

            </tr>
            @endforeach


            </tbody>
        </table>

    </div>
    {{$orders->links("pagination::bootstrap-4")}}
</div>	<!--/.main-->


@endsection
