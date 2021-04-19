# IoT Gateway dan Web Dashboard

# Topik Bahasan

IoT Gateway dan Message Broker

## Kemampuan Akhir yang Direncanakan

- Mahasiswa faham tentang konsep IoT Gateway dan penggunaannya
- Mahasiswa mampu melakukan instalasi dan konfigurasi message broker.
- Mahasiswa mampu mengolah data sensor di dalam server local atau cloud.
- Mahasiswa bisa membuat dashboard sederhana data sensor

## Teori Singkat
 

## Praktikum
### 1. Konfigurasi Web Server dan PHP
Data-data yang dihasilkan oleh sensor agar lebih menarik perlu divisualisasi atau ditampilkan, dalam hal ini pada sebuah
halaman website. Jika pada praktikum yang sebelumnya kita telah berhasil memanfaatkan IoT Platform, Node-RED untuk menampilkan
data tersebut. Pada kesempatan kali ini akan dicoba untuk membuat visualisasi data dari awal, butuh sebuah web server dan
PHP. Kemudian untuk memudahkan membuat kode program karena akan membutuhkan dashboard, misalkan chart, gauge, dan yang lain
digunakan codeigniter4 dan framework css menggunakan bootstramp.

Seperti biasanya kita akan menyiapkan instance, EC2 untuk kebutuhan di atas. Langkah-langkahnya adalah sebagai berikut
1. Buatlah sebuah instance EC2, kemudian pada langkah `3. Configure Instance` tambahkan baris perintah di bawah ini pada 
   bagian `User Data`. Untuk lebih jelasnya perhatikan gambar di bawah ini
   ![](images/01.png)
   
   ```shell
   #!/bin/bash
   apt update
   apt install apache2 php libapache2-mod-php -y
   apt install php-json php7.4-mysql php-xml php-intl php-curl -y
   apt install composer -y
   ```
   Dengan menggunakan script di atas, kita tidak perlu repot-repot menjalankan satu persatu ketika instance berhasil dibuat
karena sudah dijalankan ketika proses pembuatan instance.
   > Di EC2 kita diizinkan untuk membuat script ketika membuat instance, biasanya yang disupport adalah bash scripting atau 
   > perintah dasar pada sebuah terminal. Ketika bash script tersebut dijalankan, maka akan dijalankan sebagai user root
   > sehingga ketika kita ingin membuat direktori pada path tertentu harus full path, misalkan buat direktori di home
   > berarti `mkdir /home/ubuntu/[nama direktori]`

2. Silakan tambahkan port http yaitu 80 pada langkah `6. Configure Security Group`. Port tersebut digunakan untuk akses
web server atau web yang akan kita buat.

3. Setelah instance berhasil dijalankan, kemudian silakan buka browser Anda kemudian ketik/paste domain(alamat) dari instance
tersebut. Misalkan domain saya adalah `http://ec2-54-227-120-124.compute-1.amazonaws.com/` seharusnya akan muncul tampilan
   seperti pada gambar berikut
   
   ![](images/02.png)

4. Untuk memudahkan proses pengembangan aplikasi web, kita akan mencoba menggunakan framework codeigniter4. Silakan masuk
ke EC2 yang telah dibuat sebelumnya, bisa menggunakan putty atau perintah ssh. Jalankan beberapa baris perintah di bawah ini
   
   ```shell
   composer create-project codeigniter4/appstarter iot-jti --no-dev
   sudo chown -Rv www-data iot-jti/writable
   sudo mv iot-jti/ /var/www/html/
   ```
   Langkah installasi codeigniter menggunakan perintah `composer` agar lebih gampang karena akan download di repository,
langkah yang lain bisa secara manual dengan mengunjungi website codeigniter dan download.
   
5. Ketika akses instance melalui browser yang ditampilkan masih halaman index dari apache, kita akan mencoba untuk mengubah 
halaman tersebut menjadi halaman codeigniter. Sebelumnya kita harus membuat konfigurasi untuk website kita, ketik beberapa 
   perintah di bawah ini

   ```shell
   sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/iot-jti.conf
   sudo nano /etc/apache2/sites-available/iot-jti.conf
   sudo a2ensite iot-jti.conf
   sudo a2dissite 000-default.conf
   sudo systemctl restart apache2
   ```   
   >Ketika menjalankan perintah `sudo nano /etc/apache2/sites-available/iot-jti.conf` silakan dicari `DocumentRoot /var/www/html`
   > kemudian diganti menjadi `DocumentRoot /var/www/html/iot-jti/public`, hanya mengganti path-nya saja. CTRL+O kemudian 
   > enter untuk menyimpan perubahan dan CTRL+x untuk keluar editor nano.

6. Buka browser atau kembali browser, kemudian ketik alamat ip atau dns instance. Misalkan `http://ec2-54-227-120-124.compute-1.amazonaws.com/`
seharusnya akan menampilkan halaman seperti pada gambar berikut
   
   ![](images/03.png)

7. Untuk mempermudah proses coding, aktifkan mode debug codeigniter menggunakan perintah di bawah ini
   
   ```shell
      cd /var/www/html/iot-jti
      mv env .env
      nano .env
   ```
   > Silakan dicari pada bagian `# CI_ENVIRONMENT = production` diubah menjadi  `CI_ENVIRONMENT = development`, tekan 
   > CTRL+O kemudian enter untuk menyimpan perubahan dan CTRL+x untuk keluar editor nano.

8. Buka kembali browser, ketik alamat ip atau dns seharusnya akan menampilkan seperti pada gambar berikut pada bagian bawah
halaman codeigniter.
   
   ![](images/04.png)

>Codeignier sudah berhasil terpasang pada instance atau server, selanjutnya adalah membuat kode sesuai dengan kebutuhan.
> Skenario yang bisa dilakukan adalah untuk mengedit atau mengubah kode yang terdapat di codeigniter yaitu bisa menggunakan
> repository, misalkan git. Upload semua satu project codeigniter ke repository yang di server, kemudian bisa di-clone ke 
> komputer lokal atau laptop untuk melaukan editing. Ketika selesai edit, push ke repository dan di server atau instance 
> harus melakukan pull.
> 
> Skenario yang lain, download project codeigniter di server pindah ke laptop/lokal komputer. Bisa menggunakan WinSCP atau tool
> yang lain. Ketika ada perubahan di lokal, maka harus upload perubahan tersebut yang ada di server.
> 
> Jujur lebih menyarankan skenario yang pertama untuk menghindari terjadi konflik, terlebih lagi ketika pengembangannya sudah
> lebih dari satu orang.

#### Pertanyaan
1. Jelaskan fungsi perintah-perintah yang dimasukan ke dalam `User Data` ketika membuat sebuah instance EC2?
2. Fungi dari perintah `sudo a2dissite 000-default.conf`?

### 2. Konfigurasi Message Broker
Untuk praktikum sebelumnya kita memanfaatkan message broker yang sudah ada, dalam praktikum yang kedua mencoba bagaimana
caranya konfigurasi message broker sendiri.


### Verifikasi Hasil Percobaan

#### Pertanyaan

### 3. Menghubungkan Smart Device Aplikasi Web

## Video Pendukung

## Tugas


