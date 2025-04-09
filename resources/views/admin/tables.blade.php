
<?php
// include language configuration file based on selected language
$lang = "en";
if (isset($_GET['lang'])) {
   $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}
if( isset( $_SESSION['lang'] ) ) {
    $lang = $_SESSION['lang'];
}else {
    $lang = "en";
}
require_once ("./admin/lang/" . $lang . ".php");

?>

@extends('layouts.admin')

@section("title", "Data ")

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{ $type }}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                    <li class="breadcrumb-item active">{{ $type }}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                 
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ $type }}</h4>
                                <p class="card-title-desc">{{ $language["tables_desc"] }}
                                </p>
                            </div>
                            <div class="card-body">
                            @if ($type === 'portofolio')
                                <table  id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ $language["Show_Order"] }}</th>
                                            <th>{{ $language["Tittle"] }}</th>
                                            <th>{{ $language["Description"] }}</th>
                                            <th>{{ $language["Image"] }}</th>
                                            <th>{{ $language["Categories"] }}</th>
                                            <th>Hyperlink</th>
                                        </tr>
                                    </thead>
                                        @foreach ($SectionContents as $subsection)
                                        @php
                                            $extraData = json_decode($subsection->extra_data);
                                        @endphp
                                            <tr>
                                                <td>{{ $subsection->show_order }}</td>
                                                <td>{{ $subsection->content_key }}</td>
                                                <td>{{ $subsection->content_value }}</td>
                                                <td>
                                                    <img class="avatar-md" alt="{{ $extraData->image }}" 
                                                    src="{{ asset($extraData->image) }}" data-holder-rendered="true">
                                                </td>
                                                <td>{{ $extraData->categories }}</td>
                                                <td>{{ $extraData->link }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @elseif ($type === 'instagram')
                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ $language["Show_Order"] }}</th>
                                            <th>{{ $language["Name"] }}</th>
                                            <th>{{ $language["Content"] }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($SectionContents as $subsection)
                                        @php
                                            $extraData = json_decode($subsection->extra_data);
                                        @endphp
                                            <tr>
                                                <td>{{ $subsection->show_order }}</td>
                                                <td>{{ $subsection->content_key }}</td>
                                                <td>{{ $extraData->embed_url }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @elseif ($type === 'tiktok')
                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ $language["Show_Order"] }}</th>
                                            <th>{{ $language["Name"] }}</th>
                                            <th>{{ $language["Content"] }}</th>
                                            <th>{{ $language["Video_ID"] }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($SectionContents as $subsection)
                                        @php
                                            $extraData = json_decode($subsection->extra_data);
                                        @endphp
                                            <tr>
                                                <td>{{ $subsection->show_order }}</td>
                                                <td>{{ $subsection->content_key }}</td>
                                                <td>{{ $extraData->embed_url }}</td>
                                                <td>{{ $extraData->video_id }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @elseif ($type === 'testimonials')
                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ $language["Name"] }}</th>
                                            <th>{{ $language["Content"] }}</th>
                                            <th>Avatar</th>
                                            <th>{{ $language["Variations"] }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($SectionContents as $subsection)
                                        @php
                                            $extraData = json_decode($subsection->extra_data);
                                        @endphp
                                            <tr>
                                                <td>{{ $subsection->content_key }}</td>
                                                <td>{{ $subsection->content_value }}</td>
                                                <td>
                                                    <img class="rounded-circle avatar-md" alt="{{ $extraData->image }}" 
                                                    src="{{ asset($extraData->image) }}" data-holder-rendered="true">
                                                </td>
                                                <td>{{ $extraData->variation }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h2>All Sections</h2>
                                <table  id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>{{ $language["Name"] }}</th>
                                            <th>{{ $language["Tittle"] }}</th>
                                            <th>{{ $language["Description"] }}</th>
                                            <th>{{ $language["Content"] }}</th>
                                            <th>{{ $language["Btn_Text"] }}</th>
                                            <th>{{ $language["Btn_URL"] }}</th>
                                            <th>{{ $language["Active"] }}</th>
                                            <th>{{ $language["Show_Order"] }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sections as $section)
                                            <tr>
                                                <td>{{ $section->id }}</td>
                                                <td>{{ $section->name }}</td>
                                                <td>{{ $section->title }}</td>
                                                <td>{{ $section->description }}</td>
                                                <td>{{ $section->content }}</td>
                                                <td>{{ $section->butten_text }}</td>
                                                <td>{{ $section->butten_link }}</td>
                                                <td>{{ $section->is_active ? 'Active' : 'Non Active' }}</td>
                                                <td>{{ $section->show_order }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                            </div>
                            
                        </div>
                        <!-- end cardaa -->
                    </div> <!-- end col -->
                </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    @include('admin.partials.footer')
    
</div>

@endsection

@push("styles")
<!-- DataTables -->
<link href="{{ asset('admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ asset('admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push("scripts")

<!-- Required datatable js -->
<script src="{{ asset('admin/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ asset('admin/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('admin/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Responsive examples -->
<script src="{{ asset('admin/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<!-- Datatable init js -->
<script src="{{ asset('admin/js/pages/datatables.init.js') }}"></script>

<script src="{{ asset('admin/js/app.js') }}"></script>

@endpush