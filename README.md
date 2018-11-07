<h1 align="center"> weather </h1>

<p align="center"> 基于高德开放平台的 PHP 天气信息组件</p>


## 安装

```shell
$ composer require Ecss/weather -vvv
```
##配置

在使用本扩展之前，你需要去[高德开放平台](https://lbs.amap.com/dev/id/newuser) 注册账号，然后创建应用，获取应用的 API Key。

## 使用
```php
use Ecss\Weather\Weather;

$key = 'xxxxxxxxxxxxxxxx';

$weather = new Weather($key);
```

##获取实时天气
```php
$response = $weather->getLiveWeather('重庆');
```
示例：

```json
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "lives": [
        {
            "province": "重庆",
            "city": "重庆市",
            "adcode": "500000",
            "weather": "阴",
            "temperature": "11",
            "winddirection": "西北",
            "windpower": "4",
            "humidity": "82",
            "reporttime": "2018-11-07 15:00:00"
        }
    ]
}
```

### 获取天气预报

```php
$response = $weather->getForecastsWeather('重庆');
```
示例：

```json
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "forecasts": [
        {
            "city": "重庆市",
            "adcode": "500000",
            "province": "重庆",
            "reporttime": "2018-11-07 11:00:00",
            "casts": [
                {
                    "date": "2018-11-07",
                    "week": "3",
                    "dayweather": "小雨",
                    "nightweather": "多云",
                    "daytemp": "12",
                    "nighttemp": "9",
                    "daywind": "无风向",
                    "nightwind": "无风向",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2018-11-08",
                    "week": "4",
                    "dayweather": "多云",
                    "nightweather": "多云",
                    "daytemp": "15",
                    "nighttemp": "10",
                    "daywind": "无风向",
                    "nightwind": "无风向",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2018-11-09",
                    "week": "5",
                    "dayweather": "多云",
                    "nightweather": "小雨",
                    "daytemp": "15",
                    "nighttemp": "10",
                    "daywind": "无风向",
                    "nightwind": "无风向",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2018-11-10",
                    "week": "6",
                    "dayweather": "阴",
                    "nightweather": "阴",
                    "daytemp": "17",
                    "nighttemp": "12",
                    "daywind": "无风向",
                    "nightwind": "无风向",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                }
            ]
        }
    ]
}
```

### 获取 XML 格式返回值

以上两个方法第二个参数为返回值类型，可选 `json` 与 `xml`，默认 `json`：

```php
$response = $weather->getLiveWeather('重庆', 'xml');
```

示例：
```xml
<response>
    <status>1</status>
    <count>1</count>
    <info>OK</info>
    <infocode>10000</infocode>
    <lives type="list">
        <live>
            <province>重庆</province>
            <city>重庆市</city>
            <adcode>500000</adcode>
            <weather>阴</weather>
            <temperature>11</temperature>
            <winddirection>西北</winddirection>
            <windpower>4</windpower>
            <humidity>82</humidity>
            <reporttime>2018-11-07 15:00:00</reporttime>
        </live>
    </lives>
</response>
```

### 参数说明

```
array | string   getLiveWeather(string $city, string $format = 'json')
array | string   getForecastsWeather(string $city, string $format = 'json')
```

> - `$city` - 城市名/[高德地址位置 adcode](https://lbs.amap.com/api/webservice/guide/api/district)，比如：“深圳” 或者（adcode：440300）；
> - `$format`  - 输出的数据格式，默认为 json 格式，当 output 设置为 “`xml`” 时，输出的为 XML 格式的数据。

### 在 Laravel 中使用

在 Laravel 中使用也是同样的安装方式，配置写在 `config/services.php` 中：

```php
    .
    .
    .
     'weather' => [
        'key' => env('WEATHER_API_KEY'),
    ],
```

然后在 `.env` 中配置 `WEATHER_API_KEY` ：

```env
WEATHER_API_KEY=xxxxxxxxxxxxxxxxxxxxx
```

可以用两种方式来获取 `Overtrue\Weather\Weather` 实例：

#### 方法参数注入

```php
    .
    .
    .
    public function edit(Weather $weather) 
    {
        $response = $weather->getLiveWeather('重庆');
    }
    .
    .
    .
```

#### 服务名访问

```php
    .
    .
    .
    public function edit() 
    {
        $response = app('weather')->getLiveWeather('重庆');
    }
    .
    .
    .

```

## 参考

- [高德开放平台天气接口](https://lbs.amap.com/api/webservice/guide/api/weatherinfo/)

## License

MIT