Sistem Webgis Inventarisasi Penyebaran Covid-19 ini berbasis website, membutuhkan koneksi server local beserta MySQL, dan koneksi internet yang baik.

~~ UNTUK MENGAKSES SISTEM: ~~
1. Pertama-tama buat database bernama `bds_uas_covid19`, 
kemudian import file `bds_uas_covid19.sql` yang terletak di folder resources ke database tersebut.

2. Buka file `connection.php` yang terletak di folder server. 
Ubah nilai variabel $pw sesuai dengan password database Anda.

3. Buka browser modern Anda lalu ketikkan di url browser: `[lokasi server:port]/160717023_uas_bds/client/index.html`.
Contoh: `http://localhost:8080/160717023_uas_bds/client/index.html`

~~ GARIS BESAR SISTEM: ~~
1. Secara default, user akan mengakses sitem sebagai masyarakat dan sistem menampilkan peta persebaran pasien yang terjangkit covid19. 
Tunggu beberapa detik, sebab sistem sedang menampilkan layer kabupaten_kota.geojson penyebaran covid19 & data-data pendukung dari server.

2. Warna gradasi persebaran pasien covid19 terdapat di bawah peta, yang dimulai dari kuning terang hingga merah pekat. 
Jika peta dizoom hingga ke sebuah kabupaten/kecamatan maka akan muncul nama kabupaten/kecamatan tersebut beserta jumlah pasien.

-- Admin --
3. JIKA INGIN LOGIN SEBAGAI ADMIN, klik tulisan `Login Admin` di bar atas sistem. Anda akan diarahkan ke login.html. 
Kemudian, isikan: username = adminpro & password = coronavirus. 
Tunggu beberapa detik dan Anda akan diarahkan kembali ke beranda sebagai admin sistem.

4. Sebagai Admin, akan terdapat panel memanjang khusus Admin yang terletak di atas peta. 
Di panel ini admin dapat melakukan digit point untuk menambahkan pasien (penderita/suspect) covid19. 
Selain itu, admin dapat menyalakan/mematikan layer penderita atau suspect covid19, yang kedua layer tersebut berupa icon berwarna merah dan biru di peta.

5. Untuk menambahkan pasien covid19, klik tombol `Digit Point` dan arahkan cursor ke lokasi karantina di sebuah kabupaten/kota pasien baru tersebut. 
Setelah cursor diklik, akan muncul popup berupa form data pasien. 
Isikan semua data pasien yang diminta. Jika berhasil menambahkan, icon pasien akan muncul di peta. 
Jika tidak ingin menambahkan pasien, dan mengakhiri digit point klik `Batal Digit Point` di panel admin. 

6. Klik salah satu layer icon pasien di peta, maka akan muncul overlay informasi pasien. 
Terdapat tombol `Ubah` dan `Hapus` pasien ini. Admin bisa mengklik salah satu tombol tersebut untuk mengubah atau menghapus pasien.

~~ FITUR TAMBAHAN: ~~
1. Terdapat panel di sebelah kiri yang menginfokan pengguna terkait ringkasan kasus pasien, 
yaitu terdapat jumlah pasien dan rata-rata jumlah pasien yang dilaporkan per hari oleh admin sejak 28 Februari 2020.

2. Terdapat searchbox (persis di atas peta) untuk mencari propinsi yang terjangkit covid19. 
Ketika diketikkan kata pencarian, misalnya jawa timur, maka secara otomatis akan muncul sugesti pencarian dengan format: 
`[kode propinsi] - [nama propinsi] ([jumlah pasien])`, misalnya `32 - JAWA TIMUR (3)`. 
Jika salah satu sugesti propinsi ditekan, maka sistem akan memindahkan fokus peta ke propinsi tersebut dan 
akan disertai grafik lingkaran (pie chart) yang menginfokan data penderita & pasien untuk propinsi tersebut.

3. Terdapat panel di sebelah kanan yang menampilkan Kasus Penyebaran Virus per Propinsi. 
Klik salah satu propinsi yang ada dari pilihan dan sistem juga akan memindahkan fokus peta ke propinsi tersebut dan 
akan disertai grafik lingkaran (pie chart) yang menginfokan data penderita & pasien untuk propinsi tersebut.

4. Grafik lingkaran (pie chart) yang menginfokan data penderita & pasien untuk propinsi tersebut ketika sebuah propinsi dipilih.

5. Di bagian paling bawah sistem, terdapat 2 grafik yaitu: 
Grafik Pie Chart Kasus per Propinsi dan Grafik Garis Pelaporan Pasien Covid-19 Per Bulan (Sejak Bulan Februari).

6. Marker Cluster untuk membuat clustering/ grouping atau pengelompokkan marker pada peta, sesuai dengan level zoom.

7. Fitur Fullscreen di bagian kiri atas peta, untuk menampilkan peta secara penuh pada layar brower user.

8. Print peta menjadi file gambar PNG. User dapat mengakses fitur ini melalui bagian atas kiri dari peta.
Bentuk print gambar yang disediakan sistem adalah: CurrentSize (Ukuran tampilan peta sesungguhnya pada browser), A4 Landscape, dan A4 Potrait
