<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['dark' => ($appearance ?? 'system') == 'dark']); ?>">

<head>
    <base href="<?php echo e(\Illuminate\Support\Facades\Request::getBasePath()); ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <script>
        (function() {
            const appearance = '<?php echo e($appearance ?? 'system'); ?>';

            if (appearance === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                }
            }
        })();

        // Define asset helper function
        window.asset = function(path) {
            return "<?php echo e(asset('')); ?>" + path;
        };
        // Define storage helper function
        window.storage = function(path) {
            return "<?php echo e(asset('storage')); ?>/" + path;
        };
    </script>

    
    <style>
        html {
            background-color: oklch(1 0 0);
        }

        html.dark {
            background-color: oklch(0.145 0 0);
        }
    </style>

    <title inertia><?php echo e(config('app.name', 'Laravel')); ?></title>

    <?php
        $seoSettings = settings();
    ?>
    <!-- Debug: <?php echo e(json_encode($seoSettings)); ?> -->
    <?php if(!empty($seoSettings['metaKeywords'])): ?>
        <meta name="keywords" content="<?php echo e($seoSettings['metaKeywords']); ?>">
    <?php endif; ?>
    <?php if(!empty($seoSettings['metaDescription'])): ?>
        <meta name="description" content="<?php echo e($seoSettings['metaDescription']); ?>">
    <?php endif; ?>
    <?php if(!empty($seoSettings['metaImage'])): ?>
        <meta property="og:image"
            content="<?php echo e(str_starts_with($seoSettings['metaImage'], 'http') ? $seoSettings['metaImage'] : url($seoSettings['metaImage'])); ?>">
    <?php endif; ?>
    <meta property="og:title" content="<?php echo e(config('app.name', 'Laravel')); ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">    

    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logos/favicon.png')); ?>">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/frappe-gantt.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('css/frappe-gantt.css')); ?>">
    <?php echo app('Tighten\Ziggy\BladeRouteGenerator')->generate(); ?>
    <?php if(app()->environment('local') && file_exists(public_path('hot'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')->reactRefresh(); ?>
    <?php endif; ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.tsx']); ?>
    <script>
        window.baseUrl = '<?php echo e(url('/')); ?>';
    </script>
    <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->head; } ?>
</head>
<body class="font-sans antialiased">
    <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->body; } elseif (config('inertia.use_script_element_for_initial_page')) { ?><script data-page="app" type="application/json"><?php echo json_encode($page); ?></script><div id="app"></div><?php } else { ?><div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div><?php } ?>
</body>
</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/task/resources/views/app.blade.php ENDPATH**/ ?>