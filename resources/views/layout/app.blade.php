<!DOCTYPE html>
<html lang="en">
<head>
    <title>manager employee</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        /*.mb-0 > a {*/
            /*display: block;*/
            /*position: relative;*/
        /*}*/
        /*.mb-0 > a:after {*/
            /*content: "\f078"; !* fa-chevron-down *!*/
            /*font-family: 'FontAwesome';*/
            /*position: absolute;*/
            /*right: 0;*/
        /*}*/
        /*.mb-0 > a[aria-expanded="true"]:after {*/
            /*content: "\f077"; !* fa-chevron-up *!*/
        /*}*/
    </style>
    @stack("css")
</head>
<body>
@include("layout.header")
<main class="my-5">

    @yield("content")
</main>
@include("layout.footer")
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@stack('scripts')
<script>

    $(document).on("click"," ul.nav li.parent > a > span.sign", function(){
        $(this).find('i:first').toggleClass("icon-minus");
    });

    // Open Le current menu
    $(" ul.nav li.parent.active > a > span.sign").find('i:first').addClass("icon-minus");
    $(" ul.nav li.current").parents('ul.children').addClass("in");
    
</script>
</html>
