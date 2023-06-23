<?php
$isValidCustomer = false;
$finalResult = null;

if (isset($_POST['givenPrice'])) {
    $customer = $_POST['customer'];
    $code = $_POST['code'];
    $notification_id = $_POST['code'] ? $_POST['code'] : null;

    $customer_sql = "SELECT * FROM callcenter.customer WHERE id = '" . $customer . "%'";
    $result = mysqli_query($conn, $customer_sql);
    if (mysqli_num_rows($result) > 0) {
        $isValidCustomer = true;

        $completeCode = $code;
        $finalResult = setup_loading($conn, $customer, $completeCode, $notification_id);
    }
}

function setup_loading($conn, $customer, $completeCode, $notification = null)
{
    $explodedCodes = explode("\n", $completeCode);

    $results_arry = [
        'not_exist' => [],
        'existing' => [],
    ];


    $explodedCodes = array_map(function ($code) {
        return preg_replace('/[^a-z0-9]/i', '', $code);;
    }, $explodedCodes);


    foreach ($explodedCodes as $code) {
        $sql = "SELECT id, partnumber FROM yadakshop1402.nisha WHERE partnumber LIKE '" . $code . "%'";
        $result = mysqli_query($conn, $sql);

        $all_matched = [];
        if (mysqli_num_rows($result) > 0) {
            while ($item = mysqli_fetch_assoc($result)) {
                array_push($all_matched, $item);
            }
        }

        if (count($all_matched)) {
            $existing_code[$code] = $all_matched;
        } else {
            array_push($results_arry['not_exist'], $code);
        }
    }

    $existing_code = [];
    foreach ($explodedCodes as $code) {

        $sql = "SELECT id, partnumber FROM yadakshop1402.nisha WHERE partnumber LIKE '" . $code . "%'";
        $result = mysqli_query($conn, $sql);

        $all_matched = [];
        if (mysqli_num_rows($result) > 0) {
            while ($item = mysqli_fetch_assoc($result)) {
                array_push($all_matched, $item);
            }
        }

        if (count($all_matched)) {
            $existing_code[$code] = $all_matched;
        } else {
            array_push($results_arry['not_exist'], $code);
        }
    }

    $data = [];
    $relation_id = [];

    foreach ($explodedCodes as $code) {
        if (!in_array($code, $results_arry['not_exist'])) {
            $data[$code] = [];
            foreach ($existing_code[$code] as $item) {
                $relation_exist = isInRelation($conn, $item['id']);
                if ($relation_exist) {
                    if (!in_array($relation_exist, $relation_id)) {
                        array_push($relation_id, $relation_exist);
                        $data[$code][$item['partnumber']]['information'] = info($conn, $item['id']);
                        $data[$code][$item['partnumber']]['relation'] = relations($item['id']);
                        // $data[$code][$item->partnumber]['givenPrice'] = $this->givenPrice($item->partnumber, $relation_exist);
                        // $data[$code][$item->partnumber]['estelam'] = $this->estelam($item->partnumber);
                    }
                } else {
                    $data[$code][$item['partnumber']]['information'] = info($conn, $item['id']);
                    $data[$code][$item['partnumber']]['relation'] = relations($item['id']);
                    // $data[$code][$item->partnumber]['estelam'] = $this->estelam($item->partnumber);
                    // $data[$code][$item->partnumber]['estelam'] = $this->estelam($item->partnumber);
                }
            }
        }
    }

    return json_encode($data);

    // return Inertia::render('Price/Partials/Load', [
    //     'explodedCodes' => $explodedCodes,
    //     'not_exist' => $results_arry['not_exist'],
    //     'existing' => $data,
    //     'customer' => $customer,
    //     'completeCode' => $completeCode,
    //     'notification' => $notification,
    //     'rates' => $this->getSelectedRates()
    // ]);
}

// function validateRequest($all_data)
// {
//     Validator::make($all_data, [
//         'customer' => 'required|exists:callcenter.customer,id',
//         'code' => 'required|string',

//     ], [
//         'required' => "وارد کردن :attribute الزامی می باشد.",
//         'exists' => ":attribute وارد شده در سیستم موجود نیست."
//     ], [
//         'customer' => 'مشتری',
//         'code' => 'کد'
//     ])->validate();
// }

// function getSelectedRates()
// {
//     $rates = DB::table('rates')
//         ->select('amount', 'status')
//         ->where('selected', '1')
//         ->get();
//     return $rates;
// }

function isInRelation($conn, $id)
{
    $sql = "SELECT pattern_id FROM similars WHERE nisha_id = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($item = mysqli_fetch_assoc($result)) {
            return $item['pattern_id'];
        }
    }
    return false;
}

function info($conn, $id)
{
    $sql = "SELECT pattern_id FROM similars WHERE nisha_id = '" . $id . "'";
    $result = mysqli_query($conn, $sql);

    $isInRelation = null;
    if (mysqli_num_rows($result) > 0) {
        $isInRelation = mysqli_fetch_assoc($result);
    }


    $info = false;
    $cars = [];
    if ($isInRelation) {

        $sql = "SELECT * FROM patterns WHERE id = '" . $isInRelation['pattern_id'] . "'";
        $result = mysqli_query($conn, $sql);

        $info = null;
        if (mysqli_num_rows($result) > 0) {
            $info = mysqli_fetch_assoc($result);
        }

        if ($info['status_id'] !== 0) {
            $sql = "SELECT patterns.*, status.name AS  status_name FROM patterns INNER JOIN status ON status.id = patterns.status_id WHERE patterns.id = '" . $isInRelation['pattern_id'] . "'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $info = mysqli_fetch_assoc($result);
            }
        }

        $sql = "SELECT cars.name FROM patterncars INNER JOIN cars ON cars.id = patterncars.car_id WHERE patterncars.pattern_id = '" . $isInRelation['pattern_id'] . "'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($item = mysqli_fetch_assoc($result)) {
                array_push($cars, $item['name']);
            }
        }
    }

    return $info ? ['relationInfo' => $info, 'cars' => $cars] : false;
}

function relations($id)
{
    $isInRelation = DB::table('similars')->select('pattern_id')->where('nisha_id', $id)->first();
    $relations = false;

    if ($isInRelation) {

        $relations = DB::table('yadakshop1402.nisha')
            ->join('similars', 'nisha.id', '=', 'similars.nisha_id')
            ->select('yadakshop1402.nisha.*')
            ->where('similars.pattern_id', $isInRelation->pattern_id)
            ->get();
    } else {
        $relations = DB::table('yadakshop1402.nisha')->where('id', $id)->get();
    }

    $existing = [];
    $stockinfo = [];
    $sortedGoods = [];
    foreach ($relations as $relation) {
        $existing[$relation->partnumber] = $this->exist($relation->id)['final'];
        $stockinfo[$relation->partnumber] = $this->exist($relation->id)['stockInfo'];
        $sortedGoods[$relation->partnumber] = $relation;
    }

    arsort($existing);
    $sorted = [];
    foreach ($existing as $key => $value) {
        $sorted[$key] = $this->getMax($value);
    }

    arsort($sorted);

    return ['goods' => $sortedGoods, 'existing' => $existing, 'sorted' => $sorted, 'stockInfo' => $stockinfo];
}

// function givenPrice($code, $relation_exist = null)
// {
//     $ordared_price = null;
//     if ($relation_exist) {
//         $ordared_price = DB::table('patterns')
//             ->select('patterns.price', 'patterns.created_at')
//             ->where('id', $relation_exist)->first();
//         $ordared_price->ordered = true;
//     }

//     $givenPrices = DB::table('prices')
//         ->join('callcenter.customer', 'customer.id', '=', 'prices.customer_id')
//         ->where('partnumber', 'like', "$code%")
//         ->orderBy('created_at', 'desc')
//         ->limit(7)->get();


//     $unsortedData = [...$givenPrices, $ordared_price];
//     if ($relation_exist) {
//         usort($unsortedData, function ($a, $b) {
//             return $a->created_at < $b->created_at;
//         });
//     }
//     $final_data = $relation_exist ? $unsortedData : $givenPrices;

//     return  $final_data;
// }

// function estelam($code)
// {
//     $estelam = DB::table('callcenter.estelam')
//         ->join('yadakshop1402.seller', 'seller.id', '=', 'estelam.seller')
//         ->where('codename', 'like', "$code%")
//         ->orderBy('time', 'desc')
//         ->limit(7)->get();

//     return $estelam;
// }

// function out($id)
// {
//     $result =
//         DB::table('yadakshop1402.exitrecord')
//         ->select('qty')
//         ->where('qtyid', $id)
//         ->first();
//     return $result;
// }

// function stockInfo($id, $brand)
// {

//     $brand_id = DB::table('yadakshop1402.brand')->select('id')->where('brand.name', '=', $brand)
//         ->first();

//     $result =
//         DB::table('yadakshop1402.qtybank')
//         ->select('qtybank.id', 'qtybank.qty', 'seller.name')
//         ->join('yadakshop1402.seller', 'qtybank.seller', '=', 'seller.id')
//         ->where('codeid', $id)
//         ->where('brand', $brand_id->id)
//         ->get();

//     $existing_record = [];
//     $customers = [];
//     foreach ($result as $key => $item) {
//         $out = $this->out($item->id) ? (int) $this->out($item->id)->qty : 0;
//         $item->qty = (int)($item->qty) - $out;

//         array_push($existing_record, $item);
//         array_push($customers, $item->name);
//     }

//     $customers = array_unique($customers);

//     $final_result = [];

//     foreach ($customers as $customer) {
//         $total = 0;
//         foreach ($existing_record as $record) {
//             if ($customer === $record->name) {
//                 $total += $record->qty;
//             }
//         }

//         $final_result[$customer] = $total;
//     }

//     return $final_result;
// }

// function exist($id)
// {
//     $result =
//         DB::table('yadakshop1402.qtybank')
//         ->join('yadakshop1402.brand', 'brand.id', '=', 'qtybank.brand')
//         ->select('yadakshop1402.qtybank.id', 'codeid', 'brand.name', 'qty')
//         ->where('codeid', $id)
//         ->get();
//     $brands = [];
//     $amount = [];
//     $stockInfo = [];

//     foreach ($result as $key => $value) {
//         $out = $this->out($value->id) ? (int) $this->out($value->id)->qty : 0;
//         $value->qty = (int)($value->qty) - $out;

//         array_push($brands, $value->name);
//     }
//     $brands = array_unique($brands);

//     foreach ($brands as $key => $value) {
//         $item = $value;
//         $total = 0;
//         foreach ($result as $key => $value) {
//             if ($item == $value->name) {
//                 $total += $value->qty;
//             }
//             $stockInfo[$value->name] =  $this->stockInfo($id, $value->name);
//         }

//         array_push($amount, $total);
//     }
//     $final = array_combine($brands, $amount);
//     arsort($final);
//     return ['stockInfo' => $stockInfo, 'final' => $final];
// }

// function store(Request $request)
// {
//     Validator::make($request->all(), [
//         'partnumber' => 'required|string|exists:yadakshop.nisha,partnumber'

//     ], [
//         'required' => "The :attribute field can't be empty.",
//     ])->validate();


//     $notification = $request->input('notification');

//     DB::table('prices')->insert([
//         'partnumber' => $request->input('partnumber'),
//         'price' => $request->input('price'),
//         'customer_id' => $request->input('customer'),
//         'created_at' => Carbon::now(),
//         'updated_at' => Carbon::now(),
//     ]);

//     if ($notification) {
//         DB::table('ask_price')
//             ->where('id', $notification)
//             ->update(['status' => 'done', 'notify' => 'received', 'price' => $request->input('price')]);
//     }

//     return $this->setup_loading($request->input('customer'), $request->input('completeCode'));
// }

// function getMax($array)
// {
//     $max = 0;
//     foreach ($array as $k => $v) {
//         $max = $max < $v ? $v : $max;
//     }
//     return $max;
// }

// function test($id = '277776', $brand = 'GEN')
// {
//     $brand_id = DB::table('brand')->select('id')->where('brand.name', '=', $brand)
//         ->first();

//     $result =
//         DB::table('qtybank')
//         ->select('qtybank.id', 'qtybank.qty', 'seller.name')
//         ->join('seller', 'qtybank.seller', '=', 'seller.id')
//         ->where('codeid', $id)
//         ->where('brand', $brand_id->id)
//         ->get();

//     $existing_record = [];
//     $customers = [];
//     foreach ($result as $key => $item) {
//         $out = $this->out($item->id) ? (int) $this->out($item->id)->qty : 0;
//         $item->qty = (int)($item->qty) - $out;

//         array_push($existing_record, $item);
//         array_push($customers, $item->name);
//     }

//     $customers = array_unique($customers);

//     $final_result = [];

//     foreach ($customers as $customer) {
//         $total = 0;
//         foreach ($existing_record as $record) {
//             if ($customer === $record->name) {
//                 $total += $record->qty;
//             }
//         }

//         $final_result[$customer] = $total;
//     }

//     return $final_result;
// }

// function getCustomerName(Request $request)
// {
//     $id = $request->input('id');

//     $customer = DB::table('callcenter.customer')
//         ->select('name')
//         ->where('id', $id)
//         ->first();
//     return $customer->name;
// }

// function askPrice(Request $request)
// {
//     $customer = $request->input('customer');
//     $partNumber = $request->input('partNumber');

//     DB::table('ask_price')->insert([
//         'customer_id' => $customer,
//         'user_id' => Auth::user()->id,
//         'code' =>  $partNumber,
//         'status' =>  'pending',
//         'notify' =>  'send',
//         'created_at' => Carbon::now(),
//     ]);
// }

// function pricesetup(Request $request)
// {

//     $customer = $request->input('customer');
//     $completeCode = $request->input('code');

//     return $this->setup_loading($customer, $completeCode);
// }
