<?php if (empty($_FILES['csv_import']['tmp_name'])) {
    $mensaje = 'No se subió ningun archivo .csv. Vuelve a intentarlo.';
    $alert = 1;
} else {
    global $wpdb;
    require_once 'csv_datasource/datasource.php';
    $time_start = microtime(true);
    $csv = new File_CSV_DataSource;
    $file = $_FILES['csv_import']['tmp_name'];
    stripBOM($file);

    if (!$csv->load($file)) {
        $mensaje = 'Hubo un error al abrir el documento. Vuelve a intentarlo.';
        $alert = 1;
        return;
    }
    $csv->symmetrize();
    $tz = get_option('timezone_string');
    if ($tz && function_exists('date_default_timezone_set')) {
        date_default_timezone_set($tz);
    }
    $imported = 0;
    foreach ($csv->connect() as $data) {

        $fecharegistro = date("Y-m-d", strtotime($data['fechareg']));
        $columna1 = $data['columna1'];
        $columna2 = $data['columna2'];
        $columna3 = $data['columna3'];

        // Insertar post
        $idpost = wp_insert_post(
            array(
                'post_title'    =>  $columna1,
                'post_content'  =>  $columna2,
                'post_status'   =>  'publish',
                'post_date'     =>  $fecharegistro
            )
        );
        update_post_meta($idpost, 'columna3', $columna3);

        $imported++;

    }
    $exec_time = microtime(true) - $time_start;
    $exec_time = round($exec_time, 2);
    $mensaje = "<b>Papucho ha importado $imported registros en $exec_time segundos.</b>";
    $alert = 1;
}

if ($alert == 1) {
    echo $mensaje;
} ?>
