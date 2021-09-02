@extends('admin.app')
@section('title','add product')
@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">book list</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">book list</h1>
        </div>
    </div><!--/.row-->

    <div>Name: {{$customer->first_name' '.$customer->last_name}}</div>
    <div>phone:{{$customer->phone']}}</div>
    <div>address:{{$customer->address}}</div>
    <div>city:{{$customer->city}}</div>
    <div>city:{{$customer->zip}}</div>
    <div>city:{{$customer->create_at}}</div>






    <div class="container">

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Writer</th>
                <th scope="col">Publisher</th>

            </tr>
            </thead>
            <tbody>

            @foreach ($books as $book)
            <tr>
                <th scope="row">{{$book->id}}</th>

                <td>{{$book->name}}</td>
                <td>{{$book->price}}</td>
                <td>{{$book->author}}</td>
                <td>{{$book->publisher}}</td>


            </tr>
            @endforeach


            </tbody>
        </table>

    </div>
</div>	<!--/.main-->

{{ $books->links() }}
@endsection
