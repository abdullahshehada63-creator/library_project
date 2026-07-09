<?php
if ($lang === 'ar') {
    $lang_attr = 'ar';
    $dir = 'rtl';
    $bootstrap_css = 'https://cdn.rtlcss.com/bootstrap/v4.0.0/css/bootstrap.min.css';
    $bootstrap_js = 'https://cdn.rtlcss.com/bootstrap/v4.0.0/js/bootstrap.min.js';
} else {
    $lang_attr = 'en';
    $dir = 'ltr';
    $bootstrap_css = 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css';
    $bootstrap_js = 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang_attr; ?>" dir="<?php echo $dir; ?>">
<head>
    <meta charset="utf-8">
    <title>library_IUG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap (RTL or LTR based on language) -->
    <link rel="stylesheet" href="<?php echo $bootstrap_css; ?>">

    <!-- Optional Libraries -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Your Custom Styles -->
    <link href="css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="about.css">
    <link rel="stylesheet" href="service.css">
    <link rel="stylesheet" href="../css/search.css">
    <link rel="stylesheet" href="../css/books.css">
</head>
<body>
