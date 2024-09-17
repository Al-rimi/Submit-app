// Function to format numbers with leading zeros
function addLeadingZero(number) {
    return number < 10 ? `0${number}` : number;
}

// Function to update countdown display
function updateCountdown() {
    const countdownElement = document.getElementById("student-name");

    // Get the current date and time
    const now = new Date().getTime();
    const timeLeft = deadlineDate - now;

    if (timeLeft > 0) {
        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        countdownElement.placeholder =
            `Deadline: ${days} days ${addLeadingZero(hours)}:${addLeadingZero(minutes)}:${addLeadingZero(seconds)}`;
    } else {
        clearInterval(countdownInterval);
        countdownElement.placeholder = "Deadline has passed!";
    }
}

// Function to validate the student ID and auto-fill the student name
function validateAndAutoFill() {
    const studentIdInput = document.getElementById("student-id").value;
    const studentNameInput = document.getElementById("student-name");

    if (studentIdInput.length === 12) {
        const rows = document.querySelectorAll(".scrollingArea table tbody tr");
        let found = false;

        rows.forEach(row => {
            const idCell = row.cells[0].innerText;
            const nameCell = row.cells[1].innerText;

            if (idCell === studentIdInput) {
                studentNameInput.value = nameCell;
                studentNameInput.type = "text"
                studentNameInput.style.color = "";
                found = true;
            }
        });

        if (!found) {
            studentNameInput.type = "name"
            studentNameInput.value = "Student not found";
            studentNameInput.style.color = "red";
        }
    } else {
        studentNameInput.type = "name"
        studentNameInput.value = "";
        studentNameInput.style.color = "";
    }
}

// Function to check form inputs and shake the submit button if necessary
function checkFormAndShake(event) {
    const studentIdInput = document.getElementById("student-id");
    const studentNameInput = document.getElementById("student-name");
    const fileInput = document.getElementById("file-upload");
    const submitButton = document.getElementById("submit-button");

    if (studentIdInput.value.length !== 12) {
        event.preventDefault();
        studentIdInput.focus();
        shakeButton(submitButton);
    } else if (studentNameInput.value.trim() === "" || studentNameInput.style.color === "red") {
        event.preventDefault();
        studentIdInput.focus();
        shakeButton(submitButton);
    } else if (fileInput.files.length === 0) {
        event.preventDefault();
        fileInput.focus();
        shakeButton(submitButton);
    }
}

// Function to add a shake animation to the button
function shakeButton(button) {
    button.classList.add('shake');
    setTimeout(() => {
        button.classList.remove('shake');
    }, 500);
}

// Function to open the modal
function openModal() {
    document.getElementById("qrModal").style.display = "block";
}

// Function to close the modal
function closeModal() {
    document.getElementById("qrModal").style.display = "none";
}

// Close the modal if user clicks outside the modal content
window.onclick = function (event) {
    const modal = document.getElementById("qrModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
}

// Event listeners
document.getElementById("student-id").addEventListener("input", validateAndAutoFill);
document.getElementById("submit-button").addEventListener("click", (event) => {
    checkFormAndShake(event);
});
document.getElementById('file-upload').addEventListener('change', function () {
    this.classList.toggle('selected', this.files.length > 0);
});

// Update the countdown every 1 second
const countdownInterval = setInterval(updateCountdown, 1000);
updateCountdown(); // Initialize countdown display

// Function to count the number of students who submitted (i.e., "Yes" in the third column)
function updateSubmissionCounter() {
    const tableRows = document.querySelectorAll('#studentTable tbody tr');
    let count = 0;

    // Loop through each row and check the "Submitted" column (index 2)
    tableRows.forEach(row => {
        const submittedCell = row.cells[2];
        if (submittedCell && submittedCell.textContent.trim() === "Yes") {
            count++;
        }
    });

    document.getElementById('submissionCounter').textContent = `${count} Submitted`;
}

window.onload = updateSubmissionCounter;


document.getElementById('submission-form').addEventListener('submit', function(event) {
    event.preventDefault();
    document.getElementById('submit-button').style.display = 'none';
    document.getElementById('file-upload').style.display = 'none';
    document.getElementById('progress-container').style.display = 'block';
    document.getElementById('submit-button').disabled = true;

    var fakePercent = 0;
    var interval = setInterval(function() {
        if (fakePercent < 99) {
            fakePercent++;
            document.getElementById('progress-bar').style.width = fakePercent + '%';
        } else {
            clearInterval(interval);
        }
    }, 100);

    var formData = new FormData(this);
    var formActionUrl = this.action;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', formActionUrl, true);

    xhr.addEventListener('load', function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            clearInterval(interval);
            document.getElementById('progress-bar').style.width = '100%';
            document.getElementById('progress-bar').textContent = 'Thank You!!';
            document.getElementById('progress-bar').style.backgroundColor = 'rgba(72, 255, 0, 0.5)';

            var studentId = document.getElementById('student-id').value;
            var table = document.getElementById('studentTable');
            var rows = table.getElementsByTagName('tr');

            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName('td');
                if (cells[0] && cells[0].innerText === studentId) {
                    cells[2].innerText = 'Yes';
                    cells[2].style.color = '#a0ff61b7'; // green
                    break;
                }
            }
            updateSubmissionCounter();
        } else {
            clearInterval(interval);
            document.getElementById('progress-bar').style.width = '100%';
            document.getElementById('progress-bar').textContent = 'failed: Content too large';
            document.getElementById('progress-bar').style.backgroundColor = 'red';
            document.getElementById('submit-button').style.display = 'block';
            document.getElementById('submit-button').disabled = false;
            document.getElementById('file-upload').style.display = 'block';
            document.getElementById('file-upload').value = null;
        }
    });

    xhr.send(formData);
});

