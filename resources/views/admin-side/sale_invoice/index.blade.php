@extends('admin-side.home')
@section('content')
<style>

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    @if($param  ==  'invoice')
                                        <h4 class="card-title">Sale Invoice</h4>
                                    @else
                                        <h4 class="card-title">Return Sale Invoice</h4>
                                    @endif
                                    <!--<p class="card-title-desc">Data table with CSV and -->
                                    </p>
                                         <div class="align-middle " >
                                         <a href="{{url('add/sale/'.$param)}}">  <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" >
                                            @if($param  ==  'invoice')
                                                Add Sale Invoice
                                            @else
                                                Add Return Sale Invoice
                                            @endif
                                            </button> </a> <br><br>
                                        </div>
                                    
                                    <table id="table_one" class="table table-bordered table-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>S.NO</th>
                                                <th>Customer Name</th>
                                                <!--<th>Sale id</th>-->
                                                <th>Current Invoice</th>
                                                <th>Discount</th>
                                                <th>Extra discount</th>
                                                <th>Balance</th>
                                                <th>Date</th>
                                               <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                    
                                        <tbody>
                                            @php $i=0; @endphp
                                            @if (count($data)> 0)
                                                @foreach ($data as $item)
                                                    <tr>
                                                        @php $i++ @endphp
                                                        <td>{{$i}}</td>
                                                        <td>{{$item->user->name}}</td>
                                                        <!--<td> {{$item->sale_id}}</td>-->
                                                        <td>{{$item->current_invoice}}</td>
                                                        <td>{{$item->total_discount}}</td>
                                                        <td> {{$item->extra_descount}}</td>
                                                        <td> {{$item->net_balance}}</td>
                                                        <td>{{$item->updated_at}}</td>
                                                        <td style='width:20%'>
                                                            <a href="{{ url('edit/sale/' . urlencode($param) . '/' . $item->id) }}" class=""> <i class="fa-solid fa-pen-to-square"></i></a>
                                                            |
                                                            <a href="{{ url('delete/sale/' . urlencode($param) . '/' . $item->id)}}" class="" onclick="return confirm('Are you sure to Delete this Record ?')"><button style="background-color:white; border:none;"><i class="fa-solid fa-trash-can"></button></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
</div>


  <!-- script section end -->

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () 
    {
        $('#table_one').DataTable(
        {
            "scrollX": true
        });
    //   $('.dataTables_length').addClass('bs-select');
    });
</script>


<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{asset('assets/js/pages/shoes.js')}}"></script>
<script>
    function myFunction() 
    {
        var x = document.getElementById("validationCustom04");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>  
@endsection