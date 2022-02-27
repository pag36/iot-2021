# Socket Client

## Topik Bahasan

Socket Client

## Kemampuan Akhir yang Direncanakan

- Mahasiswa mampu untuk menjelaskan konsep TCP/IP
- Mahasiswa mampu untuk menjelaskan konsep protokol Socket TCP/IP agar MCU dapat berkomunikasi dengan perangkat lainnya
- Mahasiswa dapat membuat program socket client di sisi MCU yang bertugas mengirim data sensor ke Socket Server secara real-time

## Teori Singkat

Program socket biasanya digunakan untuk komunikasi antara berbagai proses yang berjalan pada sistem yang berbeda, program
tersebut kebanyakan dibuat untuk lingkungan program client dan server.

Ada 2 jenis protokol yang dapat digunakan untuk melakukan komunikasi menggunakan socket:

1. TCP/IP Socket

   Konsep yang digunakan pada protokol ini adalah _connection oriented_ dan _reliable data transfer_, ketika program
   yang kita buat menggunakan protokol ini tidak mementingkan kecepatan tetapi lebih mementingkan ketepatan data yang dikirimkan.

   _Connection oriented_ sendiri adalah sebuah konsep dimana socket yang terhubung harus memiliki tanggung jawab untuk
   memberikan notifikasi ketika sedang melakukan pengiriman data, atau sering disebut juga dengan istilah _synchronous_.

2. UDP Socket

   Berbeda dengan komunikasi protokol TCP/IP, UDP Socket menggunakan konsep _connectionless oriented_ dan _unreliable
   data transfer_. Akan cocok sekali ketika kita akan membangun sebuah aplikasi yang lebih mementingkan dengan kecepatan
   data dengan mengesampingkan ketepatan datanya. UDP Socket menggunakan istilah _asynchronous_, yang artinya tidak
   memperdulikan response dari penerima.

Pada kesempatan ini yang akan digunakan adalah protokol TCP/IP, untuk alur dari protokol TCP/IP dapat dilihat pada
gambar di bawah ini

![](images/socket-programming.png)

<p align="center">https://www.javatpoint.com/socket-programming</p>

Dari gambar di atas terlihat bahwa ketika sebuah server harus melakukan listening yang artinya siap menerima koneksi dari
sebuah socket client. Setelah socket server menerima koneksi dari socket client, socket server akan menerima dan selanjutnya
bisa dilanjutkan untuk berkomunikasi dengan socket client atau memutuskan komunikasi dengan socket client tersebut.

Buatlah sebuah kode berikut ini, kode tersebut ditulis menggunakan Python.

## Praktikum

```python
import socket
from threading import Thread


# Multithreaded Python server
class ClientThread(Thread):

    def __init__(self, ip, port):
        Thread.__init__(self)
        self.ip = ip
        self.port = port
        print("Incoming connection from " + ip + ":" + str(port))

    def run(self):
        while True:
            try:
                data = conn.recv(2048)
                if len(data) == 0:
                    break

                print("length: " + str(len(data)))
                print("Server received data:", data)
                # MESSAGE = input("Input response:")
                MESSAGE = "OK"
                conn.send(MESSAGE.encode("utf8"))  # echo
            except Exception as e:
                print(e)
                break


TCP_IP = "0.0.0.0"
TCP_PORT = 2004
BUFFER_SIZE = 20

tcpServer = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
tcpServer.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
tcpServer.bind((TCP_IP, TCP_PORT))
threads = []

while True:
    tcpServer.listen(4)
    print("Server started on " + TCP_IP + " port " + str(TCP_PORT))
    (conn, (ip, port)) = tcpServer.accept()
    newthread = ClientThread(ip, port)
    newthread.start()
    threads.append(newthread)

for t in threads:
    t.join()
```

> Jika sudah memiliki dan membuat instance EC2 di AWS, silakan upload kode file tersebut di atas agar kita coba langsung jalankan di cloud. Tetapi misalkan memang belum memiliki, silaan dicoba pada lokal komputer Anda. Sebaiknya memang dicoba terlebih dahulu di lokal komputer sebelum upload di cloud.

> Sebelum menjalankan dicek terlebih dahulu file tersebut, apakah sudah executable atau belum. Atau coba langsung dijalankan, tetapi kalau misalkan tidak bisa dijalankan kemungkinan file tersebut belum executable sehingga perlu dilakukan mode executable. Coba cek menggunakan perintah `ls -lh`, sehingga outputnya kurang lebih seperti di bawah ini

```
-rwxr-xr-x@  1 od3ng  staff   1.2K Apr  6 11:10 server.py
drwxr-xr-x  10 od3ng  staff   340B Apr  5 14:56 vs-client
```

Jika dilihat output dari file `server.py` tersebut sudah mode executable, dibuktikan untuk modenya `-rwxr-xr-x` yang artinya semua level user bisa menggunakan. Jika masih tidak bisa menjalankan, silakan ketika perintah `chmod +x server.py` yang dimana file `server.py` adalah program Anda.

> Catatan: Biasanya mode di atas, digunakan untuk sistem operasi jenis UNIX seperti Linux ataupun Mac OS

Setelah program tersebut dijalankan, socket server siap menerima komunikasi dari socket client. Untuk mencobanya bisa menggunakan perintah telnet, caranya adalah sebagai berikut

```
telnet [host] [port]
```

Setelah berhasil masuk silakan ketikan sesuatu dan tekan enter.

### Verifikasi Hasil Percobaan

Output yang dihasilkan dari sisi server dapat dilihat seperti di bawah ini.

```
Server started on 0.0.0.0 port 1884
length: 16
Server received data: b'Hai from ESP8266'
Incoming connection from 114.5.110.7:42950
Server started on 0.0.0.0 port 1884
length: 16
Server received data: b'Hai from ESP8266'
Incoming connection from 114.5.110.7:42951
Server started on 0.0.0.0 port 1884
length: 16
Server received data: b'Hai from ESP8266'
Incoming connection from 114.5.110.7:42955
```

> Silakan disesuaikan kode di atas untuk host dan port yang digunakan, ganti kode `TCP_IP = "0.0.0.0"` dan `TCP_PORT = 9000`, kedua konfigurasi tersebut disesuaikan dengan ip atau port yang dibuka pada laptop/komputer ataupun instance AWS Anda.

Setelah berhasil menjalankan socket sever, selanjutnya perlu dibuat socket client yang berjalan di controller atau ESP8266 Amica atau Lolita yang Anda miliki. Buatlah kode berikut

```cpp
#include <Arduino.h>
#include <ESP8266WiFi.h>

#define LED D4

const char *ssid = "****"; // nama SSID untuk koneksi Anda
const char *password = "****"; // password akses point WIFI Anda
const uint16_t port = ****; // diganti dengan port serve Anda
const char *host = "****";//diganti dengan host server Anda, bisa ip ataupun domain

void connect_wifi()
{
  Serial.printf("Connecting to %s ", ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(500);
    Serial.print(".");
  }
  Serial.println(" connected");
}

void connect_server()
{
  WiFiClient client;

  Serial.printf("\n[Connecting to %s ... ", host);
  if (client.connect(host, port))
  {
    Serial.println("connected]");

    Serial.println("[Sending a request]");
    client.print("Hai from ESP8266");

    Serial.println("[Response:]");
    String line = client.readStringUntil('\n');
    Serial.println(line);
    client.stop();
    Serial.println("\n[Disconnected]");
  }
  else
  {
    Serial.println("connection failed!]");
    client.stop();
  }
  delay(3000);
}

void setup()
{
  Serial.begin(115200);
  connect_wifi();
}

void loop()
{
  connect_server();
}
```

Untuk dapat berkomunikasi dengan socket server, ESP8266 sudah terdapat modul wifi yang siap untuk digunakan. Ubahlah kode di bawah ini sesuai dengan kebutuhan Anda.

### Verifikasi Hasil Percobaan

Ketika berhasil terhubung ke server, output di console dapat dilihat pada keluaran berikut.

```
[Connecting to ec2-52-90-53-121.compute-1.amazonaws.com ... connected]
[Sending a request]
[Response:]
OK

[Disconnected]

[Connecting to ec2-52-90-53-121.compute-1.amazonaws.com ... connected]
[Sending a request]
[Response:]
OK

[Disconnected]

[Connecting to ec2-52-90-53-121.compute-1.amazonaws.com ... connected]
[Sending a request]
```

```cpp
const char *ssid = "****";
const char *password = "****";
const uint16_t port = ****;
const char *host = "****";
```

Keterangan:

- `ssid` adalah ssid yang bisa digunakan untuk berkomunikasi, bisa tethering dengan handphone.
- `password` adalah password ssid yang digunakan.
- `port` adalah port socket sever aplikasi yang telah kita buat sebelumnya.
- `host` adalah host tempat socket server dijalankan, jika di local bisa menggunakan `localhost atau 127.0.0.1.`

Silakan upload program tersebut ke controller Anda dan amati outputnya pada serial monitor.

## Video Pendukung

<p>
<iframe width="933" height="583" src="https://www.youtube.com/embed/14j9ihm_svQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</p>
<p><iframe width="933" height="583" src="https://www.youtube.com/embed/Q2r7uWvuXZ4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
<p><iframe width="933" height="583" src="https://www.youtube.com/embed/kk56HEsUQCU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
<p><iframe width="933" height="583" src="https://www.youtube.com/embed/MsoaFrAurlo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>

## Tugas

Dianalogikan Anda mempunyai sebuah smart home dimana terpasang pada smart home tersebut sensor DHT11. Kirimkan data sensor tersebut secara berkala ke server
Hasil dari yang Anda buat, silakan dokumentasikan di google drive atau youtube dan cantumkan pada laporan Anda.
