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

    $(document).ready(function() {
        //load tat ca phong ban con
        $("a#loadChild").on("click", function (e) {
            const url = $(this).attr("data-url");
            const id = $(this).attr("data-id");
            //console.log(url);
            $.ajax({
                method: "get",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType:'json',
            })
                .done(function( msg ) {
                    if(msg.status == 200){
                        console.log(msg.data);
                        $('.loadDepartmentChild_'+id).append(msg.data);
                        $('div').removeClass("loadDepartmentChild_"+id);
                    }else{
                        alert("Tải dữ liệu thất bại");
                    }
                    // $('#addEmployee').on('hidden.bs.modal', function () {
                    //     location.reload();
                    // })
                })
                .fail(function( err ) {
                    alert("Tải dữ liệu thất bại");
                });
        });

        $("span.getListEmployee").on("click", function (e) {
            const url = $(this).attr("data-url");
            // console.log(url);
            $.ajax({
                method: "get",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType:'json',
            })
                .done(function( msg ) {
                    if(msg.status == 200){
                        $('.ajaxListEmployee').html(msg.data);
                    }else{
                        alert("Tải dữ liệu thất bại");
                    }
                })
                .fail(function( err ) {
                    alert("Tải dữ liệu thất bại");
                });
        });
        //edit ten phong ban
        $("span.editDepartmentAjax").on("click", function (e) {
            const url = $(this).attr("data-url");
            const id = $(this).attr("data-id");
            //console.log(url);
            $.ajax({
                method: "get",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType:'json',
            })
                .done(function( msg ) {
                    if(msg.status == 200){
                         $("#editDepartment_"+id).html(msg.data);
                    }else{
                        alert("Tải dữ liệu thất bại");
                    }
                })
                .fail(function( err ) {
                    alert("Tải dữ liệu thất bại");
                });
        });
    });
</script>
</html>
