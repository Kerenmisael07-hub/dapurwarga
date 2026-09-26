<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DapurWarga')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-primary-fixed": "#181445",
                        "secondary-container": "#6bff8f",
                        "on-tertiary": "#ffffff",
                        "surface-container-high": "#e6e8ea",
                        "primary-container": "#1e1b4b",
                        "on-error-container": "#93000a",
                        "surface-container-highest": "#e0e3e5",
                        "primary": "#070235",
                        "on-background": "#191c1e",
                        "inverse-primary": "#c4c1fb",
                        "tertiary-fixed-dim": "#b7c8e1",
                        "error": "#ba1a1a",
                        "surface-tint": "#5b598c",
                        "on-secondary-container": "#007432",
                        "surface-variant": "#e0e3e5",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-fixed": "#002109",
                        "primary-fixed": "#e3dfff",
                        "secondary": "#006e2f",
                        "outline-variant": "#c8c5d0",
                        "on-primary-fixed-variant": "#444173",
                        "on-surface": "#191c1e",
                        "inverse-on-surface": "#eff1f3",
                        "on-primary": "#ffffff",
                        "surface-dim": "#d8dadc",
                        "on-secondary-fixed-variant": "#005321",
                        "outline": "#787680",
                        "on-tertiary-fixed": "#0b1c30",
                        "on-tertiary-fixed-variant": "#38485d",
                        "inverse-surface": "#2d3133",
                        "on-tertiary-container": "#7a8aa2",
                        "background": "#f7f9fb",
                        "surface-bright": "#f7f9fb",
                        "on-surface-variant": "#47464f",
                        "surface-container-low": "#f2f4f6",
                        "on-secondary": "#ffffff",
                        "secondary-fixed-dim": "#4ae176",
                        "secondary-fixed": "#6bff8f",
                        "on-error": "#ffffff",
                        "error-container": "#ffdad6",
                        "surface": "#f7f9fb",
                        "tertiary-fixed": "#d3e4fe",
                        "tertiary": "#000c1d",
                        "tertiary-container": "#122336",
                        "surface-container": "#eceef0",
                        "primary-fixed-dim": "#c4c1fb",
                        "on-primary-container": "#8683ba"
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    spacing: {
                        "container-max": "1280px",
                        "stack-md": "16px",
                        "stack-lg": "32px",
                        "section-gap": "64px",
                        "stack-sm": "8px",
                        "gutter": "24px",
                        "margin-mobile": "16px"
                    },
                    fontFamily: {
                        "headline-lg-mobile": ["Inter"],
                        "body-md": ["Inter"],
                        "caption": ["Inter"],
                        "headline-lg": ["Inter"],
                        "body-lg": ["Inter"],
                        "display-lg": ["Inter"],
                        "headline-md": ["Inter"],
                        "label-md": ["Inter"]
                    },
                    fontSize: {
                        "headline-lg-mobile": ["24px", {
                            "lineHeight": "32px",
                            "fontWeight": "700"
                        }],
                        "body-md": ["16px", {
                            "lineHeight": "24px",
                            "fontWeight": "400"
                        }],
                        "caption": ["12px", {
                            "lineHeight": "16px",
                            "fontWeight": "500"
                        }],
                        "headline-lg": ["32px", {
                            "lineHeight": "40px",
                            "letterSpacing": "-0.01em",
                            "fontWeight": "700"
                        }],
                        "body-lg": ["18px", {
                            "lineHeight": "30px",
                            "fontWeight": "400"
                        }],
                        "display-lg": ["48px", {
                            "lineHeight": "56px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "800"
                        }],
                        "headline-md": ["20px", {
                            "lineHeight": "28px",
                            "fontWeight": "700"
                        }],
                        "label-md": ["14px", {
                            "lineHeight": "20px",
                            "fontWeight": "600"
                        }]
                    }
                }
            }
        };
    </script>
    <style>
        .backdrop-blur-nav {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .nav-link {
            position: relative;
            padding-bottom: 2px;
            transition: color 0.2s ease, transform 0.15s ease;
        }
        .nav-link:hover {
            color: #070235;
        }
        .nav-link:active {
            transform: scale(0.94);
        }
        .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 100%;
            background: #070235;
            border-radius: 9999px;
            transform: scaleX(0);
            transform-origin: right center;
            transition: transform 0.25s ease;
        }
        .nav-link:hover::after,
        .nav-link-active::after {
            transform: scaleX(1);
            transform-origin: left center;
        }
        .press-anim {
            transition: transform 0.15s ease, box-shadow 0.2s ease;
        }
        .press-anim:active {
            transform: scale(0.94);
        }
        .lift-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .lift-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 27, 75, 0.05);
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-surface text-on-surface antialiased font-body-md min-h-screen flex flex-col">
    @include('partials.header', ['active' => $active ?? 'beranda'])

    <main class="flex-grow w-full max-w-container-max mx-auto px-margin-mobile md:px-gutter">
        @yield('content')
    </main>
</body>
</html>