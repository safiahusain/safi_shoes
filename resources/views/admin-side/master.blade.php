<!doctype html>
<html lang="en">
@include('head')


    <body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            <!--@include('header')-->
            <!--@include('leftbar')-->
            {{-- @include('admin-side.leftbar') --}}
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
           @yield('content')
            <!--@include('footer')-->
        </div>
        <!-- END layout-wrapper -->
        
        <!-- Right Sidebar -->
        <!--@include('right_bar')-->
        <!-- /Right-bar -->

         <!-- Right bar overlay-->
         <div class="rightbar-overlay"></div>


        <!-- JAVASCRIPT -->
         <script src="https://code.jquery.com/jquery-3.6.0.min.js"
         integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
 
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
         integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
     </script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
         integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
     </script>
         {{-- <script type="text/javascript">
             $(".chosen").chosen();
         </script> --}}
         <script src="{{ asset('assets/libs/jquery/jquery.min.js')}}"></script>
         <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
         <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
         <script src="{{ asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
         <script src="{{ asset('assets/libs/node-waves/waves.min.js')}}"></script>
         <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js')}}"></script>
         <script src="{{ asset('assets/js/pages/form-validation.init.js')}}"></script>
         <script src="{{ asset('assets/js/app.js')}}"></script>
         <!-- apexcharts -->
         <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
         {{-- <script src="{{ asset('assets/js/pages/dashboard.init.js')}}"></script> --}}
          <!-- JAVASCRIPT -->
          <!-- Required datatable js -->
          <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
          <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
          <!-- Buttons examples -->
          <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
          <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
          <script src="{{ asset('assets/libs/jszip/jszip.min.js')}}"></script>
          <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
          <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
          <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
          <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
          <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
          <!-- Responsive examples -->
          <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
          <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
          <!-- Datatable init js -->
          <script src="{{ asset('assets/js/pages/datatables.init.js')}}"></script>    
          {{-- search-dropdown --}}
          
      {{-- toastr js --}}
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
 <!-- select 2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
     <!-- select 2 -->
     <script>
         $(document).ready(function() 
         {
             toastr.options.timeOut = 10000;
             @if (Session::has('error'))
                 toastr.error('{{ Session::get('error') }}');
             @elseif(Session::has('success'))
                 toastr.success('{{ Session::get('success') }}');
             @endif
         });
 
     </script>
     
      <script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
       $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
<script>
    $('#company_name').select2({
        dropdownParent: $('#exampleModal')
    });
</script>


<script>
    $('#color_id').select2({
        dropdownParent: $('#exampleModal')
    });
</script>

<script>
    $('#brand_id').select2({
        dropdownParent: $('#exampleModal')
    });
</script>

<script>
    $('#company_id').select2({
        dropdownParent: $('#exampleModal')
    });
</script>

<script>
    $('#branch_id').select2({
        dropdownParent: $('#exampleModal')
    });
</script>

<script>
    $('#expense_head').select2({
        dropdownParent: $('#exampleModal')
    });
</script>

<script>
    $('#bank_name').select2({
        dropdownParent: $('#exampleModal')
    });
</script>

<script>
    $('#customer_name').select2({
        dropdownParent: $('#exampleModal')
    });
</script>

<script>
    $('#customer_invoice').select2({
        dropdownParent: $('#exampleModal')
    });
</script>
 
     </body>
 </html>
 