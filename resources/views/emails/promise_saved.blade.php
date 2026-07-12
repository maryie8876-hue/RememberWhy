<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remember why you started.</title>
    <!-- Preheader -->
    <span style="display:none;font-size:1px;color:#F7F4EE;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;">You created something worth remembering — your promise is safe.</span>
    <style>
        body {
            background-color: #F7F4EE;
            color: #3D352E;
            font-family: ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;
            line-height: 1.8;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 60px 24px;
            text-align: center;
        }
        .content {
            background-color: #FFFDF9;
            padding: 48px 40px;
            border-radius: 24px;
            box-shadow: 0 4px 20px rgba(61, 53, 46, 0.05);
            text-align: left;
        }
        .logo {
            text-align: center;
            margin-bottom: 24px;
        }
        .eyebrow {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #C97B4A;
            margin-bottom: 20px;
        }
        .body-text {
            font-size: 18px;
            color: #756A5C;
            margin-bottom: 32px;
            padding-left: 20px;
            border-left: 1px solid rgba(117, 106, 92, 0.2);
        }
        .body-text p {
            margin-bottom: 16px;
        }
        .button-container {
            text-align: center;
            margin: 40px 0;
        }
        .button {
            display: inline-block;
            background-color: #C97B4A;
            color: #FFFFFF;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 9999px;
        }
        .footer {
            margin-top: 48px;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 13px;
            color: #756A5C;
            opacity: 0.7;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#756A5C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.5;"><path d="M12.67 19a2 2 0 0 0 1.416-.588l6.154-6.172a6 6 0 0 0-8.49-8.49L5.586 9.914A2 2 0 0 0 5 11.328V18a1 1 0 0 0 1 1z"/><path d="M16 8 2 22"/><path d="M17.5 15H9"/></svg>
            </div>

            <div class="eyebrow">Remember Why</div>
            
            <div class="body-text">
                <p>Hi,</p>
                <p>You created something worth remembering.</p>
                <p>We've kept a copy safe for you.</p>
                <p>Whenever life gets louder,<br>you can come back to it.</p>
            </div>

            <div class="button-container">
                <a href="{{ route('promise.show', ['uuid' => $promise->uuid]) }}" class="button">Open My Promise</a>
            </div>
        </div>
        
        <div class="footer">
            This email was sent because you asked us to keep your promise safe.<br>
            Nothing more.
        </div>
    </div>
</body>
</html>
