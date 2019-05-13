<?php
@session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Expires: " . date("r"));

$ad_mail =  'zdorovoemenu@openschool.ru';

function getRealIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$error = array();

if ($_POST['capcha_3_' . $_SESSION['capha_3_nn']] == $_SESSION['capha_3']) {
    
    if(isset($_POST['send']) && $_POST['send'] == 'contacts') {
        
        $error_message = array();
        
        if(empty($_POST['name'])) {
            $error_message['name'] = 'Укажите имя';
        }
        if(empty($_POST['email'])) {
            $error_message['email'] = 'Укажите E-mail';
        } else if(! preg_match('/[^@]+@[^@]+\.[^$]{2,4}/', $_POST['email'])) {
            $error_message['email'] = 'E-mail Указан не корректно';
        }
       
        if(! empty($error_message)) {
            $error['error'] = 1;
            $error['fields'] = $error_message;
            echo json_encode($error);
            exit;
        }
        
        $adress = $ad_mail;
        
        $subject_v_kodirovke_koi8_r = 'Форма c сайта';
        if (isset($_POST['title'])) {
            $subject_v_kodirovke_koi8_r = $_POST['title'];
        }
        $sub = '=?UTF-8?B?' . base64_encode($subject_v_kodirovke_koi8_r) . '?=';

        $mes = "\n Форма c сайта " . $_SERVER['HTTP_HOST'];

        if (isset($_POST['name'])) {
            $mes .= "\n От: " . $_POST['name'];
        }
        
        if (isset($_POST['email'])) {
            $mes .= "\n E-mail: " . $_POST['email'];
        }
        
        if (isset($_POST['message'])) {
            $mes .= "\n Текст: " . $_POST['message'];
        }
        
        
        $mes .= " \n ip пользователя: " . getRealIpAddr();


        $addr_a = explode(',', $ad_mail);
        if(! empty($addr_a)) {
            foreach($addr_a as $k => $v) {
                $t_addr = trim($v);
                
                $xnumer = explode(".", $_SERVER['HTTP_HOST']);
                $ser_name = $xnumer[count($xnumer) - 2] . "." . $xnumer[count($xnumer) - 1];
                $verify = mail($t_addr, $sub, $mes, "Content-type:text/plain; charset = utf-8\r\nFrom:info@" . $ser_name);
            }
        }
        
        $error['error'] = 0;
        $error['message'] = '<span class"form_tex"><img src="../img/combined-shape.svg" alt=".." class="ico_thks">Спасибо!<br>Ваше сообщение принято.<br>В ближайшее время с Вами свяжется наш специалист.</span>';
        echo json_encode($error);
        exit();
        
    }

    if(isset($_POST['send']) && $_POST['send'] == 'send_to_engagement') {
        $error_message = array();


        if(empty($_POST['name'])) {
            $error_message['name'] = 'Укажите имя';
        }

        if(empty($_POST['email'])) {
            $error_message['email'] = 'Укажите E-mail';
        } else if(! preg_match('/[^@]+@[^@]+\.[^$]{2,4}/', $_POST['email'])) {
            $error_message['email'] = 'E-mail Указан не корректно';
        }

        if (empty($_POST['city'])) {
            $error_message['city'] = 'Укажите город';
        }

        if (empty($_POST['number_school'])) {
            $error_message['number_school'] = 'Укажите школу';
        }

        if (empty($_POST['status'])) {
            $error_message['status'] = 'Укажите статус';
        }


        if(! empty($error_message)) {
            $error['error'] = 1;
            $error['fields'] = $error_message;
            echo json_encode($error);
            exit;
        }

        $adress = $ad_mail;

        $subject_v_kodirovke_koi8_r = 'Форма c сайта';
        if (isset($_POST['title'])) {
            $subject_v_kodirovke_koi8_r = $_POST['title'];
        }
        $sub = '=?UTF-8?B?' . base64_encode($subject_v_kodirovke_koi8_r) . '?=';

        $mes = "\n Форма c сайта " . $_SERVER['HTTP_HOST'];
        $mes .= "\n Принять учание ";

        if (isset($_POST['name'])) {
            $mes .= "\n От: " . $_POST['name'];
        }

        if (isset($_POST['city'])) {
            $mes .= "\n Город: " . $_POST['city'];
        }

        if (isset($_POST['number_school'])) {
            $mes .= "\n Номер школы: " . $_POST['number_school'];
        }

        if (isset($_POST['email'])) {
            $mes .= "\n E-mail: " . $_POST['email'];
        }

        if (isset($_POST['status'])) {
            $mes .= "\n Статус: " . $_POST['status'];
        }




        $mes .= " \n ip пользователя: " . getRealIpAddr();


        $addr_a = explode(',', $ad_mail);
        if(! empty($addr_a)) {
            foreach($addr_a as $k => $v) {
                $t_addr = trim($v);

                $xnumer = explode(".", $_SERVER['HTTP_HOST']);
                $ser_name = $xnumer[count($xnumer) - 2] . "." . $xnumer[count($xnumer) - 1];
                $verify = mail($t_addr, $sub, $mes, "Content-type:text/plain; charset = utf-8\r\nFrom:info@" . $ser_name);
            }
        }

        $error['error'] = 0;
        $error['message'] = '<div class"form_tex"><img src="../img/combined-shape.svg" alt=".." class="ico_thks">Спасибо! Ваша заявка принята. Мы отправим вам инструкции по дальнейшим действиям на почту.<a href="/lessons.html" class="btn-new_n2 mr26" >К урокам</a></div>';
        echo json_encode($error);
        exit();
    }
    
    
}

unset($_SESSION['capha_3_nn']);
unset($_SESSION['capha_3']);
?>