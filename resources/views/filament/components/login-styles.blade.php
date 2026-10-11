<style>
    /* =======================================================
       DESIGNERA — Premium Light Theme Centered Login Design
       ======================================================= */

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    html, body {
        background: #f8fafc !important;
        font-family: 'Inter', sans-serif !important;
        margin: 0 !important;
        padding: 0 !important;
        color: #0f172a !important;
    }

    body.fi-simple {
        background: #f8fafc !important;
        min-height: 100vh !important;
        overflow-y: auto !important;
    }

    /* ---- Full-page centered layout ---- */
    .fi-simple-layout {
        min-height: 100vh !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        background: #f8fafc !important;
        position: relative !important;
        padding: 1.5rem 1rem !important;
        box-sizing: border-box !important;
        overflow: hidden !important;
    }

    /* Soft ambient background glows for light mode */
    .fi-simple-layout::before {
        content: '';
        position: absolute;
        top: 25%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 700px;
        height: 700px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.12) 0%, rgba(168, 85, 247, 0.06) 45%, transparent 70%);
        pointer-events: none;
        z-index: 0;
        animation: lightGlow 10s ease-in-out infinite alternate;
    }

    .fi-simple-layout::after {
        content: '';
        position: absolute;
        bottom: 10%;
        right: 15%;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.08) 0%, rgba(99, 102, 241, 0.04) 50%, transparent 70%);
        pointer-events: none;
        z-index: 0;
        animation: lightGlowAlt 12s ease-in-out infinite alternate;
    }

    @keyframes lightGlow {
        0% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
        100% { transform: translate(-50%, -52%) scale(1.1); opacity: 1; }
    }
    @keyframes lightGlowAlt {
        0% { transform: scale(1); opacity: 0.7; }
        100% { transform: scale(1.15); opacity: 1; }
    }

    /* Background mesh grid for light mode */
    .login-bg-grid {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, rgba(99, 102, 241, 0.08) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
        z-index: 0;
    }

    /* Center container */
    .fi-simple-main-ctn {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 100% !important;
        max-width: 420px !important;
        margin: auto !important;
        position: relative !important;
        z-index: 1 !important;
        padding: 0 !important;
        background: transparent !important;
    }

    /* Force simple main wrapper */
    .fi-simple-main {
        width: 100% !important;
        margin: auto !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        background: transparent !important;
    }

    .fi-simple-main > * {
        margin-top: 0 !important;
    }

    main.fi-simple-main {
        background: transparent !important;
        width: 100% !important;
        max-width: 420px !important;
        padding: 0 !important;
        position: relative !important;
        z-index: 1 !important;
    }

    .fi-simple-main.fi-width-lg {
        max-width: 420px !important;
    }

    /* Card animation */
    .fi-simple-page {
        animation: loginCardIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) both !important;
        width: 100% !important;
    }

    @keyframes loginCardIn {
        from { opacity: 0; transform: translateY(28px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ---- Compact Light glassmorphism card ---- */
    .fi-simple-page-content {
        background: rgba(255, 255, 255, 0.92) !important;
        border: 1px solid rgba(226, 232, 240, 0.9) !important;
        border-radius: 20px !important;
        padding: 2rem 1.85rem !important;
        backdrop-filter: blur(24px) !important;
        -webkit-backdrop-filter: blur(24px) !important;
        box-shadow:
            0 0 0 1px rgba(99, 102, 241, 0.05),
            0 16px 36px -12px rgba(99, 102, 241, 0.12),
            0 8px 20px -4px rgba(15, 23, 42, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.9) !important;
        position: relative !important;
        overflow: hidden !important;
        transition: border-color 0.3s ease, box-shadow 0.3s ease !important;
    }

    .fi-simple-page-content:hover {
        border-color: rgba(99, 102, 241, 0.3) !important;
        box-shadow:
            0 0 0 1px rgba(99, 102, 241, 0.08),
            0 20px 44px -10px rgba(99, 102, 241, 0.18),
            0 10px 24px -4px rgba(15, 23, 42, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 1) !important;
    }

    /* Top accent gradient line */
    .fi-simple-page-content::before {
        content: '' !important;
        position: absolute !important;
        top: 0; left: 0; right: 0 !important;
        height: 3px !important;
        background: linear-gradient(90deg,
            #6366f1 0%,
            #a855f7 50%,
            #ec4899 100%) !important;
        z-index: 2 !important;
    }

    /* Header spacing */
    .fi-simple-header {
        margin-bottom: 1.25rem !important;
    }

    /* Logo styling */
    .fi-logo {
        filter: drop-shadow(0 2px 8px rgba(99, 102, 241, 0.2)) !important;
        transition: transform 0.3s ease !important;
    }
    .fi-logo:hover {
        transform: scale(1.02) !important;
    }

    /* Header text */
    .fi-simple-header-heading {
        color: #0f172a !important;
        font-size: 1.625rem !important;
        font-weight: 800 !important;
        letter-spacing: -0.03em !important;
        line-height: 1.2 !important;
        margin-top: 0.15rem !important;
        margin-bottom: 0.15rem !important;
        background: none !important;
        -webkit-text-fill-color: initial !important;
    }

    .fi-simple-header-subheading {
        color: #64748b !important;
        font-size: 0.875rem !important;
        font-weight: 400 !important;
    }

    /* Form gap spacing (Reduced vertical gap) */
    .fi-simple-page-content form {
        display: flex !important;
        flex-direction: column !important;
        gap: 0.75rem !important;
    }

    .fi-fo-field-wrp {
        margin-bottom: 0 !important;
    }

    /* Form labels */
    .fi-simple-page-content label,
    .fi-simple-page-content .fi-label,
    .fi-simple-page-content .fi-fo-field-wrp-label,
    .fi-simple-page-content .fi-label .fi-label-content,
    .fi-simple-page-content .fi-fo-field-wrp-label label span:not(.fi-required-mark) {
        color: #334155 !important;
        -webkit-text-fill-color: #334155 !important;
        font-size: 0.8125rem !important;
        font-weight: 600 !important;
        letter-spacing: 0.01em !important;
        margin-bottom: 0.2rem !important;
    }
    .fi-simple-page-content .fi-required-mark {
        color: #ef4444 !important;
        -webkit-text-fill-color: #ef4444 !important;
    }

    /* Inputs container wrapper */
    .fi-input-wrp {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        padding: 0.05rem 0.15rem !important;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04) !important;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
    }

    .fi-input-wrp:focus-within {
        border-color: #6366f1 !important;
        background: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.14), 0 4px 10px rgba(99, 102, 241, 0.08) !important;
        transform: translateY(-1px) !important;
    }

    .fi-input-wrp:hover:not(:focus-within) {
        border-color: #94a3b8 !important;
    }

    /* Icon prefix inside input */
    .fi-input-wrp .fi-input-prefix-icon,
    .fi-input-wrp svg {
        color: #6366f1 !important;
        opacity: 0.9 !important;
        transition: color 0.2s ease, opacity 0.2s ease !important;
    }

    .fi-input-wrp:focus-within .fi-input-prefix-icon,
    .fi-input-wrp:focus-within svg {
        color: #4f46e5 !important;
        opacity: 1 !important;
    }

    .fi-input,
    input[type="email"],
    input[type="password"],
    input[type="text"] {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        color: #0f172a !important;
        font-size: 0.875rem !important;
        font-weight: 400 !important;
        caret-color: #6366f1 !important;
        outline: none !important;
        padding: 0.5rem 0.4rem !important;
    }

    input::placeholder {
        color: #94a3b8 !important;
        font-size: 0.84rem !important;
    }

    /* Password reveal eye icon */
    .fi-input-wrp button, .fi-input-suffix button {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        color: #64748b !important;
        transition: color 0.2s ease !important;
    }
    .fi-input-wrp button:hover { color: #0f172a !important; }

    /* Sign in button styling */
    .fi-btn {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
        border: 1px solid rgba(99, 102, 241, 0.2) !important;
        border-radius: 10px !important;
        color: #ffffff !important;
        font-size: 0.875rem !important;
        font-weight: 600 !important;
        letter-spacing: 0.01em !important;
        padding: 0.7rem 1.25rem !important;
        margin-top: 0.25rem !important;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35) !important;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
        overflow: hidden !important;
        position: relative !important;
        cursor: pointer !important;
    }

    .fi-btn:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%) !important;
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.45), 0 0 0 3px rgba(99, 102, 241, 0.15) !important;
        transform: translateY(-1px) scale(1.005) !important;
    }

    .fi-btn:active {
        transform: translateY(0) scale(0.99) !important;
        box-shadow: 0 2px 10px rgba(99, 102, 241, 0.3) !important;
    }

    /* Shimmer sweep effect */
    .fi-btn::after {
        content: '' !important;
        position: absolute !important;
        top: 0; left: -100% !important;
        width: 60%; height: 100% !important;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent) !important;
        transition: left 0.6s ease !important;
        pointer-events: none !important;
    }
    .fi-btn:hover::after { left: 160% !important; }

    .fi-fo-field-wrp-validation-error { color: #ef4444 !important; font-size: 0.8125rem !important; margin-top: 0.15rem !important; }
    a.fi-link, .fi-link { color: #6366f1 !important; font-weight: 500 !important; transition: color 0.2s ease !important; }
    a.fi-link:hover { color: #4f46e5 !important; text-decoration: underline !important; }
</style>

<script>
(function () {
    function injectBgDecorations() {
        var layout = document.querySelector('.fi-simple-layout');
        if (!layout || document.querySelector('.login-bg-grid')) { return; }

        var grid = document.createElement('div');
        grid.className = 'login-bg-grid';
        layout.appendChild(grid);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', injectBgDecorations);
    } else {
        injectBgDecorations();
    }
})();
</script>
