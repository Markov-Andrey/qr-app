<?php


namespace App\Services;


class GS1DataMatrixService
{

    /*  $dmtx_ec_params[] = array(                             */
    /*    total number of data codewords,                      */
    /*    number of error correction codewords per block,      */
    /*    number of blocks in first group,                     */
    /*    number of data codewords per block in first group,   */
    /*    number of blocks in second group,                    */
    /*    number of data codewords per block in second group,  */
    /*    number of data regions (vertical),                   */
    /*    number of data regions (horizontal),                 */
    /*    number of rows per data region,                      */
    /*    number of columns per data region                    */
    /*  );                                                     */
    private $dmtx_ec_params = array(
        array(3, 5, 1, 3, 0, 0, 1, 1, 8, 8),
        array(5, 7, 1, 5, 0, 0, 1, 1, 10, 10),
        array(8, 10, 1, 8, 0, 0, 1, 1, 12, 12),
        array(12, 12, 1, 12, 0, 0, 1, 1, 14, 14),
        array(18, 14, 1, 18, 0, 0, 1, 1, 16, 16),
        array(22, 18, 1, 22, 0, 0, 1, 1, 18, 18),
        array(30, 20, 1, 30, 0, 0, 1, 1, 20, 20),
        array(36, 24, 1, 36, 0, 0, 1, 1, 22, 22),
        array(44, 28, 1, 44, 0, 0, 1, 1, 24, 24),
        array(62, 36, 1, 62, 0, 0, 2, 2, 14, 14),
        array(86, 42, 1, 86, 0, 0, 2, 2, 16, 16),
        array(114, 48, 1, 114, 0, 0, 2, 2, 18, 18),
        array(144, 56, 1, 144, 0, 0, 2, 2, 20, 20),
        array(174, 68, 1, 174, 0, 0, 2, 2, 22, 22),
        array(204, 42, 2, 102, 0, 0, 2, 2, 24, 24),
        array(280, 56, 2, 140, 0, 0, 4, 4, 14, 14),
        array(368, 36, 4, 92, 0, 0, 4, 4, 16, 16),
        array(456, 48, 4, 114, 0, 0, 4, 4, 18, 18),
        array(576, 56, 4, 144, 0, 0, 4, 4, 20, 20),
        array(696, 68, 4, 174, 0, 0, 4, 4, 22, 22),
        array(816, 56, 6, 136, 0, 0, 4, 4, 24, 24),
        array(1050, 68, 6, 175, 0, 0, 6, 6, 18, 18),
        array(1304, 62, 8, 163, 0, 0, 6, 6, 20, 20),
        array(1558, 62, 8, 156, 2, 155, 6, 6, 22, 22),
        array(5, 7, 1, 5, 0, 0, 1, 1, 6, 16),
        array(10, 11, 1, 10, 0, 0, 1, 2, 6, 14),
        array(16, 14, 1, 16, 0, 0, 1, 1, 10, 24),
        array(22, 18, 1, 22, 0, 0, 1, 2, 10, 16),
        array(32, 24, 1, 32, 0, 0, 1, 2, 14, 16),
        array(49, 28, 1, 49, 0, 0, 1, 2, 14, 22),
    );

    private $dmtx_ec_polynomials = array(
        5 => array(
            0, 235, 207, 210, 244, 15
        ),
        7 => array(
            0, 177, 30, 214, 218, 42, 197, 28
        ),
        10 => array(
            0, 199, 50, 150, 120, 237, 131, 172, 83, 243, 55
        ),
        11 => array(
            0, 213, 173, 212, 156, 103, 109, 174, 242, 215, 12, 66
        ),
        12 => array(
            0, 168, 142, 35, 173, 94, 185, 107, 199, 74, 194, 233, 78
        ),
        14 => array(
            0, 83, 171, 33, 39, 8, 12, 248,
            27, 38, 84, 93, 246, 173, 105
        ),
        18 => array(
            0, 164, 9, 244, 69, 177, 163, 161, 231, 94,
            250, 199, 220, 253, 164, 103, 142, 61, 171
        ),
        20 => array(
            0, 127, 33, 146, 23, 79, 25, 193, 122, 209, 233,
            230, 164, 1, 109, 184, 149, 38, 201, 61, 210
        ),
        24 => array(
            0, 65, 141, 245, 31, 183, 242, 236, 177, 127, 225, 106,
            22, 131, 20, 202, 22, 106, 137, 103, 231, 215, 136, 85, 45
        ),
        28 => array(
            0, 150, 32, 109, 149, 239, 213, 198, 48, 94,
            50, 12, 195, 167, 130, 196, 253, 99, 166, 239,
            222, 146, 190, 245, 184, 173, 125, 17, 151
        ),
        36 => array(
            0, 57, 86, 187, 69, 140, 153, 31, 66, 135, 67, 248, 84,
            90, 81, 219, 197, 2, 1, 39, 16, 75, 229, 20, 51, 252,
            108, 213, 181, 183, 87, 111, 77, 232, 168, 176, 156
        ),
        42 => array(
            0, 225, 38, 225, 148, 192, 254, 141, 11, 82, 237,
            81, 24, 13, 122, 0, 106, 167, 13, 207, 160, 88,
            203, 38, 142, 84, 66, 3, 168, 102, 156, 1, 200,
            88, 60, 233, 134, 115, 114, 234, 90, 65, 138
        ),
        48 => array(
            0, 114, 69, 122, 30, 94, 11, 66, 230, 132, 73, 145, 137,
            135, 79, 214, 33, 12, 220, 142, 213, 136, 124, 215, 166,
            9, 222, 28, 154, 132, 4, 100, 170, 145, 59, 164, 215, 17,
            249, 102, 249, 134, 128, 5, 245, 131, 127, 221, 156
        ),
        56 => array(
            0, 29, 179, 99, 149, 159, 72, 125, 22, 55, 60, 217,
            176, 156, 90, 43, 80, 251, 235, 128, 169, 254, 134,
            249, 42, 121, 118, 72, 128, 129, 232, 37, 15, 24, 221,
            143, 115, 131, 40, 113, 254, 19, 123, 246, 68, 166,
            66, 118, 142, 47, 51, 195, 242, 249, 131, 38, 66
        ),
        62 => array(
            0, 182, 133, 162, 126, 236, 58, 172, 163, 53, 121, 159, 2,
            166, 137, 234, 158, 195, 164, 77, 228, 226, 145, 91, 180,
            232, 23, 241, 132, 135, 206, 184, 14, 6, 66, 238, 83, 100,
            111, 85, 202, 91, 156, 68, 218, 57, 83, 222, 188, 25, 179,
            144, 169, 164, 82, 154, 103, 89, 42, 141, 175, 32, 168
        ),
        68 => array(
            0, 33, 79, 190, 245, 91, 221, 233, 25, 24, 6, 144,
            151, 121, 186, 140, 127, 45, 153, 250, 183, 70, 131,
            198, 17, 89, 245, 121, 51, 140, 252, 203, 82, 83, 233,
            152, 220, 155, 18, 230, 210, 94, 32, 200, 197, 192,
            194, 202, 129, 10, 237, 198, 94, 176, 36, 40, 139,
            201, 132, 219, 34, 56, 113, 52, 20, 34, 247, 15, 51
        ),
    );

    private $dmtx_log = array(
        0, 0, 1, 240, 2, 225, 241, 53,
        3, 38, 226, 133, 242, 43, 54, 210,
        4, 195, 39, 114, 227, 106, 134, 28,
        243, 140, 44, 23, 55, 118, 211, 234,
        5, 219, 196, 96, 40, 222, 115, 103,
        228, 78, 107, 125, 135, 8, 29, 162,
        244, 186, 141, 180, 45, 99, 24, 49,
        56, 13, 119, 153, 212, 199, 235, 91,
        6, 76, 220, 217, 197, 11, 97, 184,
        41, 36, 223, 253, 116, 138, 104, 193,
        229, 86, 79, 171, 108, 165, 126, 145,
        136, 34, 9, 74, 30, 32, 163, 84,
        245, 173, 187, 204, 142, 81, 181, 190,
        46, 88, 100, 159, 25, 231, 50, 207,
        57, 147, 14, 67, 120, 128, 154, 248,
        213, 167, 200, 63, 236, 110, 92, 176,
        7, 161, 77, 124, 221, 102, 218, 95,
        198, 90, 12, 152, 98, 48, 185, 179,
        42, 209, 37, 132, 224, 52, 254, 239,
        117, 233, 139, 22, 105, 27, 194, 113,
        230, 206, 87, 158, 80, 189, 172, 203,
        109, 175, 166, 62, 127, 247, 146, 66,
        137, 192, 35, 252, 10, 183, 75, 216,
        31, 83, 33, 73, 164, 144, 85, 170,
        246, 65, 174, 61, 188, 202, 205, 157,
        143, 169, 82, 72, 182, 215, 191, 251,
        47, 178, 89, 151, 101, 94, 160, 123,
        26, 112, 232, 21, 51, 238, 208, 131,
        58, 69, 148, 18, 15, 16, 68, 17,
        121, 149, 129, 19, 155, 59, 249, 70,
        214, 250, 168, 71, 201, 156, 64, 60,
        237, 130, 111, 20, 93, 122, 177, 150,
    );

    private $dmtx_exp = array(
        1, 2, 4, 8, 16, 32, 64, 128,
        45, 90, 180, 69, 138, 57, 114, 228,
        229, 231, 227, 235, 251, 219, 155, 27,
        54, 108, 216, 157, 23, 46, 92, 184,
        93, 186, 89, 178, 73, 146, 9, 18,
        36, 72, 144, 13, 26, 52, 104, 208,
        141, 55, 110, 220, 149, 7, 14, 28,
        56, 112, 224, 237, 247, 195, 171, 123,
        246, 193, 175, 115, 230, 225, 239, 243,
        203, 187, 91, 182, 65, 130, 41, 82,
        164, 101, 202, 185, 95, 190, 81, 162,
        105, 210, 137, 63, 126, 252, 213, 135,
        35, 70, 140, 53, 106, 212, 133, 39,
        78, 156, 21, 42, 84, 168, 125, 250,
        217, 159, 19, 38, 76, 152, 29, 58,
        116, 232, 253, 215, 131, 43, 86, 172,
        117, 234, 249, 223, 147, 11, 22, 44,
        88, 176, 77, 154, 25, 50, 100, 200,
        189, 87, 174, 113, 226, 233, 255, 211,
        139, 59, 118, 236, 245, 199, 163, 107,
        214, 129, 47, 94, 188, 85, 170, 121,
        242, 201, 191, 83, 166, 97, 194, 169,
        127, 254, 209, 143, 51, 102, 204, 181,
        71, 142, 49, 98, 196, 165, 103, 206,
        177, 79, 158, 17, 34, 68, 136, 61,
        122, 244, 197, 167, 99, 198, 161, 111,
        222, 145, 15, 30, 60, 120, 240, 205,
        183, 67, 134, 33, 66, 132, 37, 74,
        148, 5, 10, 20, 40, 80, 160, 109,
        218, 153, 31, 62, 124, 248, 221, 151,
        3, 6, 12, 24, 48, 96, 192, 173,
        119, 238, 241, 207, 179, 75, 150, 1,
    );


    public function getSvgData($size, $dataMatrix = [], $labels = [], $borderColor = 'black')
    {

        $width = (isset($size['w']) ? (int) $size['w'] : 10);
        $height = (isset($size['h']) ? (int) $size['h'] : 10);
        $svg = '<?xml version="1.0"?>';
        $svg .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1"';
        $svg .= ' width="'.$width.'" height="'.$height.'"';
        $svg .= ' viewBox="0 0 '.$width.' '.$height.'"><g>';
        $svg .= '<rect x="0" y="0"';
        $svg .= ' width="'.$width.'" height="'.$height.'"';
        $svg .= ' stroke="'.$borderColor.'" stroke-width="2"';
        $svg .= ' fill="white"/>';
        if (count($labels) > 0) {
            foreach ($labels as $label) {
                if (isset($label['text'])) {
                    $text = $label['text'];
                    unset($label['text']);
                    $svg .= '<text ';
                    foreach ($label as $key => $value) {
                        $svg .= ' '.$key.'="'.$value.'"';
                    }
                    $svg .= '>'.$text.'</text>';
                }
            }

        }
        if(isset($dataMatrix['svg'])){
            $x = isset($dataMatrix['x']) ? $dataMatrix['x'] : 10;
            $y = isset($dataMatrix['y']) ? $dataMatrix['y'] : 10;
            $scale = isset($dataMatrix['scale']) ? $dataMatrix['scale'] : 4;
            $tx = 'translate('.$x.' '.$y.')';
            $tx .= ' scale('.$scale.' '.$scale.')';
            $svg .= '<g transform="'.htmlspecialchars($tx).'">';
            $svg .= $dataMatrix['svg'].'</g>';
        }
        $svg .= '</g></svg>';
        return $svg;
    }

    public function createDataMatrix($data, $options = [])
    {
        list($code, $widths, $x, $y, $w, $h) =
            $this->encode_and_calculate_size($data);
        $colors = array(
            (isset($options['cs']) ? $options['cs'] : ''),
            (isset($options['cm']) ? $options['cm'] : 'black'),
            (isset($options['c2']) ? $options['c2'] : '#FF0000'),
            (isset($options['c3']) ? $options['c3'] : '#FFFF00'),
            (isset($options['c4']) ? $options['c4'] : '#00FF00'),
            (isset($options['c5']) ? $options['c5'] : '#00FFFF'),
            (isset($options['c6']) ? $options['c6'] : '#0000FF'),
            (isset($options['c7']) ? $options['c7'] : '#FF00FF'),
            (isset($options['c8']) ? $options['c8'] : 'white'),
            (isset($options['c9']) ? $options['c9'] : 'black'),
        );
        return $this->gs1datamatrix_render_svg(
            $code, $x, $y, $w, $h, $colors, $widths, $options
        );
    }

    private function gs1datamatrix_render_svg(
        $code,
        $x,
        $y,
        $w,
        $h,
        $colors,
        $widths,
        $options
    ) {
        $density = (isset($options['md']) ? (float) $options['md'] : 1);
//        list($width, $height) = $this->matrix_calculate_size($code, $widths);
//        if ($width && $height) {
//            $scale = min($w / $width, $h / $height);
//            if ($scale > 1) {
//                $scale = floor($scale);
//            }
//            $x = floor($x + ($w - $width * $scale) / 2);
//            $y = floor($y + ($h - $height * $scale) / 2);
//        } else {
//            $scale = 1;
//            $x = floor($x + $w / 2);
//            $y = floor($y + $h / 2);
//        }
        $x = $code['q'][3] * $widths[0];
        $y = $code['q'][0] * $widths[0];
        $wh = $widths[1];
        return $this->matrix_render_svg_dots($code, $colors, $x, $y, $wh, $density);
    }


    public function matrix_render_svg_dots($code, $colors, $x, $y, $wh, $density)
    {
        $dots = '';
        foreach ($code['b'] as $by => $row) {
            $y1 = $y + $by * $wh;
            foreach ($row as $bx => $color) {
                $x1 = $x + $bx * $wh;
                $mc = $colors[$color];
                if ($mc) {
                    $dots .= $this->matrix_dot_svg(
                        $x1, $y1, $wh, $wh, $mc, $density
                    );
                }
            }
        }
        return $dots;
    }

    private function matrix_dot_svg($x, $y, $w, $h, $mc, $md)
    {
        $x += (1 - $md) * $w / 2;
        $y += (1 - $md) * $h / 2;
        $w *= $md;
        $h *= $md;
        $svg = '<rect x="'.$x.'" y="'.$y.'"';
        $svg .= ' width="'.$w.'" height="'.$h.'"';
        $svg .= ' fill="'.$mc.'"/>';
        return $svg;
    }

    private function encode_and_calculate_size($data)
    {
        $code = $this->encode($data);
        $widths = array(
            (isset($options['wq']) ? (int) $options['wq'] : 1),
            (isset($options['wm']) ? (int) $options['wm'] : 1),
            (isset($options['ww']) ? (int) $options['ww'] : 3),
            (isset($options['wn']) ? (int) $options['wn'] : 1),
            (isset($options['w4']) ? (int) $options['w4'] : 1),
            (isset($options['w5']) ? (int) $options['w5'] : 1),
            (isset($options['w6']) ? (int) $options['w6'] : 1),
            (isset($options['w7']) ? (int) $options['w7'] : 1),
            (isset($options['w8']) ? (int) $options['w8'] : 1),
            (isset($options['w9']) ? (int) $options['w9'] : 1),
        );
        $size = $this->dispatch_calculate_size($code, $widths);
        $dscale = ($code && isset($code['g']) && $code['g'] == 'm') ? 4 : 1;
        $scale = (isset($options['sf']) ? (float) $options['sf'] : $dscale);
        $scalex = (isset($options['sx']) ? (float) $options['sx'] : $scale);
        $scaley = (isset($options['sy']) ? (float) $options['sy'] : $scale);
        $dpadding = ($code && isset($code['g']) && $code['g'] == 'm') ? 0 : 10;
        $padding = (isset($options['p']) ? (int) $options['p'] : $dpadding);
        $vert = (isset($options['pv']) ? (int) $options['pv'] : $padding);
        $horiz = (isset($options['ph']) ? (int) $options['ph'] : $padding);
        $top = (isset($options['pt']) ? (int) $options['pt'] : $vert);
        $left = (isset($options['pl']) ? (int) $options['pl'] : $horiz);
        $right = (isset($options['pr']) ? (int) $options['pr'] : $horiz);
        $bottom = (isset($options['pb']) ? (int) $options['pb'] : $vert);
        $dwidth = ceil($size[0] * $scalex) + $left + $right;
        $dheight = ceil($size[1] * $scaley) + $top + $bottom;
        $iwidth = (isset($options['w']) ? (int) $options['w'] : $dwidth);
        $iheight = (isset($options['h']) ? (int) $options['h'] : $dheight);
        $swidth = $iwidth - $left - $right;
        $sheight = $iheight - $top - $bottom;
        return array(
            $code, $widths,
            $left, $top, $swidth, $sheight
        );
    }

    private function encode_data($data)
    {
        /* Convert to data codewords. */
        $edata = array(232);
        $length = strlen($data);
        $offset = 0;
        while ($offset < $length) {
            $ch1 = ord(substr($data, $offset, 1));
            $offset++;
            if ($ch1 >= 0x30 && $ch1 <= 0x39) {
                $ch2 = ord(substr($data, $offset, 1));
                if ($ch2 >= 0x30 && $ch2 <= 0x39) {
                    $offset++;
                    $edata[] = (($ch1 - 0x30) * 10) + ($ch2 - 0x30) + 130;
                } else {
                    $edata[] = $ch1 + 1;
                }
            } else {
                if ($ch1 < 0x80) {
                    $edata[] = $ch1 + 1;
                } else {
                    $edata[] = 235;
                    $edata[] = ($ch1 - 0x80) + 1;
                }
            }
        }
        /* Add padding. */
        $length = count($edata);
        $ec_params = $this->detect_version($length);
        if ($length > $ec_params[0]) {
            $length = $ec_params[0];
            $edata = array_slice($edata, 0, $length);
            if ($edata[$length - 1] == 235) {
                $edata[$length - 1] = 129;
            }
        } else {
            if ($length < $ec_params[0]) {
                $length++;
                $edata[] = 129;
                while ($length < $ec_params[0]) {
                    $length++;
                    $r = (($length * 149) % 253) + 1;
                    $edata[] = ($r + 129) % 254;
                }
            }
        }
        /* Return. */
        return array($edata, $ec_params);
    }

    private function detect_version($length)
    {
        for ($i = 0, $j = 24; $i < $j; $i++) {
            if ($length <= $this->dmtx_ec_params[$i][0]) {
                return $this->dmtx_ec_params[$i];
            }
        }
        return $this->dmtx_ec_params[$j - 1];
    }

    private function encode_ec($data, $ec_params)
    {
        $blocks = $this->ec_split($data, $ec_params);
        for ($i = 0, $n = count($blocks); $i < $n; $i++) {
            $ec_block = $this->ec_divide($blocks[$i], $ec_params);
            $blocks[$i] = array_merge($blocks[$i], $ec_block);
        }
        return $this->ec_interleave($blocks);
    }

    private function ec_split($data, $ec_params)
    {
        $blocks = array();
        $num_blocks = $ec_params[2] + $ec_params[4];
        for ($i = 0; $i < $num_blocks; $i++) {
            $blocks[$i] = array();
        }
        for ($i = 0, $length = count($data); $i < $length; $i++) {
            $blocks[$i % $num_blocks][] = $data[$i];
        }
        return $blocks;
    }

    private function ec_divide($data, $ec_params)
    {
        $num_data = count($data);
        $num_error = $ec_params[1];
        $generator = $this->dmtx_ec_polynomials[$num_error];
        $message = $data;
        for ($i = 0; $i < $num_error; $i++) {
            $message[] = 0;
        }
        for ($i = 0; $i < $num_data; $i++) {
            if ($message[$i]) {
                $leadterm = $this->dmtx_log[$message[$i]];
                for ($j = 0; $j <= $num_error; $j++) {
                    $term = ($generator[$j] + $leadterm) % 255;
                    $message[$i + $j] ^= $this->dmtx_exp[$term];
                }
            }
        }
        return array_slice($message, $num_data, $num_error);
    }

    private function ec_interleave($blocks)
    {
        $data = array();
        $num_blocks = count($blocks);
        for ($offset = 0; true; $offset++) {
            $break = true;
            for ($i = 0; $i < $num_blocks; $i++) {
                if (isset($blocks[$i][$offset])) {
                    $data[] = $blocks[$i][$offset];
                    $break = false;
                }
            }
            if ($break) {
                break;
            }
        }
        return $data;
    }

    private function create_matrix($ec_params, $data)
    {
        /* Create matrix. */
        $rheight = $ec_params[8] + 2;
        $rwidth = $ec_params[9] + 2;
        $height = $ec_params[6] * $rheight;
        $width = $ec_params[7] * $rwidth;
        $bitmap = array();
        for ($y = 0; $y < $height; $y++) {
            $row = array();
            for ($x = 0; $x < $width; $x++) {
                $row[] = ((
                    ((($x + $y) % 2) == 0) ||
                    (($x % $rwidth) == 0) ||
                    (($y % $rheight) == ($rheight - 1))
                ) ? 1 : 0);
            }
            $bitmap[] = $row;
        }
        /* Create data region. */
        $rows = $ec_params[6] * $ec_params[8];
        $cols = $ec_params[7] * $ec_params[9];
        $matrix = array();
        for ($y = 0; $y < $rows; $y++) {
            $row = array();
            for ($x = 0; $x < $width; $x++) {
                $row[] = null;
            }
            $matrix[] = $row;
        }
        $this->place_data($matrix, $rows, $cols, $data);
        /* Copy into matrix. */
        for ($yy = 0; $yy < $ec_params[6]; $yy++) {
            for ($xx = 0; $xx < $ec_params[7]; $xx++) {
                for ($y = 0; $y < $ec_params[8]; $y++) {
                    for ($x = 0; $x < $ec_params[9]; $x++) {
                        $row = $yy * $ec_params[8] + $y;
                        $col = $xx * $ec_params[9] + $x;
                        $b = $matrix[$row][$col];
                        if (is_null($b)) {
                            continue;
                        }
                        $row = $yy * $rheight + $y + 1;
                        $col = $xx * $rwidth + $x + 1;
                        $bitmap[$row][$col] = $b;
                    }
                }
            }
        }
        /* Return matrix. */
        return array($height, $width, $bitmap);
    }

    private function place_data(&$mtx, $rows, $cols, $data)
    {
        $row = 4;
        $col = 0;
        $offset = 0;
        $length = count($data);
        while (($row < $rows || $col < $cols) && $offset < $length) {
            /* Corner cases. Literally. */
            if ($row == $rows && $col == 0) {
                $this->place_1($mtx, $rows, $cols, $data[$offset++]);
            } else {
                if ($row == $rows - 2 && $col == 0 && $cols % 4 != 0) {
                    $this->place_2($mtx, $rows, $cols, $data[$offset++]);
                } else {
                    if ($row == $rows - 2 && $col == 0 && $cols % 8 == 4) {
                        $this->place_3($mtx, $rows, $cols, $data[$offset++]);
                    } else {
                        if ($row == $rows + 4 && $col == 2 && $cols % 8 == 0) {
                            $this->place_4($mtx, $rows, $cols, $data[$offset++]);
                        }
                    }
                }
            }
            /* Up and to the right. */
            while ($row >= 0 && $col < $cols && $offset < $length) {
                if ($row < $rows && $col >= 0 && is_null($mtx[$row][$col])) {
                    $b = $data[$offset++];
                    $this->place_0($mtx, $rows, $cols, $row, $col, $b);
                }
                $row -= 2;
                $col += 2;
            }
            $row += 1;
            $col += 3;
            /* Down and to the left. */
            while ($row < $rows && $col >= 0 && $offset < $length) {
                if ($row >= 0 && $col < $cols && is_null($mtx[$row][$col])) {
                    $b = $data[$offset++];
                    $this->place_0($mtx, $rows, $cols, $row, $col, $b);
                }
                $row += 2;
                $col -= 2;
            }
            $row += 3;
            $col += 1;
        }
    }

    private function place_0(&$matrix, $rows, $cols, $row, $col, $b)
    {
        $this->place_b($matrix, $rows, $cols, $row - 2, $col - 2, $b & 0x80);
        $this->place_b($matrix, $rows, $cols, $row - 2, $col - 1, $b & 0x40);
        $this->place_b($matrix, $rows, $cols, $row - 1, $col - 2, $b & 0x20);
        $this->place_b($matrix, $rows, $cols, $row - 1, $col - 1, $b & 0x10);
        $this->place_b($matrix, $rows, $cols, $row - 1, $col - 0, $b & 0x08);
        $this->place_b($matrix, $rows, $cols, $row - 0, $col - 2, $b & 0x04);
        $this->place_b($matrix, $rows, $cols, $row - 0, $col - 1, $b & 0x02);
        $this->place_b($matrix, $rows, $cols, $row - 0, $col - 0, $b & 0x01);
    }

    private function place_1(&$matrix, $rows, $cols, $b)
    {
        $matrix[$rows - 1][0] = (($b & 0x80) ? 1 : 0);
        $matrix[$rows - 1][1] = (($b & 0x40) ? 1 : 0);
        $matrix[$rows - 1][2] = (($b & 0x20) ? 1 : 0);
        $matrix[0][$cols - 2] = (($b & 0x10) ? 1 : 0);
        $matrix[0][$cols - 1] = (($b & 0x08) ? 1 : 0);
        $matrix[1][$cols - 1] = (($b & 0x04) ? 1 : 0);
        $matrix[2][$cols - 1] = (($b & 0x02) ? 1 : 0);
        $matrix[3][$cols - 1] = (($b & 0x01) ? 1 : 0);
    }

    private function place_2(&$matrix, $rows, $cols, $b)
    {
        $matrix[$rows - 3][0] = (($b & 0x80) ? 1 : 0);
        $matrix[$rows - 2][0] = (($b & 0x40) ? 1 : 0);
        $matrix[$rows - 1][0] = (($b & 0x20) ? 1 : 0);
        $matrix[0][$cols - 4] = (($b & 0x10) ? 1 : 0);
        $matrix[0][$cols - 3] = (($b & 0x08) ? 1 : 0);
        $matrix[0][$cols - 2] = (($b & 0x04) ? 1 : 0);
        $matrix[0][$cols - 1] = (($b & 0x02) ? 1 : 0);
        $matrix[1][$cols - 1] = (($b & 0x01) ? 1 : 0);
    }

    private function place_3(&$matrix, $rows, $cols, $b)
    {
        $matrix[$rows - 3][0] = (($b & 0x80) ? 1 : 0);
        $matrix[$rows - 2][0] = (($b & 0x40) ? 1 : 0);
        $matrix[$rows - 1][0] = (($b & 0x20) ? 1 : 0);
        $matrix[0][$cols - 2] = (($b & 0x10) ? 1 : 0);
        $matrix[0][$cols - 1] = (($b & 0x08) ? 1 : 0);
        $matrix[1][$cols - 1] = (($b & 0x04) ? 1 : 0);
        $matrix[2][$cols - 1] = (($b & 0x02) ? 1 : 0);
        $matrix[3][$cols - 1] = (($b & 0x01) ? 1 : 0);
    }

    private function place_4(&$matrix, $rows, $cols, $b)
    {
        $matrix[$rows - 1][0] = (($b & 0x80) ? 1 : 0);
        $matrix[$rows - 1][$cols - 1] = (($b & 0x40) ? 1 : 0);
        $matrix[0][$cols - 3] = (($b & 0x20) ? 1 : 0);
        $matrix[0][$cols - 2] = (($b & 0x10) ? 1 : 0);
        $matrix[0][$cols - 1] = (($b & 0x08) ? 1 : 0);
        $matrix[1][$cols - 3] = (($b & 0x04) ? 1 : 0);
        $matrix[1][$cols - 2] = (($b & 0x02) ? 1 : 0);
        $matrix[1][$cols - 1] = (($b & 0x01) ? 1 : 0);
    }


    private function place_b(&$matrix, $rows, $cols, $row, $col, $b)
    {
        if ($row < 0) {
            $row += $rows;
            $col += (4 - (($rows + 4) % 8));
        }
        if ($col < 0) {
            $col += $cols;
            $row += (4 - (($cols + 4) % 8));
        }
        $matrix[$row][$col] = ($b ? 1 : 0);
    }

    private function encode($data)
    {
        list($data, $ec) = $this->encode_data($data);
        $data = $this->encode_ec($data, $ec);
        list($h, $w, $mtx) = $this->create_matrix($ec, $data);
        return array(
            'g' => 'm',
            'q' => array(1, 1, 1, 1),
            's' => array($w, $h),
            'b' => $mtx
        );
    }

    private function dispatch_calculate_size($code, $widths)
    {
        if ($code && isset($code['g']) && $code['g']) {
            return $this->matrix_calculate_size($code, $widths);
        }
        return array(0, 0);
    }

    private function matrix_calculate_size($code, $widths)
    {
        $width = (
            $code['q'][3] * $widths[0] +
            $code['s'][0] * $widths[1] +
            $code['q'][1] * $widths[0]
        );
        $height = (
            $code['q'][0] * $widths[0] +
            $code['s'][1] * $widths[1] +
            $code['q'][2] * $widths[0]
        );
        return array($width, $height);
    }

}
