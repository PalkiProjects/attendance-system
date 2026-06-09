import cv2
import os
import csv
from datetime import datetime

recognizer = cv2.face.LBPHFaceRecognizer_create()
recognizer.read("trainer.yml")

face_cascade = cv2.CascadeClassifier(
    cv2.data.haarcascades + "haarcascade_frontalface_default.xml"
)

label_map = {
    0: "Ashutosh Tyagi",
    1: "Gaurav Nandal",
    2: "Kanika Tyagi",
    3: "Palki Tyagi",
    4: "Urvashi Tyagi"
}

attendance_file = "attendance.csv"

# Lower value = better match
CONFIDENCE_LIMIT = 50

if not os.path.exists(attendance_file):
    with open(attendance_file, "w", newline="") as f:
        writer = csv.writer(f)
        writer.writerow(["Name", "Date", "Time"])

marked_today = set()
today = str(datetime.now().date())

# Load already marked names for today
with open(attendance_file, "r", newline="") as f:
    reader = csv.reader(f)
    next(reader, None)

    for row in reader:
        if len(row) >= 3:
            name, date, time = row
            if date == today:
                marked_today.add(name)

cap = cv2.VideoCapture(0)

while True:
    ret, frame = cap.read()

    if not ret:
        print("Camera not working")
        break

    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

    faces = face_cascade.detectMultiScale(
        gray,
        scaleFactor=1.2,
        minNeighbors=6,
        minSize=(80, 80)
    )

    for (x, y, w, h) in faces:
        face = gray[y:y+h, x:x+w]

        student_id, confidence = recognizer.predict(face)

        if confidence < CONFIDENCE_LIMIT:
            name = label_map.get(student_id, "Unknown")
            color = (0, 255, 0)
            text = f"{name} ({round(confidence, 2)})"

            if name not in marked_today:
                now = datetime.now()

                with open(attendance_file, "a", newline="") as f:
                    writer = csv.writer(f)
                    writer.writerow([
                        name,
                        str(now.date()),
                        now.strftime("%H:%M:%S")
                    ])

                marked_today.add(name)
                print(f"Attendance Marked: {name}")
            else:
                print(f"Already Marked: {name}")

        else:
            name = "Unknown"
            color = (0, 0, 255)
            text = f"Unknown ({round(confidence, 2)})"

        cv2.rectangle(frame, (x, y), (x+w, y+h), color, 2)

        cv2.putText(
            frame,
            text,
            (x, y-10),
            cv2.FONT_HERSHEY_SIMPLEX,
            0.7,
            color,
            2
        )

    cv2.imshow("Face Attendance System", frame)

    # Press ESC to exit
    if cv2.waitKey(1) & 0xFF == 27:
        break

cap.release()
cv2.destroyAllWindows()