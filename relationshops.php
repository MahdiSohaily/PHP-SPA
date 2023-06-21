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
            لیست اجناس انتخاب شده برای افزودن به رابطه!
        </p>
        <div class="hidden sm:block">
            <div class="py-2">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>

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
            برای ثبت رایطه در سیستم فورم ذیل را با دقت پر نمایید.
        </p>

        <div class="hidden sm:block">
            <div class="py-2">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>

        <div class="p-3">
            <form action="" method="post" onsubmit="event.preventDefault();createRelation()">
                <input id="mode" type="text" name="form" value="create" hidden>
                <div class="col-span-12 sm:col-span-4 mb-5">
                    <label class="block font-medium text-sm text-gray-700">
                        اسم رابطه
                    </label>
                    <input name="relation_name" value="" class="border-1 text-sm border-gray-300 mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2" required id="relation_name" type="text" />
                    <p class="mt-2"></p>
                </div>
                <div class="col-span-12 sm:col-span-4 mb-5">
                    <label class="block font-medium text-sm text-gray-700">
                        قیمت
                    </label>
                    <input name="price" value="" class="ltr border-1 text-sm border-gray-300 mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2" id="price" type="text" />
                    <p class="mt-2"></p>
                </div>
                <div class="col-span-12 sm:col-span-4 mb-5">
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
                <div class="col-span-12 sm:col-span-4 mb-5">
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

        <div class="flex items-center justify-end px-4 py-3  text-right sm:px-6">
            <button type="type" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="px-2 material-icons hover:cursor-pointer">save</i>
                ذخیره سازی
            </button>
        </div>
        </form>
        <FormRelation @submitted="createRelation">
            <template #form>


                <InputError :message="form.errors.values" class="mt-2" />
            </template>

            <template #actions>
                <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                    ذخیره سازی موفقانه صورت گرفت.
                </ActionMessage>

                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    <i class="px-2 material-icons hover:cursor-pointer">save</i>
                    ذخیره سازی
                </PrimaryButton>
            </template>
        </FormRelation>
    </div>
</div>
</div>
<script>
    let result = null;
    selected_goods = [];
    let relation_active = false;
    const selected_box = document.getElementById('selected_box');
    const resultBox = document.getElementById("search_result");

    // search for goods to define their relationship
    function search(pattern) {
        if (pattern.length > 6) {
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
        const id = element.getAttribute("data-id");
        const partNumber = element.getAttribute("data-partnumber");
        selected_goods.push({
            id: id,
            partNumber: partNumber
        });
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
    }

    // A function to display the selected goods in the relation box
    function displaySelectedGoods() {
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

    // A function to create the relationship
    function createRelation() {
        var params = new URLSearchParams();
        params.append('search_goods_for_relation', 'search_goods_for_relation');
        params.append('selected_goods', selected_goods);
        params.append('pattern', pattern);

        axios.post("./app/Controllers/RelationshipAjaxController.php", params)
            .then(function(response) {
                resultBox.innerHTML = response.data;
                // console.log(response.data);
            })
            .catch(function(error) {
                console.log(error);
            });
    }
</script>
<?php
require_once('./views/Layouts/footer.php');
