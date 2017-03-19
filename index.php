<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Importar post de un excel</title>
</head>
<body>
    <h1 class="custom-font"><strong>Seleccionar archivo (.csv)</strong></h1>
    <form action="<?php echo home_url('papucho/'); ?>" method="post" enctype="multipart/form-data">
        <p>
            <input type="file" name="csv_import">
        </p>
        <input type="submit" class="btn btn-rounded btn-primary" value="Importar datos">
    </form>
</body>
</html>
