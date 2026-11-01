const daftarBuku = [
    { judul: 'Laskar Pelangi', harga: 85000, stok: 5, kategori: 'Novel' },
    { judul: 'Filosofi Teras', harga: 98000, stok: 0, kategori: 'Self-Help' },
    { judul: 'Atomic Habits', harga: 120000, stok: 3, kategori: 'Self-Help' },
    { judul: 'Bumi Manusia', harga: 105000, stok: 2, kategori: 'Novel' },
];

const bukuTersedia = daftarBuku
    .filter((buku) => buku.stok > 0)
    .map((buku) => buku.judul);
console.log('Buku yang tersedia:', bukuTersedia);

const totalHarga = daftarBuku.reduce((total, buku) => total + buku.harga, 0);
console.log('Total harga seluruh buku:', `Rp${totalHarga}`);

daftarBuku.forEach((buku) => {
    console.log(`${buku.judul} - Rp${buku.harga} (Stok: ${buku.stok})`);
});

function prosesPembayaran(judulBuku) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            const buku = daftarBuku.find((item) => item.judul === judulBuku);

            if (buku && buku.stok > 0) {
                resolve(`Pembayaran berhasil untuk buku: ${judulBuku}`);
            } else {
                reject(new Error('Gagal: Buku tidak tersedia atau stok habis!'));
            }
        }, 1500);
    });
}

async function transaksiToko() {
    try {
        console.log(await prosesPembayaran('Atomic Habits'));
    } catch (error) {
        console.error(error.message);
    }

    try {
        console.log(await prosesPembayaran('Filosofi Teras'));
    } catch (error) {
        console.error(error.message);
    }
}

transaksiToko();