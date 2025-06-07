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
                    <h4 class="mb-sm-0 font-size-18">
                        @if(isset($systemInfo))
                            {{ $systemInfo['title'] }} Documentation
                        @else
                            System Documentation
                        @endif
                    </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Support</a></li>
                            @if(isset($systemInfo))
                                <li class="breadcrumb-item"><a href="{{ route('admin.documentation.index') }}">Documentation</a></li>
                                <li class="breadcrumb-item active">{{ $systemInfo['title'] }}</li>
                            @else
                                <li class="breadcrumb-item active">Documentation</li>
                            @endif
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        @if(isset($systemInfo))
            <!-- System Documentation Header -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-md me-3">
                                            <span class="avatar-title bg-primary rounded-circle">
                                                <i class="bx bx-file-find font-size-24"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="mb-1">{{ $systemInfo['title'] }}</h4>
                                            <p class="text-muted mb-0">{{ $systemInfo['category'] }} • Version {{ $systemInfo['version'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-lg-end">
                                        <div class="d-flex gap-2 justify-content-lg-end">
                                            <a href="{{ route('admin.documentation.index') }}" class="btn btn-outline-secondary">
                                                <i class="bx bx-arrow-back me-1"></i>All Docs
                                            </a>
                                            <a href="{{ route('admin.documentation.export', $system) }}" class="btn btn-outline-primary">
                                                <i class="bx bx-download me-1"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-calendar text-muted me-2"></i>
                                        <span class="text-muted">Last Updated: {{ $systemInfo['lastUpdated'] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-tag text-muted me-2"></i>
                                        <span class="text-muted">Category: {{ $systemInfo['category'] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-code-alt text-muted me-2"></i>
                                        <span class="text-muted">Version: {{ $systemInfo['version'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documentation Content -->
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="documentation-content">
                                <div id="markdown-content">
                                    @if(isset($content))
                                        {!! \Illuminate\Support\Str::markdown($content) !!}
                                    @else
                                        {!! \Illuminate\Support\Str::markdown($readmeContent) !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Table of Contents Sidebar -->
                <div class="col-lg-3">
                    <div class="card sticky-top" style="top: 100px;">
                        <div class="card-header">
                            <h6 class="mb-0">Table of Contents</h6>
                        </div>
                        <div class="card-body">
                            <div id="toc" class="toc-content">
                                <!-- TOC will be generated by JavaScript -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary btn-sm" onclick="scrollToTop()">
                                    <i class="bx bx-up-arrow-alt me-1"></i>Back to Top
                                </button>
                                <button class="btn btn-outline-info btn-sm" onclick="printDoc()">
                                    <i class="bx bx-printer me-1"></i>Print
                                </button>
                                <a href="{{ route('admin.faq') }}" class="btn btn-outline-warning btn-sm">
                                    <i class="bx bx-help-circle me-1"></i>FAQ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Documentation Overview -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="avatar-sm me-3">
                                            <span class="avatar-title bg-primary rounded-circle">
                                                <i class="bx bx-book font-size-18"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">Boy Projects System Documentation</h5>
                                            <p class="text-muted mb-0">Comprehensive guides for all system components and features</p>
                                        </div>
                                    </div>
                                    <p class="text-muted">
                                        Welcome to the Boy Projects documentation center. Here you'll find detailed guides for each system component,
                                        including setup instructions, API references, troubleshooting guides, and best practices.
                                    </p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-lg-end">
                                        <a href="{{ route('admin.documentation.index') }}" class="btn btn-primary">
                                            <i class="bx bx-book-open me-1"></i>Browse All Documentation
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Default README Content -->
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
                    </div>
                </div>
            </div>
        @endif

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

@include('admin.partials.footer')

</div>

@endsection

@push('styles')
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

/* Table of Contents Styles */
.toc-content {
    max-height: 400px;
    overflow-y: auto;
}

.toc-content ul {
    list-style: none;
    padding-left: 0;
    margin-bottom: 0;
}

.toc-content ul ul {
    padding-left: 15px;
    margin-top: 5px;
}

.toc-content li {
    margin-bottom: 5px;
}

.toc-content a {
    color: #6c757d;
    text-decoration: none;
    font-size: 0.9em;
    display: block;
    padding: 2px 0;
    border-left: 2px solid transparent;
    padding-left: 8px;
}

.toc-content a:hover {
    color: #007bff;
    border-left-color: #007bff;
}

.toc-content a.active {
    color: #007bff;
    border-left-color: #007bff;
    font-weight: 500;
}

/* Smooth scrolling for TOC links */
html {
    scroll-behavior: smooth;
}

/* Highlight current section */
.documentation-content h1,
.documentation-content h2,
.documentation-content h3,
.documentation-content h4 {
    scroll-margin-top: 100px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    generateTableOfContents();
    setupScrollSpy();
});

function generateTableOfContents() {
    const tocContainer = document.getElementById('toc');
    const headings = document.querySelectorAll('.documentation-content h1, .documentation-content h2, .documentation-content h3, .documentation-content h4');
    
    if (headings.length === 0) {
        tocContainer.innerHTML = '<p class="text-muted small">No headings found</p>';
        return;
    }
    
    let tocHTML = '<ul>';
    let currentLevel = 1;
    
    headings.forEach((heading, index) => {
        const level = parseInt(heading.tagName.charAt(1));
        const id = heading.id || `heading-${index}`;
        const text = heading.textContent.trim();
        
        // Set ID if not exists
        if (!heading.id) {
            heading.id = id;
        }
        
        // Adjust nesting
        if (level > currentLevel) {
            tocHTML += '<ul>'.repeat(level - currentLevel);
        } else if (level < currentLevel) {
            tocHTML += '</ul>'.repeat(currentLevel - level);
        }
        
        tocHTML += `<li><a href="#${id}" class="toc-link" data-target="${id}">${text}</a></li>`;
        currentLevel = level;
    });
    
    tocHTML += '</ul>'.repeat(currentLevel);
    tocContainer.innerHTML = tocHTML;
    
    // Add click handlers
    document.querySelectorAll('.toc-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.getElementById(this.dataset.target);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
}

function setupScrollSpy() {
    const tocLinks = document.querySelectorAll('.toc-link');
    const headings = document.querySelectorAll('.documentation-content h1, .documentation-content h2, .documentation-content h3, .documentation-content h4');
    
    function updateActiveLink() {
        const scrollPosition = window.scrollY + 120;
        
        let currentHeading = null;
        headings.forEach(heading => {
            if (heading.offsetTop <= scrollPosition) {
                currentHeading = heading;
            }
        });
        
        // Remove active class from all links
        tocLinks.forEach(link => link.classList.remove('active'));
        
        // Add active class to current link
        if (currentHeading) {
            const activeLink = document.querySelector(`.toc-link[data-target="${currentHeading.id}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
            }
        }
    }
    
    window.addEventListener('scroll', updateActiveLink);
    updateActiveLink(); // Initial call
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function printDoc() {
    window.print();
}
</script>
@endpush 