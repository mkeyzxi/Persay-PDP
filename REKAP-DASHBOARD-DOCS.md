# Dokumentasi: Rekap Dashboard

## Sumber Data

Semua data diambil dari tabel `material_issues_items`, yang di-join ke `material_issues` (untuk `posting_date`) dan `projects`. Data difilter berdasarkan **tahun** dan (opsional) **bulan** dari `posting_date`.

---

## 1. Nilai SAP (`total_val_sap`)

**Kolom sumber:** `material_issues_items.val_currency`

**Rumus:**
```
Nilai SAP = SUM(val_currency)
```

**Penjelasan:** Nilai SAP adalah **total nilai rupiah** dari semua material yang tercatat di SAP pada periode tertentu. Setiap kali logistik mengimpor data SAP, setiap baris item memiliki kolom `val_currency` yang berisi nilai uang dari material tersebut. Dashboard menjumlahkan seluruh nilai ini per bulan.

---

## 2. Total Selisih (`total_selisih`)

**Kolom sumber:**
- `material_issues_items.quantity_sap` — jumlah material menurut SAP
- `material_issues_items.quantity_installed` — jumlah material yang sudah terpasang (diisi oleh Konstruksi)

**Rumus:**
```
Selisih per item  = quantity_sap - COALESCE(quantity_installed, 0)
Total Selisih     = SUM(selisih per item)
```

**Penjelasan:**
- `quantity_sap` = berapa banyak material yang **dikirim/dikeluarkan** menurut catatan SAP.
- `quantity_installed` = berapa banyak yang **benar-benar terpasang** di lapangan (diinput oleh tim Konstruksi).
- **Selisih** = material yang sudah keluar dari SAP tapi **belum terpasang**. Idealnya selisih = 0 (semua material terpakai).
- Jika `quantity_installed` masih `NULL` (belum diinput Konstruksi), dianggap 0.

| Kondisi | Arti |
|---------|------|
| Selisih > 0 | Ada material yang belum terpasang (ditampilkan warna **kuning/amber**) |
| Selisih = 0 | Semua material sudah terpasang (ditampilkan warna **hijau**) |

---

## 3. Klaster Umur Project

**Kolom sumber:** `projects.contract_start_date`

**Rumus:**
```
Umur = selisih tahun antara contract_start_date dan tanggal hari ini
```

**Penjelasan:** Setiap project yang memiliki `contract_start_date` dihitung umurnya dari tanggal mulai kontrak hingga hari ini, lalu dikelompokkan ke dalam klaster berikut:

| Klaster | Kriteria | Warna di Chart |
|---------|----------|----------------|
| < 1 Tahun | umur < 1 tahun | 🟢 Hijau |
| 1 Tahun | 1 ≤ umur < 2 tahun | 🔵 Biru |
| 2 Tahun | 2 ≤ umur < 3 tahun | 🟣 Indigo |
| 3 Tahun | 3 ≤ umur < 4 tahun | 🟡 Kuning |
| 4 Tahun | 4 ≤ umur < 5 tahun | 🟠 Oranye |
| 5+ Tahun | umur ≥ 5 tahun | 🔴 Merah |

**Tujuan:** Mengetahui distribusi umur project yang masih aktif. Project yang berumur sangat lama (5+ tahun) bisa mengindikasikan project bermasalah atau PDP yang perlu ditindaklanjuti.

---

## Filter yang Tersedia

- **Tahun**: Dinamis dari tahun `fiscal_year` paling awal di database hingga tahun saat ini
- **Bulan**: Opsional, untuk melihat data bulan tertentu saja. Jika tidak dipilih, menampilkan seluruh tahun

## File Terkait

- **Component:** `app/Livewire/RekapDashboard.php`
- **View:** `resources/views/livewire/rekap-dashboard.blade.php`
