# 綠界電子發票 api package

系統作業流程參閱專案內文件

## 參數
* Server: 介接網址
* MerchantID: 特約店代碼
* HashKey
* HashIV

## 範例

### 開立發票

```
$server = 'https://einvoice-stage.ecpay.com.tw';
$id = '2000132';
$key = 'ejCk326UnaZWKisg';
$iv = 'q9jcZX8Ib9LM8wYk';

$invoice = new ecPay\eInvoice\Invoice($server, $id, $key, $iv);
$response = $invoice->setRelateNumber('YEP' . date('YmdHis'))
    ->setCustomerEmail('cylee@chyp.com.tw')
    ->setItems([
        [
            'name' => '商品範例',
            'quantity' => 1,
            'unit' => '個',
            'price' => 100,
            'totalPrice' => 100,
        ],
    ])
    ->setSalesAmount(100)
    ->sendRequest();
$parseResponse = $invoice->getResponse();
```

### 取得發票

```
$server = 'https://einvoice-stage.ecpay.com.tw';
$id = '2000132';
$key = 'ejCk326UnaZWKisg';
$iv = 'q9jcZX8Ib9LM8wYk';

# 開立發票時的 RelateNumber
$relateNumber = '';

# 開立發票後回傳的發票號碼
$InvoiceNo = '';

# format - Y-m-d
$InvoiceDate = '';

$invoice = new ecPay\eInvoice\GetInvoice($server, $id, $key, $iv);
    $response = $invoice->setRelateNumber($relateNumber)
        ->setInvoiceNo($InvoiceNo)
        ->setInvoiceDate($InvoiceDate)
        ->sendRequest();
$parseResponse = $invoice->getResponse();
```

### 查詢愛心碼
```
$server = 'https://einvoice-stage.ecpay.com.tw';
$id = '2000132';
$key = 'ejCk326UnaZWKisg';
$iv = 'q9jcZX8Ib9LM8wYk';

$invoice = new ecPay\eInvoice\CheckLoveCode($server, $id, $key, $iv);
$response = $invoice->setLoveCode('9527')->sendRequest();
```

### 查詢手機條碼
```
$server = 'https://einvoice-stage.ecpay.com.tw';
$id = '2000132';
$key = 'ejCk326UnaZWKisg';
$iv = 'q9jcZX8Ib9LM8wYk';

$invoice = new ecPay\eInvoice\CheckBarcode($server, $id, $key, $iv);
$response = $invoice->setBarcode('/YC+RROR')->sendRequest();

```
