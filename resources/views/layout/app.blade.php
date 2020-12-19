<!DOCTYPE html>
<html lang="en">
<head>
    <title>manager employee</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
i{
    font-size: 1.6rem;
    color: orange;
}
        /* layout */
         ul.nav {
            margin-bottom: 2px;
            font-size: 12px; /* to change font-size, please change instead .lbl */
        }
         ul.nav ul,
         ul.nav ul li {
            list-style: none!important;
            list-style-type: none!important;
            margin-top: 1px;
            margin-bottom: 1px;
        }
        ul.nav ul {
            padding-left: 0;
            width: auto;
        }
        ul.nav ul.children {
            padding-left: 12px;
            width: auto;
        }
         ul.nav ul.children li{
            margin-left: 0px;
        }
         ul.nav li a.link:hover {
            text-decoration: none;
        }

     ul.nav li a.link:hover .lbl {
            color: #999!important;
        }

         ul.nav li.current>a.link .lbl {
            background-color: #999;
            color: #fff!important;
        }

        /* parent item */
         ul.nav li.parent a.link {
            padding: 0px;
            color: #ccc;
        }
         ul.nav>li.parent>a.link {
            border: solid 1px #999;
            text-transform: uppercase;
        }
        ul.nav li.parent a.link:hover {
            background-color: #fff;
            -webkit-box-shadow:inset 0 3px 8px rgba(0,0,0,0.125);
            -moz-box-shadow:inset 0 3px 8px rgba(0,0,0,0.125);
            box-shadow:inset 0 3px 8px rgba(0,0,0,0.125);
        }

        /* link tag (a)*/
         ul.nav li.parent ul li a.link {
            color: #222;
            border: none;
            display:inline-block;
            padding-left: 5px;
             width: 55%;
        }

         ul.nav li.parent ul li a.link:hover {
            background-color: #fff;
            -webkit-box-shadow:none;
            -moz-box-shadow:none;
            box-shadow:none;
        }

        /* sign for parent item */
         ul.nav li .sign {
            display: inline-block;
            width: 14px;
            padding: 5px 8px;
            background-color: transparent;
            color: #fff;
        }
        ul.nav li.parent>a.link>.sign{
            margin-left: 0px;
            background-color: #999;
        }

        /* label */
         ul.nav li .lbl {
            padding: 5px 12px;
            display: inline-block;
        }
        ul.nav li.current>a.link>.lbl {
            color: #fff;
        }
         ul.nav  li a.link .lbl{
            font-size: 12px;
        }

        /* THEMATIQUE
        ------------------------- */
        /* theme 1 */
        ul.nav>li.item-1.parent>a.link {
            border: solid 1px #ff6307;
        }
         ul.nav>li.item-1.parent>a.link>.sign,
        ul.nav>li.item-1 li.parent>a.link>.sign{
            margin-left: 0px;
            background-color: #ff6307;
        }
         ul.nav>li.item-1 .lbl {
            color: #ff6307;
        }
         ul.nav>li.item-1 li.current>a.link .lbl {
            background-color: #ff6307;
            color: #fff!important;
        }

        /* theme 2 */
         ul.nav>li.item-8.parent>a.link {
            border: solid 1px #51c3eb;
        }
         ul.nav>li.item-8.parent>a.link>.sign,
         ul.nav>li.item-8 li.parent>a.link>.sign{
            margin-left: 0px;
            background-color: #51c3eb;
        }
         ul.nav>li.item-8 .lbl {
            color: #51c3eb;
        }
         ul.nav>li.item-8 li.current>a.link .lbl {
            background-color: #51c3eb;
            color: #fff!important;
        }

        /* theme 3 */
         ul.nav>li.item-15.parent>a.link {
            border: solid 1px #94cf00;
        }
         ul.nav>li.item-15.parent>a>.sign,
         ul.nav>li.item-15 li.parent>a>.sign{
            margin-left: 0px;
            background-color: #94cf00;
        }
         ul.nav>li.item-15 .lbl {
            color: #94cf00;
        }
         ul.nav>li.item-15 li.current>a.link .lbl {
            background-color: #94cf00;
            color: #fff!important;
        }

        /* theme 4 */
         ul.nav>li.item-22.parent>a.link {
            border: solid 1px #ef409c;
        }
         ul.nav>li.item-22.parent>a.link>.sign,
         ul.nav>li.item-22 li.parent>a.link>.sign{
            margin-left: 0px;
            background-color: #ef409c;
        }
         ul.nav>li.item-22 .lbl {
            color: #ef409c;
        }
         ul.nav>li.item-22 li.current>a.link .lbl {
            background-color: #ef409c;
            color: #fff!important;
        }
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
