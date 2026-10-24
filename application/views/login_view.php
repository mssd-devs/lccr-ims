<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-bordered" data-assets-path="<?= base_url(); ?>assets/" data-template="vertical-menu-template-bordered" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Institution Management System</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url(); ?>assets/img/favicon/favicon.ico" />
    
    <!-- PWA -->
    <link rel="manifest" href="<?= base_url(); ?>manifest.json" />
    <meta name="theme-color" content="#4F46E5" />
    <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/fonts/remixicon/remixicon.css" />

    <style>
        :root {
            --primary: #4F46E5;
            --primary-hover: #4338CA;
            --secondary: #ec4899;
            --bg-color: #f8fafc;
            --surface: rgba(255, 255, 255, 0.85);
            --surface-border: rgba(255, 255, 255, 1);
            --text-main: #1e293b;
            --text-muted: #64748b;
            --input-bg: rgba(255, 255, 255, 0.9);
            --input-border: rgba(203, 213, 225, 1);
            --error: #ef4444;
            --success: #10b981;
        }

        * {
            box-sizing: border-box;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background-color: var(--bg-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
            color: var(--text-main);
        }

        /* Animated Mesh Gradient Background */
        .ambient-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            overflow: hidden;
            background: #f1f5f9;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.4;
            animation: float 20s infinite ease-in-out;
        }

        .orb-1 {
            width: 600px;
            height: 600px;
            background: #c7d2fe;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 500px;
            height: 500px;
            background: #fbcfe8;
            bottom: -50px;
            right: -100px;
            animation-delay: -5s;
            animation-duration: 25s;
        }

        .orb-3 {
            width: 400px;
            height: 400px;
            background: #e9d5ff;
            top: 40%;
            left: 30%;
            animation-delay: -10s;
            animation-duration: 18s;
            opacity: 0.5;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(50px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-30px, 40px) scale(0.95);
            }
        }

        .login-wrapper {
            width: 100%;
            max-width: 560px;
            padding: 2rem;
            z-index: 10;
            perspective: 1000px;
        }

        .glass-panel {
            background: var(--surface);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid var(--surface-border);
            border-radius: 32px;
            padding: 3rem 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.02);
            position: relative;
            transform-style: preserve-3d;
            animation: formEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes formEntrance {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95) rotateX(-5deg);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotateX(0);
            }
        }

        .brand-header {
            text-align: center;
            margin-bottom: 2.5rem;
            transform: translateZ(20px);
        }

        .brand-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            border-radius: 24px;
            background: #ffffff;
            border: 1px solid var(--surface-border);
            padding: 10px;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .brand-icon-fallback {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            border-radius: 24px;
            background: #ffffff;
            border: 1px solid var(--surface-border);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .brand-icon-fallback i {
            font-size: 3rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-title {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-main);
            margin: 0;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
            transform: translateZ(15px);
        }

        .styled-input {
            width: 100%;
            height: 60px;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 16px;
            padding: 20px 20px 8px;
            color: var(--text-main);
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            outline: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .styled-input:focus {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02), 0 0 0 4px rgba(79, 70, 229, 0.15);
        }

        .input-label {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1rem;
            pointer-events: none;
            transition: 0.2s ease all;
        }

        .styled-input:focus~.input-label,
        .styled-input:not(:placeholder-shown)~.input-label {
            top: 14px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: 0.5px;
        }

        .captcha-container {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 2rem;
            transform: translateZ(15px);
        }

        .captcha-image-wrapper {
            background: #ffffff;
            border-radius: 16px;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 130px;
            height: 60px;
            flex-shrink: 0;
            overflow: hidden;
            border: 1.5px solid var(--input-border);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .captcha-image-wrapper img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 10px;
        }

        .captcha-input {
            flex: 1;
            min-width: 0;
            width: 100%;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 16px;
            padding: 0 15px;
            color: var(--text-main);
            font-size: 1.1rem;
            font-weight: 700;
            outline: none;
            text-align: center;
            letter-spacing: 2px;
            height: 60px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .captcha-input:focus {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02), 0 0 0 4px rgba(79, 70, 229, 0.15);
        }

        .submit-btn {
            width: 100%;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 16px;
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
            transform: translateZ(20px);
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: all 0.5s ease;
        }

        .submit-btn:hover {
            transform: translateZ(20px) translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(79, 70, 229, 0.5);
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn i {
            transition: transform 0.3s ease;
        }

        .submit-btn:hover i {
            transform: translateX(5px);
        }

        .alert-box {
            padding: 1rem 1.25rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateZ(10px);
            animation: alertFade 0.4s ease-out forwards;
        }

        @keyframes alertFade {
            from {
                opacity: 0;
                transform: translateY(-10px) translateZ(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0) translateZ(10px);
            }
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }

        .terms-text {
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
            transform: translateZ(15px);
        }

        .terms-text a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .terms-text a:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-content {
            background: #ffffff;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            transform: translateY(20px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .modal-overlay.active .modal-content {
            transform: translateY(0) scale(1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--input-border);
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
        }

        .modal-close {
            background: #f1f5f9;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: #e2e8f0;
            color: var(--error);
        }

        .modal-body {
            overflow-y: auto;
            color: var(--text-muted);
            font-size: 1rem;
            line-height: 1.6;
            padding-right: 15px;
        }
        
        .modal-body h4 {
            color: var(--text-main);
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }
        
        .modal-body h4:first-child {
            margin-top: 0;
        }
        
        .modal-body p {
            margin-bottom: 1rem;
        }
        
        .modal-body::-webkit-scrollbar {
            width: 6px;
        }
        
        .modal-body::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .modal-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .footer-text {
            text-align: center;
            margin-top: 2rem;
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
            transform: translateZ(5px);
        }

        .footer-text strong {
            color: var(--text-main);
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="ambient-bg">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="login-wrapper">
        <div class="glass-panel">
            <div class="brand-header">
                <?php
                $settings = $this->db->get("tbl_websettings");
                if ($settings->num_rows() > 0) {
                    $row = $settings->row();
                    if (!empty($row->IMS_WEB_LOGO)) { ?>
                        <img src="<?= base_url('assets/img/' . $row->IMS_WEB_LOGO) ?>" class="brand-logo" alt="Logo">
                    <?php } else { ?>
                        <div class="brand-icon-fallback">
                            <i class="ri-shield-user-fill"></i>
                        </div>
                    <?php } ?>
                    <h1 class="brand-title"><?= (!empty($row->IMS_WEB_NOS) ? $row->IMS_WEB_NOS : "MOROBYTE"); ?></h1>
                <?php } ?>
            </div>

            <?php if ($this->session->flashdata("error") != "") { ?>
                <div class="alert-box alert-error">
                    <i class="ri-error-warning-fill ri-lg"></i>
                    <span><?= $this->session->flashdata("error"); ?></span>
                </div>
            <?php } ?>

            <?php if ($this->session->flashdata("success") != "") { ?>
                <div class="alert-box alert-success">
                    <i class="ri-checkbox-circle-fill ri-lg"></i>
                    <span><?= $this->session->flashdata("success"); ?></span>
                </div>
            <?php } ?>

            <form action="<?= base_url("LoginController/SubmitLogin"); ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="input-group">
                    <input type="text" class="styled-input" id="username" name="IMS_USERS_UNAME" placeholder=" " autofocus required autocomplete="off">
                    <label class="input-label" for="username">Username</label>
                </div>

                <div class="input-group">
                    <input type="password" class="styled-input" id="password" name="IMS_USERS_PWORD" placeholder=" " required>
                    <label class="input-label" for="password">Password</label>
                </div>

                <div class="captcha-container">
                    <div class="captcha-image-wrapper">
                        <?= $captchaImg; ?>
                    </div>
                    <input type="text" class="captcha-input" name="captcha_id" required placeholder="CODE" autocomplete="off">
                </div>

                <div class="terms-text">
                    By signing in, you agree to our <a href="#" onclick="openModal('termsModal'); return false;">Terms & Conditions</a> and <a href="#" onclick="openModal('privacyModal'); return false;">Privacy Notice</a>.
                </div>

                <button type="submit" class="submit-btn">
                    <span>Sign In</span>
                    <i class="ri-arrow-right-line"></i>
                </button>
            </form>

            <div class="footer-text">
                &copy; <?= date('Y') ?> <strong>Institution Management System</strong><br>
                Powered by <a href="https://morobyte.com">MOROBYTE IT Solutions</a>
            </div>
        </div>
    </div>

    <!-- Terms Modal -->
    <div class="modal-overlay" id="termsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Terms & Conditions</h3>
                <button class="modal-close" onclick="closeModal('termsModal')">
                    <i class="ri-close-line ri-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                <h4>1. Introduction</h4>
                <p>Welcome to the Institution Management System. By accessing or using our system, you agree to be bound by these terms and conditions.</p>
                
                <h4>2. Use License</h4>
                <p>Permission is granted to temporarily access the materials (information or software) on our system for personal, non-commercial transitory viewing only.</p>
                
                <h4>3. Disclaimer</h4>
                <p>The materials on the system are provided on an 'as is' basis. We make no warranties, expressed or implied, and hereby disclaim and negate all other warranties.</p>
                
                <h4>4. Limitations</h4>
                <p>In no event shall we or our suppliers be liable for any damages arising out of the use or inability to use the materials on our system.</p>
            </div>
        </div>
    </div>

    <!-- Privacy Modal -->
    <div class="modal-overlay" id="privacyModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Privacy Notice</h3>
                <button class="modal-close" onclick="closeModal('privacyModal')">
                    <i class="ri-close-line ri-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                <h4>1. Information Collection</h4>
                <p>We collect information you provide directly to us when you create an account, update your profile, or use our system features.</p>
                
                <h4>2. Use of Information</h4>
                <p>We use the information we collect to provide, maintain, and improve our services, as well as to communicate with you.</p>
                
                <h4>3. Data Security</h4>
                <p>We implement appropriate technical and organizational security measures designed to protect the security of any personal information we process.</p>
                
                <h4>4. Sharing of Information</h4>
                <p>We do not share your personal information with third parties except as described in this privacy notice or with your consent.</p>
            </div>
        </div>
    </div>

    <!-- PWA Install Banner -->
    <div id="pwa-install-banner" style="display: none; position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: #ffffff; padding: 15px 25px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); z-index: 9999; align-items: center; justify-content: space-between; gap: 20px; border: 1px solid #e2e8f0; width: 90%; max-width: 400px; font-family: 'Outfit', sans-serif;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="width: 40px; height: 40px; background: #e0e7ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #4F46E5;">
                <i class="ri-smartphone-line" style="font-size: 24px;"></i>
            </div>
            <div>
                <h6 style="margin: 0; font-size: 15px; font-weight: 700; color: #1e293b; text-align: left;">Install App</h6>
                <p style="margin: 0; font-size: 13px; color: #64748b; text-align: left;">Add to home screen</p>
            </div>
        </div>
        <div style="display: flex; gap: 8px; align-items: center;">
            <button id="pwa-close-btn" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 8px; font-size: 18px; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">&times;</button>
            <button id="pwa-install-btn" style="background: #4F46E5; color: white; border: none; border-radius: 8px; padding: 0 16px; height: 32px; font-size: 13px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2); transition: all 0.2s;">Install</button>
        </div>
    </div>

    <!-- Core Libs -->
    <script src="<?= base_url(); ?>assets/vendor/libs/jquery/jquery.js"></script>
    <script>
        // Captcha Cache Buster to fix image caching issues
        document.addEventListener("DOMContentLoaded", function() {
            var captchaImg = document.querySelector('.captcha-image-wrapper img');
            if (captchaImg) {
                var src = captchaImg.getAttribute('src');
                if (src) {
                    var separator = src.indexOf('?') !== -1 ? '&' : '?';
                    captchaImg.setAttribute('src', src + separator + 'v=' + new Date().getTime());
                }
            }
        });

        // Modal functions
        function openModal(id) {
            document.getElementById(id).classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent scrolling background
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close modal on click outside
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });

        // Simple 3D tilt effect for the glass panel
        document.addEventListener('mousemove', (e) => {
            const panel = document.querySelector('.glass-panel');
            if (!panel) return;
            const xAxis = (window.innerWidth / 2 - e.pageX) / 50;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 50;
            panel.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
        });

        // Reset tilt on mouse leave
        document.addEventListener('mouseleave', () => {
            const panel = document.querySelector('.glass-panel');
            if (!panel) return;
            panel.style.transform = `rotateY(0deg) rotateX(0deg)`;
            panel.style.transition = 'transform 0.5s ease';
            setTimeout(() => {
                panel.style.transition = '';
            }, 500);
        });

        // PWA Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('<?= base_url(); ?>sw.js')
                    .then(registration => {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    })
                    .catch(err => {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }

        // PWA Install Prompt Logic
        let deferredPrompt;
        const pwaInstallBanner = document.getElementById('pwa-install-banner');
        const pwaInstallBtn = document.getElementById('pwa-install-btn');
        const pwaCloseBtn = document.getElementById('pwa-close-btn');

        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent the mini-infobar from appearing on mobile
            e.preventDefault();
            // Stash the event so it can be triggered later.
            deferredPrompt = e;
            // Update UI notify the user they can install the PWA
            if(pwaInstallBanner) pwaInstallBanner.style.display = 'flex';
        });

        if(pwaInstallBtn) {
            pwaInstallBtn.addEventListener('click', async () => {
                // Hide the app provided install promotion
                pwaInstallBanner.style.display = 'none';
                // Show the install prompt
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    // Wait for the user to respond to the prompt
                    const { outcome } = await deferredPrompt.userChoice;
                    console.log(`User response to the install prompt: ${outcome}`);
                    // We've used the prompt, and can't use it again, throw it away
                    deferredPrompt = null;
                }
            });
        }

        if(pwaCloseBtn) {
            pwaCloseBtn.addEventListener('click', () => {
                pwaInstallBanner.style.display = 'none';
            });
        }
    </script>
</body>

</html>