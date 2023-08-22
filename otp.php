<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OTP Page</title>
 
  <style>
html {
				margin: 0;
				padding: 0;
				height: 100%;
				font-family: "Segoe UI", Roboto, "Helvetica Neue", sans-serif;
			}

.container {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  text-align: center;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

h1 {
  font-size: 24px;
}

p {
  font-size: 16px;
  margin-bottom: 20px;
}

#otp-container {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.otp-input {
  padding: 10px;
  width: 40px;
  border-radius: 10px;
  text-align: center;
  margin: 0 5px; /* Add spacing between OTP boxes */
}

#error-message {
  color: red;
  margin-bottom: 10px;
}

#proceed-btn {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  cursor: pointer;
}

#proceed-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

#resend-otp {
  margin-top: 20px;
}

#resend-link {
  color: #4CAF50;
}

</style>
</head>
<body>
  <div class="container">
    <h1>OTP Verification</h1>
    <p>Please enter the <span id="otp-length"> </span>-digit OTP sent to your email.</p>
    <form id="otp-form">
      <div id="otp-container"></div>
      <div id="error-message"></div>
      <button type="submit" id="proceed-btn" disabled>Proceed</button>
    </form>
  </div>
  <script src="script.js"></script>
</body>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const urlParams = new URLSearchParams(window.location.search);
  const otpLength = parseInt(urlParams.get("length")) || 4;

  const otpContainer = document.getElementById("otp-container");
  const otpLengthElement = document.getElementById("otp-length");

  otpLengthElement.textContent = otpLength;

  const otpInputs = [];

  const otpBoxWidth = otpLength === 6 ? 40 : 60; // Set fixed width based on OTP length

  for (let i = 0; i < otpLength; i++) {
    const input = document.createElement("input");
    input.type = "text";
    input.className = "otp-input";
    input.maxLength = 1;
    input.required = true;
    input.style.width = `${otpBoxWidth}px`;
    otpContainer.appendChild(input);
    otpInputs.push(input);

    input.addEventListener("input", handleOTPInput);
    input.addEventListener("keydown", handleKeyDown);
  }

  function handleOTPInput(e) {
    const input = e.target;
    const otpValue = input.value;
    if (otpValue.length === 1) {
      const currentIndex = otpInputs.indexOf(input);
      if (currentIndex < otpInputs.length - 1) {
        otpInputs[currentIndex + 1].focus();
      } else {
        otpInputs[0].focus();
      }
    }
    handleProceedButton();
  }

  function handleKeyDown(e) {
    const input = e.target;
    const key = e.key;
    if (key === "Backspace" && input.value === "") {
      const currentIndex = otpInputs.indexOf(input);
      if (currentIndex > 0) {
        otpInputs[currentIndex - 1].focus();
      }
      handleProceedButton();
    }
  }

  function handleProceedButton() {
    const otpValue = otpInputs.map(input => input.value).join("");
    const proceedBtn = document.getElementById("proceed-btn");
    proceedBtn.disabled = otpValue.length !== otpLength;
  }
});

    </script>
</html>
