<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login to Success Stories</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: #000;
            color: white;
            overflow-x: hidden;
        }

        /* LOGIN SECTION */
        #loginSection {
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            background: linear-gradient(135deg, #111, #222);
            position: absolute;
            /* Keeps it in place */
            top: 0;
            left: 0;
            right: 0;
            z-index: 10;
            /* Ensures it is clickable */
        }

        #loginSection input {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-size: 1rem;
            width: 250px;
        }

        #loginSection button {
            padding: 10px 25px;
            border: none;
            border-radius: 8px;
            background: #00ffaa;
            color: black;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        #loginSection button:hover {
            background: #00dd88;
        }

        #successSection {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            padding: 20px;
        }


        .message {
            font-size: 2rem;
            font-weight: bold;
        }

        /* Password Input Fields */
        .password-container {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .password-input {
            width: 40px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            border: 2px solid #00ffaa;
            border-radius: 8px;
            background: transparent;
            color: white;
            outline: none;
            flex: 1 1 40px;
            /* Responsive shrinking */
        }


        .password-input:focus {
            border-color: #00dd88;
        }

        .password-input::placeholder {
            color: transparent;
        }

        /* Hapus ini karena bikin duplikasi display: flex dan bisa ganggu centering */
        .container-fluid {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }


        @media (max-width: 500px) {
            .message {
                font-size: 1.2rem;
                text-align: center;
            }

            .password-input {
                width: 35px;
                height: 45px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>

    <!-- LOGIN SECTION -->
    <section id="loginSection">
        <h1>Login</h1>
        <input type="text" placeholder="Masukkan NIK" id="nikInput" />
        <button onclick="handleLogin()">Masuk</button>
    </section>

    <!-- SUCCESS SECTION -->
    <section id="successSection" class="d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="container-fluid d-flex flex-column justify-content-center align-items-center vh-100">
            <h2 class="mb-5 text-center">Please enter your password:</h2>
            <div class="d-flex flex-wrap justify-content-center mt-4" style="max-width: 100%; padding: 0 10px;">
                <input type="text" id="pass1" class="password-input" maxlength="1"
                    oninput="moveFocus(this, 'pass2')" />
                <input type="text" id="pass2" class="password-input" maxlength="1"
                    oninput="moveFocus(this, 'pass3')" />
                <input type="text" id="pass3" class="password-input" maxlength="1"
                    oninput="moveFocus(this, 'pass4')" />
                <input type="text" id="pass4" class="password-input" maxlength="1"
                    oninput="moveFocus(this, 'pass5')" />
                <input type="text" id="pass5" class="password-input" maxlength="1"
                    oninput="moveFocus(this, 'pass6')" />
                <input type="text" id="pass6" class="password-input" maxlength="1"
                    oninput="moveFocus(this, 'pass7')" />
                <input type="text" id="pass7" class="password-input" maxlength="1"
                    oninput="moveFocus(this, 'pass8')" />
                <input type="text" id="pass8" class="password-input" maxlength="1" oninput="submitPassword()" />
            </div>
        </div>
    </section>


    <!-- GSAP CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script>
        function handleLogin() {
            const nik = document.getElementById("nikInput").value.trim();
            if (nik === "") {
                alert("Silakan masukkan NIK terlebih dahulu.");
                return;
            }

            // Fade out login
            gsap.to("#loginSection", {
                opacity: 0,
                duration: 1,
                onComplete: function() {
                    document.getElementById("loginSection").style.display = "none";
                    document.getElementById("successSection").style.display = "flex"; // Show success section

                    // Fade in success section
                    gsap.to("#successSection", {
                        opacity: 1,
                        duration: 1
                    });
                }
            });
        }


        // Function to move focus from one input to the next
        function moveFocus(currentInput, nextInputId) {
            if (currentInput.value.length === 1) {
                document.getElementById(nextInputId).focus();
            }
        }

        // Function to handle password submission
        function submitPassword() {
            let password = "";
            for (let i = 1; i <= 8; i++) {
                password += document.getElementById("pass" + i).value;
            }
            // Check if the password is complete
            if (password.length === 8) {
                alert("Password entered: " + password); // You can replace this with actual logic
            }
        }
    </script>

</body>

</html>
