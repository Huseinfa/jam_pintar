<div class="alert alert-info">
    @if ($boost_source === 'github')
        ✅ Rekomendasi diperkuat dari aktivitas GitHub kamu (slot: {{ $boost_slot }})
    @elseif ($boost_source === 'manual_input')
        📝 Rekomendasi diperkuat dari jam belajar yang kamu input (slot: {{ $boost_slot }})
    @else
        📊 Rekomendasi berdasarkan analisis kebiasaan belajar murni (EDAS)
    @endif
</div>

<h2>Waktu Belajar Optimal: <strong>{{ $recommendation }}</strong></h2>