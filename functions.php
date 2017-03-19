<?php function stripBOM($fname) {
    $res = fopen($fname, 'rb');
    if (false !== $res) {
        $bytes = fread($res, 3);
        if ($bytes == pack('CCC', 0xef, 0xbb, 0xbf)) {
            fclose($res);

            $contents = file_get_contents($fname);
            if (false === $contents) {
                trigger_error('Failed to get file contents.', E_USER_WARNING);
            }
            $contents = substr($contents, 3);
            $success = file_put_contents($fname, $contents);
            if (false === $success) {
                trigger_error('Failed to put file contents.', E_USER_WARNING);
            }
        } else {
            fclose($res);
        }
    }
} ?>
