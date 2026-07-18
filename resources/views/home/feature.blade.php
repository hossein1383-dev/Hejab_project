@php
    $features = App\Models\Feature::all();
@endphp

<section class="card-area pt-5">
    <div class="container pb-3">
        <div class="row gy-4 gx-4">
            @foreach ($features as $feature)
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card text-center h-100 shadow-sm feature-card">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <div class="card-icon-wrapper mb-3 d-flex align-items-center justify-content-center">
                                <i class="bi {{ $feature->icon }} fs-2 text-white card-icon"></i>
                            </div>
                            <p class="card-text fw-bold mb-1">{{ $feature->title }}</p>
                            <p class="card-text small text-muted">{{ $feature->body }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
