@extends('layouts.admin')

@include('admin.partials.navbar')  

@section('content')

@section("title", "| Documentation ")

<div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Documentation</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Support</a></li>
                            <li class="breadcrumb-item active">Documentation</li>
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
                        <div class="documentation-content">
                            <div id="markdown-content">
                                {!! \Illuminate\Support\Str::markdown($readmeContent) !!}
                            </div>
                        </div>
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

@section('styles')
<style>
.documentation-content {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    line-height: 1.6;
    color: #333;
}

.documentation-content h1 {
    border-bottom: 1px solid #eee;
    padding-bottom: 0.3em;
    margin-bottom: 16px;
    font-size: 2em;
    font-weight: 600;
}

.documentation-content h2 {
    border-bottom: 1px solid #eee;
    padding-bottom: 0.3em;
    margin-top: 24px;
    margin-bottom: 16px;
    font-size: 1.5em;
    font-weight: 600;
}

.documentation-content h3 {
    margin-top: 24px;
    margin-bottom: 16px;
    font-size: 1.25em;
    font-weight: 600;
}

.documentation-content h4 {
    margin-top: 24px;
    margin-bottom: 16px;
    font-size: 1em;
    font-weight: 600;
}

.documentation-content p {
    margin-bottom: 16px;
}

.documentation-content ul, .documentation-content ol {
    margin-bottom: 16px;
    padding-left: 2em;
}

.documentation-content li {
    margin-bottom: 0.25em;
}

.documentation-content pre {
    background-color: #f6f8fa;
    border-radius: 6px;
    font-size: 85%;
    line-height: 1.45;
    overflow: auto;
    padding: 16px;
    margin-bottom: 16px;
}

.documentation-content code {
    background-color: #f6f8fa;
    border-radius: 3px;
    font-size: 85%;
    margin: 0;
    padding: 0.2em 0.4em;
}

.documentation-content pre code {
    background-color: transparent;
    border: 0;
    display: inline;
    line-height: inherit;
    margin: 0;
    overflow: visible;
    padding: 0;
    word-wrap: normal;
}

.documentation-content blockquote {
    border-left: 0.25em solid #dfe2e5;
    color: #6a737d;
    padding: 0 1em;
    margin-bottom: 16px;
}

.documentation-content table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    margin-bottom: 16px;
}

.documentation-content table th,
.documentation-content table td {
    border: 1px solid #dfe2e5;
    padding: 6px 13px;
}

.documentation-content table th {
    background-color: #f6f8fa;
    font-weight: 600;
}

.documentation-content table tr:nth-child(2n) {
    background-color: #f6f8fa;
}

.documentation-content hr {
    background-color: #e1e4e8;
    border: 0;
    height: 0.25em;
    margin: 24px 0;
    padding: 0;
}

.documentation-content a {
    color: #0366d6;
    text-decoration: none;
}

.documentation-content a:hover {
    text-decoration: underline;
}

.documentation-content strong {
    font-weight: 600;
}

.documentation-content em {
    font-style: italic;
}
</style>
@endsection 