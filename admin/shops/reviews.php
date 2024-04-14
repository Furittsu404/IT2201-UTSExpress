<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload Demo</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<h2>Image Upload Demo</h2>

<input type="file" id="file-input">
<br><br>
<img id="img-upload" src="" alt="Uploaded Image" style="max-width: 300px; max-height: 300px;">

<script>
    $(document).ready(function() {
        $('#file-input').change(function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#img-upload').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>

</body>
</html>
