<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>{{ $title ?? 'Dashboard Penjual' }} - DapurWarga</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "secondary-fixed": "#6bff8f",
                    "on-surface": "#191c1e",
                    "on-background": "#191c1e",
                    "surface-container-low": "#f2f4f6",
                    "on-error-container": "#93000a",
                    "inverse-primary": "#c4c1fb",
                    "on-tertiary-fixed-variant": "#38485d",
                    "surface-container-highest": "#e0e3e5",
                    "on-secondary-container": "#007432",
                    "outline-variant": "#c8c5d0",
                    "surface-container-high": "#e6e8ea",
                    "on-primary": "#ffffff",
                    "surface-dim": "#d8dadc",
                    "error": "#ba1a1a",
                    "surface-tint": "#5b598c",
                    "surface": "#f7f9fb",
                    "primary-fixed-dim": "#c4c1fb",
                    "secondary-container": "#6bff8f",
                    "on-secondary-fixed": "#002109",
                    "surface-container": "#eceef0",
                    "tertiary-fixed": "#d3e4fe",
                    "on-primary-fixed-variant": "#444173",
                    "on-tertiary": "#ffffff",
                    "on-surface-variant": "#47464f",
                    "surface-variant": "#e0e3e5",
                    "tertiary": "#000c1d",
                    "primary-fixed": "#e3dfff",
                    "primary-container": "#1e1b4b",
                    "inverse-surface": "#2d3133",
                    "on-secondary": "#ffffff",
                    "inverse-on-surface": "#eff1f3",
                    "secondary": "#006e2f",
                    "outline": "#787680",
                    "on-tertiary-fixed": "#0b1c30",
                    "surface-bright": "#f7f9fb",
                    "secondary-fixed-dim": "#4ae176",
                    "on-primary-fixed": "#181445",
                    "tertiary-fixed-dim": "#b7c8e1",
                    "surface-container-lowest": "#ffffff",
                    "on-tertiary-container": "#7a8aa2",
                    "tertiary-container": "#122336",
                    "on-primary-container": "#8683ba",
                    "error-container": "#ffdad6",
                    "on-error": "#ffffff",
                    "on-secondary-fixed-variant": "#005321",
                    "primary": "#070235",
                    "background": "#f7f9fb"
            },
            "borderRadius": {
                    "DEFAULT": "0.125rem",
                    "lg": "0.25rem",
                    "xl": "0.5rem",
                    "full": "0.75rem"
            },
            "spacing": {
                    "section-gap": "64px",
                    "stack-sm": "8px",
                    "gutter": "24px",
                    "stack-md": "16px",
                    "container-max": "1280px",
                    "margin-mobile": "16px",
                    "stack-lg": "32px"
            },
            "fontFamily": {
                    "caption": ["Inter"],
                    "body-md": ["Inter"],
                    "headline-lg-mobile": ["Inter"],
                    "display-lg": ["Inter"],
                    "headline-md": ["Inter"],
                    "headline-lg": ["Inter"],
                    "label-md": ["Inter"],
                    "body-lg": ["Inter"]
            },
            "fontSize": {
                    "caption": ["12px", { "lineHeight": "16px", "fontWeight": "500" }],
                    "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                    "headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "700" }],
                    "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "800" }],
                    "headline-md": ["20px", { "lineHeight": "28px", "fontWeight": "700" }],
                    "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "700" }],
                    "label-md": ["14px", { "lineHeight": "20px", "fontWeight": "600" }],
                    "body-lg": ["18px", { "lineHeight": "30px", "fontWeight": "400" }]
            }
    },
        },
      }
    </script>
<style>
        body { font-family: 'Inter', sans-serif; }
    </style>
