<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Submit">
    <meta property="og:description" content="Submit your algorithm design project.">
    <meta property="og:image" content="{{ asset('favicon.ico') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <title>Submit</title>
    <link rel="stylesheet" href="{{ asset('assets\app-uie189.css') }}">
    <script>
        const deadlineDate = new Date("2024-09-18T23:59:59").getTime(); // deadline date
    </script>
</head>

<body>
    <h3 id="countdown"></h3>
    <header>
        <h1>李小波 Algorithm Design</h1>
    </header>
    <div id="qrModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <img src="{{ asset('assets/ggak71.png') }}" alt="WeChat QR Code" class="qr-code">
        </div>
    </div>
    <main class="mainContainer">
        <div id="divForm" class="divForm ">
            <h3>Submit your project</h3>
            <form id="submission-form" method="POST" action="{{ route('students.submit') }}"
                enctype="multipart/form-data">
                @csrf
                <div id="progress-container" class="progress-container" style="display: none">
                    <div id="progress-bar" class="progress-bar"></div>
                </div>
                <input id="student-name" type="name" name="name" placeholder="Name"
                    @if (session('success') || $errors->any()) value="{{ session('success') ? session('success') : implode(' ', $errors->all()) }}"
                    style="color: {{ $errors->any() ? 'red' : (session('success') ? 'green' : '') }};" @endif
                    readonly class="countdown">

                <input type="text" id="student-id" name="id" placeholder="Student ID" maxlength="12"
                    oninput="validateAndAutoFill()" autocomplete="off">
                <input type="file" id="file-upload" name="files[]" accept="*/*" multiple>
                <button id="submit-button">Submit</button>
            </form>
        </div>
        <div id="divTable" class="divTable ">
            <div class="fixedArea ">
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Submitted</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="scrollingArea">
                <!-- Student Table -->
                <table id="studentTable">
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->student_id }}</td>
                                <td>{{ $student->student_name }}</td>
                                <td style="color: {{ $student->submit_count > 0 ? '#a0ff61b7;' : '#ff5d5dd3;' }}">
                                    {{ $student->submit_count > 0 ? 'Yes' : 'No' }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <div class="left">
                <a href="https://github.com/Al-rimi/Submit-page" target="_blank" class="icon-text">
                    <svg aria-hidden="true" class="octicon octicon-mark-github" height="24" version="1.1"
                        viewBox="0 0 16 16" width="24">
                        <path fill-rule="evenodd"
                            d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z">
                        </path>
                    </svg>
                </a>
            </div>
            <div class="right">
                <a href="javascript:void(0);" class="icon-text" onclick="openModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-wechat" viewBox="0 0 16 16">
                        <path
                            d="M11.176 14.429c-2.665 0-4.826-1.8-4.826-4.018 0-2.22 2.159-4.02 4.824-4.02S16 8.191 16 10.411c0 1.21-.65 2.301-1.666 3.036a.32.32 0 0 0-.12.366l.218.81a.6.6 0 0 1 .029.117.166.166 0 0 1-.162.162.2.2 0 0 1-.092-.03l-1.057-.61a.5.5 0 0 0-.256-.074.5.5 0 0 0-.142.021 5.7 5.7 0 0 1-1.576.22M9.064 9.542a.647.647 0 1 0 .557-1 .645.645 0 0 0-.646.647.6.6 0 0 0 .09.353Zm3.232.001a.646.646 0 1 0 .546-1 .645.645 0 0 0-.644.644.63.63 0 0 0 .098.356" />
                        <path
                            d="M0 6.826c0 1.455.781 2.765 2.001 3.656a.385.385 0 0 1 .143.439l-.161.6-.1.373a.5.5 0 0 0-.032.14.19.19 0 0 0 .193.193q.06 0 .111-.029l1.268-.733a.6.6 0 0 1 .308-.088q.088 0 .171.025a6.8 6.8 0 0 0 1.625.26 4.5 4.5 0 0 1-.177-1.251c0-2.936 2.785-5.02 5.824-5.02l.15.002C10.587 3.429 8.392 2 5.796 2 2.596 2 0 4.16 0 6.826m4.632-1.555a.77.77 0 1 1-1.54 0 .77.77 0 0 1 1.54 0m3.875 0a.77.77 0 1 1-1.54 0 .77.77 0 0 1 1.54 0" />
                    </svg>
                </a>
            </div>
            <script></script>
        </div>
    </footer>

    <!-- circles moving in the background -->
    <div class="area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
    <script>
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
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('students.submit') }}', true);

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
    </script>

    <script src="{{ asset('assets\app-n21vwo.js') }}"></script>

</body>

</html>
