<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
<title>Trays4Us - <?php echo e($page_title ?? ''); ?></title>

<?php
if(isset($page_description) AND !empty($page_description)) {
    $page_description = strip_tags($page_description);
} else {
   $page_description = "Custom wooden trays – a harmonious blend of functionality and personalization for resellers seeking unique, exclusive offerings";
}

if(empty($og_image))
    $og_image = asset('assets/frontend-assets/images/website-logo.svg');
?>

<meta name="description" content="<?php echo $page_description; ?>" />
<link rel="canonical" href="<?php echo e(url()->current()); ?>" />
<meta name="ahrefs-site-verification" content="0d86ad3bb3131692276f77f7bbb4327f05c8e94bf66c416384b6af2c7fbc2e18">
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo e($page_title ?? ''); ?>" />
<meta property="og:description" content="<?php echo $page_description; ?>" />
<meta property="og:url" content="<?php echo e(url()->current()); ?>" />
<meta property="og:image" content="<?php echo e($og_image); ?>">
<meta property="og:site_name" content="Trays4Us" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?php echo e($page_title ?? ''); ?>">
<meta name="twitter:description" content="<?php echo $page_description; ?>">
<meta name="twitter:image" content="<?php echo e($og_image); ?>">

<link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('assets/frontend-assets/images/apple-touch-icon.png')); ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('assets/frontend-assets/images/favicon-32x32.png')); ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('assets/frontend-assets/images/favicon-16x16.png')); ?>">

<link rel="manifest" href="<?php echo e(asset('assets/frontend-assets/images/site.webmanifest')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('/assets/css/bootstrap.min.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/sweetalert2.min.css')); ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/frontend-assets/css/style.css'). '?time=' . time()); ?>"/>
<?php /**PATH /home/customer/www/staging.trays4.us/public_html/resources/views/partials/frontend/headers-style.blade.php ENDPATH**/ ?>