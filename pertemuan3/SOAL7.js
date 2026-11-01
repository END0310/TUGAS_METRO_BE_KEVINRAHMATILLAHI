function tunggu(ms) {
    return new Promise((resolve) => setTimeout(resolve, ms));
}

async function jalankanLangkah() {
    console.log('Mulai');
    await tunggu(1000);
    console.log('Langkah 1');
    await tunggu(1000);
    console.log('Selesai');
}

function cekStok(jumlah) {
    return new Promise((resolve, reject) => {
        if (jumlah > 0) {
            resolve('Stok tersedia');
        } else {
            reject(new Error('Stok habis'));
        }
    });
}

async function periksaStok() {
    try {
        console.log(await cekStok(5));
    } catch (error) {
        console.error(error.message);
    }
}

jalankanLangkah();
periksaStok();