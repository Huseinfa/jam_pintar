        {{-- Partial: single result card (no html/head/body) --}}

        {{-- HEADER --}}
        <div class="header">
            <div class="logo">
                SMARTPEAK
            </div>

            <div class="header-title">
                Hasil Rekomendasi Belajar
            </div>

            <div class="header-subtitle">
                Dokumen ini berisi hasil rekomendasi waktu belajar berdasarkan
                jawaban kuisioner yang telah diisi pada sistem SmartPeak.
            </div>
        </div>

        {{-- PREFERRED STUDY TIME --}}
        <div class="card">
            <div class="section-title">
                Preferred Study Time
            </div>

            <div class="study-badge">
                {{ strtoupper($result->recommendation->preferred_study_time ?? $result->recommendation->prefered_study_time) }}
            </div>
        </div>

        {{-- RECOMMENDATION --}}
        <div class="card">
            <div class="section-title">
                Rekomendasi Belajar
            </div>

            <div class="recommendation-text">
                {{ $result->recommendation->recomendation }}
            </div>
        </div>

        {{-- STUDY HOURS --}}
        <div class="card">

            <div class="section-title">
                Waktu Belajar yang Disarankan
            </div>

            <div class="time-wrapper">

                {{-- MAIN TIME --}}
                <div class="time-box">

                    <div class="time-label">
                        Jam Belajar Utama
                    </div>

                    <div class="time-value">
                        {{ \Carbon\Carbon::parse($result->recommendation->study_hour_start)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($result->recommendation->study_hour_end)->format('H:i') }}
                    </div>

                </div>

                {{-- ALT TIME --}}
                <div class="time-box right">

                    <div class="time-label">
                        Jam Alternatif
                    </div>

                    <div class="time-value">

                        @if($result->recommendation->alt_study_hour_start && $result->recommendation->alt_study_hour_end)

                            {{ \Carbon\Carbon::parse($result->recommendation->alt_study_hour_start)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($result->recommendation->alt_study_hour_end)->format('H:i') }}

                        @else
                            -
                        @endif

                    </div>

                </div>

            </div>

            <div style="clear: both;"></div>

        </div>

        <div class="divider"></div>
