# 🧪 Online Laboratory Assignment Maintenance System

A web-based application to manage laboratory assignments based on specific **Course Name** and **Course Code**. This system enables students, instructors, and admins to manage courses, assignments, submissions, and grading from a centralized platform.

---

## 🚀 Features

- 🔐 **Role-Based Authentication** (Student, Instructor, Admin)
- 📚 **Course Management** (with unique course code and name)
- 📝 **Assignment Creation** (by instructors)
- 📤 **File Submission** (by students)
- 🧮 **Grading & Feedback** (by instructors)
- 📊 **Admin View of All Grades**
- 📅 **Deadline Management**
- 📥 **Upload & View Submissions**
- 🖥️ Responsive Frontend with HTML, CSS, JS

---

## 🛠️ Technologies Used

| Technology | Purpose |
|-----------|---------|
| **PHP** | Backend Logic (Core PHP with APIs) |
| **MySQL** | Database for storing users, courses, assignments |
| **HTML, CSS, JavaScript** | Frontend |
| **Apache Server (XAMPP)** | Hosting the backend locally |
| **Draw.io** | ER and DFD Diagram Design |
| **ChatGPT / GitHub Copilot** | Development Assistance |
| **VS Code** | Code Editor |

---

## 🗃️ Database Schema

The system uses 4 main tables:
- `users` (id, name, email, password, role, course_id)
- `courses` (id, course_name, course_code)
- `assignments` (id, title, description, deadline, course_id)
- `submissions` (id, assignment_id, user_id, file_path, grade)

👉 SQL file included in: `database.sql`

---

## 📂 Project Structure

/online_lab_system/
│
├── backend/
│ ├── api/ # PHP APIs
│ ├── config/ # Database connection (db.php)
│ ├── uploads/ # Submitted assignments
│
├── frontend/
│ ├── index.html # Login Page
│ ├── register.html # Registration Page
│ ├── dashboard.html # Student, Instructor, Admin views
│ ├── styles.css # CSS Styling
│ ├── script.js # JS Interactions
│
├── database.sql # SQL schema file
├── README.md # You're reading it!



---

## 🧪 Testing

- ✅ Tested for all user roles (student, instructor, admin)
- ✅ File upload and download tested
- ✅ Grade visibility and submission workflows tested
- ✅ Tested on Chrome, Firefox, Edge

---

## 🔮 Future Scope

- 📱 Mobile App Version
- 📧 Email & SMS Notifications
- 📊 Data Analytics for Admins
- 🔍 Plagiarism Checker Integration
- 🌐 Multi-language Support

---

## 🤝 Acknowledgment

Thanks to faculty mentors, OpenAI ChatGPT, GitHub Copilot, and open-source communities for their help and support in the development of this project.

---

## 📸 Screenshots

Include screenshots in a `screenshots/` folder and add:

```markdown
![Login Page](screenshots/login.png)
![Instructor Dashboard](screenshots/instructor.png)
![Student View](screenshots/student.png)
