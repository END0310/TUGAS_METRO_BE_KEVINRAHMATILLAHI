const produk = [
    { nama: 'Pensil', harga: 2000, stok: 10 },
    { nama: 'Buku', harga: 8000, stok: 0 },
    { nama: 'Penghapus', harga: 1500, stok: 5 },
];

const produkTersedia = produk.filter((item) => item.stok > 0);
console.log('Produk yang tersedia:', produkTersedia.map((item) => item.nama));

const produkPenghapus = produk.find((item) => item.nama === 'Penghapus');
console.log('Produk Penghapus:', produkPenghapus);

produk.forEach((item) => {
    console.log(`${item.nama} - Rp${item.harga}`);
});