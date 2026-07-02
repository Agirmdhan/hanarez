<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Syarat & Ketentuan - Hanarez</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 40px 20px;
        }
        .paper {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,.08);
            padding: 48px 56px;
        }
        h1 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            text-align: center;
            margin: 0 0 8px;
        }
        .subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 13px;
            margin: 0 0 36px;
        }
        h2 {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            margin: 28px 0 10px;
        }
        p {
            font-size: 14px;
            line-height: 1.7;
            color: #374151;
            margin: 0 0 12px;
        }
        ul {
            margin: 8px 0 16px;
            padding-left: 24px;
        }
        ul li {
            font-size: 14px;
            line-height: 1.7;
            color: #374151;
            margin-bottom: 6px;
        }
        .footer-print {
            text-align: center;
            margin-top: 36px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #9ca3af;
        }
        @media print {
            body { background: #fff; padding: 0; }
            .paper { box-shadow: none; padding: 40px; border-radius: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="paper">
        <div class="no-print" style="text-align:right;margin-bottom:16px;display:flex;gap:8px;justify-content:flex-end;flex-wrap:wrap;">
            <a href="{{ asset('dokumen/Syarat_dan_Ketentuan_Kos_Hanarez_Putri.docx') }}" 
               style="padding:8px 18px;background:#2563eb;color:#fff;border:0;border-radius:6px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download DOCX
            </a>
            <button onclick="window.print()" style="padding:8px 18px;background:#1f2937;color:#fff;border:0;border-radius:6px;font-size:13px;font-weight:600;cursor:pointer;">
                Cetak PDF
            </button>
            <a href="{{ url('/register') }}" style="padding:8px 18px;background:#e5e7eb;color:#374151;border:0;border-radius:6px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;">
                &larr; Kembali
            </a>
        </div>

        <h1>SYARAT DAN KETENTUAN</h1>
        <p class="subtitle" style="font-size:12px;line-height:1.5;">
            PENDAFTARAN PENGHUNI KOS PUTRI<br>
            HANAREZ PUTRI<br>
            Jl. Pancoran Barat XIJ No.4, RT.12/RW.3, Pancoran, Kec. Pancoran,<br>
            Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12780
        </p>

        <p>Dokumen ini berisi syarat dan ketentuan yang wajib dibaca, dipahami, dan disetujui oleh calon penghuni sebelum melakukan pendaftaran dan menempati kamar di Hanarez Putri. Dengan mendaftar, calon penghuni dianggap telah menyetujui seluruh ketentuan di bawah ini.</p>

        <h2>1. Ketentuan Umum</h2>
        <ul>
            <li>Kos ini diperuntukkan khusus bagi penghuni putri. Pendaftar wajib melampirkan identitas diri (KTP/KTM) yang masih berlaku.</li>
            <li>Calon penghuni wajib berusia minimal 17 tahun, atau didampingi persetujuan orang tua/wali bagi yang belum cukup umur.</li>
            <li>Pendaftaran dilakukan melalui sistem pendaftaran online dan dinyatakan sah setelah data diverifikasi oleh admin/pengelola kos.</li>
            <li>Penghuni wajib mengisi data pribadi dengan benar, termasuk nomor kontak yang dapat dihubungi dan kontak darurat (keluarga/wali).</li>
            <li>Masa sewa minimal adalah 1 (satu) bulan dan dapat diperpanjang sesuai kesepakatan.</li>
        </ul>

        <h2>2. Ketentuan Pembayaran</h2>
        <ul>
            <li>Sewa kamar dibayarkan secara bulanan dan wajib dilunasi paling lambat tanggal awal masuk setiap bulannya.</li>
            <li>Pembayaran dilakukan melalui sistem pembayaran online yang tersedia pada aplikasi/website kos, dengan mengunggah bukti transfer sebagai konfirmasi.</li>
            <li>Keterlambatan pembayaran lebih dari 7 (tujuh) hari dari batas waktu akan dikenakan denda sebesar Rp50.000 per hari keterlambatan.</li>
            <li>Apabila penghuni menunggak pembayaran lebih dari 1 (satu) bulan tanpa konfirmasi, pengelola berhak meninjau ulang status keanggotaan penghuni.</li>
            <li>Biaya yang sudah dibayarkan tidak dapat ditarik kembali (non-refundable), kecuali dalam kondisi yang diatur pada bagian Pembatalan dan Pengakhiran Sewa.</li>
        </ul>

        <h2>3. Jam Malam dan Ketertiban</h2>
        <ul>
            <li>Jam malam berlaku mulai pukul 22.00 WIB. Penghuni diharapkan sudah berada di dalam kos pada jam tersebut.</li>
            <li>Penghuni yang pulang melebihi jam malam wajib memberi konfirmasi kepada admin/pengelola kos sebelumnya.</li>
            <li>Pintu utama kos akan dikunci pada jam malam; penghuni bertanggung jawab membawa kunci/akses masuk masing-masing.</li>
            <li>Dilarang membuat keributan, memutar musik dengan volume keras, atau mengganggu kenyamanan penghuni lain, terutama di atas jam malam.</li>
            <li>Penghuni wajib menjaga kebersihan kamar dan area bersama (dapur, kamar mandi, ruang tamu, dan lainnya).</li>
        </ul>

        <h2>4. Ketentuan Tamu</h2>
        <ul>
            <li>Tamu (termasuk keluarga) hanya diperbolehkan berkunjung pada jam kunjungan, yaitu pukul 08.00–20.00 WIB.</li>
            <li>Tamu laki-laki dilarang masuk ke area kamar dan hanya diperbolehkan menunggu di ruang tamu/area bersama yang disediakan.</li>
            <li>Tamu yang menginap (menginap sehari atau lebih) wajib mendapat izin baik tertulis atau by chat dari pengelola kos terlebih dahulu.</li>
            <li>Penghuni bertanggung jawab penuh atas perilaku tamu yang dibawa masuk ke area kos.</li>
        </ul>

        <h2>5. Fasilitas dan Perawatan Kamar</h2>
        <ul>
            <li>Kamar diserahkan dalam kondisi bersih dan fasilitas yang berfungsi normal pada saat penghuni mulai menempati kamar.</li>
            <li>Kerusakan fasilitas akibat kelalaian penghuni menjadi tanggung jawab penghuni untuk memperbaiki atau mengganti.</li>
            <li>Kerusakan fasilitas di luar kelalaian penghuni (kerusakan wajar/teknis) dapat dilaporkan melalui fitur laporan keluhan pada sistem, dan akan ditindaklanjuti oleh pengelola.</li>
            <li>Dilarang memindahkan barang inventaris kos (kasur, lemari, meja, dan lainnya) keluar dari kamar tanpa izin pengelola.</li>
            <li>Dilarang melakukan perubahan permanen pada kamar (mengecat, melubangi dinding, dan sejenisnya) tanpa izin tertulis dari pengelola.</li>
        </ul>

        <h2>6. Larangan dan Sanksi Pelanggaran</h2>
        <ul>
            <li>Dilarang membawa, mengonsumsi, atau menyimpan minuman keras, narkoba, dan barang terlarang lainnya di area kos.</li>
            <li>Dilarang merokok di dalam kamar maupun area dalam gedung kos.</li>
            <li>Dilarang melakukan tindakan asusila, kekerasan, atau hal-hal yang melanggar norma kesusilaan dan hukum yang berlaku.</li>
            <li>Pelanggaran terhadap larangan di atas dapat dikenakan sanksi berupa teguran tertulis, denda, hingga pemutusan kontrak sewa secara sepihak tanpa pengembalian biaya.</li>
        </ul>

        <h2>7. Pembatalan dan Pengakhiran Sewa</h2>
        <ul>
            <li>Penghuni yang ingin mengakhiri masa sewa wajib memberi pemberitahuan tertulis atau chat kepada pengelola minimal 7 (tujuh) hari sebelumnya.</li>
            <li>Pengelola berhak mengakhiri masa sewa secara sepihak apabila penghuni terbukti melanggar ketentuan dalam dokumen ini secara berulang.</li>
            <li>Penghuni wajib mengembalikan kamar dalam kondisi bersih dan fasilitas lengkap pada saat pengakhiran sewa.</li>
        </ul>

        <h2>8. Ketentuan Penutup</h2>
        <ul>
            <li>Pengelola berhak mengubah syarat dan ketentuan ini sewaktu-waktu, dan perubahan akan diinformasikan melalui fitur pengumuman pada sistem.</li>
            <li>Dengan menyelesaikan proses pendaftaran, calon penghuni dinyatakan telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan yang berlaku.</li>
            <li>Hal-hal yang belum diatur dalam dokumen ini akan ditentukan kemudian oleh pengelola kos.</li>
        </ul>

        <div style="margin-top:36px;padding-top:20px;border-top:1px solid #e5e7eb;">
            <p style="font-size:13px;color:#6b7280;"><em>Dengan mencentang kotak persetujuan pada formulir pendaftaran, saya menyatakan telah membaca dan menyetujui seluruh Syarat dan Ketentuan di atas.</em></p>
            <div style="margin-top:20px;display:grid;grid-template-columns:1fr 1fr;gap:16px;font-size:13px;color:#374151;">
                <div>
                    <p>Nama Lengkap: ____________________________</p>
                    <p style="margin-top:24px;">Tanggal: ___________</p>
                </div>
                <div style="text-align:right;">
                    <p>Tanda Tangan: ____________________________</p>
                </div>
            </div>
        </div>

        <div class="footer-print">
            Hanarez Putri &mdash; Dokumen Syarat & Ketentuan
        </div>
    </div>
</body>
</html>