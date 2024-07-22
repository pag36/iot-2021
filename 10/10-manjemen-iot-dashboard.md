# Manajemen IoT Dashboard System

# Topik Bahasan

Manajemen IoT Dashboard System

## Kemampuan Akhir yang Direncanakan

- Mahasiswa mampu mengkonfigurasi rule user pada IoT Platform
- Mahasiswa mampu mengkonfigurasi smart device
- Mahasiswa mampu mengimplementasikan program di sisi smart device merujuk pada library IoT Server yang digunakan
- Mahasiswa mampu untuk mengkomunikasikan antara smart device dan IoT Server
- Mahasiswa mampu untuk menampilkan data sensor ke IoT Dashboard System sebagai monitoring

## Teori Singkat

Layaknya sebuah IoT platform yang mempermudah pengguna dalam memvisualisaikan atau menyajikan data kepada pengguna, Node-RED
juga menyediakan sebuah dashboard agar kita dapat dengan mudah untuk menyajikan data secara live atau real time.

Untuk menggunakan atau membuat tampilan dashhboard menggunakan Node-RED juga sangat mudah, yaitu tinggal melakukan drag and
drop pada worksheet untuk setiap komponen.

![](images/dashboard.png)

<p>https://flows.nodered.org/node/node-red-dashboard</p>

## Praktikum

### 1. Install Dashboard Node-RED

Untuk menggunakan dashboard Node-RED, kita harus install terlebih dahulu modulnya terlebih dahulu. Dapat dilakukan menggunakan
2 cara untuk installasinya, sebagai berikut

1.  Menggunakan perintah `npm`.

    Langkah-langkah yang dapat dilakukan adalah sebagai berikut

    - Masuk ke direktori installasi Node-RED, ketika menggunakan EC2 terdapat di `/home/ubuntu/.node-red`. Jalankan perintah
      `cd /home/ubuntu/.node-red` di EC2 Anda.
    - Selanjutnya jalankan perintah `npm i node-red-dashboard`.

2.  Menggunakan menu `Manage pallete` pada Node-RED, mengakses Node-RED via browser.

    Langkah yang dapat dilakukan adalah sebagai berikut

    - Silakan akses Node-RED via browser, misalkan `http://ec2-52-91-160-126.compute-1.amazonaws.com:1880/`. **Sesuaikan 
    alamat atau lokasi Node-RED yang Anda install, misalkan jika menggunakan Oracle Cloud.**
    - Klik button yang terdapat di pojok kanan atas dan cari menu `Manage pallete`. Perhatikan gambar di bawah ini

      ![](images/01.png)

    - Sehingga akan muncul jendela `User Settings`, pilih tab `install` dan ketik `dashboard` sehingga akan muncul modul-modul
      yang bisa kita install dan klik `tombol install`. Untuk lebih jelasnya perhatikan gambar di bawah ini

      ![](images/02.png)

    - Akan muncul pop notifikasi proses install seperti gambar di bawah ini, silakan pilih atau klik `tombol install`.

      ![](images/03.png)

    - Silakan cek dengan melihat pada Node-RED via browser, seharusnya sudah bertambah komponen-komponen dashboard pada
      pallete yang terdapat di sebelah kanan.
      ![](images/04.png)

### 2. Membuat Dashboard Node-RED

Pada praktikum yang kedua akan dibuat sebuah tampilan seolah-olah menyalakan lampu dari internet, ikutilah langkah-langkah
sebagai berikut

1.  Terlebih dahulu pilih menu `dashboard`, yang terdapat di pojok kanan bawah. dashbaord ini adalah untuk mengkonfigurasi
    website yang akan kita buat misalkan dari sistem menu/hirarki menu ataupun title website. Perhatikan gambar di bawah ini

    ![](images/05.png)

    Setelah ditambahkan
    
    ![](images/06.png)

2.  Pada bagian `Tabs & Links` klik tombol `tab` sehingga akan ditambahkan tab baru di bawahnya, pada tab baru yang terbentuk
    yaitu `Tab 1` klik tombol `edit` sehingga akan muncul jendela `Edit dashboard tab node` seperti berikut

    ![](images/07.png)

    Pada bagian `Name` isikan `Home` dan `Icon` diganti dengan `fa-home` dan klik tombol `Update` untuk mengakhiri.

    > Untuk mengganti icon dengan yang lain bisa menggunakan `Material Design Icon, Font Awesome Icon, atau Weather Icon`.
    > Contoh di atas menggunakan style dari icon `Font Awesome Icon`.

3.  Selanjutnya tambahkan `Group` pada `Tab Home` tersebut dengan klik tombol `group`. Selanjutnya klik `edit` pada group
    yang baru ditambahkan sehingga akan muncul jendela `Edit dashboard tab node` kembali. Sesuaikan nilai-nilai seperti pada
    gambar berikut

    ![](images/08.png)

4.  Ulangi langkah sebelumnya sehingga tampilannya menjadi seperti berikut

    ![](images/09.png)

5.  Drag ke worksheet/flow node `switch` kemudian double klik sehingga akan menampilkan jendela seperti di bawah, sesuaikan
    bagian seperti `Group, Label, dan Name` seperti pada gambar di bawah ini.
    
    ![](images/10.png)
    
6.  Ulangi langkah sebelumnya, tetapi yang ditambahkan adalah node `text`, sesuaikan property seperti pada gambar berikut

    ![](images/11.png)

7.  Hubungkan `node switch` dan `node text`, hasil akhirnya adalah sebagai berikut. Kemudian silakan lakukan deploy dengan
    klik tombol `Deploy`. Untuk melihat tampilannya silakan akses Node-RED, misalnya `http://ec2-52-91-160-126.compute-1.amazonaws.com:1880/ui`.

    ![](images/12.png)
    
    Hasil akhirnya adalah sebagai berikut

    ![](images/13.png)

> Ketika melakukan installasi pada komputer atau laptop Anda, silakan alamat pada browser diganti dengan `http://localhost:1880/ui`. 

#### Pertanyaan

Silakan modifikasi flow di atas sehingga ketika node switch digeser tidak menghasilkan nilai true atau false, tetapi ketika
digeser nilainya adalah nyala atau mati. Perhatikan gambar berikut ini

Dalam keadaan mati
![](images/14.png)

Dalam keadaan hidup
![](images/15.png)

## Video Pendukung

<p>
<iframe width="790" height="494" src="https://www.youtube.com/embed/3A4RbbbzrFE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</p>

## Tugas

Buatlah sebuah dashboard website untuk memonitoring dan control pada sebuah ruang lobby, ruang kajur, dan ruang dosen.
Masing-masing ruang dengan detail node yang dibutuhkan pada node dashboard sebagai berikut;

1. Tab Home memiliki group Lobby, Ruang Kajur, dan Ruang Dosen.
   - Group Lobby terdapat 2 node inject, 2 function, gauge, dan chart.
   - Group Ruang Kajur terdapat 2 node inject, 2 function, gauge, dan chart.
   - Group Ruang Dosen terdapat 2 node inject, 2 function, gauge, dan chart.
     > Jika diperhatikan node gauge dan chart bisa otomatis berjalan, hal tersebut diaktifkan saja pada bagian otomatis
     > pada node inject.
     >
     > Sedangkan nilai yang selalu muncul acak itu menggunakan node funcion, `Math.floor(Math.random()*101)`
     >
     > Jumlah line antara node chart pada Lobby, Ruang Kajur, dan Ruang Dosen berbeda bisa dilakukan dengan cara mengubah
     > `Setup Outputs` pada function.
2. Tab Room Control terdiri dari group Lampu dan AC.
   - Group Lampu memiliki 3 switch, 3 function, dan 3 text.
   - Group AC memiliki 3 slider dan 3 text.
     > function digunakan untuk parsing boolean ke string, "nyala atau mati".
3. Tab About hanya terdiri dari text biasa.

Hasilnya adalah sebagai berikut

![](images/tugas.gif)
