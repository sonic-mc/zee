<x-guest-layout>
    {{-- Skip link: visible only on keyboard focus, jumps straight to the form --}}
    <a href="#login-form" class="skip-link">Skip to login form</a>

    {{-- Screen-reader live region: announces dynamic state changes (contrast, font size) --}}
    <div id="a11y-announce" role="status" aria-live="polite" aria-atomic="true"
         class="visually-hidden"></div>

    <div class="login-card shadow rounded-4 p-4 p-md-5 w-100">
        <div class="text-center mb-4">
            <h1 class="fw-bold mb-2">Login to Your Account</h1>
            <p class="text-muted mb-0">
                Enter your details below to access your account.
            </p>
        </div>

        {{--
            Accessibility Features panel.
            <details>/<summary> is natively keyboard-operable (Enter/Space to toggle)
            and announces its expanded state to screen readers without any JavaScript.
        --}}
        <details class="a11y-info-panel mb-4" id="a11yInfoPanel">
            <summary class="a11y-info-summary" aria-label="Accessibility features available on this page — click to expand">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true" focusable="false" class="me-2 align-middle">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Accessibility Features
                <span class="a11y-info-chevron" aria-hidden="true">&#9660;</span>
            </summary>

            <div class="a11y-info-body" role="region" aria-label="Accessibility features description">
                <p class="small mb-3">
                    This login page is designed to be fully accessible. The following features
                    are available to support users with visual and motor impairments:
                </p>

                <ol class="a11y-feature-list">
                    <li>
                        <strong>Screen Reader Support</strong><br>
                        All fields, buttons, and error messages carry proper labels and
                        ARIA attributes. A live announcement region reads out state
                        changes (e.g. contrast toggled, text size changed) without
                        interrupting your screen reader.
                    </li>
                    <li>
                        <strong>High Colour Contrast Mode</strong><br>
                        Use the <em>High Contrast</em> button above to switch to a
                        black background with white and yellow text. This improves
                        readability for users with low vision or colour blindness.
                        Your preference is saved and restored automatically.
                    </li>
                    <li>
                        <strong>Adjustable Text Size</strong><br>
                        Use the <em>A+</em> and <em>A−</em> buttons above to increase
                        or decrease the size of all text on the page (range: 12 – 28 px).
                        Your chosen size is saved and restored on your next visit.
                    </li>
                    <li>
                        <strong>Keyboard Navigation</strong><br>
                        Every element is reachable by pressing <kbd>Tab</kbd> and
                        activatable with <kbd>Enter</kbd> or <kbd>Space</kbd>.
                        A visible focus ring highlights the currently selected element.
                        A "Skip to login form" link appears when you first press
                        <kbd>Tab</kbd>, letting you bypass the accessibility toolbar.
                    </li>
                    <li>
                        <strong>Clear Labels and Instructions</strong><br>
                        Each field has a persistent label and helper text. Required
                        fields are marked with an asterisk (*). No information is
                        communicated by placeholder text alone.
                    </li>
                    <li>
                        <strong>Accessible Error Messages</strong><br>
                        If your login attempt fails, an error summary appears at the
                        top of the form and focus moves to it automatically. Each
                        field also shows its own inline error message prefixed with
                        a warning icon and the word "Error:" so it is never conveyed
                        by colour alone.
                    </li>
                    <li>
                        <strong>Show / Hide Password</strong><br>
                        The eye icon button next to the password field toggles
                        password visibility. Its state (shown/hidden) is announced
                        to screen readers and focus returns to the password field
                        after toggling so you can review what you typed.
                    </li>
                    <li>
                        <strong>Large Touch Targets</strong><br>
                        All buttons and input fields meet the WCAG 2.5.5 minimum
                        touch target size of 44 × 44 px. The checkbox is enlarged
                        and the "Forgot password" link has extra padding for easy
                        tapping on mobile devices.
                    </li>
                    <li>
                        <strong>Forgot Password Recovery</strong><br>
                        A clearly labelled "Forgot your password?" link below the
                        login button opens the password reset page. Screen readers
                        will hear a full description of what the link does when it
                        receives focus.
                    </li>
                </ol>
            </div>
        </details>

        {{-- Accessibility Controls --}}
        <div role="group" aria-label="Accessibility controls"
             class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

            {{-- High-contrast toggle: aria-pressed reflects current state --}}
            <button type="button"
                    class="btn btn-outline-dark"
                    id="toggleContrast"
                    aria-pressed="false"
                    aria-label="Toggle high contrast mode">
                High Contrast: <span id="contrastLabel">Off</span>
            </button>

            {{-- Text-size controls --}}
            <div class="d-flex align-items-center gap-2">
                <span class="small text-muted" aria-hidden="true">Text size:</span>
                <button type="button"
                        class="btn btn-outline-secondary a11y-size-btn"
                        id="decreaseText"
                        aria-label="Decrease text size">A&minus;</button>
                <button type="button"
                        class="btn btn-outline-secondary a11y-size-btn"
                        id="increaseText"
                        aria-label="Increase text size">A+</button>
            </div>
        </div>

        <x-auth-session-status class="mb-3 alert alert-success" :status="session('status')" />

        <main id="login-form">
            {{-- Required-field legend --}}
            <p class="small text-muted mb-3">
                Fields marked <abbr title="required" aria-hidden="true" class="text-danger fw-bold">*</abbr>
                <span class="visually-hidden">marked as required</span> are required.
            </p>

            <form method="POST" action="{{ route('login') }}" novalidate aria-label="Login form">
                @csrf

                {{--
                    Error summary: listed before the fields so screen readers encounter it
                    first. tabindex="-1" lets JS move focus here programmatically.
                    role="alert" causes an immediate announcement on page load.
                --}}
                @if ($errors->any())
                    <div id="error-summary"
                         class="error-summary alert alert-danger"
                         role="alert"
                         aria-labelledby="errorSummaryHeading"
                         tabindex="-1">
                        <h2 id="errorSummaryHeading" class="h6 fw-bold mb-2">
                            <span aria-hidden="true">&#9888;</span>
                            There {{ $errors->count() === 1 ? 'is 1 problem' : 'are ' . $errors->count() . ' problems' }} with your submission:
                        </h2>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Email Address --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">
                        Email Address
                        <abbr title="required" aria-hidden="true" class="text-danger ms-1">*</abbr>
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        aria-required="true"
                        autofocus
                        autocomplete="username"
                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                        aria-describedby="emailHelp{{ $errors->has('email') ? ' emailError' : '' }}"
                        @error('email') aria-invalid="true" @enderror
                    >
                    <div id="emailHelp" class="form-text">
                        Enter the email address linked to your account. Example: name@example.com
                    </div>
                    @error('email')
                        <div id="emailError" class="field-error invalid-feedback" role="alert" aria-live="assertive">
                            <span aria-hidden="true" class="error-icon">&#9888;</span>
                            <span class="error-text">Error: {{ $message }}</span>
                        </div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">
                        Password
                        <abbr title="required" aria-hidden="true" class="text-danger ms-1">*</abbr>
                    </label>
                    {{--
                        Input group keeps the show/hide toggle immediately adjacent to
                        the field, so keyboard users reach it in one Tab press.
                    --}}
                    <div class="input-group">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            aria-required="true"
                            autocomplete="current-password"
                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                            aria-describedby="passwordHelp showPasswordBtn{{ $errors->has('password') ? ' passwordError' : '' }}"
                            @error('password') aria-invalid="true" @enderror
                        >
                        {{--
                            aria-pressed   — announces current state to screen readers.
                            aria-controls  — explicitly links the button to the field it affects.
                            type="button"  — prevents accidental form submission.
                        --}}
                        <button type="button"
                                id="showPasswordBtn"
                                class="btn btn-outline-secondary show-password-btn"
                                aria-pressed="false"
                                aria-controls="password"
                                aria-label="Show password">
                            {{-- Eye-open icon (visible when password is hidden) --}}
                            <svg id="iconShow" xmlns="http://www.w3.org/2000/svg"
                                 width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 aria-hidden="true" focusable="false">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            {{-- Eye-off icon (visible when password is shown) --}}
                            <svg id="iconHide" xmlns="http://www.w3.org/2000/svg"
                                 width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 aria-hidden="true" focusable="false"
                                 class="d-none">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8
                                         a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24
                                         A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8
                                         a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07
                                         a3 3 0 1 1-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                            <span class="visually-hidden" id="showPasswordState">Password is hidden</span>
                        </button>
                    </div>
                    <div id="passwordHelp" class="form-text">
                        Your password is case-sensitive. Minimum 8 characters.
                    </div>
                    @error('password')
                        <div id="passwordError" class="field-error invalid-feedback" role="alert" aria-live="assertive">
                            <span aria-hidden="true" class="error-icon">&#9888;</span>
                            <span class="error-text">Error: {{ $message }}</span>
                        </div>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="form-check form-check-lg mb-4">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label class="form-check-label" for="remember_me">Remember Me</label>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-dark btn-lg btn-login fw-semibold">
                        Login
                    </button>
                </div>

                {{--
                    Feature 11 — Accessible "Forgot Password".
                    - Placed outside the submit row so keyboard Tab order is:
                        Login button → Forgot password link  (predictable, feature 12)
                    - aria-describedby points to a hidden explanation read by screen readers.
                    - Icon + text label: never relies on text alone or icon alone.
                    - role="link" is implicit on <a href>, kept for clarity in code review.
                --}}
                @if (Route::has('password.request'))
                    <div class="forgot-password-wrapper" role="navigation" aria-label="Account recovery">
                        <hr class="forgot-divider" aria-hidden="true">
                        <p id="forgotDesc" class="visually-hidden">
                            Opens the password reset page. You will be asked to enter your
                            email address to receive a reset link.
                        </p>
                        <div class="text-center">
                            <a class="forgot-link"
                               href="{{ route('password.request') }}"
                               aria-describedby="forgotDesc">
                                {{-- Lock icon: aria-hidden, label is in the text --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     width="14" height="14" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round"
                                     aria-hidden="true" focusable="false"
                                     class="me-1 align-middle">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                                Forgot your password?
                            </a>
                        </div>
                    </div>
                @endif
            </form>
        </main>
    </div>

    <style>
        :root {
            --base-font-size: 16px;
            --min-font-size: 12;
            --max-font-size: 28;
        }

        body {
            font-size: var(--base-font-size);
        }

        .login-card {
            background: #ffffff;
            border: 1px solid #dcdcdc;
        }

        /* ── Accessibility Features info panel ── */
        .a11y-info-panel {
            border: 1px solid #b6d4fe;
            border-radius: 0.5rem;
            background: #eff6ff;
            overflow: hidden;
        }

        .a11y-info-summary {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.7rem 1rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: #1d4ed8;
            cursor: pointer;
            list-style: none;          /* removes default triangle in Firefox */
            user-select: none;
        }

        /* Remove default marker in WebKit/Blink */
        .a11y-info-summary::-webkit-details-marker { display: none; }

        .a11y-info-summary:hover {
            background: #dbeafe;
        }

        .a11y-info-chevron {
            margin-left: auto;
            font-size: 0.75rem;
            transition: transform 0.2s ease;
        }

        details[open] .a11y-info-chevron {
            transform: rotate(180deg);
        }

        .a11y-info-body {
            padding: 0 1rem 1rem;
            border-top: 1px solid #bfdbfe;
        }

        .a11y-feature-list {
            padding-left: 1.25rem;
            margin: 0;
        }

        .a11y-feature-list li {
            font-size: 0.875rem;
            line-height: 1.55;
            margin-bottom: 0.6rem;
            color: #1e3a5f;
        }

        .a11y-feature-list li:last-child { margin-bottom: 0; }

        kbd {
            display: inline-block;
            padding: 0.1em 0.35em;
            font-size: 0.8em;
            font-family: monospace;
            border: 1px solid #94a3b8;
            border-radius: 0.25rem;
            background: #f1f5f9;
            color: #1e293b;
            line-height: 1.4;
        }

        /* High-contrast overrides for the info panel */
        body.high-contrast .a11y-info-panel {
            background: #001a33 !important;
            border-color: #fff !important;
        }

        body.high-contrast .a11y-info-summary {
            color: #7dd3fc !important;
        }

        body.high-contrast .a11y-info-summary:hover {
            background: #002244 !important;
        }

        body.high-contrast .a11y-info-body {
            border-top-color: #555 !important;
        }

        body.high-contrast .a11y-feature-list li {
            color: #e2e8f0 !important;
        }

        body.high-contrast kbd {
            background: #1e293b !important;
            color: #f8fafc !important;
            border-color: #94a3b8 !important;
        }

        /* ── Large Inputs & Buttons ── */
        /* WCAG 2.5.5: minimum touch target 44×44 px for all interactive elements */

        /* Inputs: enforce minimum height and comfortable padding */
        .form-control-lg {
            min-height: 3rem;       /* 48 px — above the 44 px minimum */
            padding: 0.65rem 1rem;
            font-size: 1.05rem;
        }

        /* Submit button: full-width, tall, generous padding */
        .btn-login {
            min-height: 3.25rem;    /* 52 px */
            font-size: 1.1rem;
            letter-spacing: 0.02em;
            transition: background 0.15s ease, transform 0.1s ease;
        }

        .btn-login:hover {
            background: #222 !important;
        }

        .btn-login:active {
            transform: scale(0.98);  /* tactile press feedback */
        }

        /* All other buttons: enforce minimum 44 px touch target */
        .btn {
            min-height: 2.75rem;    /* 44 px */
            min-width: 2.75rem;
        }

        /* A+ / A- text-size buttons: square, finger-friendly */
        .a11y-size-btn {
            min-width: 2.75rem;
            min-height: 2.75rem;
            padding: 0.375rem 0.6rem;
            font-weight: 700;
        }

        /* Spacing between interactive elements prevents mis-taps */
        .mb-3 { margin-bottom: 1.25rem !important; }
        .mb-4 { margin-bottom: 1.75rem !important; }

        /* Enlarged checkbox for easier tap/click (WCAG 2.5.5) */
        .form-check-lg .form-check-input {
            width: 1.4rem;
            height: 1.4rem;
            margin-top: 0.15rem;
            cursor: pointer;
        }

        .form-check-lg .form-check-label {
            padding-left: 0.4rem;
            line-height: 1.6;
            cursor: pointer;
        }

        /* ── Feature 11 — Forgot password section ── */
        /* Divider creates clear visual separation from the primary action (feature 12) */
        .forgot-password-wrapper {
            margin-top: 0.5rem;
        }

        .forgot-divider {
            border-color: #dcdcdc;
            margin: 1rem 0 0.85rem;
        }

        /* Forgot link: visually consistent with all other interactive elements
           (same font size, same focus ring, same hover cue) — feature 12 */
        .forgot-link {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 1rem;            /* matches form labels and helper text */
            font-weight: 500;
            color: #0d6efd;
            text-decoration: underline;
            text-underline-offset: 2px;
            padding: 0.5rem 0.5rem;    /* 44 px tap target height */
            min-height: 2.75rem;
            border-radius: 0.375rem;   /* same border-radius as .btn */
            transition: color 0.15s ease, background 0.15s ease;
        }

        .forgot-link:hover {
            color: #0a58ca;
            background: #f0f7ff;       /* matches input focus tint — feature 12 */
            text-decoration-thickness: 2px;
        }

        body.high-contrast .forgot-link {
            color: #ffff00 !important;
            background: transparent !important;
        }

        body.high-contrast .forgot-link:hover {
            background: #1a1a00 !important;
        }

        body.high-contrast .forgot-divider {
            border-color: #555 !important;
        }

        /* ── Feature 12 — Consistent helper text across all fields ── */
        /* All .form-text nodes use the same size, weight, and colour */
        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.3rem;
            line-height: 1.4;
        }

        body.high-contrast .form-text {
            color: #ccc !important;
        }

        /* ── Feature 12 — Consistent interactive-element shape language ── */
        /* All buttons share the same border-radius token */
        .btn,
        .form-control,
        .forgot-link {
            border-radius: 0.375rem;
        }

        /* Accessibility toolbar buttons: same visual weight as secondary actions */
        #toggleContrast,
        .a11y-size-btn {
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* ── Feature 12 — Consistent spacing scale ── */
        /* Form groups, checkboxes, and sections all use the same rhythm */
        .mb-3 { margin-bottom: 1.25rem !important; }
        .mb-4 { margin-bottom: 1.75rem !important; }


        /* ── Show/Hide Password button ── */
        .show-password-btn {
            border-color: #ced4da;
            background: #fff;
            line-height: 1;
        }

        .show-password-btn:hover {
            background: #f8f9fa;
        }

        /* Ensure the button matches the lg input height */
        .input-group .form-control-lg ~ .show-password-btn {
            padding: 0.5rem 0.85rem;
        }

        body.high-contrast .show-password-btn {
            background: #000 !important;
            color: #fff !important;
            border: 2px solid #fff !important;
        }

        /* Keep focus ring visible in high-contrast mode — handled above in
           the focus indicator block; this selector is kept as a safety net */
        body.high-contrast .show-password-btn:focus-visible {
            outline: 3px solid #ffdd00 !important;
            box-shadow: 0 0 0 2px #000, 0 0 0 5px #ffdd00 !important;
        }

        /* ── Accessible Error Messages ── */
        /* Left border + icon means error is never conveyed by colour alone */
        .error-summary {
            border-left: 5px solid #b91c1c;
        }

        .field-error {
            display: flex;
            align-items: flex-start;
            gap: 0.3rem;
            font-weight: 600;
        }

        .error-icon {
            flex-shrink: 0;
            font-size: 1rem;
            line-height: 1.5;
        }

        /* Underline on invalid inputs (shape cue, not just colour) */
        .form-control.is-invalid {
            border-bottom: 3px solid #b91c1c;
            background-image: none; /* remove Bootstrap's SVG icon - we use our own text prefix */
        }

        /* High-contrast overrides for errors */
        body.high-contrast .error-summary {
            background: #000 !important;
            color: #fff !important;
            border: 2px solid #fff !important;
            border-left: 5px solid #ffdd00 !important;
        }

        body.high-contrast .field-error,
        body.high-contrast .error-text {
            color: #ffdd00 !important;
        }

        body.high-contrast .form-control.is-invalid {
            border: 2px solid #ffdd00 !important;
            border-bottom: 4px solid #ffdd00 !important;
        }


        /* ═══════════════════════════════════════════════════════════════
           VISIBLE FOCUS INDICATORS  (WCAG 2.4.11 — Focus Appearance)
           Technique: dual-ring = white inner gap + coloured outer ring.
           The white gap ensures the ring stays visible on ANY background
           colour (white card, dark high-contrast mode, coloured buttons).
        ═══════════════════════════════════════════════════════════════ */

        /* 1. Suppress browser default & Bootstrap's own shadow first */
        *:focus { outline: none; box-shadow: none; }
        *:focus:not(:focus-visible) { outline: none; box-shadow: none; }

        /* 2. Base ring applied to every keyboard-focused element */
        *:focus-visible {
            outline: 3px solid #005fcc;         /* blue outer ring          */
            outline-offset: 2px;                /* gap from element border  */
            box-shadow: 0 0 0 2px #fff,         /* white inner gap          */
                        0 0 0 5px #005fcc;      /* blue outer halo          */
            transition: outline-color 0.1s ease,
                        box-shadow   0.1s ease;
        }

        /* 3. Text inputs & textareas — also tint the left border so the
           active field is distinguishable from its neighbours at a glance */
        .form-control:focus-visible {
            outline: 3px solid #005fcc !important;
            outline-offset: 2px !important;
            box-shadow: 0 0 0 2px #fff,
                        0 0 0 5px #005fcc !important;
            border-left: 4px solid #005fcc !important;
            background-color: #f0f7ff !important; /* subtle tint for sighted users */
        }

        /* 4. Buttons — invert background slightly so inactive and focused
           states are distinguishable even at low contrast */
        .btn:focus-visible {
            outline: 3px solid #005fcc !important;
            outline-offset: 3px !important;
            box-shadow: 0 0 0 2px #fff,
                        0 0 0 6px #005fcc !important;
        }

        /* 5. Checkboxes — outline must be oversized to surround the
           custom checkbox widget, not just the hidden input element */
        .form-check-input:focus-visible {
            outline: 3px solid #005fcc !important;
            outline-offset: 3px !important;
            box-shadow: 0 0 0 2px #fff,
                        0 0 0 6px #005fcc !important;
        }

        /* 6. Links — thicker underline signals focus state independently
           of colour for users with colour-vision deficiencies */
        .forgot-link:focus-visible,
        a:focus-visible {
            outline: 3px solid #005fcc !important;
            outline-offset: 3px !important;
            box-shadow: 0 0 0 2px #fff,
                        0 0 0 6px #005fcc !important;
            text-decoration-thickness: 3px;
            text-underline-offset: 3px;
        }

        /* 7. High-contrast overrides — switch to yellow ring on black */
        body.high-contrast *:focus-visible,
        body.high-contrast .form-control:focus-visible,
        body.high-contrast .btn:focus-visible,
        body.high-contrast .form-check-input:focus-visible,
        body.high-contrast .forgot-link:focus-visible,
        body.high-contrast a:focus-visible {
            outline-color: #ffdd00 !important;
            box-shadow: 0 0 0 2px #000,
                        0 0 0 5px #ffdd00 !important;  /* black gap on black bg */
        }

        body.high-contrast .form-control:focus-visible {
            border-left-color: #ffdd00 !important;
            background-color: #0d0d0d !important;
        }

        /* Skip link: off-screen until focused by keyboard */
        .skip-link {
            position: fixed;
            top: -100%;
            left: 1rem;
            z-index: 9999;
            padding: 0.5rem 1rem;
            background: #005fcc;
            color: #fff;
            font-weight: 600;
            border-radius: 0 0 0.375rem 0.375rem;
            text-decoration: none;
            transition: top 0.15s ease;
        }
        .skip-link:focus {
            top: 0;
            outline: 3px solid #ffdd00 !important;
            outline-offset: 3px;
            box-shadow: 0 0 0 2px #005fcc,
                        0 0 0 5px #ffdd00 !important;
        }

        /* ── High Contrast Mode ── */
        body.high-contrast {
            background: #000 !important;
            color: #fff !important;
        }

        body.high-contrast .login-card {
            background: #111 !important;
            color: #fff !important;
            border: 2px solid #fff !important;
        }

        body.high-contrast .form-control {
            background: #000 !important;
            color: #fff !important;
            border: 2px solid #fff !important;
        }

        body.high-contrast .form-text,
        body.high-contrast .text-muted,
        body.high-contrast .form-label,
        body.high-contrast .form-check-label,
        body.high-contrast h1,
        body.high-contrast p {
            color: #fff !important;
        }

        body.high-contrast .btn-dark {
            background: #fff !important;
            color: #000 !important;
            border: 2px solid #fff !important;
        }

        body.high-contrast .btn-outline-dark,
        body.high-contrast .btn-outline-secondary {
            background: #fff !important;
            color: #000 !important;
            border: 2px solid #fff !important;
        }

        /* Keep focus ring visible in high-contrast mode — consolidated into
           the focus indicator block above; duplicate block removed */
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ── Focus error summary on page load if errors are present ─────
            const errorSummary = document.getElementById('error-summary');
            if (errorSummary) {
                errorSummary.focus();
            }

            const announce       = document.getElementById('a11y-announce');
            const toggleContrast = document.getElementById('toggleContrast');
            const contrastLabel  = document.getElementById('contrastLabel');
            const increaseText  = document.getElementById('increaseText');
            const decreaseText  = document.getElementById('decreaseText');

            const MIN_SIZE = 12;
            const MAX_SIZE = 28;
            const STEP     = 2;

            // ── Restore persisted preferences ──────────────────────────────
            let currentFontSize = parseInt(localStorage.getItem('fontSize') || '16', 10);
            applyFontSize(currentFontSize);

            if (localStorage.getItem('highContrast') === 'true') {
                enableContrast(true, false); // restore silently (no announcement on load)
            }

            // ── Announce focused section label to screen-reader live region ──
            // Helps users using screen readers AND sighted keyboard users
            // understand where Tab has moved them.
            const focusableLabels = {
                'email':          'Email Address field',
                'password':       'Password field',
                'showPasswordBtn':'Show or hide password button',
                'remember_me':    'Remember Me checkbox',
                'toggleContrast': 'High contrast toggle button',
                'decreaseText':   'Decrease text size button',
                'increaseText':   'Increase text size button',
            };

            document.addEventListener('focusin', function (e) {
                const label = focusableLabels[e.target.id];
                if (label) say('Focused: ' + label);
                // Announce the forgot-password link by its href match
                if (e.target.classList.contains('forgot-link')) {
                    say('Focused: Forgot your password link — opens the password reset page');
                }
            });

            const showPasswordBtn  = document.getElementById('showPasswordBtn');
            const passwordInput    = document.getElementById('password');
            const iconShow         = document.getElementById('iconShow');
            const iconHide         = document.getElementById('iconHide');
            const showPasswordState = document.getElementById('showPasswordState');

            showPasswordBtn.addEventListener('click', function () {
                const isVisible = passwordInput.type === 'text';

                // Toggle input type
                passwordInput.type = isVisible ? 'password' : 'text';

                // Update button state
                const nowVisible = !isVisible;
                showPasswordBtn.setAttribute('aria-pressed', String(nowVisible));
                showPasswordBtn.setAttribute('aria-label', nowVisible ? 'Hide password' : 'Show password');

                // Swap icons
                iconShow.classList.toggle('d-none', nowVisible);
                iconHide.classList.toggle('d-none', !nowVisible);

                // Update visually-hidden state text (for ATs that read button contents)
                showPasswordState.textContent = nowVisible ? 'Password is visible' : 'Password is hidden';

                // Announce to screen-reader live region
                say(nowVisible ? 'Password is now visible' : 'Password is now hidden');

                // Return focus to the password field so users can review what they typed
                passwordInput.focus();
            });

            // ── High-contrast toggle ────────────────────────────────────────
            toggleContrast.addEventListener('click', function () {
                const isOn = document.body.classList.contains('high-contrast');
                enableContrast(!isOn, true);
            });

            function enableContrast(on, shouldAnnounce) {
                document.body.classList.toggle('high-contrast', on);
                toggleContrast.setAttribute('aria-pressed', String(on));
                contrastLabel.textContent = on ? 'On' : 'Off';
                localStorage.setItem('highContrast', String(on));
                if (shouldAnnounce) {
                    say('High contrast mode ' + (on ? 'enabled' : 'disabled'));
                }
            }

            // ── Text size ───────────────────────────────────────────────────
            increaseText.addEventListener('click', function () {
                if (currentFontSize < MAX_SIZE) {
                    currentFontSize += STEP;
                    applyFontSize(currentFontSize);
                    say('Text size increased to ' + currentFontSize + ' pixels');
                } else {
                    say('Maximum text size reached');
                }
            });

            decreaseText.addEventListener('click', function () {
                if (currentFontSize > MIN_SIZE) {
                    currentFontSize -= STEP;
                    applyFontSize(currentFontSize);
                    say('Text size decreased to ' + currentFontSize + ' pixels');
                } else {
                    say('Minimum text size reached');
                }
            });

            function applyFontSize(size) {
                document.documentElement.style.setProperty('--base-font-size', size + 'px');
                decreaseText.disabled = (size <= MIN_SIZE);
                increaseText.disabled = (size >= MAX_SIZE);
                localStorage.setItem('fontSize', String(size));
            }

            // ── Screen-reader announcement helper ───────────────────────────
            function say(message) {
                announce.textContent = '';          // reset so repeated messages re-trigger
                requestAnimationFrame(function () {
                    announce.textContent = message;
                });
            }
        });
    </script>
</x-guest-layout>
