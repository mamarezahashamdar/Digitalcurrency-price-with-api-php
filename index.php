<?php
include 'jdf.php';
$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
$parameters = [
  'start' => '1',
  'limit' => '5',
  'convert' => 'USD'
];

$headers = [
  'Accepts: application/json',
  'X-CMC_PRO_API_KEY: 0d7a16c8-2765-48c1-9df3-c5af84935b62'
];
$qs = http_build_query($parameters); // query string encode the parameters
$request = "{$url}?{$qs}"; // create the request URL


$curl = curl_init(); // Get cURL resource
// Set cURL options
curl_setopt_array($curl, array(
  CURLOPT_URL => $request, // set the request URL
  CURLOPT_HTTPHEADER => $headers, // set the headers
  CURLOPT_RETURNTRANSFER => 1 // ask for raw response instead of bool
));

$response = curl_exec($curl); // Send the request, save the response
$myJson = json_decode($response, true); // print json decoded response
curl_close($curl); // Close request


$cryptocurrencies = $myJson['data'];

?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="public/css/style.css">
  <title>قیمت ارزهای دیجیتال</title>
</head>

<body>
  <div class="container">
    <div class="note">
      <span>
        "قیمت ارزهای دیجیتال رو هر 20 تا 30 ثانیه از <mark>CoinMarketCap</mark> براتون آپدیت میکنم. هر دلار به 50,000 تومان محاسبه میشه. توی اینجا همیشه 5 تا از ارزهای معروف و پرطرفدار رو داریم."
      </span>
      <h4>creator : <mark>Mamareza</mark></h4>
    </div>

    <div class="row">
      <?php foreach ($cryptocurrencies as $crypto) :
        $price = $crypto['quote']['USD']['price'] * 50000;
      ?>
        <div class="digital-currency">
          <div class="digital-currency__header">
            <?php if ($crypto['name'] == 'Bitcoin') : ?>
              <img src="public/images/BTC.png" alt="Bitcoin" class="digital-currency__image">
            <?php elseif ($crypto['name'] == 'Ethereum') : ?>
              <img src="public/images/ETH.png" alt="Ethereum" class="digital-currency__image">
            <?php elseif ($crypto['name'] == 'Tether USDt') : ?>
              <img src="public/images/TH.png" alt="Tether USDt" class="digital-currency__image">
            <?php elseif ($crypto['name'] == 'BNB') : ?>
              <img src="public/images/BNB.png" alt="Bitcoin" class="digital-currency__image">
            <?php elseif ($crypto['name'] == 'XRP') : ?>
              <img src="public/images/XRP.png" alt="XRP" class="digital-currency__image">
            <?php endif; ?>
            <h4><?= $crypto['name']; ?> - <?= $crypto['symbol']; ?></h4>
          </div>
          <div class="digital-currency__total__price">
            <span>قیمت ارز : </span>
            <p><?= number_format($crypto['quote']['USD']['price'], 2, '.', ','); ?> دلار</p>
          </div>
          <p class="digital-currency__rial"><?= number_format($price, 0, '.', ','); ?> تومان</p>
          <div class="digital-currency__time">
            <span>تاریخ اخرین بروزرسانی : </span>
            <p><?php
                $dateString = $crypto['last_updated'];
                $timestamp = strtotime($dateString);
                echo jdate('Y-m-d H:i:s', $timestamp, 'Asia/Tehran');
                ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>

</html>