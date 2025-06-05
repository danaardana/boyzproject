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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Support</a></li>
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
                            <div class="col-xl-8 col-lg-10">
                                <div class="text-center">
                                    <h5>Need help with the Boy Projects Dashboard?</h5>
                                    <p class="text-muted">Find answers to common questions about our comprehensive e-commerce management system, from basic navigation to advanced features and troubleshooting.</p>
                                    <div>
                                        <a href="{{ route('admin.messages.index') }}" class="btn btn-primary mt-2 me-2 waves-effect waves-light">
                                            <i class="bx bx-envelope me-1"></i>Contact Support
                                        </a>
                                        <a href="{{ route('admin.documentation') }}" class="btn btn-success mt-2 waves-effect waves-light">
                                            <i class="bx bx-book me-1"></i>View Documentation
                                        </a>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="col-xl-10">
                                            <form class="app-search d-none d-lg-block mt-4" id="faq-search">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="Search FAQs..." id="search-input">
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

                        <!-- FAQ Cards -->
                        <div class="row mt-5" id="faq-container">
                            @foreach($faqs as $faq)
                            <div class="col-xl-4 col-sm-6 faq-item" data-category="{{ strtolower(str_replace(' ', '-', $faq['category'])) }}">
                                <div class="card">
                                    <div class="card-body overflow-hidden position-relative">
                                        <div>
                                            <i class="bx {{ $faq['icon'] }} widget-box-1-icon text-primary"></i>
                                        </div>
                                        <div class="faq-count">
                                            <h5 class="text-primary">{{ $faq['id'] }}.</h5>
                                        </div>
                                        <div class="mb-2">
                                            <span class="badge bg-light text-dark">{{ $faq['category'] }}</span>
                                        </div>
                                        <h5 class="mt-3 faq-question">{{ $faq['question'] }}</h5>
                                        <p class="text-muted mt-3 mb-0 faq-answer">{{ $faq['answer'] }}</p>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            @endforeach
                        </div>
                        <!-- end row -->

                        <!-- FAQ Categories Table -->
                        <div class="row mt-5">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">FAQ Categories Overview</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-hover mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Category</th>
                                                        <th scope="col">Questions Count</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Last Updated</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($faqCategories as $index => $category)
                                                    <tr>
                                                        <th scope="row">{{ $index + 1 }}</th>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-3">
                                                                    <div class="avatar-title bg-{{ $category['color'] }}-subtle text-{{ $category['color'] }} rounded-circle font-size-16">
                                                                        <i class="bx bx-help-circle"></i>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <h5 class="font-size-14 mb-1">{{ $category['name'] }}</h5>
                                                                    <p class="text-muted font-size-13 mb-0">{{ $category['name'] }} related questions</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $category['color'] }}-subtle text-{{ $category['color'] }} font-size-12">
                                                                {{ $category['count'] }} Questions
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if($category['count'] > 0)
                                                                <span class="badge bg-success-subtle text-success font-size-12">Active</span>
                                                            @else
                                                                <span class="badge bg-warning-subtle text-warning font-size-12">Empty</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="text-muted font-size-13">{{ now()->format('M d, Y') }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-3">
                                                                <a href="javascript:void(0);" class="text-success filter-category" data-category="{{ strtolower(str_replace(' ', '-', $category['name'])) }}">
                                                                    <i class="mdi mdi-eye font-size-18"></i>
                                                                </a>
                                                                <a href="javascript:void(0);" class="text-primary">
                                                                    <i class="mdi mdi-pencil font-size-18"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- end table responsive -->
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

@section('scripts')
<script>
$(document).ready(function() {
    // Search functionality
    $('#search-input').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        $('.faq-item').each(function() {
            const question = $(this).find('.faq-question').text().toLowerCase();
            const answer = $(this).find('.faq-answer').text().toLowerCase();
            const category = $(this).find('.badge').text().toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm) || category.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        
        // Show "no results" message if no items are visible
        const visibleItems = $('.faq-item:visible').length;
        if (visibleItems === 0 && searchTerm !== '') {
            if (!$('#no-results').length) {
                $('#faq-container').append(`
                    <div class="col-12" id="no-results">
                        <div class="text-center py-5">
                            <i class="bx bx-search-alt font-size-48 text-muted"></i>
                            <h5 class="mt-3">No FAQs Found</h5>
                            <p class="text-muted">No FAQs match your search criteria. Try different keywords.</p>
                        </div>
                    </div>
                `);
            }
        } else {
            $('#no-results').remove();
        }
    });
    
    // Category filter functionality
    $('.filter-category').on('click', function() {
        const category = $(this).data('category');
        
        // Reset search
        $('#search-input').val('');
        $('#no-results').remove();
        
        // Show all items first
        $('.faq-item').show();
        
        // Filter by category
        $('.faq-item').each(function() {
            if ($(this).data('category') !== category) {
                $(this).hide();
            }
        });
        
        // Scroll to FAQ section
        $('html, body').animate({
            scrollTop: $('#faq-container').offset().top - 100
        }, 800);
        
        // Add visual feedback
        $(this).closest('tr').addClass('table-active');
        setTimeout(() => {
            $(this).closest('tr').removeClass('table-active');
        }, 2000);
    });
    
    // Reset filters functionality
    $('#faq-search').on('submit', function(e) {
        e.preventDefault();
        // Trigger search on form submit
        $('#search-input').trigger('keyup');
    });
    
    // Add "Show All" functionality
    $('<button class="btn btn-outline-secondary btn-sm ms-2" id="show-all">Show All</button>')
        .insertAfter('#search-input')
        .on('click', function() {
            $('#search-input').val('');
            $('.faq-item').show();
            $('#no-results').remove();
        });
    
    // Add smooth scrolling for FAQ cards
    $('.faq-item .card').on('click', function() {
        $(this).toggleClass('shadow-lg');
        setTimeout(() => {
            $(this).removeClass('shadow-lg');
        }, 1000);
    });
    
    // Add animation on page load
    $('.faq-item').each(function(index) {
        $(this).css('opacity', '0').delay(index * 100).animate({
            opacity: 1
        }, 500);
    });
});
</script>
@endsection
