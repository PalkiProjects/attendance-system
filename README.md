# AI-Based Face Attendance System

A Python and OpenCV based Face Recognition Attendance System that detects faces through a camera, recognizes registered students, and automatically marks attendance in a CSV file.

## Features

- Real-time face detection
- Face recognition using OpenCV LBPH algorithm
- Automatic attendance marking
- Duplicate attendance prevention for the same day
- CSV-based attendance record
- Privacy-friendly dataset structure

## Tech Stack

- Python
- OpenCV
- NumPy
- LBPH Face Recognizer
- CSV File Handling

## Project Structure

```txt
Face_Attendance_System/
│
├── dataset/
│   └── Student_Name/
│       ├── 1.jpg
│       └── 2.jpg
│
├── train_model.py
├── face_attendance.py
├── requirements.txt
├── .gitignore
└── README.md
