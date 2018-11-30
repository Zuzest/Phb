<?php

class F extends ComponentBase
{
  /*public function __construct()
  {
  $di                = $this->getDi();
  $this->siteVersion = $di->getSession()->get('siteVersion');

  return $this;
  vdump($siteVersion);exit;
  }*/
  /*public static function dispatch() {
    // $action = $this->getActionName();
    vdump(__METHOD__, \DI::Request()->getQuery());
    // vdump(__METHOD__, $action, \DI::Request()->getQuery());
  }*/
/**
 * @param  boolean
 * @param  integer
 * @param  boolean
 * @param  integer
 * @param  integer bit0 = отправлять на первую или на ппоследнюю страницу: bit1 = отображать до текущей страницы то, что не влезло после
 * @return array
 */
  public static function pagina(
    $n = false,
    $fpp = 20,
    $cp = false,
    $x = 4,
    $r = 3
  ) {
    if (is_array($n)) {
      $r   = isset($n[4]) ? $n[4] : $r;    // страниц до и страниц после
      $x   = isset($n[3]) ? $n[3] : $x;    // страниц до и страниц после
      $cp  = isset($n[2]) ? $n[2] : $cp;   //      current_page
      $fpp = isset($n[1]) ? $n[1] : $fpp;  // элементов на страницу
      $n   = isset($n[0]) ? $n[0] : false; //      количество элементов

      // отображать ли спереди то, что не влезло после

    } elseif (!$fpp || !$cp) {
      return false;
    }

    if (!$n || $n <= 0) {
      return false;
    }

    $p               = $n / $fpp;
    $pages           = ($p - (int) $p) ? (int) $p + 1 : (int) $p; //       общее количество страниц (округляем до целого вверх)
    $pagina['pages'] = $pages;

    if ($cp > $pages) {
      if (($r & 1) === 1) {
        $cp = $pages;
      } else {
        $cp = 1;
      }
    }

    $pagina['limit']    = [(($cp - 1) * $fpp), $fpp];
    $pagina['limitStr'] = implode(',', $pagina['limit']);
    // $pagina['current'] = ($pages === 1) ? 1 : $cp;

    $pp = $ps = $pn = $pe = false;

    if (1 === $pages) {
      return $pagina;
    }

    $px  = $x * 2 + 1;                        // сколько страниц хотим отобразить
    $ppx = ($pages - $px > 0) ? $px : $pages; // сколько страниц можем отобразить

    $xp = ($cp - $x <= 0) ? $x + ($cp - $x) - 1 : $x;
    $xn = ($cp + $x <= $pages) ? $x : $pages - $cp;

    if (($r & 2) === 2) {
      // ЕСЛИ МАГИЧЕСКИЙ МАТЬ ЕГО ВТОРОЙ БИТ
      $xp = ($xn < $x) ? $ppx - $xn - 1 : $xp;
      $xn = ($xp < $x) ? $ppx - $xp - 1 : $xn;
    }

    if (0 !== $xp) {
      for ($i = $cp - $xp; $i < $cp; $i++) {
        $pp[] = $i;
      }
    }
    if (0 !== $xn) {
      for ($i = $cp; $i < $cp + $xn; $i++) {
        $pn[] = $i + 1;
      }
    }
    if ($pp && $pp[0] > 1) {
      $ps = 1;
      if ($pp[0] > 2) {
        array_unshift($pp, '...');
      }

    }
    $pagina['start'] = $ps;
    $pagina['prev']  = $pp;
    if ($pn && $pn[count($pn) - 1] < $pages) {
      $pe = $pages;
      if ($pn[count($pn) - 1] < $pages - 1) {
        array_push($pn, '...');
      }

    }
    $pagina['current'] = $cp;
    $pagina['next']    = $pn;
    $pagina['end']     = $pe;

    return $pagina;
  }

  public static function transliterate($string)
  {

    /*
      в нашем случае массив будет выполнять роль базы аналогий русских букв с латиницей
      где ключ элемента это буква на русском, а значение - ее эквивалент на английском
      */
    // echo "string";
    // $letters = array();
    $letters = [
      'А' => 'A', 'Б'  => 'B', 'В'   => 'V', 'Г'  => 'G', 'Д' => 'D',
      'Е' => 'E', 'Ё'  => 'YO', 'Ж'  => 'ZH', 'З' => 'Z', 'И' => 'I',
      'Й' => 'J', 'К'  => 'K', 'Л'   => 'L', 'М'  => 'M', 'Н' => 'N',
      'О' => 'O', 'П'  => 'P', 'Р'   => 'R', 'С'  => 'S', 'Т' => 'T',
      'У' => 'U', 'Ф'  => 'F', 'Х'   => 'H', 'Ц'  => 'C', 'Ч' => 'CH',
      'Ш' => 'SH', 'Щ' => 'CSH', 'Ь' => '', 'Ы'   => 'Y', 'Ъ' => '',
      'Э' => 'E', 'Ю'  => 'YU', 'Я'  => 'YA',
      'а' => 'a', 'б'  => 'b', 'в'   => 'v', 'г'  => 'g', 'д' => 'd',
      'е' => 'e', 'ё'  => 'yo', 'ж'  => 'zh', 'з' => 'z', 'и' => 'i',
      'й' => 'j', 'к'  => 'k', 'л'   => 'l', 'м'  => 'm', 'н' => 'n',
      'о' => 'o', 'п'  => 'p', 'р'   => 'r', 'с'  => 's', 'т' => 't',
      'у' => 'u', 'ф'  => 'f', 'х'   => 'h', 'ц'  => 'c', 'ч' => 'ch',
      'ш' => 'sh', 'щ' => 'csh', 'ь' => '', 'ы'   => 'y', 'ъ' => '',
      'э' => 'e', 'ю'  => 'yu', 'я'  => 'ya', /* ' ' => '-', '"' => '',
    '/' => '', '«' => '', '»' => '', */
    ];
    /*
      Далее наша функция будет возвращать строку,
      полученную в результате перестановки.

      То бишь, функция str_replace, находит в переменной $string буквы
      по ключам массива $letters, и заменяет эквивалентными им значениями.
      */

    return str_replace(array_keys($letters), array_values($letters), $string);
  }

  public static function makelink($str, $options = [])
  {

    // https://gist.github.com/sgmurphy/3098978

    // Make sure string is in UTF-8 and strip invalid UTF-8 characters
      $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

      $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => false,
      );

      // Merge options
      $options = array_merge($defaults, $options);

      $char_map = array(
        // Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
        'ÿ' => 'y',
        // Latin symbols
        '©' => '(c)',
        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',
        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z',
        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',
        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
      );

      // Make custom replacements
      $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

      // Transliterate characters to ASCII
      if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
      }

      // Replace non-alphanumeric characters with our delimiter
      $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

      // Remove duplicate delimiters
      $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

      // Truncate slug to max. characters
      $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

      // Remove delimiter from ends
      $str = trim($str, $options['delimiter']);

      return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
  }

  private static $breadcrumbs = false;

  public static function getBreadcrumbs()
  {
    return self::$breadcrumbs;
  }

  public static function resetBreadcrumbs() {
    self::$breadcrumbs = false;
  }
  public static function setBreadcrumbs(array $breadcrumbs = [])
  {
    if (empty($breadcrumbs)) {
      $breadcrumbs = false;
    }
    self::$breadcrumbs = [];

    self::$breadcrumbs = $breadcrumbs;
    // vdump($breadcrumbs);
  }

  public static function addBreadcrumbs($breadcrumb = false)
  {

    self::$breadcrumbs[] = $breadcrumb;
  }

  public static function switchDESC($desc)
  {
    switch ($desc) {
      case 'DESC':
        return 'ASC';
      case 'ASC':
        return false;
      default:
        return 'DESC';
    }
  }

  public static function switchASC($asc)
  {
    switch ($asc) {
      case 'ASC':
        return 'DESC';
      case 'DESC':
        return false;
      default:
        return 'ASC';
    }
  }

  public static function getHoursInterval($hours = 0) {
    $from = ($hours <= 23)? $hours: 0;

    $range = range($from, 23);
    foreach($range as $from) {
      $to = sprintf("%02d", $from+1);
      $to .=':00';
      if($from >= 23) {
        $to = '23:59';
      }
      $r[] = sprintf("%02d", $from).':00 - '.$to;
    }
    return $r;
  }

  public static function curl($p = false)
  {
    if (!$p) {
      return false;
    }

    $p = (object) $p;
    // extract($p);
    // vdump($url);
    // vdump($p);exit;
    // vdump(true xor '');exit;

    // инициируем url
    $ch = curl_init($p->url);

    $options = [
      // Количество секунд ожидания при попытке соединения. Используйте 0 для бесконечного ожидания.
      CURLOPT_CONNECTTIMEOUT => 10,
      // TRUE для включения заголовков в вывод.
      // CURLOPT_HEADER => false,

      // TRUE для исключения тела ответа из вывода. Метод запроса устанавливается в HEAD. Смена этого параметра в FALSE не меняет его обратно в GET.
      // CURLOPT_NOBODY => false,

      // Максимальное количество принимаемых редиректов. Используйте этот параметр вместе с параметром CURLOPT_FOLLOWLOCATION.
      CURLOPT_MAXREDIRS      => 10,
      // TRUE для следования любому заголовку "Location: ", отправленному сервером в своем ответе (учтите, что это происходит рекурсивно, PHP будет следовать за всеми посылаемыми заголовками "Location: ", за исключением случая, когда установлена константа CURLOPT_MAXREDIRS).
      CURLOPT_FOLLOWLOCATION => true,
      // TRUE для возврата результата передачи в качестве строки из curl_exec() вместо прямого вывода в браузер.
      CURLOPT_RETURNTRANSFER => true,
    ];

    if ($post = $p->post ?? false) {
        $options[CURLOPT_POST] = true;
        $options[CURLOPT_POSTFIELDS]  = http_build_query($post);
    }

    $fp = isset($p->file) ? $p->file : false;
    // Файл, в который будет записан результат передачи. По умолчанию используется поток вывода STDOUT (окно браузера).
    if ($fp) {
      $options[CURLOPT_FILE] = $fp;
    }

    if(isset($p->options)) {
      foreach($p->options as $key => $val) {
        $options[$key] = $val;
      }
    }
    // vdump($p, $options);
    /*if(isset($p->path)) {
    $fp = fopen($p->path,'w');
    // Файл, в который будет записан результат передачи. По умолчанию используется поток вывода STDOUT (окно браузера).
    $options[CURLOPT_FILE] = $fp;
    }*/

    curl_setopt_array($ch, $options);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    // curl_setopt($ch, CURLOPT_URL, $url2);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
    // curl_setopt($ch, CURLOPT_COOKIESESSION, true);

    /*curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10);
    curl_setopt($ch, CURLOPT_HEADER,false);
    curl_setopt($ch, CURLOPT_NOBODY,false);
    curl_setopt($ch, CURLOPT_MAXREDIRS,10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);*/

    /*$header = curl_getinfo($ch);
    vdump($header);*/
    $result = curl_exec($ch);
    $error  = curl_error($ch);
    // vdump($result, $error, $ch);exit;
    curl_close($ch);
    // if(isset($p->path)) fclose($fp);

    return [$result, $error];
  }
}
