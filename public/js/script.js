document.getElementById("up3").addEventListener("click", function (e) {
    e.preventDefault(); // Mencegah langsung ke /up3

    Swal.fire({
        title: "Masukkan Kunci Akses",
        input: "password",
        inputLabel: "Kunci diperlukan untuk membuka halaman UP3",
        inputPlaceholder: "Masukkan kunci di sini",
        showCancelButton: true,
        confirmButtonText: "Buka",
        preConfirm: (password) => {
            if (password !== "rahasia123") {
                Swal.showValidationMessage("Kunci salah!");
                return false;
            }
        },
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/monitoring_pascabayar_daftung/administrator";
        }
    });
});
document
    .getElementById("unit_ulp_pascabayar")
    .addEventListener("change", function () {
        const unit = this.value;
        fetch(`/get-rekap-data/${unit}`)
            .then((response) => response.json())
            .then((data) => {
                if (data) {
                    // Set data dari server
                    document.getElementById("target_carry_over").value =
                        data.target_carry_over ?? "";
                    document.getElementById("target_harian").value =
                        data.target_harian ?? "";
                    document.getElementById("realisasi").value =
                        data.realisasi ?? "";
                    document.getElementById("persen_pencapaian").value =
                        data.persen_pencapaian ?? "";
                    document.getElementById("unit_ulp_daftung").value =
                        data.unit_ulp_daftung ?? "";
                    document.getElementById("daftung_pagi").value =
                        data.daftung_pagi ?? "";
                    document.getElementById("cetak_pk_pagi").value =
                        data.cetak_pk_pagi ?? "";
                    document.getElementById("cetak_pk_siang").value =
                        data.cetak_pk_siang ?? "";
                    document.getElementById("jumlah_peremajaan").value =
                        data.jumlah_peremajaan ?? "";
                } else {
                    // Reset data
                    document.getElementById("target_carry_over").value = "";
                    document.getElementById("target_harian").value = "";
                    document.getElementById("realisasi").value = "";
                    document.getElementById("persen_pencapaian").value = "";
                    document.getElementById("unit_ulp_daftung").value = "";
                    document.getElementById("daftung_pagi").value = "";
                    document.getElementById("cetak_pk_pagi").value = "";
                    document.getElementById("cetak_pk_siang").value = "";
                    document.getElementById("jumlah_peremajaan").value = "";
                }

                // Tambahkan baris ini untuk menyamakan ULP daftung
                document.getElementById("unit_ulp_daftung").value = unit;
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    });
