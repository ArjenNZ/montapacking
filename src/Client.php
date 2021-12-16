<?php 
 
namespace ArjenNZ\Montapacking;

/**
*  @author ArjenNZ
*/
 
class Client
{
    protected $username;
    protected $password;
 
    protected $apihost = 'api.montapacking.nl/rest';
    protected $protocol = 'https';
    protected $apiversion = 'v5';
    protected $useragent = 'Montapacking PHP API Client (montapacking.nl)';
 
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
 
 
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
 
    public function getHealth()
    {
        return $this->sendRequest('/health');
    }
 
    public function getProduct($sku)
    {
        return $this->sendRequest('/product/' . $sku);
    }
 
    public function getProductByBarcode($barcode)
    {
        return $this->sendRequest('/product?barcode=' . $barcode);
    }
 
    public function getProductStock($sku)
    {
        return $this->sendRequest('/product/' . $sku . '/stock');
    }
 
    public function getProductUpdatesSince($time, $skus = [])
    {
        $date = $this->formatTime($time);
 
        return $this->sendRequest('/product/updated_since/' . $date);
    }
 
    public function addProduct($params)
    {
        return $this->sendRequest('/product', $params, self::METHOD_POST);
    }
 
    public function updateProduct($sku, $params)
    {
        return $this->sendRequest('/product/' . $sku, $params, self::METHOD_PUT);
    }
 
    public function deleteBarcodeFromProduct($sku, $barcode)
    {
        return $this->sendRequest('/product/' . $sku . '/barcode/' . $barcode, [], self::METHOD_DELETE);
    }
 
    public function deleteAllBarcodesFromProduct($sku)
    {
        return $this->sendRequest('/product/' . $sku . '/barcode', [], self::METHOD_DELETE);
    }
 
    public function deleteProduct($sku)
    {
        return $this->sendRequest('/product/' . $sku, [], self::METHOD_DELETE);
    }
 
    public function getDeal($code)
    {
        return $this->sendRequest('/deal/' . $code);
    }
 
    public function addDeal($params)
    {
        return $this->sendRequest('/deal', $params, self::METHOD_POST);
    }
 
    public function updateDeal($code, $params)
    {
        return $this->sendRequest('/deal/' . $code, $params, self::METHOD_PUT);
    }
 
    public function getOrder($orderid)
    {
        return $this->sendRequest('/order/' . $orderid);
    }
 
    public function getOrderUpdatesSince($time)
    {
        $date = $this->formatTime($time);
 
        return $this->sendRequest('/order/updated_since/' . $date);
    }
 
    public function addOrder($params)
    {
        return $this->sendRequest('/order', $params, self::METHOD_POST);
    }
 
    public function updateOrder($orderid, $params)
    {
        return $this->sendRequest('/order/' . $orderid, $params, self::METHOD_PUT);
    }
 
    public function deleteOrder($orderid, $params)
    {
        return $this->sendRequest('/order/' . $orderid, $params, self::METHOD_DELETE);
    }
 
    public function forgetOrder($orderid, $params)
    {
        return $this->sendRequest('/order' . $orderid . '/forget', $params, self::METHOD_POST);
    }

    public function getReturnsOrder($orderid)
    {
        return $this->sendRequest('/order/' . $orderid . '/return');
    }
 
    public function getSerialsOrder($orderid)
    {
        return $this->sendRequest('/order/' . $orderid . '/serials');
    }

    public function getEventsOrder($orderid)
    {
        return $this->sendRequest('/order/' . $orderid . '/events');
    }

    public function addRMALinksOrder($orderid, $params)
    {
        return $this->sendRequest('/order/' . $orderid . '/rmalinks', $params, self::METHOD_POST);
    }

    public function getDeletedLinesOrder($orderid)
    {
        return $this->sendRequest('/order/' . $orderid . '/linesdeleted');
    }

    public function getColliOrder($orderid)
    {
        return $this->sendRequest('/order/' . $orderid . '/colli');
    }

    public function getReturnForecastsOrder($orderid)
    {
        return $this->sendRequest('/order/' . $orderid . '/returnforecasts');
    }

    public function getInboundForecast($ponumber, $sku)
    {
        return $this->sendRequest('/inboundforecast/group/' . $ponumber . '/' . $sku);
    }

    public function getInboundForecastGroup($ponumber)
    {
        return $this->sendRequest('/inboundforecast/group/' . $ponumber);
    }

    public function addInboundForecast($ponumber, $params)
    {
        return $this->sendRequest('/inboundforecast/group/' . $ponumber, $params, self::METHOD_POST);
    }

    public function addInboundForecastGroup($params)
    {
        return $this->sendRequest('/inboundforecast/group', $params, self::METHOD_POST);
    }

    public function updateInboundForecast($ponumber, $sku, $params)
    {
        return $this->sendRequest('/inboundforecast/group/' . $ponumber . '/' . $sku, $params, self::METHOD_PUT);
    }

    public function updateInboundForecastGroup($ponumber, $params)
    {
        return $this->sendRequest('/inboundforecast/group/' . $ponumber, $params, self::METHOD_PUT);
    }

    public function deleteInboundForecast($ponumber, $sku)
    {
        return $this->sendRequest('/inboundforecast/group/' . $ponumber . '/' . $sku, [], self::METHOD_DELETE);
    }

    public function deleteInboundForecastGroup($ponumber)
    {
        return $this->sendRequest('/inboundforecast/group/' . $ponumber, [], self::METHOD_DELETE);
    }

    public function getReturnForcast($code)
    {
        return $this->sendRequest('/returnforecast/' . $code);
    }

    public function addReturnForecast($params)
    {
        return $this->sendRequest('/returnforecast', $params, self::METHOD_POST);
    }

    public function getReturnForcastLabel($code)
    {
        return $this->sendRequest('/returnforecast/' . $code . '/returnlabel?shipperCode=DPD');
    }

    public function getInfo()
    {
        return $this->sendRequest('/info');
    }

    public function getSuppliers()
    {
        return $this->sendRequest('/supplier');
    }

    public function getSupplier($suppliercode)
    {
        return $this->sendRequest('/supplier/' . $suppliercode);
    }

    public function addSupplier($params)
    {
        return $this->sendRequest('/supplier', $params, self::METHOD_POST);
    }

    public function updateSupplier($suppliercode, $params)
    {
        return $this->sendRequest('/supplier/' . $suppliercode, $params, self::METHOD_PUT);
    }

    public function deleteSupplier($suppliercode)
    {
        return $this->sendRequest('/supplier/' . $suppliercode, [], self::METHOD_DELETE);
    }

    public function getReturnsSince($time)
    {
        $date = $this->formatTime($time);
 
        return $this->sendRequest('/return/since/' . $date);
    }

    public function getReturnUpdatesSince($time)
    {
        $date = $this->formatTime($time);
 
        return $this->sendRequest('/return/updated_since/' . $date);
    }

    public function getReturnDocuments($id)
    {
        return $this->sendRequest('/return/' . $id . '/documents');
    }

    public function getOrderEvents($id)
    {
        return $this->sendRequest('/orderevents/since_id/' . $id);
    }

    public function getOrderEventsSince($time)
    {
        $date = $this->formatTime($time);
 
        return $this->sendRequest('/orderevents/since/' . $date);
    }

    public function getShippingOptions()
    {
        return $this->sendRequest('/shippingoptions');
    }
 
    protected function sendRequest($endpoint, $params = [], $method = self::METHOD_GET, $filters = [])
    {
        $client = new \GuzzleHttp\Client();
 
        $url = $this->getUrl($endpoint);
        
        
        $response = $client->request($method, $url, [
            'auth' => [
                $this->username,
                $this->password
            ],
            'json' => $params
        ]);
        
 
        $data = json_decode($response->getBody()->getContents());
 
        return $data;
    }
 
    protected function getUrl($endpoint)
    {
        return $this->protocol . '://' . $this->apihost . '/' . $this->apiversion . $endpoint;
    }

    protected function formatTime($time)
    {
        $datetime = new \DateTime($time);
 
        return $datetime->format('Y-m-d\TH:i:s');
    }
}
