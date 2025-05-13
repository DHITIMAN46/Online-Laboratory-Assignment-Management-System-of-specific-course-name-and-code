
// JavaScript for Online Lab Management System
// This script handles user registration, login, and dashboard functionalities for both students and instructors.
const API_URL = "http://localhost/online_lab_system/backend/api";

// Register
function register() {
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const role = document.getElementById("role").value;
    const course_name = document.getElementById("course_name").value.trim();
    const course_code = document.getElementById("course_code").value.trim();

    if (!name || !email || !password || !role || !course_name || !course_code) {
        alert("All fields are required!");
        return;
    }

    fetch(`${API_URL}/register.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ name, email, password, role, course_name, course_code })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            window.location.href = "index.html";
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Something went wrong. Please try again.");
    });
}

// Login
function login() {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    if (!email || !password) {
        alert("Email and password are required!");
        return;
    }

    fetch(`${API_URL}/login.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email, password })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            localStorage.setItem("user_id", data.user_id);
            localStorage.setItem("role", data.role);
            localStorage.setItem("course_id", data.course_id);
            window.location.href = "dashboard.html";
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Something went wrong. Please try again.");
    });
}

// JavaScript for Online Lab Management System
//const API_URL = "http://localhost/online_lab_system/backend/api";

// Dashboard Logic
window.onload = () => {
    const role = localStorage.getItem("role"); // ✅ Corrected key
    const userId = localStorage.getItem("user_id");

    if (window.location.pathname.includes("dashboard.html")) {
        document.getElementById("userInfo").innerText = `Logged in as: ${role}`;

        if (role === "instructor") {
            document.getElementById("instructorPanel").style.display = "block";
            fetchCoursesDropdown();
            loadSubmissionsForGrading();
        } else if (role === "student") {
            document.getElementById("studentPanel").style.display = "block";
            fetchAssignments(userId);
            fetchGrades(userId);
        } else if (role === "admin") { // ✅ Correctly placed else-if
            document.getElementById("adminSection").style.display = "block";
            fetchAllGrades();
        }
    }
};

// Fetch Assignments for Students
function fetchAssignments() {
    const course_id = localStorage.getItem("course_id");
  
    fetch(`${API_URL}/get_assignments_by_course.php?course_id=${course_id}`)
      .then(res => res.json())
      .then(assignments => {
        const table = document.getElementById("assignmentTable");
        table.innerHTML = "";
  
        assignments.forEach(a => {
          table.innerHTML += `
            <tr>
              <td>${a.title}</td>
              <td>${a.description}</td>
              <td>${a.deadline}</td>
              <td><input type="file" id="file_${a.id}"><button onclick="submitAssignment(${a.id})">Upload</button></td>
            </tr>
          `;
        });
      })
      .catch(err => console.error("Error fetching assignments:", err));
  }
  

// Submit Assignment
function submitFile(assignmentId, userId) {
    const fileInput = document.getElementById(`file_${assignmentId}`);
    const file = fileInput.files[0];
    const formData = new FormData();
    formData.append("file", file);
    formData.append("assignment_id", assignmentId);
    formData.append("user_id", userId);

    fetch(`${API_URL}/upload_submission.php`, {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => alert(data.message || data.error))
        .catch(error => console.error("Error uploading file:", error));
}

// Fetch Grades for Students
function fetchGrades(userId) {
    fetch(`${API_URL}/get_grades.php?user_id=${userId}`)
        .then(res => res.json())
        .then(data => {
            const table = document.getElementById("gradesTable");
            table.innerHTML = "";
            data.forEach(g => {
                table.innerHTML += `<tr>
                    <td>${g.course}</td>
                    <td>${g.assignment}</td>
                    <td>${g.grade}</td>
                </tr>`;
            });
        })
        .catch(error => console.error("Error fetching grades:", error));
}

// Fetch Courses for Instructors
function fetchCoursesDropdown() {
    fetch(`${API_URL}/get_courses.php`)
        .then(res => res.json())
        .then(data => {
            const dropdown = document.getElementById("courseList");
            dropdown.innerHTML = "";
            data.forEach(c => {
                dropdown.innerHTML += `<option value="${c.id}">${c.course_name}</option>`;
            });
        })
        .catch(error => console.error("Error fetching courses:", error));
}

// Create Assignment (Instructor)
function createAssignment() {
    const course_id = document.getElementById("courseList").value;
    const title = document.getElementById("title").value;
    const description = document.getElementById("description").value;
    const deadline = document.getElementById("deadline").value;

    fetch(`${API_URL}/add_assignment.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ course_id, title, description, deadline })
    })
        .then(res => res.json())
        .then(data => alert(data.message || data.error))
        .catch(error => console.error("Error creating assignment:", error));
}

// Load Submissions for Grading (Instructor)
function loadSubmissionsForGrading() {
    fetch(`${API_URL}/get_submissions.php`)
        .then(res => res.json())
        .then(data => {
            const table = document.getElementById("gradingTable");
            table.innerHTML = "";
            data.forEach(s => {
                table.innerHTML += `<tr>
                    <td>${s.student_name}</td>
                    <td>${s.assignment_title}</td>
                    <td><a href="${s.file_path}" target="_blank">View</a></td>
                    <td>
                        <input type="number" id="grade_${s.id}" min="0" max="100" />
                        <button onclick="submitGrade(${s.id})">Submit</button>
                    </td>
                </tr>`;
            });
        })
        .catch(error => console.error("Error loading submissions:", error));
}

// Submit Grade (Instructor)
function submitGrade(submissionId) {
    const grade = document.getElementById(`grade_${submissionId}`).value;

    fetch(`${API_URL}/grade_assignment.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ submission_id: submissionId, grade, feedback: "" })
    })
        .then(res => res.json())
        .then(data => {
            alert(data.message || data.error);
            loadSubmissionsForGrading();
        })
        .catch(error => console.error("Error submitting grade:", error));
}


// Fetch All Grades (Admin)
fetch(`${API_URL}/get_all_grades.php`)
  .then(res => res.json())
  .then(grades => {
    const table = document.getElementById("adminGradesTable");
    table.innerHTML = "";

    grades.forEach(grade => {
      table.innerHTML += `
        <tr>
          <td>${grade.student_name}</td>
          <td>${grade.course_name}</td>
          <td>${grade.assignment_title}</td>
          <td>${grade.grade ?? "-"}</td>
        </tr>`;
    });
  })
  .catch(err => console.error("Error fetching grades for admin:", err));


