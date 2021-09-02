@extends('admin.app')
@section('title','add product')




@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Add books</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add books</h1>
        </div>
    </div><!--/.row-->




	<!--/.main-->




<div class="container">
    <form action="{{route('sendnewbook')}}" method="post"  enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlFile1">Book cover image</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image">
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput1">Book Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Book Name">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Writer Name</label>
            <input type="text" class="form-control" id="author" name="author"  placeholder="Writer Name">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Publisher</label>
            <input type="text" class="form-control" id="publisher" name="publisher" placeholder="Publisher">
        </div>


        <div class="form-group">
        <label for="exampleFormControlInput1">Category</label>
            <br>
     


             <input type="checkbox" name="category[]" value="BEST-SELLER">
                BEST-SELLER

            <br>

            <input type="checkbox" name="category[]" value="ENGINEERING">
                ENGINEERING

            <br>
          <input type="checkbox" name="category[]" value="PROGRAMMING">
                PROGRAMMING

            <br>
          <input type="checkbox" name="category[]" value="COMPETITIVE EXAM">
                COMPETITIVE EXAM

            <br>
           <input type="checkbox" name="category[]" value=" COMMER’S FACULTY">
                COMMER’S FACULTY

            <br>
           <input type="checkbox" name="category[]" value="JOB">
                JOB

            <br>
         
           <input type="checkbox" name="category[]" value="ACADEMIC">
                ACADEMIC

            <br>
            <input type="checkbox" name="category[]" value="OLYMPIAD">
                OLYMPIAD

            <br>
            <input type="checkbox" name="category[]" value="MEDICAL">
                MEDICAL

            <br>
           <input type="checkbox" name="category[]" value="Motivational/Novel">
           Motivational/Novel

            <br>
            
       
           <input type="checkbox" name="category[]" value="Law">
               Law

            <br>
            
                <br>
           <input type="checkbox" name="category[]" value="OTHER">
                OTHER

            <br>
            
            
            
        </div>



        <div class="form-group">
            <label for="exampleFormControlInput1">Price</label>
            <input type="text" class="form-control" id="category" name="price" placeholder="price">
        </div>






        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width: 70vw;">Description</span>
            </div>
            <textarea class="form-control" aria-label="With textarea" style="resize: vertical; width: 60vw;"></textarea>
        </div>






        <button type="submit" class="btn btn-primary">Submit</button>


    </form>
</div>
</div>


@endsection
