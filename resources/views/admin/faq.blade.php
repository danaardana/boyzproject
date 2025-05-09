@extends('layouts.admin')

@include('admin.partials.navbar')  

@section('content')

@section("title", "| FaQ ")

<div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">FAQs</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                            <li class="breadcrumb-item active">FAQs</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center mt-3">
                            <div class="col-xl-5 col-lg-8">
                                <div class="text-center">
                                    <h5>Can't find what you are looking for?</h5>
                                    <p class="text-muted">If several languages coalesce, the grammar of the resulting language
                                        is more simple and regular than that of the individual</p>
                                    <div>
                                        <button type="button" class="btn btn-primary mt-2 me-2 waves-effect waves-light">Email
                                            Us</button>
                                        <button type="button" class="btn btn-success mt-2 waves-effect waves-light">Send us a
                                            tweet</button>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="col-xl-10">
                                            <form class="app-search d-none d-lg-block mt-4">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="Search...">
                                                    <button class="btn btn-primary" type="button"><i class="bx bx-search-alt align-middle"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row mt-5">
                            <div class="col-xl-4 col-sm-6">
                                <div class="card">
                                    <div class="card-body overflow-hidden position-relative">
                                        <div>
                                            <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                        </div>
                                        <div class="faq-count">
                                            <h5 class="text-primary">01.</h5>
                                        </div>
                                        <h5 class="mt-3">What is Lorem Ipsum?</h5>
                                        <p class="text-muted mt-3 mb-0">New common language will be more simple and regular than the existing European languages. It will be as simple as occidental.</p>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            <div class="col-xl-4 col-sm-6">
                                <div class="card">
                                    <div class="card-body overflow-hidden position-relative">
                                        <div>
                                            <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                        </div>
                                        <div class="faq-count">
                                            <h5 class="text-primary">02.</h5>
                                        </div>
                                        <h5 class="mt-3">Where does it come from?</h5>
                                        <p class="text-muted mt-3 mb-0">Everyone realizes why a new common language would be desirable one could refuse to pay expensive translators.</p>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-xl-4 col-sm-6">
                                <div class="card">
                                    <div class="card-body overflow-hidden position-relative">
                                        <div>
                                            <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                        </div>
                                        <div class="faq-count">
                                            <h5 class="text-primary">03.</h5>
                                        </div>
                                        <h5 class="mt-3">Where can I get some?</h5>
                                        <p class="text-muted mt-3 mb-0">If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages.</p>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-xl-4 col-sm-6">
                                <div class="card">
                                    <div class="card-body overflow-hidden position-relative">
                                        <div>
                                            <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                        </div>
                                        <div class="faq-count">
                                            <h5 class="text-primary">04.</h5>
                                        </div>
                                        <h5 class="mt-3">Why do we use it?</h5>
                                        <p class="text-muted mt-3 mb-0">Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary.</p>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-xl-4 col-sm-6">
                                <div class="card">
                                    <div class="card-body overflow-hidden position-relative">
                                        <div>
                                            <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                        </div>
                                        <div class="faq-count">
                                            <h5 class="text-primary">05.</h5>
                                        </div>
                                        <h5 class="mt-3">
                                            Where can I get some?</h5>
                                        <p class="text-muted mt-3 mb-0">The point of using Lorem Ipsum is that it has a
                                            more-or-less normal they distribution of letters opposed to using content here.</p>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-xl-4 col-sm-6">
                                <div class="card">
                                    <div class="card-body overflow-hidden position-relative">
                                        <div>
                                            <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                        </div>
                                        <div class="faq-count">
                                            <h5 class="text-primary">06.</h5>
                                        </div>
                                        <h5 class="mt-3">What is Lorem Ipsum?</h5>
                                        <p class="text-muted mt-3 mb-0">To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental</p>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end  card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

@include('admin.partials.footer')

</div>

@endsection
