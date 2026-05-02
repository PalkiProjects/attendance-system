
#include <WiFi.h>
#include <HTTPClient.h>
#include <SPI.h>
#include <MFRC522.h>


const char* ssid = "NITISHA";          
const char* password = "11111111";  


const char* serverName = "http://172.20.10.4/attendance/attendance.php";

#define SS_PIN 5     
#define RST_PIN 22    

MFRC522 rfid(SS_PIN, RST_PIN);


String tagUID = "";
String studentName = "";



void setup() {
  Serial.begin(115200);
  delay(1000);

  Serial.println("====================================");
  Serial.println(" SMART ATTENDANCE SYSTEM STARTING...");
  Serial.println("====================================");

  
  SPI.begin();

  
  rfid.PCD_Init();

  Serial.println("RFID Reader Initialized");
  Serial.println("Scan your RFID Card...");

  
  connectToWiFi();
}



void loop() {

  
  if (!rfid.PICC_IsNewCardPresent()) {
    return;
  }

  
  if (!rfid.PICC_ReadCardSerial()) {
    return;
  }

  
  tagUID = "";

 
  for (byte i = 0; i < rfid.uid.size; i++) {
    tagUID += String(rfid.uid.uidByte[i], HEX);
  }

  
  tagUID.toUpperCase();

  Serial.println("\nCard Detected!");
  Serial.print("UID: ");
  Serial.println(tagUID);

  
  sendAttendance(tagUID);

  
  rfid.PICC_HaltA();

  
  rfid.PCD_StopCrypto1();

  delay(2000);
}



void connectToWiFi() {
  Serial.print("Connecting to WiFi");

  WiFi.begin(ssid, password);

  int attempts = 0;

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");

    attempts++;

    if (attempts > 20) {
      Serial.println("\nWiFi Connection Failed!");
      Serial.println("Restarting...");
      ESP.restart();
    }
  }

  Serial.println("\nWiFi Connected Successfully!");
  Serial.print("ESP32 IP Address: ");
  Serial.println(WiFi.localIP());
}



void sendAttendance(String uid) {

  
  if (WiFi.status() == WL_CONNECTED) {

    HTTPClient http;

    
    http.begin(serverName);

    
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    
    String httpRequestData = "uid=" + uid;

    Serial.println("Sending Attendance Data...");
    Serial.print("POST Data: ");
    Serial.println(httpRequestData);

    
    int httpResponseCode = http.POST(httpRequestData);

    
    if (httpResponseCode > 0) {

      String response = http.getString();

      Serial.print("HTTP Response Code: ");
      Serial.println(httpResponseCode);

      Serial.print("Server Response: ");
      Serial.println(response);

      Serial.println("Attendance Marked Successfully!");

    } else {

      Serial.print("Error sending POST request. Code: ");
      Serial.println(httpResponseCode);

    }

    
    http.end();

  } else {

    Serial.println("WiFi Disconnected!");
    Serial.println("Reconnecting...");
    connectToWiFi();

  }
}