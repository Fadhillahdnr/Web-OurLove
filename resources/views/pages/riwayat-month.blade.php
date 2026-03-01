<section class="anniversary-section py-5">

    <div class="container">

        <div class="text-center mb-5">
            <h2 class="section-title">
                💕 Riwayat Anniversary Kita 💕
            </h2>
            <p class="text-muted">
                Setiap bulan adalah cerita baru yang indah ✨
            </p>
        </div>

        <div class="timeline-wrapper">

            @forelse($anniversaries as $log)

                @php
                    $isMilestone = in_array($log->month_number, [6,12,18,24]);
                @endphp

                <div class="timeline-item">

                    <div class="timeline-dot {{ $isMilestone ? 'milestone-dot' : '' }}"></div>

                    <div class="timeline-card {{ $isMilestone ? 'milestone-card' : '' }}">

                        <h5 class="fw-bold text-danger mb-1">
                            Bulan ke-{{ $log->month_number }} 💖
                        </h5>

                        <small class="text-muted d-block mb-3">
                            {{ \Carbon\Carbon::parse($log->date)->translatedFormat('d F Y') }}
                        </small>

                        <p class="mb-0">
                            {{ $log->message }}
                        </p>

                        @if($isMilestone)
                            <span class="badge bg-warning text-dark mt-3">
                                🌟 Special Milestone
                            </span>
                        @endif

                    </div>

                </div>

            @empty
                <div class="text-center">
                    <p class="text-muted">Belum ada riwayat anniversary 💗</p>
                </div>
            @endforelse

        </div>

    </div>

</section>