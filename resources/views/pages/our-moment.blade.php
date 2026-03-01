<section class="py-5 moment-section">

    <div class="container fade-in">
        
        <h2 class="section-title text-center mb-5">
            <span class="title-accent">Moment Kita</span> 🌸
        </h2>

        <div class="row g-4">
            @forelse($moments as $moment)

            <div class="col-lg-4 col-md-6">

                <a href="{{ route('moments.show', $moment->slug ?: $moment->id) }}" 
                   class="moment-link">

                    <div class="card moment-card border-0 h-100">

                        <!-- Image -->
                        <div class="moment-image-wrapper">
                            <img 
                                src="{{ $moment->image_url }}" 
                                alt="{{ $moment->title }}"
                                class="moment-image"
                            >

                            <div class="moment-overlay"></div>
                        </div>

                        <!-- Content -->
                        <div class="card-body p-4">

                            <h5 class="moment-title mb-2">
                                {{ $moment->title }}
                            </h5>

                            <p class="moment-desc">
                                {{ $moment->description }}
                            </p>

                            <div class="moment-date">
                                {{ \Carbon\Carbon::parse($moment->date)->translatedFormat('d F Y') }}
                            </div>

                        </div>

                    </div>

                </a>

            </div>

            @empty
            <div class="col-12 text-center py-5">
                <div class="empty-state">
                    <div class="empty-icon">💖</div>
                    <p class="text-muted mt-3">
                        Belum ada moment tersimpan
                    </p>
                </div>
            </div>
            @endforelse
        </div>

    </div>

</section>