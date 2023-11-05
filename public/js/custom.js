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

