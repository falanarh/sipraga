let elements = document.querySelectorAll(".bg-rounded-prior");
elements.forEach((element) => {
    if (element.textContent === "Sedang") {
        element.style.backgroundColor = "#FF9800";
    } else if (element.textContent === "Rendah") {
        element.style.backgroundColor = "#C3C562";
    } else if (element.textContent === "Tinggi") {
        element.style.backgroundColor = "#900C3F";
    }
});

let elements2 = document.querySelectorAll(".bg-rounded-status");
elements2.forEach((element) => {
    if (element.textContent === "Menunggu") {
        element.style.backgroundColor = "#F8DE22";
    } else if (element.textContent === "Dikerjakan") {
        element.style.backgroundColor = "#539BFF";
    } else if (element.textContent === "Selesai") {
        element.style.backgroundColor = "#13DEB9";
    } else if (element.textContent === "Ditolak") {
        element.style.backgroundColor = "#F6412D";
    }
});

let elements3 = document.querySelectorAll(".bg-rounded-status-pengelolaan");
elements3.forEach((element) => {
    if (element.textContent === "Menunggu") {
        element.style.backgroundColor = "#FFAE1F";
    } else if (element.textContent === "Disetujui") {
        element.style.backgroundColor = "#13DEB9";
    } else if (element.textContent === "Ditolak") {
        element.style.backgroundColor = "#FF2C1F";
    }
});

let elements4 = document.querySelectorAll(".bg-rounded-jenis");
elements4.forEach((element) => {
    if (element.textContent === "Kursi") {
        element.style.backgroundColor = "#2EC586";
    } else if (element.textContent === "Meja Dosen") {
        element.style.backgroundColor = "#2E86C5";
    } else if (element.textContent === "Papan Tulis") {
        element.style.backgroundColor = "#FFAE1F";
    }
});

let elements5 = document.querySelectorAll(".bg-rounded-status-pengecekan");
elements5.forEach((element) => {
    if (element.textContent === "Belum dikerjakan") {
        element.style.backgroundColor = "#FFAE1F";
    } else if (element.textContent === "Sudah dikerjakan") {
        element.style.backgroundColor = "#13DEB9";
    }
});

let elements6 = document.querySelectorAll(".bg-rounded-status-monitoring");
elements6.forEach((element) => {
    if (element.textContent === "Belum Dikerjakan") {
        element.style.backgroundColor = "#FFAE1F";
    } else if (element.textContent === "Sedang Dikerjakan") {
        element.style.backgroundColor = "#539BFF";
    } else if (element.textContent === "Selesai Dikerjakan") {
        element.style.backgroundColor = "#13DEB9";
    }
});


// Fungsi untuk menampilkan SweetAlert konfirmasi
function showConfirmUbahDialog() {
    Swal.fire({
        title: "Yakin ingin mengubah status jadwal?",
        text: "Anda tidak dapat mengembalikan ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, ubah!",
    }).then((result) => {
        if (result.isConfirmed) {
            // Aksi yang ingin Anda lakukan ketika konfirmasi diterima
            Swal.fire(
                "Diubah!",
                "Status jadwal telah berhasil diubah.",
                "success"
            );
        }
    });
}

// Menambahkan event listener ke tombol "Ubah"
document.querySelectorAll(".ubahButton").forEach(function (button) {
    button.addEventListener("click", function (e) {
        e.preventDefault(); // Untuk mencegah aksi bawaan dari hyperlink
        showConfirmUbahDialog(); // Menampilkan konfirmasi saat tombol "Ubah" diklik
    });
});
