@extends('layouts.adminapp')
@section('title' , 'O6U : Admin')
@section('content')

            <!-- Page Content  -->
            <div id="content">
                <nav>
                    <div>
                        <div class="title2">
                            <div class="row" style="margin:0;">
                                <div class="col-md-5 my-2">
                                    <button type="button" id="sidebarCollapse" class="btn stf">
                                        <i class="fas fa-align-left"></i> Dashboard
                                    </button>   
                                </div>
                            </div> 
                        </div>
                    </div>
                </nav>
                <h3 style="text-align:center;color: #5d85aa;margin-top: 20px;margin-bottom: 20px;">&mdash; <span style="font-family: 'Sofia';font-size: 35px;">  Our Stuff </span> &mdash;</h3>
                <div class="row our-prec" style="margin:0;">
                        
                    <!-- First columns for the orders -->
                    <div class="col-md-4 blog-cont">
                        <!-- contain element of the orders div -->
                        <div class="blog">
                            <!-- divide the row to three columns first to the title and icon second for the price and the third for the precentage of prev period-->
                            <div class="row">
                                <!-- Title of block -->
                                <div class="title col-md-12">
                                    <p class="float-left title-text">Professors</p>
                                    <!-- Icon -->
                                    <p class="float-right title-icon"><i class="fas fa-user-tie"></i></p>
                                </div>
    
                                <!-- Price -->
                                <div class="order-price col-md-12">
                                    <p>{{App\User::where('type' , 'doctor')->count()}}</p>
                                </div>
                           
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 blog-cont">
                        <!-- contain element of the orders div -->
                        <div class="blog">
                            <!-- divide the row to three columns first to the title and icon second for the price and the third for the precentage of prev period-->
                            <div class="row">
                                <!-- Title of block -->
                                <div class="title col-md-12">
                                    <p class="float-left title-text">Students</p>
                                    <!-- Icon -->
                                    <p class="float-right title-icon"><i class="fas fa-user-graduate"></i></p>
                                </div>
    
                                <!-- Price -->
                                <div class="order-price col-md-12">
                                    <p>{{App\Student::count()}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 blog-cont">
                        <!-- contain element of the orders div -->
                        <div class="blog">
                            <!-- divide the row to three columns first to the title and icon second for the price and the third for the precentage of prev period-->
                            <div class="row">
                                <!-- Title of block -->
                                <div class="title col-md-12">
                                    <p class="float-left title-text">Subjects</p>
                                    <!-- Icon -->
                                    <p class="float-right title-icon"><i class="fas fa-copy"></i></p>
                                </div>
    
                                <!-- Price -->
                                <div class="order-price col-md-12">
                                    <p>{{App\Subject::count()}}</p>
                                </div>
                            
                              
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 blog-cont">
                        <!-- contain element of the orders div -->
                        <div class="blog">
                            <!-- divide the row to three columns first to the title and icon second for the price and the third for the precentage of prev period-->
                            <div class="row">
                                <!-- Title of block -->
                                <div class="title col-md-12">
                                    <p class="float-left title-text">Teacher Assistants</p>
                                    <!-- Icon -->
                                    <p class="float-right title-icon"><i class="fas fa-chalkboard-teacher"></i></p>
                                </div>
    
                                <!-- Price -->
                                <div class="order-price col-md-12">
                                    <p>{{App\User::where('type' , 'teachingAssistant')->count()}}</p>
                                </div>
                            
                             
                            </div>
                        </div>
                    </div>
                </div>

            </div>

@endsection

