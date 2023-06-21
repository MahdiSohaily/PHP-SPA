<?php
require_once './config/config.php';
require_once './database/connect.php';
require_once('./views/Layouts/header.php');
$sql = "SELECT * FROM rates ORDER BY amount ASC";
$rates = $conn->query($sql);
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
        <SectionBorder />
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
        <SectionBorder />

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

        <SectionBorder />

        <div class="p-3">
            <form action="" method="post">
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="grid grid-cols-6 gap-6">
                        <input type="text" name="form" value="update" hidden>
                        <div class="col-span-6 sm:col-span-4">
                            <label class="block font-medium text-sm text-gray-700">
                                شماره فنی
                            </label>
                            <input name="partNumber" value="<?php echo $selected_good['partnumber'] ?>" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2" required id="serial" type="text" />
                            <p class="mt-2"></p>
                        </div>

                        <!-- Price -->
                        <div class="col-span-6 sm:col-span-4">
                            <label class="block font-medium text-sm text-gray-700">
                                قیمت جنس
                            </label>
                            <input name="price" value="<?php echo $selected_good['price'] ?>" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2" id="price" type="text" />
                            <p class="mt-2"> </p>
                        </div>
                        <!-- Weight -->
                        <div class="col-span-6 sm:col-span-4">
                            <label class="block font-medium text-sm text-gray-700">
                                وزن جنس
                            </label>
                            <input name="weight" value="<?php echo $selected_good['weight'] ?>" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2" id="weight" type="text" />
                            <p class="mt-2"> </p>
                        </div>
                        <!-- Mobis -->
                        <div class="col-span-6 sm:col-span-4">
                            <label class="block font-medium text-sm text-gray-700">
                                موبیز
                            </label>
                            <input name="mobis" value="<?php echo $selected_good['mobis'] ?>" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2" id="mobis" type="text" />
                            <p class="mt-2"> </p>
                        </div>
                        <!-- Korea section -->
                        <div class="col-span-6 sm:col-span-4">
                            <label class="block font-medium text-sm text-gray-700">
                                کوریا
                            </label>
                            <input name="korea" value="<?php echo $selected_good['korea'] ?>" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2" id="korea" v-model="form.korea" type="text" />
                            <p class="mt-2"> </p>
                        </div>
                    </div>
                </div>

                <div v-if="hasActions" class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <button type="type" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="px-2 material-icons hover:cursor-pointer">save</i>
                        ذخیره سازی
                    </button>
                    <?php
                    if ($success) {
                    ?>
                        <br>
                        <p class="text-green-400"><?php echo $success ?></p>
                    <?php
                    }
                    ?>

                    <?php
                    if ($errors) {
                    ?>
                        <br>
                        <p class="text-orange-400"><?php echo $errors ?></p>
                    <?php
                    }
                    ?>
                </div>
            </form>
            <FormRelation @submitted="createRelation">
                <template #form>
                    <!-- Name -->
                    <div class="pb-2">
                        <InputLabel for="name" value=" />
                        <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full ltr" autocomplete="name" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>
                    <div class="pb-2">
                        <InputLabel for="price" value="قیمت" />
                        <TextInput id="price" v-model="form.price" type="text" class="mt-1 block w-full ltr" autocomplete="price" />
                        <InputError :message="form.errors.price" class="mt-2" />
                    </div>
                    <div class="pb-2">
                        <InputLabel for="cars" value="خودرو های مرتبط" />
                        <select type="cars" multiple class="mt-1 block w-full border-gray-300 ltr focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" autocomplete="username" v-model="form.car_id" id="cars">
                            <option v-for="item in cars" :value="item.id" class="text-sm">
                                {{ item.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.car_id" class="mt-2" />
                    </div>
                    <div class="pb-2">
                        <InputLabel for="status" value="وضعیت" />
                        <select type="status" class="mt-1 block w-full ltr border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" autocomplete="username" v-model="form.status_id" id="status">
                            <option v-for="item in status" :value="item.id" class="text-sm">
                                {{ item.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.status_id" class="mt-2" />
                    </div>
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
</script>
<?php
require_once('./views/Layouts/footer.php');
