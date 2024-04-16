@extends('admin-side.home')
@section('content')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card overflow-hidden">
                                <div class="bg-primary bg-soft">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="text-primary p-3">
                                                <h5 class="text-primary">User Profile !</h5>
                                                <p>It will seem like simplified</p>
                                            </div>
                                        </div>
                                        <div class="col-5 align-self-end">
                                            <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="avatar-md profile-user-wid mb-4">
                                                <img src="assets/images/users/avatar-1.jpg" alt="" class="img-thumbnail rounded-circle">
                                            </div>
                                            <h5 class="font-size-15 text-truncate">{{ $data->name }}</h5>
                                            <p class="text-muted mb-0 text-truncate">{{ $data->user_type }}</p>
                                        </div>

                                        <div class="col-sm-8">
                                            <div class="pt-4">
                                               
                                                <div class="row mt-5">
                                                    <div class="col-6">
                                                        <h5 class="font-size-15">125</h5>
                                                        <p class="text-muted mb-0">Projects</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5 class="font-size-15">$1245</h5>
                                                        <p class="text-muted mb-0">Revenue</p>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <a href="{{ route('edit-profile') }}" class="btn btn-primary waves-effect waves-light btn-sm">Edit Profile <i class="mdi mdi-arrow-right ms-1"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    <!-- end card -->
                </div>    
                <div class="col-xl-8">
                    <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Personal Information</h4>

                                    <p class="text-muted mb-4">Hi I'm Cynthia Price,has been the industry's standard dummy text To an English person, it will seem like simplified English, as a skeptical Cambridge.</p>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap mb-0">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Full Name :</th>
                                                    <td>{{ $data->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Mobile :</th>
                                                    <td>(123) 123 1234</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">E-mail :</th>
                                                    <td>{{ $data->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Location :</th>
                                                    <td>California, United States</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                    </div>
                    <!-- end card -->
                </div>
            </div>
        </div>  
    </div>   
</div>    
       
                     
<script>
    function myFunction() {
        var x = document.getElementById("validationCustom04");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>  
@endsection