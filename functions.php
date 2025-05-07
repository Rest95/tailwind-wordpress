<?php
require get_template_directory() . '/includes/nav-menu-tree.php';
require get_template_directory() . '/includes/icons.php';
require get_template_directory() . '/includes/theme-setup.php';
// require get_template_directory() . '/includes/theme-blocks.php';
// require get_template_directory() . '/blocks/register-blocks.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . "wp-config.php";
require_once ABSPATH . "wp-includes/wp-db.php";
add_filter('wpgs_show_featured_image_in_gallery', '__return_false', 20);
add_filter('woocommerce_nif_field_required', '__return_false');


add_action(
  'rest_api_init',
  function () {
    register_rest_route(
      'personalizados',
      'send-email',
      array(
        'methods' => 'POST',
        'callback' => 'sendEmailPersonalizados'
      )
    );
  }
);


function getRequestHeaders()
{
  $headers = array();
  foreach ($_SERVER as $key => $value) {
    if (substr($key, 0, 5) <> 'HTTP_') {
      continue;
    }
    $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
    $headers[$header] = $value;
  }
  return $headers;
}

function sendEmailPersonalizados($request)
{
  $accessToken = 'Bearer webaniceday';
  $auth = getRequestHeaders();
  if ($auth['Authorization']) {
    if ($auth['Authorization'] == $accessToken) {
      $data = $request->get_params();
      $headers = array('Content-Type: text/html; charset=UTF-8');
      $body = '<head>
                <link rel="preconnect" href="https://fonts.googleapis.com" />
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
                <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet" />
              </head>
              
              <!--[if mso]>
              <style type=”text/css”>
              .body-text {
              font-family: Arial, sans-serif;
              }
              </style>
              <![endif]-->
              
              
                <div style="direction: ltr">
                  <div style="direction: ltr">
                    <div style="direction: ltr; margin: 0px auto; max-width: 640px; width: 100%;">
                      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                        style="direction: ltr; width: 100%" width="100%">
                        <tbody style="direction: ltr">
                          <tr style="direction: ltr">
                            <td style="direction: ltr; font-size: 0px; padding: 0 4%; text-align: center; vertical-align: top;"
                              align="center" valign="top">
                              <div
                                style="font-size: 13px; text-align: left; direction: ltr; display: inline-block; vertical-align: top;width: 100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%"
                                  style="direction: ltr; max-width: 640px;">
                                  <tbody style="direction: ltr">
                                    <tr style="direction: ltr">
                                      <td style="direction: ltr; vertical-align: top; padding: 0" valign="top">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                          style="direction: ltr; max-width: 640px;" width="100%">
                                          <tbody>
                                            <tr style="direction: ltr">
                                              <td align="center" style="padding-top: 20px; padding-bottom: 0px;">
                                                <div style="text-align:right; width: 32px; height: 59px;">
                                                  <img height="auto"
                                                    src="https://i.imgur.com/Xr8r4Yq.png"
                                                    style="direction: ltr; border: 0; display: block; outline: none; text-decoration: none; height: auto; width: 100%;"
                                                    width="100" class="CToWUd" />
                                                </div>
                                              </td>
                                            </tr>
                                            <tr style="direction: ltr">
                                              <td align="center" style="
                                                direction: ltr;
                                                font-size: 0px;
                                                padding: 0;
                                                padding-top: 0px;
                                                padding-bottom: 0px;
                                                word-break: break-word;
                                                padding-left: 0px;
                                                padding-right: 0px;
                                              ">
                                                <div style="
                                                  width: 100%;
                                                  direction: ltr;
                                                  border-collapse: collapse;
                                                  border-spacing: 0px;
                                                  padding-left: 0px;
                                                  padding-right: 0px;
                                                ">
                                                  <div style="
                                                    width: 100%;
                                                    direction: ltr;
                                                    border-collapse: collapse;
                                                    border-spacing: 0px;
                                                    padding-left: 0px;
                                                    padding-top: 0px;
                                                    padding-bottom: 26px;
                                                    padding-right: 0px;
                                                    border-radius: 4px;
                                                  ">
                                                    <table align="start" border="0" cellpadding="0" cellspacing="0"
                                                      role="presentation" style="
                                                      direction: ltr;
                                                      border-collapse: collapse;
                                                      border-spacing: 0px;
                                                    ">
                                                      <tbody style="direction: ltr">
                                                        <tr style="direction: ltr">
                                                          <td style="direction: ltr">
                                                            <div style="
                                                              direction: ltr;
                                                              font-weight: 500;
                                                              font-family: \'Inter\', Arial,
                                                                sans-serif;
                                                              text-align: start;
                                                              color: #333333;
                                                              font-size: 18px;
                                                              font-weight: 500;
                                                              line-height: 20px;
                                                              margin-top: 0px;
                                                              padding-bottom: 16px;
                                                              text-align: center;
                                                            ">
                                                              Novo pedido de personalização.
                                                            </div>
                                                          </td>
                                                        </tr>
                                                      </tbody>
                                                    </table>
                                                  </div>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="padding-top: 26px;padding-bottom: 42px;">
                                              <div
                                              style="direction: ltr; font-weight: 400; font-family: \'Inter\', Arial, sans-serif; text-align: left; color: #000; font-size: 10px; line-height: 12px; margin-top: 0px;">
                                              Nome:
                                            </div>
                                            <div
                                              style="direction: ltr; font-weight: 400;font-family: \'Inter\', Arial, sans-serif;text-align: left;color: #111827;font-size: 16px;line-height: 28px;margin-top: 0px; padding-bottom:8px">
                                              ' . $data['nome'] . '
                                            </div>
              
                                            <div
                                              style="direction: ltr; font-weight: 400; font-family: \'Inter\', Arial, sans-serif; text-align: left; color: #000; font-size: 10px; line-height: 12px; margin-top: 0px;">
                                              Email:
                                            </div>
                                            <div
                                              style="direction: ltr; font-weight: 400;font-family: \'Inter\', Arial, sans-serif;text-align: left;color: #111827;font-size: 16px;line-height: 28px;margin-top: 0px; padding-bottom:8px">
                                              ' . $data['email'] . '
                                            </div>';
      if ($data['observacoes']) {
        $body .= ' <div
                                                style="direction: ltr; font-weight: 400; font-family: \'Inter\', Arial, sans-serif; text-align: left; color: #000; font-size: 10px; line-height: 12px; margin-top: 0px;">
                                                Observações:
                                              </div>
                                              <div
                                                style="direction: ltr; font-weight: 400;font-family: \'Inter\', Arial, sans-serif;text-align: left;color: #111827;font-size: 16px;line-height: 28px;margin-top: 0px; padding-bottom:8px">
                                                ' . $data['observacoes'] . '
                                              </div>';
      }

      $body .= '
                                              <div
                                              style="direction: ltr; font-weight: 400; font-family: \'Inter\', Arial, sans-serif; text-align: left; color: #000; font-size: 12px; line-height: 12px; margin-top: 0px;">
                                              Artigos:
                                            </div>
                                            
                                            <table style="border-collapse: separate; border-spacing: 0px 8px; padding-top:16px; overflow:auto;direction: ltr; max-width: 640px;" width="100%">
                                            <thead>
                                            <tr>
                                              <th style="text-align:left; font-family: \'Inter\', Arial, sans-serif; font-weight: 400; padding-left:8px; padding-right: 8px; font-size: 12px;">
                                                Modalidade
                                              </th>
                                              <th style="text-align:left; font-family: \'Inter\', Arial, sans-serif; font-weight: 400; padding-left:8px; padding-right: 8px; font-size: 12px;">
                                                Categoria
                                              </th>
                                              <th style="text-align:left; font-family: \'Inter\', Arial, sans-serif; font-weight: 400; padding-left:8px; padding-right: 8px; font-size: 12px;">
                                                Género
                                              </th>
                                              <th style="text-align:left; font-family: \'Inter\', Arial, sans-serif; font-weight: 400; padding-left:8px; padding-right: 8px; font-size: 12px;">
                                                Produto
                                              </th>
                                              <th style="text-align:left; font-family: \'Inter\', Arial, sans-serif; font-weight: 400; padding-left:8px; padding-right: 8px; font-size: 12px;">
                                                Quantidade
                                              </th>
                                            </tr>
                                            </thead>
          <tbody>';
      foreach ($data['items'] as $key => $item) {
        $body .= '
                        <tr>
                        <td style="background-color:#000; text-align:left; font-family: \'Inter\', Arial, sans-serif; font-weight: 400; padding:8px; font-size: 12px; color:#fff; border: 1px solid #000;  ">';
        if ($item['modalidade']) {
          $body .= $item['modalidade']['nome'];
        } else {
          $body .= '-';
        }
        $body .= '
                        </td>

                        <td style=" text-align:left; font-family: \'Inter\', Arial, sans-serif; font-weight: 700; padding:8px; font-size: 12px; color:#000; border-top: 1px solid #BFBFBF;  border-bottom: 1px solid #BFBFBF;">
                        ';
        if ($item['gama']) {
          $body .= $item['gama']['nome'];
        } else {
          $body .= '-';
        }
        $body .= '
                        </td>

                        <td style=" text-align:left; font-family: \'Inter\', Arial, sans-serif; font-weight: 400; padding:8px; font-size: 12px; color:#000; border-top: 1px solid #BFBFBF;  border-bottom: 1px solid #BFBFBF;  ">
                        ';

        if ($item['tipo']) {
          $body .= $item['tipo'];
        } else {
          $body .= '-';
        }

        $body .= '
                        </td>

                        <td style=" text-align:left; font-family: \'Inter\', Arial, sans-serif; font-weight: 400; padding:8px; font-size: 12px; color:#000; border-top: 1px solid #BFBFBF;  border-bottom: 1px solid #BFBFBF;  ">
                        ';
        if ($item['produto']) {
          $body .= $item['produto']['nome'];
        } else {
          $body .= '-';
        }
        $body .= '
                        </td>

                        <td style=" text-align:left; font-family: \'Inter\', Arial, sans-serif; font-weight: 400; padding:8px; font-size: 12px; color:#000; border-top: 1px solid #BFBFBF;  border-bottom: 1px solid #BFBFBF; border-right: 1px solid #BFBFBF;  ">
                        ';
        if ($item['produto']) {
          $body .= $item['produto']['quantidade'];
        } else {
          $body .= '-';
        }


        $body .= '
                        </td>
                        </tr>
                        ';
      }

      $body .= '</tbody>
          </table>

          </td>
        </tr>

        <tr style="direction: ltr">
          <td align="center" style="
            direction: ltr;
            font-size: 0px;
            padding: 0;
            padding-top: 10px;
            padding-bottom: 10px;
            word-break: break-word;
          ">
            <div>
              <a href="https://pacto.cc" target="_blank" style="text-decoration: none">
                <div style="text-align:right; width: 96px; height: 15px;">
                <img height="auto"
                  src="https://i.imgur.com/D4FXC5T.png"
                  style="direction: ltr; border: 0; display: block; outline: none; text-decoration: none; height: auto; width: 100%;"
                  width="100" class="CToWUd" />
                </div>
              </a>
            </div>
          </td>
        </tr>
        <tr style="direction: ltr">
          <td align="center" style="padding-top: 20px; padding-bottom: 20px;">
            <div style="
            direction: ltr;
            font-weight: 400;
            font-family: \'Inter\', Arial,
              sans-serif;
            text-align: center;
            color: #333333;
            font-size: 8px;
            line-height: 12px;
            margin-top: 20px;
            padding-top: 24px;
          ">
              Developed by <a href="https://willbe.co"
                style="text-decoration: underline; color: #333333;">Willbe
                Collective</a>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>';

      wp_mail('info@pacto.cc', 'Pacto.cc - Produtos Personalizados - ' . $data['nome'], $body, $headers);

      $response = new WP_REST_Response('Email enviado 👍');
      $response->set_status(200);
    } else {
      $response = new WP_REST_Response('Forbiden');
      $response->set_status(403);
    }
  } else {
    $response = new WP_REST_Response('No token provided');
    $response->set_status(403);
  }
  return rest_ensure_response($response);
}

function register_personalizados()
{
  wp_register_script('app-personalizados', get_stylesheet_directory_uri() . '/assets/personalizados/js/main.aca89383.js', array(), null, true);
  wp_register_style('style-personalizados', get_stylesheet_directory_uri() . '/assets/personalizados/css/main.bec58af1.css', array(), null, '');
}

add_action('wp_enqueue_scripts', 'register_personalizados');

function willbe_price_personalizados_shortcode()
{
  $body = '<noscript>You need to enable JavaScript to run this app.</noscript><div id="root"></div>';
  return $body;
}

add_shortcode('personalizados', 'willbe_price_personalizados_shortcode');


add_filter('wc_product_has_unique_sku', '__return_false', PHP_INT_MAX);

add_action('wp_ajax_nopriv_subscribe_to_egoi_newsletter', 'subscribe_to_egoi_newsletter');
add_action('wp_ajax_subscribe_to_egoi_newsletter', 'subscribe_to_egoi_newsletter');

function subscribe_to_egoi_newsletter()
{
  $list_id = 1;
  $api_key = "31c6048f18c9ae854aa44aef4270c1865059bef0";

  $data = json_decode(stripslashes($_POST['data']));
  $data = json_encode($data);
  $curl = curl_init();

  curl_setopt_array(
    $curl,
    array(
      CURLOPT_URL => "https://api.egoiapp.com/lists/" . $list_id . "/contacts",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $data,
      CURLOPT_HTTPHEADER => array(
        "Apikey: " . $api_key,
        "Content-Type: application/json"
      ),
    )
  );
  $response = curl_exec($curl);
  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  curl_close($curl);
  echo $status;
  die;
}
//inicio de copia
add_filter('login_headerurl', 'login_logo_url');
function login_logo_url($url)
{
  return 'https://willbe.co';
}

function wlb_login_logo()
{
  ?>
  <style type="text/css">
    #login h1 a,
    .login h1 a {
      background-image: url(http://pacto.cc/wp-content/uploads/2023/02/willbe-e-pacto.png);
      min-height: 70px;
      width: 70%;
      background-size: contain;
      background-repeat: no-repeat;
      padding-bottom: 30px;
    }
  </style>
<?php }
add_action('login_enqueue_scripts', 'wlb_login_logo');
//fim de copia

add_action(
  'woocommerce_cart_calculate_fees',
  function () {
    if (is_admin()) {
      return;
    }

    $payment_method = WC()->session->get('chosen_payment_method');


    if ($payment_method === 'cod') {
      $amount = 3; // How much the fee should be
      $tax = 0; // empty value equals to Standard tax rate
      $title = 'Pagamento na entrega';

      WC()->cart->add_fee($title, floatval($amount), false, $tax);
    }
  },
  10,
  0
);

/**
 * By default WooCommerce doesn't update checkout when changing payment
 * method so we need to trigger update here
 */
add_action(
  'wp_head',
  function () {
    ?>
  <script type="text/javascript">
    jQuery(document).ready(function ($) {
      /**
       * Trigger checkout update when changing payment method
       */
      $(document.body).on('change', 'input[name="payment_method"]', function () {
        $(document.body).trigger('update_checkout');
      });
    });
  </script>
  <?php
  },
  10,
  0
);


add_filter('oembed_response_data', 'disable_embeds_filter_oembed_response_data_');
function disable_embeds_filter_oembed_response_data_($data)
{
  unset($data['author_url']);
  unset($data['author_name']);
  return $data;
}


function hide_shipping_when_free_is_available($rates, $package)
{
  $new_rates = array();
  foreach ($rates as $rate_id => $rate) {
    // Only modify rates if free_shipping is present.
    if ('free_shipping' === $rate->method_id) {
      $new_rates[$rate_id] = $rate;
      break;
    }
  }

  if (!empty($new_rates)) {
    //Save local pickup if it's present.
    foreach ($rates as $rate_id => $rate) {
      if ('local_pickup' === $rate->method_id) {
        $new_rates[$rate_id] = $rate;
        break;
      }
    }
    return $new_rates;
  }

  return $rates;
}

add_filter('woocommerce_package_rates', 'hide_shipping_when_free_is_available', 10, 2);