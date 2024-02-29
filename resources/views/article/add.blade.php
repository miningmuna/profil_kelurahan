<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <input class="form-control" type="text" placeholder="title" name="title" aria-label="default input example">
        <input type="file" name="thumbnail">
        <textarea id="editor" type="text" name="description"></textarea>
        <button type="submit">SUBMIT</button>
    </form>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>
