@if(session('success'))
<div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-check-circle-fill"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-exclamation-triangle-fill"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-start gap-2">
        <i class="bi bi-exclamation-triangle-fill mt-1"></i>
        <div>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
