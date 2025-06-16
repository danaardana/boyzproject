@extends('layouts.admin')

@include('admin.partials.navbar')  

@section('content')

@section("title", "| Sent Messages ")

<div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Sent Messages</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Messages</a></li>
                            <li class="breadcrumb-item active">Sent Messages</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <!-- Left sidebar -->
                <div class="email-leftbar card">
                    <div class="mail-list mt-4">
                        <a href="{{ route('admin.messages.index', ['filter' => 'inbox']) }}">
                            <i class="mdi mdi-email-outline me-2"></i> Inbox 
                            @php
                                $unreadCount = \App\Models\ContactMessage::where('is_read', false)->notDeleted()->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="ms-1 float-end badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.messages.index', ['filter' => 'important']) }}">
                            <i class="mdi mdi-star me-2"></i>Important
                        </a>
                        <a href="{{ route('admin.messages.index', ['filter' => 'sent']) }}" class="active">
                            <i class="mdi mdi-email-check-outline me-2"></i>Sent Mail
                        </a>
                        <a href="{{ route('admin.messages.index', ['filter' => 'trash']) }}">
                            <i class="mdi mdi-trash-can-outline me-2"></i>Trash
                        </a>
                    </div>

                    <h6 class="mt-4">Labels</h6>

                    <div class="mail-list mt-1">
                        <a href="#"><span class="mdi mdi-arrow-right-drop-circle text-info float-end"></span>Warranty</a>
                        <a href="#"><span class="mdi mdi-arrow-right-drop-circle text-warning float-end"></span>Installation</a>
                        <a href="#"><span class="mdi mdi-arrow-right-drop-circle text-primary float-end"></span>Support</a>
                        <a href="#"><span class="mdi mdi-arrow-right-drop-circle text-danger float-end"></span>General</a>
                    </div>
                </div>
                <!-- End Left sidebar -->

                <!-- Right Sidebar -->
                <div class="email-rightbar mb-3">

                    <div class="card">
                        <div class="btn-toolbar gap-2 p-3" role="toolbar">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary waves-light waves-effect" onclick="window.location.href='{{ route('admin.messages.index', ['filter' => 'inbox']) }}'" title="View Inbox">
                                    <i class="fa fa-inbox"></i>
                                </button>
                                <button type="button" class="btn btn-secondary waves-light waves-effect" disabled title="Not available for sent messages">
                                    <i class="far fa-star"></i>
                                </button>
                                <button type="button" class="btn btn-secondary waves-light waves-effect" disabled title="Not available for sent messages">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        
                        <ul class="message-list">
                            @foreach($responses as $response)
                            <li data-response-id="{{ $response->id }}">
                                <div class="col-mail col-mail-1">
                                    <div class="checkbox-wrapper-mail">
                                        <input type="checkbox" id="chk{{ $response->id }}" value="{{ $response->id }}" disabled>
                                        <label for="chk{{ $response->id }}" class="toggle"></label>
                                    </div>
                                    <a href="{{ route('admin.messages.sent.show', $response) }}" class="title">
                                        To: {{ $response->contactMessage->customer->name }}
                                    </a>
                                    <span class="mdi mdi-send text-success" title="Sent Message"></span>
                                </div>
                                <div class="col-mail col-mail-2">
                                    <a href="{{ route('admin.messages.sent.show', $response) }}" class="subject">
                                        <span class="badge bg-success me-2">Balasan</span>
                                        Balasan Pesan: {{ $response->contactMessage->content_key ?? 'Pesan' }} – 
                                        <span class="teaser">{{ Str::limit($response->message, 60) }}</span>
                                    </a>
                                    <div class="date">{{ $response->created_at ? $response->created_at->format('M d') : 'N/A' }}</div>
                                </div>
                                <div class="col-mail col-mail-status">
                                    <span class="badge bg-info">By {{ $response->admin->name }}</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                    </div> <!-- card -->

                    <div class="row">
                        <div class="col-7">
                            Showing {{ $responses->count() }} sent messages
                        </div>
                        <div class="col-5">
                            {{ $responses->links() }}
                        </div>
                    </div>
                </div> <!-- end Col-9 -->

            </div>

        </div><!-- End row -->
    </div> <!-- container-fluid -->
</div>

@include('admin.partials.footer')
    
    </div>
    
@endsection

@push('styles')
<style>
.message-list li {
    background-color: #f8f9fa;
    border-left: 3px solid #28a745;
}

.message-list li:hover {
    background-color: #e9ecef;
}

.mail-list a.active {
    background-color: #f0f8ff;
    color: #007bff;
    font-weight: 600;
}
</style>
@endpush 