<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        @yield('title') — {{ config('app.name', 'Website Sekolah') }}
    </title>

    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#123C9B">

    <style>
        :root {
            color-scheme: light;
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: #334155;
            background:
                radial-gradient(
                    circle at top left,
                    rgba(37, 99, 235, 0.16),
                    transparent 34rem
                ),
                linear-gradient(145deg, #f8fafc, #eff6ff);
        }

        .error-page {
            display: grid;
            min-height: 100vh;
            place-items: center;
            padding: 1.5rem;
        }

        .error-card {
            width: min(42rem, 100%);
            padding: clamp(2rem, 6vw, 4rem);
            border: 1px solid rgba(148, 163, 184, 0.28);
            border-radius: 1.5rem;
            background: rgba(255, 255, 255, 0.94);
            box-shadow: 0 24px 65px rgba(15, 23, 42, 0.14);
            text-align: center;
        }

        .error-icon {
            display: grid;
            width: 5rem;
            height: 5rem;
            place-items: center;
            margin: 0 auto 1.5rem;
            border-radius: 1.35rem;
            color: #123c9b;
            background: #dbeafe;
        }

        .error-icon svg {
            width: 2.5rem;
            height: 2.5rem;
        }

        .error-code {
            display: inline-flex;
            margin-bottom: 1rem;
            padding: 0.35rem 0.8rem;
            border-radius: 999px;
            color: #123c9b;
            background: #eff6ff;
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.08em;
        }

        .error-card h1 {
            margin: 0 0 1rem;
            color: #0f172a;
            font-size: clamp(1.8rem, 5vw, 2.75rem);
            line-height: 1.15;
        }

        .error-description {
            max-width: 34rem;
            margin: 0 auto;
            color: #64748b;
            font-size: 1rem;
            line-height: 1.75;
        }

        .error-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.75rem;
            margin-top: 2rem;
        }

        .error-button {
            display: inline-flex;
            min-height: 3rem;
            align-items: center;
            justify-content: center;
            padding: 0.7rem 1.2rem;
            border: 1px solid transparent;
            border-radius: 0.8rem;
            font: inherit;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .error-button-primary {
            color: #fff;
            background: #123c9b;
        }

        .error-button-primary:hover {
            background: #0f3488;
        }

        .error-button-secondary {
            border-color: rgba(148, 163, 184, 0.45);
            color: #334155;
            background: #fff;
        }

        .error-button-secondary:hover {
            background: #f8fafc;
        }

        .error-button:focus-visible {
            outline: 3px solid rgba(245, 190, 54, 0.7);
            outline-offset: 3px;
        }

        @media (max-width: 575.98px) {
            .error-actions {
                flex-direction: column;
            }

            .error-button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <main class="error-page">
        <section
            class="error-card"
            aria-labelledby="error-title"
        >
            <div
                class="error-icon"
                aria-hidden="true"
            >
                @yield('icon')
            </div>

            <div class="error-code">
                ERROR @yield('code')
            </div>

            <h1 id="error-title">
                @yield('heading')
            </h1>

            <p class="error-description">
                @yield('description')
            </p>

            <div class="error-actions">
                @yield('actions')
            </div>
        </section>
    </main>
</body>
</html>