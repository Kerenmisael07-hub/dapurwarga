<!DOCTYPE html>
<html lang="id"><head>
@include('partials.dashboard-head', ['title' => 'Dashboard Superadmin'])
</head>
<body class="bg-surface text-on-surface h-screen flex flex-col overflow-hidden">
@include('partials.dashboard-header', ['title' => 'Dashboard Superadmin', 'brandOnDesktop' => true])
<main class="flex-1 overflow-y-auto bg-background p-margin-mobile md:p-gutter">
    <div class="max-w-container-max mx-auto space-y-stack-lg pb-section-gap">
        <div>
            <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Dashboard Superadmin</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">Kelola pengguna, peran, dan pengaturan utama DapurWarga.</p>
        </div>
    </div>
</main>
</body></html>
