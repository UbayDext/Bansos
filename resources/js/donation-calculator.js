document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('contribution-calculator');
    if (!wrapper) return;

    const input       = document.getElementById('contributionInput');
    const waButton    = document.getElementById('waButton');

    if (!input || !waButton) return;

    const disasterTitle = wrapper.dataset.disasterTitle || '';
    const whatsappAdmin = wrapper.dataset.whatsappAdmin || '';

    console.log('WA ADMIN =', whatsappAdmin);

    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(amount);
    }

    function updateWaLink() {
        // nilai sudah disaring Alpine, tapi kita jaga-jaga
        const raw = (input.value || '').replace(/\D/g, '');
        if (input.value !== raw) input.value = raw;

        const nominal = parseInt(raw || '0', 10);

        if (!nominal || !whatsappAdmin) {
            waButton.href = '#';
            waButton.classList.add('pointer-events-none', 'opacity-60');
            return;
        }

        waButton.classList.remove('pointer-events-none', 'opacity-60');

        const nominalFormatted = formatRupiah(nominal);

        const text = `
Assalamu'alaikum Admin.

Saya ingin berkontribusi untuk program "${disasterTitle}".
Jumlah donasi: ${nominalFormatted}.

Mohon informasi cara transfer / pembayaran. Terima kasih.
        `.trim();

        const encodedText = encodeURIComponent(text);
        waButton.href = `https://wa.me/${whatsappAdmin}?text=${encodedText}`;
    }

    input.addEventListener('input', updateWaLink);
    updateWaLink(); // initial
});
