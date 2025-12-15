<script>
document.addEventListener('DOMContentLoaded', function () {
    const input  = document.getElementById('search-disaster');
    const cards  = Array.from(document.querySelectorAll('.disaster-card'));
    const emptyMessage = document.getElementById('disaster-empty-msg');

    if (!input || !cards.length) return;

    input.addEventListener('input', function () {
        const term = this.value.trim().toLowerCase();   // huruf kecil semua
        let visibleCount = 0;

        cards.forEach(card => {
            const title = (card.dataset.title || '').toLowerCase();

            // kalau input kosong → tampilkan semua
            // kalau tidak kosong → hanya yang DIAWALI kata kunci
            const match = term === '' ? true : title.startsWith(term);

            if (match) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        // atur pesan "Tidak ada data."
        if (emptyMessage) {
            if (visibleCount === 0) {
                emptyMessage.classList.remove('hidden');
            } else {
                emptyMessage.classList.add('hidden');
            }
        }
    });
});
</script>
