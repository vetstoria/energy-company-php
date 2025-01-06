## Installation pre-requisites

- Install PHP version 8.2 or above
- Setup composer on your system

## Useful commands

### Install dependencies

```
composer install
```

### Build & Run the application

```terminal
$ ./deploy-energy.php
```
Above command will start the application on url `http://127.0.0.1:8000`. Can be accessed using `http://localhost:8000` as well.

### Run the tests

```terminal
$ php artisan test
```

## API

Below is a list of API endpoints with their respective input and output. Please note that the application needs to be running. For more information about how to run the application, please refer to [run the application](#run-the-application) section below.

### Store Readings

Endpoint

```
POST /readings
```

Example of body

```json
{
    "smartMeterId": <smartMeterId>,
    "electricityReadings": [
        { "time": <time>, "reading": <reading> },
        { "time": <time>, "reading": <reading> },
        ...
    ]
}
```

Parameters

| Parameter      | Description                                |
| -------------- | ------------------------------------------ |
| `smartMeterId` | One of the smart meters' id listed above   |
| `time`         | The time when the _delta_ is measured      |
| `reading`      | The _delta_ reading since the last reading |

Example readings

| Date (`GMT`)                        | Reading (`kW`) |
| ----------------------------------- | -------------: |
| `2020-11-11T08:00:00.0000000+00:00` |         0.0503 |
| `2020-11-12T08:00:00.0000000+00:00` |         0.0213 |

In the above example, `0.0213 kW` where consumed between `2020-11-11 8:00` and `2020-11-12 8:00`.

Posting readings using CURL

```console
$ curl \
  -X POST \
  -H "Content-Type: application/json" \
  "http://localhost:8000/readings" \
  -d '{"smartMeterId":"smart-meter-0","electricityReadings":[{"time":"2020-11-11T08:00:00.0000000+00:00","reading":0.0503},{"time":"2020-11-12T08:00:00.0000000+00:00","reading":0.0213}]}'
```

The above command returns 201 OK and response as "Readings inserted successfully".

### Get Stored Readings

Endpoint

```
GET /readings/<smartMeterId>
```

Parameters

| Parameter      | Description                              |
| -------------- | ---------------------------------------- |
| `smartMeterId` | One of the smart meters' id listed above |

Retrieving readings using CURL

```console
$ curl "http://localhost:8000/readings/smart-meter-1"
```

Example output

```json
[
  { "time": "2020-11-14T08:00:00.0000000+00:00", "reading": "0.8998" },
  { "time": "2020-11-15T08:00:00.0000000+00:00", "reading": "0.6023" }
]
```

### View Current Price Plan and Compare Usage Cost Against all Price Plans

Endpoint

```
GET /price-plan/<smartMeterId>/comparisons
```

Parameters

| Parameter      | Description                              |
| -------------- | ---------------------------------------- |
| `smartMeterId` | One of the smart meters' id listed above |

Retrieving readings using CURL

```console
$ curl "http://localhost:8000/price-plan/smart-meter-1/comparisons"
```

Example output

```json
{
    "priceComparisons": [
        {
            "supplier": "Dr Evil's Dark Energy",
            "cost": 0.4529635476463834
        },
        {
            "supplier": "The Green Eco",
            "cost": 0.009059270952927669
        },
        {
            "supplier": "Power for Everyone",
            "cost": 0.004529635476463834
        }
    ],
    "currentSupplier": "The Green Eco"
}
```

### View Recommended Price Plans for Usage

Endpoint

```
GET /price-plan/<smartMeterId>/recommendations[?limit=<limit>]
```

Parameters

| Parameter      | Description                                          |
| -------------- | ---------------------------------------------------- |
| `smartMeterId` | One of the smart meters' id listed above             |
| `limit`        | (Optional) limit the number of plans to be displayed |

Retrieving readings using CURL

```console
$ curl "http://localhost:8000/price-plan/smart-meter-1/recommendations?limit=2"
```

Example output

```json
[
  {
    "supplier": "Power For Everyone",
    "cost": 0.004529635476463834
  },
  {
    "supplier": "The Green Eco",
    "cost": 0.009059270952927669
  }
]
```
Compatible IDEs

Tested on:

- Visual Studio Code(with PHP Intelephense & PHPUnit extension)
- IntelliJ IDEA Ultimate

