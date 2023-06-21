<?php
require_once './config/config.php';
require_once './database/connect.php';
require_once('./views/Layouts/header.php');
$sql = "SELECT * FROM cars";
$cars = $conn->query($sql);

$status_sql = "SELECT * FROM status";
$status = $conn->query($status_sql);
?>
<div class="rtl h-70S grid grid-cols-1 my-8 md:grid-cols-3 gap-6 lg:gap-8 p-6 lg:p-8">
    <div class="bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-between p-3">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="material-icons font-semibold text-orange-400">search</i>
                جستجوی اجناس
            </h2>
        </div>

        <div class="flex justify-center px-3">
            <input type="text" name="serial" id="serial" class="rounded-md py-3 px-3 w-full border-1 text-sm border-gray-300 focus:outline-none text-gray-500" min="0" max="30" onkeyup="search(this.value)" placeholder="شماره فنی ..." />
        </div>
        <div class="hidden sm:block">
            <div class="py-2">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>
        <div id="search_result" class="p-3">
            <!-- Search Results are going to be appended here -->
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-between p-3">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="material-icons text-green-600">beenhere</i>
                اجناس انتخاب شده
            </h2>
            <button class="flex items-center border-none bg-red-500 hover:bg-red-600 text-white rounded-lg px-4 py-2 text-sm" onclick="clearAll()">
                <i class="px-2 material-icons hover:cursor-pointer">delete</i>
                حذف همه
            </button>
        </div>
        <p class="px-3 mb-4 text-gray-500 text-sm leading-relaxed">
            <span class="text-red-500">*</span>
            لیست اجناس انتخاب شده برای افزودن به رابطه!
        </p>
        <div class="hidden sm:block">
            <div class="py-2">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>
        <p id="select_box_error" class="px-3 tiny-text text-red-500 hidden">
            لیست اجناس انتخاب شده برای افزودن به رابطه خالی بوده نمیتواند!
        </p>
        <p id="duplicate_relation" class="px-3 tiny-text text-red-500 hidden">
            شما همزمان نمی توانید ۲ رابطه را بارگذاری نمایید.(شما میتوانید با حذف همه رابطه جدید را وارد نمایید)
        </p>
        <div id="selected_box" class="p-3">
            <!-- selected items are going to be added here -->
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="p-3">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="material-icons font-semibold text-blue-500">save</i>
                ثبت رابطه در سیستم
            </h2>
        </div>

        <p class="px-3 py-1 mb-4 text-gray-500 text-sm leading-relaxed">
            برای ثبت رابطه در سیستم فورم ذیل را با دقت پر نمایید.
        </p>

        <div class="hidden sm:block">
            <div class="py-2">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>

        <div class="p-3">
            <form action="" method="post" onsubmit="event.preventDefault();createRelation()">
                <input id="mode" type="text" name="operation" value="create" hidden>
                <div class="col-span-12 sm:col-span-4 mb-3">
                    <label class="block font-medium text-sm text-gray-700">
                        اسم رابطه
                    </label>
                    <input name="relation_name" value="" class="border-1 text-sm border-gray-300 mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2" required id="relation_name" type="text" />
                    <p class="mt-2"></p>
                </div>
                <div class="col-span-12 sm:col-span-4 mb-3">
                    <label class="block font-medium text-sm text-gray-700">
                        قیمت
                    </label>
                    <input name="price" value="" class="ltr border-1 text-sm border-gray-300 mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2" id="price" type="text" />
                    <p class="mt-2"></p>
                </div>
                <div class="col-span-12 sm:col-span-4 mb-3">
                    <label for="cars">
                        خودرو های مرتبط
                    </label>
                    <select type="cars" multiple class="p-2 border-1 text-sm border-gray-300 mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" id="cars">
                        <?php
                        if (mysqli_num_rows($cars) > 0) {
                            while ($item = mysqli_fetch_assoc($cars)) {
                        ?>
                                <option value="<?php echo $item['id'] ?>" class="text-sm">
                                    <?php echo $item['name'] ?>
                                </option>

                        <?php }
                        } ?>
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-4 mb-3">
                    <label for="cars">
                        وضعیت
                    </label>
                    <select type="status" class="border-1 p-2 text-sm border-gray-300 mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" id="status">
                        <option value="" class="text-sm">وضعیت مورد نظر خود برای رابطه را انتخاب کنید!</option>
                        <?php
                        if (mysqli_num_rows($status) > 0) {
                            while ($item = mysqli_fetch_assoc($status)) {
                        ?>
                                <option value="<?php echo $item['id'] ?>" class="text-sm">
                                    <?php echo $item['name'] ?>
                                </option>

                        <?php }
                        } ?>
                    </select>
                </div>
        </div>
        <p id="form_success" class="px-3 tiny-text text-green-500 hidden">
            رابطه جدید اجناس موفقانه در پایگاه داده ثبت شد!
        </p>
        <p id="form_error" class="px-3 tiny-text text-red-500 hidden">
            ذخیره سازی اطلاعات ناموفق بود!
        </p>
        <div class="flex items-center justify-end px-4 py-3  text-right sm:px-6">
            <button type="type" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="px-2 material-icons hover:cursor-pointer">save</i>
                ذخیره سازی
            </button>
        </div>
        </form>
    </div>
</div>
</div>
<script>
    let serial = null;
    let pattern_id = null;
    selected_goods = [];
    let relation_active = false;


    const selected_box = document.getElementById('selected_box');
    const resultBox = document.getElementById("search_result");
    const error_message = document.getElementById('select_box_error');
    const duplicate_relation = document.getElementById('duplicate_relation');
    const form_success = document.getElementById('form_success');
    const form_error = document.getElementById('form_error');

    // search for goods to define their relationship
    function search(pattern) {
        serial = pattern;
        if (pattern.length > 6) {
            error_message.classList.add('hidden');
            duplicate_relation.classList.add('hidden');
            pattern = pattern.replace(/\s/g, "");
            pattern = pattern.replace(/-/g, "");
            pattern = pattern.replace(/_/g, "");

            resultBox.innerHTML = `<tr class=''>
                                        <div class='w-full h-96 flex justify-center items-center'>
                                            <img class=' block w-10 mx-auto h-auto' src='./public/img/loading.png' alt='google'>
                                        </div>
                                    </tr>`;
            var params = new URLSearchParams();
            params.append('search_goods_for_relation', 'search_goods_for_relation');
            params.append('pattern', pattern);

            axios.post("./app/Controllers/RelationshipAjaxController.php", params)
                .then(function(response) {
                    resultBox.innerHTML = response.data;
                    // console.log(response.data);
                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
            resultBox.innerHTML = "";
        }
    };

    // A function to add a good to the relation box
    function add(element) {
        duplicate_relation.classList.add('hidden');
        const id = element.getAttribute("data-id");
        const partNumber = element.getAttribute("data-partnumber");
        selected_goods.push({
            id: id,
            partNumber: partNumber
        });
        error_message.classList.add('hidden');
        remove(id);
        displaySelectedGoods();
    };

    // A function to remove added goods from relation box
    function remove(id) {
        const item = document.getElementById("search-" + id);
        if (item) {
            item.remove();
        }
    }

    // A function to remove an specific item from selected items list
    function remove_selected(id) {
        selected_goods = selected_goods.filter((item) => {
            return item.id != id;
        });
        displaySelectedGoods();
    };

    //A function to clear all selected items
    function clearAll() {
        selected_goods = [];
        relation_active = false;
        displaySelectedGoods();
        duplicate_relation.classList.add('hidden');
    }

    // A function to display the selected goods in the relation box
    function displaySelectedGoods() {
        console.log(selected_goods);
        let template = '';
        for (const good of selected_goods) {
            template += `
            <div class="w-full flex justify-between items-center shadow-md hover:shadow-lg rounded-md px-4 py-3 mb-2 border-1 border-gray-300">
                <p class="text-sm font-semibold text-gray-600">
                    ` + good.partNumber + `
                </p>
                    <i data-id="` + good.id + `" data-partNumber="` + good.partNumber + `" onclick="remove_selected(` + good.id + `)"
                            class="material-icons add text-red-600 cursor-pointer rounded-circle hover:bg-gray-200">do_not_disturb_on
                    </i>
                </div>
            `;
        }
        selected_box.innerHTML = template;
    }

    function getSelectedItems(id) {
        let selected = [];
        for (var option of document.getElementById(id).options) {
            if (option.selected) {
                selected.push(option.value);
            }
        }

        return selected;
    }

    // A function to create the relationship
    function createRelation() {
        duplicate_relation.classList.add('hidden');
        // Accessing the form fields to get thier value for an ajax store operation
        const relation_name = document.getElementById('relation_name').value;
        const mode = document.getElementById('mode').value;
        const price = document.getElementById('price').value;
        const cars = getSelectedItems('cars');
        const status = document.getElementById('status').value;

        // Defining a params instance to be attached to the axios request
        const params = new URLSearchParams();
        params.append('store_relation', 'store_relation');
        params.append('relation_name', relation_name);
        params.append('price', price);
        params.append('cars', JSON.stringify(cars));
        params.append('status', status);

        // Side effects data
        params.append('mode', mode);
        params.append('pattern_id', pattern_id);
        params.append('selected_goods', JSON.stringify(selected_goods));
        params.append('serial', serial);


        if (selected_goods.length > 0) {
            axios.post("./app/Controllers/RelationshipAjaxController.php", params)
                .then(function(response) {
                    console.log(response.data);
                    if (response.data == 'true') {
                        form_success.classList.remove('hidden');
                        setTimeout(() => {
                            form_success.classList.add('hidden');
                        }, 1000)
                    } else {
                        form_error.classList.remove('hidden');
                        setTimeout(() => {
                            form_error.classList.add('hidden');
                        }, 1000)
                    }
                })
                .catch(function(error) {

                });
        } else {
            error_message.classList.remove('hidden');
        }


    }


    // A function to load all the relationships for the selected relationship
    function load(element) {

        const pattern = element.getAttribute("data-pattern");
        if (!relation_active) {
            duplicate_relation.classList.add('hidden');
            relation_active = true;
            pattern_id = pattern;

            const params = new URLSearchParams();
            params.append('load_relation', 'load_relation');
            params.append('pattern', pattern_id);

            axios.post("./app/Controllers/RelationshipAjaxController.php", params)
                .then(function(response) {
                    push_data(response.data);
                    displaySelectedGoods();
                    load_pattern_ifo(pattern_id);
                })
                .catch(function(error) {

                });
        } else {
            duplicate_relation.classList.remove('hidden');
        }
    }
    const push_data = (data) => {
        for (const item of data) {
            remove(item.id);
            selected_goods.push({
                id: item.id,
                partNumber: item.partNumber
            });
        }
    };

    const load_pattern_ifo = (id) => {
        const params = new URLSearchParams();
        params.append('load_pattern_ifo', 'load_pattern_ifo');
        params.append('pattern', pattern_id);

        axios.post("./app/Controllers/RelationshipAjaxController.php", params)
            .then(function(response) {
                const pattern_info = (response.data.pattern);
                const pattern_info_cars = (response.data.cars);
            })
            .catch(function(error) {
                console.log(error);
            });
    };
</script>
<?php
require_once('./views/Layouts/footer.php');
