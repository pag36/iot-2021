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
   sudo apt update
   sudo apt install apache2 php libapache2-mod-php -y
   sudo apt install php-json php7.4-mysql php-xml php-intl php-curl -y
   sudo apt install composer -y
   ```
   Dengan menggunakan script di atas, kita tidak perlu repot-repot menjalankan satu persatu ketika instance berhasil dibuat
karena sudah dijalankan ketika proses pembuatan instance.
   > Di EC2 kita diizinkan untuk membuat script ketika membuat instance, biasanya yang disupport adalah bash scripting atau 
   > perintah dasar pada sebuah terminal. Ketika bash script tersebut dijalankan, maka akan dijalankan sebagai user root
   > sehingga ketika kita ingin membuat direktori pada path tertentu harus full path, misalkan buat direktori di home
   > berarti `mkdir /home/ubuntu/[nama direktori]`

2. Silakan tambahkan port http yaitu 80 pada langkah `6. Configure Security Group`. Port tersebut digunakan untuk akses
web server atau web yang akan kita buat.
```shell
composer create-project codeigniter4/appstarter iot-jti --no-dev
sudo chown -Rv www-data iot-jti/writable
sudo mv iot-jti/ /var/www/html/

sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/iot-jti.conf
sudo nano /etc/apache2/sites-available/iot-jti.conf
DocumentRoot /var/www/html -> DocumentRoot /var/www/html/iot-jti/public
sudo a2ensite iot-jti.conf
sudo a2dissite 000-default.conf
sudo systemctl restart apache2

cd /var/www/html/iot-jti
mv env .env
nano .env
CI_ENVIRONMENT = development
```




### Verifikasi Hasil Percobaan

#### Pertanyaan

### 2. Konfigurasi Message Broker


### Verifikasi Hasil Percobaan

#### Pertanyaan

### 3. Menghubungkan Smart Device Aplikasi Web

## Video Pendukung

## Tugas


