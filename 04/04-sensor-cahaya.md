# LDR

## Topik Bahasan
Implementasi program sensor cahaya LDR

## Kemampuan Akhir yang Direncanakan
- Menjelaskan cara kerja sensor LDR
- Menjelaskan cara kerja analogRead
- Mampu membedakan nilai yang keluar dari sensor baik dalam keadaan cahaya terang, redup, dan gelap
- Mampu melakukan kalibrasi sensor LDR

## Teori Singkat

### Sensor Cahaya

Sensor cahaya digunakan untuk menangkap intensitas cahaya di sekitar. Sensor yang digunakan adalah sensor LDR (Light Dependent Resistor). 

Pin pada sensor cahaya terdapat 3 buah, VCC, ground, dan data. Data yang ditangkap pada sensor cahaya berupa data analog, sehingga kita harus menghubungkan pin data pada pin analog NodeMCU. Struktur pin pada sensor cahaya LDR seperti berikut.
![sensor cahaya](sensor-ldr.jpg)

Contoh penggunaan LDR digunakan sebagai sensor penerang jalan otomatis, lampu kamar tidur, alarm, rangkaian anti pencurian otomatis menggunakan laser, dan masih banyak yang lain.

**Skematik dari rangkaian di atas**

| NODEMCU | LDR|
|-|-|
| A0 | Data|
| Vin| VCC|
| GND | Ground |

> A0 merupakan pin khusus yang digunakan sebagai input analog

## Praktikum 1 - Membaca data intensitas cahaya

Pada praktikum pertama, anda akan melakukan percobaan untuk menangkap data intensitas cahaya.

Berikut ini adalah rangkaian yang dapat digunakan
![](images/esp8266-ldr.png)

Contoh source code untuk membaca data intensitas cahaya.

1. Buatlah projek pada PlatformIO, namanya sesuai dengan keinginan Anda.
2. Deklarasikan variabel untuk menampung nilai sensor dan untuk variabel sensor seperti di bawah ini

    ```c++
    #define sensorLDR A0
    int nilaiSensor;
    ```
3. Tambahkan beberapa kode untuk melakukan konfigurasi serial monitor pada `fungsi setup()`.
    ```c++
    Serial.begin(115200);
    Serial.println("Contoh Penggunaan Sensor LDR");
    delay(3000);
    ```
4. Dan yang terakhir, membuat kode untuk membaca nilai dari sensor dan menampilkannya seperti berikut ini pada `fungsi loop()`.
    ```c++
    nilaiSensor = analogRead(sensorLDR);
    Serial.print(“Nilai Sensor : “);
    Serial.println(nilaiSensor);
    delay(1000);
    ```

Setelah source code diupload, buka serial monitor pada PlatformIO untuk melihat hasil pembacaan data intensitas cahaya di sekitar sensor.

> Normalnya ketika program Anda dijalankan maka akan menampilkan nilai 0-1024, semakin rendah nilai dari pembacaan sensor berarti semakin gelap cahaya yang terdapat di sekitar Anda dan sebaliknya. Ketika hasil pembacaan sensor nilainya tidak seperti yang disebutkan, silakan kalibrasi sensor tersebut dengan cara memutar baut kecil yang terdapat di sensor menggunakan obeng kecil sambil mengamati keluaran yang ada di serial monitor.

## Video Pendukung
<p>
<iframe width="798" height="499" src="https://www.youtube.com/embed/84RNgzA-ESo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</p>

## Tugas
1. Buatlah rangkaian menggunakan fritzing tentang simulasi lampu yang otomatis menyala dengan lampu LED sebagai gambaran dari sebuah rumah. 1 LED mewakili 1 ruangan dalam rumah. Sehingga ketika waktu sore datang atau ketika mendung dan hujan, lampu otomatis nyala. Begitu pula ketika pagi datang, lampu otomatis mati.
2. Buatlah sebuah rangkaian untuk LED, sensor cahaya dan sensor suhu menggunakan fritzing, kemudian buatlah program dengan skenario sebagai berikut
    + Ketika cahaya redup dan suhu kategori dingin maka LED warna biru akan berkedip-kedip.
    + Ketika cahaya terang dan suhu tergolong tinggi, LED merah akan menyala.
    > Ketika tidak memiliki LED RGB, silakan memanfaatkan LED build in adalah LED bawaan esp8266, biasanya berwarna biru atau merah
3. Upload hasilnya berupa file video menggunakan youtube atau google drive dan sisipkan linknya pada laporan Anda. Ketika menggunakan google drive, urlnya dilakukan shorten agar lebih mudah dibaca menggunakan tool seperti [bit.ly](https://bit.ly), [s.id](https://home.s.id/), atau yang lain.
