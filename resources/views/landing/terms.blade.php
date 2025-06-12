@extends('layouts.landing')

@section('content')
  <!--=== Syarat &amp; Ketentuan Start ===-->
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-12 terms">
          <h2 class="font-700">Syarat & Ketentuan</h2>
          
          <h3>1. Penerimaan Ketentuan</h3>
          <p>Dengan menggunakan layanan Boys Project, Anda setuju untuk terikat oleh syarat dan ketentuan yang berlaku. Jika Anda tidak setuju dengan ketentuan ini, mohon untuk tidak menggunakan layanan kami.</p>
          
          <h3>2. Definisi Layanan</h3>
          <p>Boys Project adalah platform yang menyediakan berbagai layanan digital termasuk namun tidak terbatas pada pembuatan website, aplikasi mobile, desain grafis, dan layanan konsultasi teknologi informasi.</p>
          
          <h3>3. Pendaftaran dan Akun Pengguna</h3>
          <p>Untuk menggunakan layanan tertentu, Anda mungkin diminta untuk mendaftar dan membuat akun. Anda bertanggung jawab untuk menjaga kerahasiaan informasi akun Anda dan semua aktivitas yang terjadi di bawah akun tersebut.</p>
          <p>Anda setuju untuk memberikan informasi yang akurat, terkini, dan lengkap selama proses pendaftaran dan memperbarui informasi tersebut agar tetap akurat dan terkini.</p>
          
          <h3>4. Penggunaan Layanan</h3>
          <p>Anda setuju untuk menggunakan layanan kami hanya untuk tujuan yang sah dan sesuai dengan ketentuan yang berlaku. Anda tidak diperkenankan untuk:</p>
          <ul>
            <li>Menggunakan layanan untuk aktivitas yang melanggar hukum</li>
            <li>Mengganggu atau merusak integritas atau kinerja layanan</li>
            <li>Mencoba mendapatkan akses tidak sah ke sistem atau data</li>
            <li>Menyalahgunakan atau mendistribusikan informasi yang diperoleh dari layanan</li>
          </ul>
          
          <h3>5. Hak Kekayaan Intelektual</h3>
          <p>Semua konten, fitur, dan fungsionalitas layanan Boys Project, termasuk namun tidak terbatas pada teks, grafis, logo, ikon, gambar, klip audio, unduhan digital, kompilasi data, dan perangkat lunak, adalah milik eksklusif Boys Project dan dilindungi oleh hukum hak cipta, merek dagang, dan hukum kekayaan intelektual lainnya.</p>
          
          <h3>6. Pembayaran dan Penagihan</h3>
          <p>Untuk layanan berbayar, Anda setuju untuk membayar semua biaya yang berlaku sesuai dengan struktur harga yang telah ditentukan. Pembayaran harus dilakukan sesuai dengan metode dan jadwal yang telah disepakati.</p>
          <p>Semua pembayaran tidak dapat dikembalikan kecuali ditentukan lain dalam kebijakan pengembalian yang berlaku atau diwajibkan oleh hukum yang berlaku.</p>
          
          <h3>7. Privasi dan Perlindungan Data</h3>
          <p>Kami menghormati privasi Anda dan berkomitmen untuk melindungi informasi pribadi Anda. Penggunaan informasi pribadi Anda diatur oleh <a href="{{ route('landing.privacy') }}"><span class="default-color">Kebijakan Privasi</span></a> kami yang merupakan bagian integral dari ketentuan ini.</p>
          
          <h3>8. Pembatasan Tanggung Jawab</h3>
          <p>Boys Project tidak bertanggung jawab atas kerugian langsung, tidak langsung, insidental, khusus, atau konsekuensial yang timbul dari penggunaan atau ketidakmampuan menggunakan layanan kami, termasuk namun tidak terbatas pada kerusakan karena kehilangan data atau keuntungan.</p>
          
          <h3>9. Penghentian Layanan</h3>
          <p>Kami berhak untuk menghentikan atau menangguhkan akses Anda ke layanan kami, dengan atau tanpa pemberitahuan, karena alasan apa pun, termasuk namun tidak terbatas pada pelanggaran ketentuan ini.</p>
          
          <h3>10. Perubahan Ketentuan</h3>
          <p>Boys Project berhak untuk mengubah atau memperbarui syarat dan ketentuan ini kapan saja tanpa pemberitahuan sebelumnya. Perubahan akan berlaku segera setelah dipublikasikan di website kami. Penggunaan berkelanjutan atas layanan kami setelah perubahan tersebut akan dianggap sebagai penerimaan atas ketentuan yang telah diperbarui.</p>
          
          <h3>11. Hukum yang Berlaku</h3>
          <p>Syarat dan ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum Republik Indonesia. Setiap sengketa yang timbul akan diselesaikan melalui pengadilan yang berwenang di Indonesia.</p>
          
          <h3>12. Kontak</h3>
          <p>Jika Anda memiliki pertanyaan tentang syarat dan ketentuan ini, silakan hubungi kami melalui:</p>
          <ul>
            <li>Email: info@boysproject.com</li>
            <li>Telepon: +62  8211 9904 42</li>
            <li>Live Chat di website ini</li>
          </ul>
          
          <p><strong>Terakhir diperbarui:</strong> {{ date('d F Y') }}</p>
        </div>
      </div>
    </div>
  </section>
  <!--=== Syarat &amp; Ketentuan End ===-->
@endsection 